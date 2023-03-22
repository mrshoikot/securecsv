<?php

namespace Mrshoikot\EncryptAndExport\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class EncryptAndExportCommand extends Command
{
    
    public $signature = 'encrypt-and-export';

    public $description;

    public function __construct()
    {
        parent::__construct();
        $this->description = trans('encrypt-and-export::description');
    }

    public function handle(): int
    {
        // Ask the user for the table name
        $table = $this->ask(trans('encrypt-and-export::translations.q_table_name'));

        // Check if the table exists in the datbase
        if (!Schema::hasTable($table)) {
            $this->error("The table {$table} does not exist in the database.");

            return self::FAILURE;
        }

        // Display the columns in the table
        $columns = Schema::getColumnListing($table);
        $this->info(trans('encrypt-and-export::translations.column_list', ['table' => $table]));

        foreach ($columns as $key => $column) {
            $this->info("[$key]: $column");
        }

        // Ask the user for the columns to encrypt
        $columnIndexesToEncrypt = $this->ask(trans('encrypt-and-export::translations.q_columns'));
        $columnIndexesToEncrypt = preg_split('/[\s,]+/', $columnIndexesToEncrypt);
        $selectedColumns = [];

        // Check if the columns exist in the table
        foreach ($columnIndexesToEncrypt as $index) {
            if ($index >= count($columns)) {
                $this->error(trans('encrypt-and-export::translations.invalid_column'));

                return self::FAILURE;
            } else {
                $selectedColumns[] = $columns[$index];
            }
        }

        // Ask the user for the export path
        $export_path = $this->ask(trans('encrypt-and-export::translations.q_export_path'));

        if (empty($export_path)) {
            $export_path = base_path();
        }

        // Check if the export path is valid
        if (!File::isDirectory($export_path)) {
            $this->error(trans('encrypt-and-export::translations.not_valid_dir', ['path' => $export_path]));

            return self::FAILURE;
        }

        // Check if the export path is writable
        if (!File::isWritable($export_path)) {
            $this->error(trans('encrypt-and-export::translations.not_writable', ['path' => $export_path]));

            return self::FAILURE;
        }

        $this->export($table, $selectedColumns, $export_path);

        return self::SUCCESS;
    }


    /**
     * Export the data to a CSV file
     *
     * @param string $table
     * @param array $columns
     * @param string $export_path
     * @return void
     */
    protected function export(string $table, array $columns, string $export_path): void
    {
        $file_name = $table . '_' . date('Y-m-d_H-i-s') . '.csv';
        $file_path = $export_path . '/' . $file_name;

        $this->info("Exporting the data to {$file_path}...");

        $query = DB::table($table);

        $query->orderBy('created_at')->chunk(100, function ($rows) use ($columns, $file_path) {
            $rows = $rows->toArray();

            $data = [];

            foreach ($rows as $row) {
                $row = (array) $row;

                foreach ($columns as $column) {
                    $row[$column] = encrypt($row[$column]);
                }

                $data[] = $row;
            }

            $this->writeToCsv($data, $file_path);
        });

        $this->info(trans('encrypt-and-export::translations.exported', ['path' => $file_path]));
    }


    /**
     * Write the data to a CSV file
     *
     * @param array $data
     * @param string $file_path
     * @return void
     */
    protected function writeToCsv(array $data, string $file_path): void
    {
        $file = fopen($file_path, 'a');

        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
    }
}
