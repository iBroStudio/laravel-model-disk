<?php

use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use IBroStudio\ModelDisk\Contracts\DiskConfig;
use IBroStudio\ModelDisk\DataObjects\FtpConfig;
use IBroStudio\ModelDisk\DataObjects\LocalConfig;
use IBroStudio\ModelDisk\Enums\DiskDriver;
use IBroStudio\ModelDisk\ModelDisk;
use IBroStudio\ModelDisk\PendingDisk;
use IBroStudio\ModelDisk\Tests\Support\Models\ModelWithDisk;
use IBroStudio\ModelDisk\ValueObjects\Disk;
use Illuminate\Contracts\Filesystem\Filesystem;

it('can instantiate a new disk', function (DiskConfig $config) {
    $model = ModelWithDisk::factory()->create();
    $modelDisk = Mockery::mock(ModelDisk::class);
    $pendingModelDisk = new PendingDisk($model, new $modelDisk);
    $pendingModelDisk->disk($config);

    expect(
        getPrivateProperty($pendingModelDisk, 'disk')
    )->toEqual(
        new Disk(
            driver: DiskDriver::fromKey($config->driver),
            config: $config
        )
    );
})->with([
    fn () => new LocalConfig(root: storage_path('app/test')),
]);

it('can save a disk', function (DiskConfig $config) {
    $model = ModelWithDisk::factory()->create();
    $modelDisk = Mockery::mock(ModelDisk::class);
    $disk = new Disk(
        driver: DiskDriver::fromKey($config->driver),
        config: $config
    );
    $pendingModelDisk = new PendingDisk($model, new $modelDisk);
    $pendingModelDisk->disk($config);
    $pendingModelDisk->save();
    $dataFromRepository = $model->data_repository(Disk::class);
    dd(
        method_exists($config::class, 'fromDataObjectModel').' '.$config::class
    );
    expect($dataFromRepository->first())->toBeInstanceOf(DataObject::class)
        ->and($dataFromRepository->values())->toEqual($disk);
})->with([
    //'local' => fn () => new LocalConfig(root: storage_path('app/test')),
    'ftp' => fn () => new FtpConfig(
        host: fake()->domainName(),
        username: fake()->userName(),
        password: EncryptableText::make(fake()->password()),
    ),
]);

it('can build a disk', function (DiskConfig $config) {
    $model = ModelWithDisk::factory()->create();
    $modelDisk = Mockery::mock(ModelDisk::class);
    $pendingModelDisk = new PendingDisk($model, new $modelDisk);
    $pendingModelDisk->disk($config);
    $pendingModelDisk->save();

    expect($pendingModelDisk->build())->toBeInstanceOf(Filesystem::class);
})->with([
    'local' => fn () => new LocalConfig(root: storage_path('app/test')),
]);
/*
it('can instantiate config', function () {
    $config = new FtpConfig(
        host: fake()->domainName(),
        username: fake()->userName(),
        password: EncryptableText::make(fake()->password()),
    );
});
//*/
