<?php

namespace IBroStudio\ModelDisk\DataObjects;

use IBroStudio\DataRepository\DataObjects\DataRepository;
use IBroStudio\DataRepository\ValueObjects\Authentication\S3Authentication;
use IBroStudio\ModelDisk\Contracts\DiskConfig;
use IBroStudio\ModelDisk\Enums\DiskDriver;

class S3Config extends DataRepository implements DiskConfig
{
    public string $driver;

    public function __construct(
        public S3Authentication $authentication,
        public string $region,
        public string $bucket,
        public string $url,
        public string $endpoint = '',
        public bool $use_path_style_endpoint = false,
        public bool $throw = false
    ) {
        $this->driver = DiskDriver::s3;
    }
}
