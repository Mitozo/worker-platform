<?php

namespace App\Service\Contracts;

public interface FileImporterInterface
{
    public const READ_CSV = 0;
    public const READ_EXCEL = 1;

    public function import(string $filename, string $tableName): void;
    public function insertJsonData(string $tableName, string $jsonData, ?string $uuid): bool;
    public function readFileContent(array $opitons, int $flag): mixed;
}
