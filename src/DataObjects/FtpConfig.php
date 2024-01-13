<?php

namespace IBroStudio\ModelDisk\DataObjects;

use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use IBroStudio\ModelDisk\Contracts\DiskConfig;
use IBroStudio\ModelDisk\Enums\DiskDriver;
use Spatie\LaravelData\Data;

class FtpConfig extends Data implements DiskConfig
{
    public string $driver;

    public function __construct(
        public string $host,
        public string $username,
        public EncryptableText $password,
        // Optional FTP Settings...
        public int $port = 21,
        public string $root = '',
        public bool $passive = true,
        public bool $ssl = true,
        public int $timeout = 30
    ) {
        $this->driver = DiskDriver::ftp;
    }

    public static function fromDataObjectModel(DataObject $dataObject): self
    {
        return new self(

        );
    }
}
