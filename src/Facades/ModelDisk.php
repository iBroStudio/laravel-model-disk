<?php

namespace IBroStudio\ModelDisk\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \IBroStudio\ModelDisk\ModelDisk
 */
class ModelDisk extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \IBroStudio\ModelDisk\ModelDisk::class;
    }
}
