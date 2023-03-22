<?php

namespace Mrshoikot\EncryptAndExport\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mrshoikot\EncryptAndExport\EncryptAndExportServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Mrshoikot\\EncryptAndExport\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            EncryptAndExportServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_encrypt-and-export_table.php.stub';
        $migration->up();
        */
    }
}
