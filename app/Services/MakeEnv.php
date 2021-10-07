<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class MakeEnv extends Base implements Runnable
{
    public function run()
    {
        if ($this->envFileExists($this->context->argument('name'))) {
            $this->context->error('Env file already exists');
            exit(1);
        }

        $this->createEnvFile($this->context->argument('name'));
    }

    private function envFileExists($envFile): bool
    {
        return File::exists(
            config('owl.env_folder')."/$envFile.json"
        );
    }

    private function createEnvFile($filename)
    {
        File::copy(
            'stubs/env.stub',
            config('owl.env_folder')."/{$filename}.json"
        );
    }
}
