<?php

namespace IBroStudio\ModelDisk\Tests\Support\Models;

use IBroStudio\DataRepository\Concerns\HasDataRepository;
use IBroStudio\ModelDisk\Concerns\HasDisks;
use IBroStudio\ModelDisk\Enums\DiskDriver;
use IBroStudio\ModelDisk\Tests\Support\Database\Factory\ModelWithDiskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelWithDisk extends Model implements \IBroStudio\ModelDisk\Contracts\ModelWithDisk
{
    use HasDataRepository;
    use HasDisks;
    use HasFactory;

    protected $fillable = [
        'name',
        'disk_driver',
    ];

    protected $casts = [
        'disk_driver' => DiskDriver::class,
    ];

    protected static function newFactory()
    {
        return ModelWithDiskFactory::new();
    }
}
