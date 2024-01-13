<?php

namespace IBroStudio\ModelDisk\DataObjects;

use IBroStudio\ModelDisk\Contracts\DiskConfig;
use IBroStudio\ModelDisk\Enums\DiskDriver;
use Spatie\LaravelData\Data;

class S3Config extends Data implements DiskConfig
{
    public string $driver;

    public function __construct(
        public string $key,
        public string $secret,
        public string $region,
        public string $bucket,
        public string $url,
        public string $endpoint,
        public bool $use_path_style_endpoint = false,
        public bool $throw = false
    ) {
        $this->driver = DiskDriver::s3;
    }
}
