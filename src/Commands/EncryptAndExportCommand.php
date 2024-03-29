<?php

namespace Mrshoikot\EncryptAndExport\Commands;

use Illuminate\Console\Command;
use Mrshoikot\EncryptAndExport\EncryptAndExport;

class EncryptAndExportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $signature = 'securecsv';

    /**
     * The console command description.
     *
     * @var string
     */
    public $description;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->description = trans('securecsv::description');
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $exporter = new EncryptAndExport();

        // Ask the user for the table name
        $table = $this->ask(trans('securecsv::translations.q_table_name'));

        // Try to set the table name
        try {
            $exporter->setTable($table);
        } catch (\InvalidArgumentException $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        // Display the columns in the table
        $this->info(trans('securecsv::translations.column_list', ['table' => $table]));

        foreach ($exporter->allColumns as $key => $column) {
            $this->info("[$key]: $column");
        }

        // Ask the user for the columns to encrypt
        $columnIndexesToEncrypt = $this->ask(trans('securecsv::translations.q_columns'));

        // Convert the string to an array using space and comma as delimiters
        $columnIndexesToEncrypt = preg_split('/[\s,]+/', $columnIndexesToEncrypt);
        $selectedColumns = [];

        // Try to select the choosen columns
        foreach ($columnIndexesToEncrypt as $index) {
            try {
                $exporter->selectColumn($exporter->allColumns[$index]);
                $selectedColumns[] = $exporter->allColumns[$index];
            } catch (\InvalidArgumentException $e) {
                $this->error($e->getMessage());

                return self::FAILURE;
            }
        }

        // Ask the user for the export path
        $export_path = $this->ask(trans('securecsv::translations.q_export_path'));

        // Try to set the export path if the user inserted one
        if (! empty($export_path)) {
            try {
                $exporter->setPath($export_path);
            } catch (\InvalidArgumentException $e) {
                $this->error($e->getMessage());

                return self::FAILURE;
            }
        }

        // Finally, Export the data
        $exporter->export();
        $this->info(trans('securecsv::translations.exported', ['path' => $export_path]));

        return self::SUCCESS;
    }
}
