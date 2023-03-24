<?php

namespace Mrshoikot\EncryptAndExport;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class EncryptAndExport
{
    /**
     * The name of the table to export
     *
     * @var string
     */
    private $table;

    /**
     * The columns that are going to be encrypted
     *
     * @var array
     */
    private $selectedColumns;

    /**
     * The path where the CSV file will be exported
     *
     * @var string
     */
    private $path;

    /**
     * All the columns in the table
     *
     * @var array
     */
    public $allColumns;

    /**
     * Create a new instance of EncryptAndExport
     *
     * @return void
     */
    public function __construct()
    {
        $this->selectedColumns = [];

        // Set the default path to /storage/app
        $this->path = storage_path('app');
    }

    /**
     * Get the value of a private property
     *
     * @param  string  $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * Set the table name
     *
     * @param  string  $table
     * @return void
     */
    public function setTable($table)
    {
        // Check if the table exists in the database
        if (! Schema::hasTable($table)) {
            throw new \InvalidArgumentException("The table {$table} does not exist in the database.");
        }

        $this->table = $table;
        $this->allColumns = Schema::getColumnListing($this->table);
    }

    /**
     * Select a column to encrypt
     *
     * @param  string|array  $column
     * @return void
     */
    public function selectColumn($columns)
    {
        // Check if the column is not an array
        if (! is_array($columns)) {
            $columns = [$columns];
        }

        // Insert the columns to the selectedColumns array
        foreach ($columns as $column) {
            // Check if the column exists in the table
            if (! in_array($column, $this->allColumns)) {
                throw new \InvalidArgumentException(trans('encrypt-and-export::translations.invalid_column'));
            }
            $this->selectedColumns[] = $column;
        }
    }

    /**
     * Set the path where the CSV file will be exported
     *
     * @param  string  $path
     * @return void
     */
    public function setPath($path)
    {
        // Check if the path is a directory
        if (! File::isDirectory($path)) {
            throw new \InvalidArgumentException(trans('encrypt-and-export::translations.not_valid_dir', ['path' => $path]));
        }

        // Check if the path is writable
        if (! File::isWritable($path)) {
            throw new \InvalidArgumentException(trans('encrypt-and-export::translations.not_writable', ['path' => $path]));
        }

        $this->path = $path;
    }

    /**
     * Export the data to a CSV file
     */
    public function export(): string
    {
        $file_name = $this->table.'_'.date('Y-m-d_H-i-s').'.csv';
        $this->path = $this->path.'/'.$file_name;

        $query = DB::table($this->table);

        $query->orderBy('created_at')->chunk(100, function ($rows) {
            $rows = $rows->toArray();

            $data = [];

            foreach ($rows as $row) {
                $row = (array) $row;

                // Encrypt the selected columns
                foreach ($this->selectedColumns as $column) {
                    $row[$column] = encrypt($row[$column]);
                }

                $data[] = $row;
            }

            $this->writeToCsv($data, $this->path);
        });

        return $this->path;
    }

    /**
     * Write the data to a CSV file
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
