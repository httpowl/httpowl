<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class MakeCollection extends Base implements Runnable
{
    public function run()
    {
        if ($this->collectionFileExists($this->context->argument('name'))) {
            $this->context->error('Collection file already exists');
            return ;
        }

        $this->createCollectionFile($this->context->argument('name'));
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
