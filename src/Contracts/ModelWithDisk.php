<?php

namespace IBroStudio\ModelDisk\Contracts;

use IBroStudio\DataRepository\Relations\MorphManyDataObjects;
use Illuminate\Contracts\Filesystem\Filesystem;

interface ModelWithDisk
{
    //public function disk(DiskData $diskData): Filesystem;
    //public function disk();

    public function data_repository(?string $dataClass = null, ?array $valuesQuery = null): MorphManyDataObjects;
}
