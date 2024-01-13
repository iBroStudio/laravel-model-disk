<?php

namespace IBroStudio\ModelDisk\Tests\Support\Database\Factory;

use IBroStudio\ModelDisk\Enums\DiskDriver;
use IBroStudio\ModelDisk\Tests\Support\Models\ModelWithDisk;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModelWithDiskFactory extends Factory
{
    protected $model = ModelWithDisk::class;

    public function definition()
    {
        return [
            'name' => fake()->name(),
        ];
    }

    public function local(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'disk_driver' => DiskDriver::Local,
            ];
        });
    }

    public function ftp(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'disk_driver' => DiskDriver::Ftp,
            ];
        });
    }

    public function sftp(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'disk_driver' => DiskDriver::Sftp,
            ];
        });
    }

    public function s3(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'disk_driver' => DiskDriver::S3,
            ];
        });
    }
}
