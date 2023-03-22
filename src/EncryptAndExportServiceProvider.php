<?php

namespace Mrshoikot\EncryptAndExport;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Mrshoikot\EncryptAndExport\Commands\EncryptAndExportCommand;

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
            ->hasCommand(EncryptAndExportCommand::class);
    }
}
