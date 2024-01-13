<?php

namespace IBroStudio\ModelDisk;

use IBroStudio\ModelDisk\Contracts\ModelWithDisk;

class ModelDisk
{
    public function for(ModelWithDisk $model): PendingDisk
    {
        return new PendingDisk($model, $this);
    }
}
