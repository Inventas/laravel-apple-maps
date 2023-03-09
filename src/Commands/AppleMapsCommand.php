<?php

namespace Inventas\AppleMaps\Commands;

use Illuminate\Console\Command;

class AppleMapsCommand extends Command
{
    public $signature = 'laravel-apple-maps';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
