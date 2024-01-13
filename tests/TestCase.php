<?php

namespace IBroStudio\ModelDisk\Tests;

use IBroStudio\DataRepository\DataRepositoryServiceProvider;
use IBroStudio\ModelDisk\ModelDiskServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelData\LaravelDataServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'IBroStudio\\ModelDisk\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            DataRepositoryServiceProvider::class,
            LaravelDataServiceProvider::class,
            ModelDiskServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/Support/Database/Migrations/create_support_tables.php.stub';
        $migration->up();

        $migration = include __DIR__.'/../vendor/ibrostudio/laravel-data-repository/database/migrations/create_data_repository_table.php.stub';
        $migration->up();

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-model-disk_table.php.stub';
        $migration->up();
        */
    }
}
