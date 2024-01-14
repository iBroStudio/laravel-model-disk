<?php

use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\ValueObjects\Authentication\S3Authentication;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use IBroStudio\ModelDisk\Contracts\DiskConfig;
use IBroStudio\ModelDisk\DataObjects\S3Config;
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
})->with('disk-drivers');

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

    expect($dataFromRepository->first())->toBeInstanceOf(DataObject::class)
        ->and($dataFromRepository->values())->toEqual($disk);
})->with('disk-drivers');

it('can build a disk', function (DiskConfig $config) {
    $model = ModelWithDisk::factory()->create();
    $modelDisk = Mockery::mock(ModelDisk::class);
    $pendingModelDisk = new PendingDisk($model, new $modelDisk);
    $pendingModelDisk->disk($config);
    $pendingModelDisk->save();

    expect($pendingModelDisk->build())->toBeInstanceOf(Filesystem::class);
})->with('disk-drivers');

/*
it('can instantiate config', function () {

    $config = new S3Config(
        authentication: S3Authentication::make(
            key: fake()->uuid(),
            secret: EncryptableText::make(fake()->password())
        ),
        region: fake()->word(),
        bucket: fake()->word(),
        url: fake()->url()
    );
    dd($config);
});
//*/
