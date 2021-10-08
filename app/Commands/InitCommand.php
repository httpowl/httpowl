<?php

namespace App\Commands;

use App\Classes\Emoji;
use LaravelZero\Framework\Commands\Command;

class InitCommand extends Command
{
    protected $signature = 'init';

    protected $description = 'Initialize default files and folders';

    public function handle(): int
    {
        (new \App\Services\Init($this))->run();

        $this->info('You are ready to go ' . Emoji::ROCKET);
        return 0;
    }
}
