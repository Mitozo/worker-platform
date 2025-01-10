<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Style\SymfonyStyle;

class ExcelToJsonImporter
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function import(string $filePath, string $tableName, SymfonyStyle $io): void
    {
        $spreadsheet = IOFactory::load($filePath);
        
        $sheetsName = [];
        $sql = "Select sheets_name, uuid_key from file_details where id = :id";
        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($sql);
        $resultQuery = $stmt->executeQuery(['id' => 1])->fetchAllAssociative(); // Bind parameters
        $sheetsName = json_decode($resultQuery[0]['sheets_name'], true);
        $uuidKey = $resultQuery[0]['uuid_key'];

        $io->section('Processing  Excel Sheets');
        
        $sheetObject = [];
        foreach ($sheetsName['observable_sheets'] as $key => $sheet) {
            // Parse sheets
            $currentSheet = $spreadsheet->getSheetByName($sheet);
            if (!$sheet) {
                $message = "Sheet '{$sheet}' not found in the file.";
                $io->warning($message);
                continue;
                // throw new \Exception($message);
            }
            
            $highestRow = $currentSheet->getHighestRow();
            if (0 !== $key) {
                $io->writeln('');
            }
            $io->writeln(" [{$sheet}]");
            $sheetConvertionProgress = new ProgressBar($io, $highestRow);
            $sheetConvertionProgress->setFormat('debug');
            $sheetConvertionProgress->start();
            // Extract headers
            $headerExtraction = $currentSheet->rangeToArray('A1:' . $currentSheet->getHighestColumn() . '1')[0];

            // Read sheets into indexed data
            $sheetObject[$sheet] = $this->readSheetAsIndexedJson($currentSheet, $headerExtraction, $uuidKey, $sheetConvertionProgress);
            $sheetConvertionProgress->finish();
        }
        $io->newLine(2);

        $io->section('Combining and Inserting Data');
        $totalRows = count(reset($sheetObject));
        $progressBar = new ProgressBar($io, $totalRows);
        $progressBar->start();
        // Combine and insert JSON into the database
        $this->combineAndInsertData($sheetObject, $tableName, $progressBar);
        $progressBar->finish();
        $io->success('Data import completed successfully!');
    }

    private function readSheetAsIndexedJson(Worksheet $sheet, array $keys, string $indexBy, ProgressBar $sheetConvertionProgress): array
    {
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
                    $value = $cell->getFormattedValue();
                }

                $cellValues[] = $value;
            }

            $row = array_combine($keys, $cellValues);
            $data[$row[$indexBy]][] = $row; // Index by UUID
            $sheetConvertionProgress->advance();
        }

        return $data;
    }

    private function insertJsonData(string $tableName, string $uuid, string $jsonData): void
    {
        $connection = $this->entityManager->getConnection();

        $sql = "INSERT INTO {$tableName} (uuid, content_input) VALUES (:uuid, :data)";
        $connection->executeStatement($sql, [
            'uuid' => $uuid,
            'data' => $jsonData,
        ]);
    }


    private function combineAndInsertData(array $dataIndex, string $tableName, ProgressBar $progressBar): void
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
            $this->insertJsonData($tableName, $uuid, $jsonData);
            $progressBar->advance();
        }
    }
}
