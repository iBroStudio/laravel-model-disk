<?php

use IBroStudio\ModelDisk\Facades\ModelDisk;
use IBroStudio\ModelDisk\PendingDisk;
use IBroStudio\ModelDisk\Tests\Support\Models\ModelWithDisk;

it('can instantiate PendingModelDisk for a model', function () {
    $model = ModelWithDisk::factory()->create();
    $instance = ModelDisk::for($model);
    expect($instance)->toBeInstanceOf(PendingDisk::class);
});
