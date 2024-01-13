<?php

namespace IBroStudio\ModelDisk\Commands;

use Illuminate\Console\Command;

class ModelDiskCommand extends Command
{
    public $signature = 'laravel-model-disk';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
