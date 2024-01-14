<?php

use IBroStudio\DataRepository\ValueObjects\Authentication\BasicAuthentication;
use IBroStudio\DataRepository\ValueObjects\Authentication\S3Authentication;
use IBroStudio\DataRepository\ValueObjects\Authentication\SshAuthentication;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use IBroStudio\ModelDisk\DataObjects\FtpConfig;
use IBroStudio\ModelDisk\DataObjects\LocalConfig;
use IBroStudio\ModelDisk\DataObjects\S3Config;
use IBroStudio\ModelDisk\DataObjects\SftpConfig;
use Illuminate\Support\Arr;

$filters = [];
$drivers = collect([
    'local' => fn () => new LocalConfig(root: storage_path('app/test')),
    'ftp' => fn () => new FtpConfig(
        host: fake()->domainName(),
        authentication: BasicAuthentication::make(
            username: fake()->userName(),
            password: EncryptableText::make(fake()->password()),
        )
    ),
    'sftp-basic' => fn () => new SftpConfig(
        host: fake()->domainName(),
        authentication: BasicAuthentication::make(
            username: fake()->userName(),
            password: EncryptableText::make(fake()->password()),
        )
    ),
    'sftp-ssh' => fn () => new SftpConfig(
        host: fake()->domainName(),
        authentication: SshAuthentication::make(
            username: fake()->userName(),
            privateKey: EncryptableText::make(fake()->macAddress()),
            passphrase: EncryptableText::make(fake()->password()),
        )
    ),
    's3' => fn () => new S3Config(
        authentication: S3Authentication::make(
            key: fake()->uuid(),
            secret: EncryptableText::make(fake()->password())
        ),
        region: fake()->word(),
        bucket: fake()->word(),
        url: fake()->url()
    ),
]);

$filtered = $drivers->filter(function (Closure $config, string $driver) use ($filters) {
    if (count($filters)) {
        return Arr::exists(array_flip($filters), $driver);
    }

    return true;
});
//dd($filtered->toArray());
dataset('disk-drivers', $filtered->toArray());
