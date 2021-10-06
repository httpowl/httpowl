<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Init extends Base implements Runnable
{
    public function run()
    {
        $owlBaseFolder = config('owl.base_folder');
        if (!Storage::exists($owlBaseFolder)) {
            File::makeDirectory($owlBaseFolder);
        }

        $envFolder = config('owl.env_folder');
        if (!Storage::exists($envFolder)) {
            File::makeDirectory($envFolder);
        }

        $defaultEnvFile = config('owl.default_env_file');
        if (!File::exists($defaultEnvFile)) {
            File::copy('stubs/env.stub', $defaultEnvFile);
        }
    }
}
