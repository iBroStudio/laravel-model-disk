<?php

namespace IBroStudio\ModelDisk\Enums;

use BenSampo\Enum\Enum;
use IBroStudio\ModelDisk\Contracts\DiskConfig;
use IBroStudio\ModelDisk\DataObjects\FtpConfig;
use IBroStudio\ModelDisk\DataObjects\LocalConfig;
use IBroStudio\ModelDisk\DataObjects\S3Config;
use IBroStudio\ModelDisk\DataObjects\SftpConfig;

final class DiskDriver extends Enum
{
    const local = 'local';

    const ftp = 'ftp';

    const sftp = 'sftp';

    const s3 = 's3';

    public function load(array $config): DiskConfig
    {
        return match ($this->value) {
            self::local => LocalConfig::from($config),
            self::ftp => FtpConfig::from($config),
            self::sftp => SftpConfig::from($config),
            self::s3 => S3Config::from($config),
            default => throw new \Exception('Driver without config class'),
        };
    }
}
