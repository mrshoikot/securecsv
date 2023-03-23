<?php

namespace Mrshoikot\Scrud\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Mrshoikot\EncryptAndExport\EncryptAndExport;
use Mrshoikot\EncryptAndExport\EncryptAndExportServiceProvider;
use Orchestra\Testbench\TestCase;

class EncryptAndExportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up the test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create dummy user
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'password' => 'password',
        ]);
    }

    /**
     * Get the package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            EncryptAndExportServiceProvider::class,
        ];
    }

    /**
     * Set the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();
    }

    /**
     * Test if it can set the table name.
     *
     * @return void
     */
    public function test_it_can_set_the_table_name()
    {
        $encryptAndExport = new EncryptAndExport();
        $encryptAndExport->setTable('users');

        $this->assertSame('users', $encryptAndExport->table);
    }

    /**
     * Test if it throws an exception if the table does not exist.
     *
     * @return void
     */
    public function test_it_throws_an_exception_if_table_does_not_exist()
    {
        $this->expectException(\InvalidArgumentException::class);

        $encryptAndExport = new EncryptAndExport();
        $encryptAndExport->setTable('non_existent_table');
    }

    /**
     * Test if it can select a column to encrypt.
     *
     * @return void
     */
    public function test_it_can_select_a_column_to_encrypt()
    {
        $encryptAndExport = new EncryptAndExport();
        $encryptAndExport->setTable('users');
        $encryptAndExport->selectColumn('email');

        $this->assertSame(['email'], $encryptAndExport->selectedColumns);
    }

    /**
     * Test if it throws an exception if the selected column does not exist.
     *
     * @return void
     */
    public function test_it_throws_an_exception_if_selected_column_does_not_exist()
    {
        $this->expectException(\InvalidArgumentException::class);

        $encryptAndExport = new EncryptAndExport();
        $encryptAndExport->setTable('users');
        $encryptAndExport->selectColumn('non_existent_column');
    }

    /**
     * Test if it can set the export path.
     *
     * @return void
     */
    public function test_it_can_set_the_export_path()
    {
        $encryptAndExport = new EncryptAndExport();
        $encryptAndExport->setPath(storage_path('app'));

        $this->assertSame(storage_path('app'), $encryptAndExport->path);
    }

    /**
     * Test if it throws an exception if the export path is not a directory.
     *
     * @return void
     */
    public function test_it_throws_an_exception_if_export_path_is_not_a_directory()
    {
        $this->expectException(\InvalidArgumentException::class);

        $encryptAndExport = new EncryptAndExport();
        $encryptAndExport->setPath('non_existent_directory');
    }

    /**
     * Test if it throws an exception if the export path is not writable.
     *
     * @return void
     */
    public function test_it_throws_an_exception_if_export_path_is_not_writable()
    {
        $this->expectException(\InvalidArgumentException::class);

        $encryptAndExport = new EncryptAndExport();

        // Use a file path instead of a directory to make it not writable
        $encryptAndExport->setPath(storage_path('app/test.txt'));
    }

    /**
     * Test if it can export the data to a CSV file.
     *
     * @return void
     */
    public function test_it_can_export_the_data_to_a_csv_file()
    {
        $encryptAndExport = new EncryptAndExport();
        $encryptAndExport->setTable('users');
        $encryptAndExport->selectColumn('email');
        $path = $encryptAndExport->export();

        $this->assertFileExists($path);
    }
}
