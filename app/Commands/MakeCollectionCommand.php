<?php

namespace App\Commands;

use App\Classes\Emoji;
use LaravelZero\Framework\Commands\Command;

class MakeCollectionCommand extends Command
{
    protected $signature = 'make:collection {name}';

    protected $description = 'Creates new collection file';

    public function handle(): int
    {
        (new \App\Services\MakeCollection($this))->run();

        $this->info(Emoji::CHECK . ' Collection file created');
        return 0;
    }
}
