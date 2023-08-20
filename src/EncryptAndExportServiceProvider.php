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
            ->name('securecsv')
            ->hasCommand(EncryptAndExportCommand::class)
            ->hasTranslations();
    }
}
