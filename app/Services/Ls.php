<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class Ls extends Base implements Runnable
{
    public function run()
    {
        $collections = Storage::files(config('owl.base_folder'));

        if (!$collections) {
            $this->context->info('No collection found. Run "owl make:collection <name>" to create');
            return ;
        }

        foreach ($collections as $collection) {
            $this->context->info(pathinfo($collection, PATHINFO_FILENAME));
        }
    }
}
