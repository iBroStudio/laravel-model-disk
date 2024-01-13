<?php

namespace IBroStudio\ModelDisk\DataObjects;

use IBroStudio\ModelDisk\Contracts\DiskConfig;
use IBroStudio\ModelDisk\Enums\DiskDriver;
use League\Flysystem\Visibility;
use Spatie\LaravelData\Data;

class LocalConfig extends Data implements DiskConfig
{
    public string $driver;

    public function __construct(
        public string $root,
        public string $url = '',
        public string $visibility = Visibility::PRIVATE,
        public bool $throw = false
    ) {
        $this->driver = DiskDriver::local;
    }
}
