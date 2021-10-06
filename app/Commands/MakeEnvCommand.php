<?php

namespace App\Commands;

use App\Classes\Emoji;
use LaravelZero\Framework\Commands\Command;

class MakeEnvCommand extends Command
{
    protected $signature = 'make:env {name}';

    protected $description = 'Create new env file';

    public function handle(): int
    {
        (new \App\Services\MakeEnv($this))->run();

        $this->info(Emoji::CHECK.' Env file created');
        return 0;
    }
}
