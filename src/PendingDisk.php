<?php

namespace IBroStudio\ModelDisk;

use IBroStudio\ModelDisk\Contracts\DiskConfig;
use IBroStudio\ModelDisk\Contracts\ModelWithDisk;
use IBroStudio\ModelDisk\Enums\DiskDriver;
use IBroStudio\ModelDisk\ValueObjects\Disk;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class PendingDisk
{
    protected Disk $disk;

    public function __construct(
        protected ModelWithDisk $model,
        protected ModelDisk $modelDisk
    ) {
    }

    public function disk(DiskConfig $config): self
    {
        $this->disk = new Disk(
            driver: DiskDriver::fromKey($config->driver),
            config: $config
        );

        return $this;
    }

    public function driver(): DiskDriver
    {
        return $this->disk->driver();
    }

    public function build(): Filesystem
    {
        $disk = $this->model->data_repository(Disk::class)->values();

        return Storage::build(
            $disk->config()
                ->convertValueObjects()
                ->toArray()
        );
    }

    public function save(): Disk
    {
        $this->model->data_repository()->add($this->disk);

        return $this->disk;
    }
}
