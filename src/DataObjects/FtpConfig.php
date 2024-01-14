<?php

namespace IBroStudio\ModelDisk\DataObjects;

use IBroStudio\DataRepository\DataObjects\DataRepository;
use IBroStudio\DataRepository\ValueObjects\Authentication\BasicAuthentication;
use IBroStudio\ModelDisk\Contracts\DiskConfig;
use IBroStudio\ModelDisk\Enums\DiskDriver;

class FtpConfig extends DataRepository implements DiskConfig
{
    public string $driver;

    public function __construct(
        public string $host,
        public BasicAuthentication $authentication,
        // Optional FTP Settings...
        public int $port = 21,
        public string $root = '',
        public bool $passive = true,
        public bool $ssl = true,
        public int $timeout = 30
    ) {
        $this->driver = DiskDriver::ftp;
    }
}
