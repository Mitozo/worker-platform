<?php

namespace App\Command;

use App\Service\ExcelToJsonImporter;  // Import the service you're injecting
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-excel',
    description: 'import xls file and compile it',
    hidden: false,
)]
class ImportExcelCommand extends Command
{
    // Define your dependencies (e.g., the service for handling the file import)
    private ExcelToJsonImporter $importer;

    // Constructor to inject dependencies
    public function __construct(ExcelToJsonImporter $importer)
    {
        $this->importer = $importer;
        parent::__construct();  // Always call the parent constructor
    }

    // Configure the command (name, description, arguments, options)
    protected function configure(): void
    {
        $this
            ->setDescription('Imports data from an Excel file into the database.')
            ->addArgument('file', InputArgument::REQUIRED, 'Path to the Excel file')
            ->addArgument('table', InputArgument::REQUIRED, 'Database table name');
    }

    // Execute the command's logic
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        // Get the arguments passed to the command
        $file = $input->getArgument('file');
        $table = $input->getArgument('table');

        $io->note("Starting import of file: '{$file}'");

        try {
            // Call the service method to import the data
            $this->importer->import($file, $table, $io);
        } catch (\Exception $e) {
            // Handle any exception during the import
            $io->error("Error during import: " . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
