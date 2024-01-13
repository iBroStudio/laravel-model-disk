<?php

namespace IBroStudio\ModelDisk\DataObjects;

use IBroStudio\ModelDisk\Contracts\DiskConfig;
use IBroStudio\ModelDisk\Enums\DiskDriver;
use League\Flysystem\Visibility;
use Spatie\LaravelData\Data;

class SftpConfig extends Data implements DiskConfig
{
    public string $driver;

    public function __construct(
        public string $host,
        // Settings for basic authentication...
        public string $username,
        public string $password,
        // Settings for SSH key based authentication with encryption password...
        public string $privateKey,
        //public string $passphrase,
        // Settings for file / directory permissions...
        public string $visibility = Visibility::PRIVATE,// `private` = 0600, `public` = 0644
        public string $directory_visibility = Visibility::PRIVATE,// `private` = 0700, `public` = 0755
        // Optional SFTP Settings...
        public string $hostFingerprint = '',
        public int $maxTries = 4,
        public string $passphrase = '',
        public int $port = 22,
        public string $root = '',
        public int $timeout = 30,
        public bool $useAgent = true,
    ) {
        $this->driver = DiskDriver::sftp;
    }
}
/*
    // Settings for SSH key based authentication with encryption password...
    'privateKey' => env('SFTP_PRIVATE_KEY'),
    'passphrase' => env('SFTP_PASSPHRASE'),

    // Settings for file / directory permissions...


],
*/
