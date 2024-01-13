<?php

namespace IBroStudio\ModelDisk\ValueObjects;

use IBroStudio\ModelDisk\Contracts\DiskConfig;
use IBroStudio\ModelDisk\Enums\DiskDriver;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

final class Disk extends ValueObject
{
    private DiskDriver $driver;

    private DiskConfig $config;

    public function __construct(DiskDriver|string $driver, DiskConfig|array $config)
    {
        if (isset($this->driver)
            || isset($this->config)
        ) {
            throw new InvalidArgumentException(self::IMMUTABLE_MESSAGE);
        }

        if (! $driver instanceof DiskDriver) {
            $driver = DiskDriver::fromKey($driver);
        }

        if (! $config instanceof DiskConfig) {
            $config = $driver->load($config);
        }

        $this->driver = $driver;
        $this->config = $config;
    }

    public function value(): string
    {
        return $this->driver->value;
    }

    public function driver(): DiskDriver
    {
        return $this->driver;
    }

    public function config(): DiskConfig
    {
        return $this->config;
    }

    public function toArray(): array
    {
        return [
            'driver' => $this->driver,
            'config' => $this->config,
        ];
    }
}
