<?php

namespace Mrshoikot\EncryptAndExport;

use Mrshoikot\EncryptAndExport\Commands\EncryptAndExportCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class EncryptAndExportServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('encrypt-and-export')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_encrypt-and-export_table')
            ->hasCommand(EncryptAndExportCommand::class);
    }
}
