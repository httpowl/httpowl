<?php

namespace App\Commands;

use App\Classes\Emoji;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class MakeCollectionCommand extends Command
{
    protected $signature = 'make:collection {name}';

    protected $description = 'Creates new collection file';

    public function handle(): int
    {
        if ($this->collectionFileExists($this->argument('name'))) {
            $this->error('Collection file already exists');
            return 1;
        }

        $this->createCollectionFile($this->argument('name'));

        $this->info(Emoji::CHECK.' Collection file created');

        return 0;
    }

    protected function collectionFileExists($collectionFile): bool
    {
        return File::exists(
            config('owl.base_folder')."/$collectionFile.json"
        );
    }

    private function createCollectionFile($filename)
    {
        File::copy(
            'stubs/collection.stub',
            config('owl.base_folder')."/{$filename}.json"
        );
    }
}
