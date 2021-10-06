<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class RunCommand extends Command
{
    protected $signature = 'run {collection:action?} {action?}
        {--headers: Show only response headers}
        {--body: Show only response body}
        {--status: Show only response status code}
        {--env: Env file to use}
    ';

    protected $description = 'List methods, make http requests';

    public function handle(): int
    {
        (new \App\Services\Request($this))->run();

        return 0;
    }
}
