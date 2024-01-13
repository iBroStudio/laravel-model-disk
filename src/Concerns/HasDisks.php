<?php

namespace IBroStudio\ModelDisk\Concerns;

use IBroStudio\ModelDisk\Contracts\DiskConfig;
use IBroStudio\ModelDisk\Facades\ModelDisk;
use IBroStudio\ModelDisk\PendingDisk;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

trait HasDisks
{
    private ?PendingDisk $pendingDisk = null;

    public static function bootHasDisks(): void
    {
        static::saving(function (Model $model) {
            $model->setRawAttributes(Arr::except($model->getAttributes(), 'disk'));
        });

        static::saved(function (Model $model) {
            if ($model->pendingDisk) {
                $disk = $model->pendingDisk->save();
                $model->pendingDisk = null;
                $model->update(['disk_driver' => $disk->driver()]);
            }
        });
    }

    public function disk(): Attribute
    {
        return Attribute::make(
            get: fn () => ModelDisk::for($this)->build(),
            set: fn (DiskConfig $diskConfig) => $this->pendingDisk = ModelDisk::for($this)->disk($diskConfig),
        );
    }
}
