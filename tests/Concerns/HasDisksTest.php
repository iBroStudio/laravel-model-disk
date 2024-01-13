<?php

use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use IBroStudio\ModelDisk\Contracts\DiskConfig;
use IBroStudio\ModelDisk\DataObjects\FtpConfig;
use IBroStudio\ModelDisk\DataObjects\LocalConfig;
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
        ->andReturnUsing(fn () => Storage::build($config->toArray()));

    expect($model->disk)->toBeInstanceOf(Filesystem::class);
})->with([
    fn () => new LocalConfig(root: storage_path('app/test')),
    fn () => new FtpConfig(
        host: fake()->domainName(),
        username: fake()->userName(),
        password: EncryptableText::make(fake()->password())
    ),
]);
