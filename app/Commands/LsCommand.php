<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class LsCommand extends Command
{
    protected $signature = 'ls';

    protected $description = 'List collections';

    public function handle(): int
    {
        (new \App\Services\Ls($this))->run();

        return 0;
    }
}
