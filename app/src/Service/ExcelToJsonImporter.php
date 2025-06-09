<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;

class ExcelToJsonImporter implements FileImporterInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function import(string $filePath, string $tableName): void
    {
        $spreadsheet = IOFactory::load($filePath);
        
        $sheetsName = [];
        $sql = "Select sheets_name, uuid_key from file_details where id = :id";
        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($sql);
        $resultQuery = $stmt->executeQuery(['id' => 1])->fetchAllAssociative(); // Bind parameters
        $sheetsName = json_decode($resultQuery[0]['sheets_name'], true);
        $uuidKey = $resultQuery[0]['uuid_key'];
        
        $sheetObject = [];
        foreach ($sheetsName['observable_sheets'] as $sheet) {
            // Parse sheets
            $currentSheet = $spreadsheet->getSheetByName($sheet);
            if (!$sheet) {
                throw new \Exception("Sheet '{$sheet}' not found in the file.");
            }

            // Extract headers
            $headerExtraction = $currentSheet->rangeToArray('A1:' . $currentSheet->getHighestColumn() . '1')[0];

            // Read sheets into indexed data
            $sheetObject[$sheet] = $this->readFileContent([$currentSheet, $headerExtraction, $uuidKey], 1);
        }
        // Combine and insert JSON into the database
        $this->combineAndInsertData($sheetObject, $tableName);
    }

    private function readFileContent(array $options, int $flag): mixed
    {
        if ($flag != 1) {
            throw new Exception("Error Processing Request: must be a type of Excel file", 1);
        }
        [$sheet, $keys, $indexBy] = $options;
        $data = [];

        foreach ($sheet->getRowIterator() as $index => $row) {
            if ($index === 1) { // Skip header row
                continue;
            }

            $cellValues = [];
            foreach ($row->getCellIterator() as $cell) {
                $value = $cell->getValue();
                
                // Check if the cell contains a formula
                if ($cell->isFormula()) {
                    // Get the calculated value instead of the formula string
                    $value = $cell->getCalculatedValue();
                }

                $cellValues[] = $value;
            }

            $row = array_combine($keys, $cellValues);
            $data[$row[$indexBy]][] = $row; // Index by UUID
        }

        return $data;
    }

    private function insertJsonData(string $tableName, string $jsonData, ?string $uuid): void
    {
        $connection = $this->entityManager->getConnection();

        $sql = "INSERT INTO {$tableName} (uuid, content_input) VALUES (:uuid, :data)";
        $connection->executeStatement($sql, [
            'uuid' => $uuid,
            'data' => $jsonData,
        ]);
    }


    private function combineAndInsertData(array $dataIndex, string $tableName): void
    {
        // Assuming all sheets are indexed by UUID, get the first sheet as the primary key source
        $primarySheet = reset($dataIndex); // First sheet data
        $primaryKeys = array_keys($primarySheet); // UUIDs in the first sheet

        foreach ($primaryKeys as $uuid) {
            $combined = [];

            // Dynamically collect data from each sheet for the current UUID
            foreach ($dataIndex as $sheetName => $sheetData) {
                $combined[$sheetName] = $sheetData[$uuid] ?? [];
            }

            // Convert combined data to JSON
            $jsonData = json_encode($combined, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            // Insert into the database
            $this->insertJsonData($tableName, $jsonData, $uuid);
        }
    }
}
