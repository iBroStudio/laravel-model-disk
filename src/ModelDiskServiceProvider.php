<?php

namespace IBroStudio\ModelDisk;

use IBroStudio\ModelDisk\Commands\ModelDiskCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ModelDiskServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-model-disk')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-model-disk_table')
            ->hasCommand(ModelDiskCommand::class);
    }
}
