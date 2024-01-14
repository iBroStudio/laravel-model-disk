<?php

use IBroStudio\ModelDisk\Contracts\DiskConfig;
use IBroStudio\ModelDisk\Enums\DiskDriver;
use IBroStudio\ModelDisk\Facades\ModelDisk;
use IBroStudio\ModelDisk\PendingDisk;
use IBroStudio\ModelDisk\Tests\Support\Models\ModelWithDisk;
use IBroStudio\ModelDisk\ValueObjects\Disk;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

it('can handle the disk attribute', function (DiskConfig $config) {
    $model = ModelWithDisk::factory()->create();
    $driver = DiskDriver::fromKey($config->driver);
    $disk = Disk::make(
        driver: $driver,
        config: $config
    );
    $pendingDisk = Mockery::mock(PendingDisk::class);

    ModelDisk::shouldReceive('for->disk')
        ->andReturn($pendingDisk);

    $model->disk = $config;

    $pendingDisk->shouldReceive('save')
        ->once()
        ->andReturn($disk);

    $model->save();

    expect($model->refresh()->disk_driver->is($driver))->toBeTrue();

    ModelDisk::shouldReceive('for->build')
        ->once()
        ->andReturnUsing(fn () => Storage::build($config->convertValueObjects()->toArray()));

    expect($model->disk)->toBeInstanceOf(Filesystem::class);
})->with('disk-drivers');
