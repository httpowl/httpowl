<?php

namespace App\Commands;

use App\Classes\Emoji;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use LaravelZero\Framework\Commands\Command;

class InitCommand extends Command
{
    protected $signature = 'init';

    protected $description = 'Initialize default files and folders';

    public function handle(): int
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

        $this->info('You are ready to go '.Emoji::ROCKET);

        return 0;
    }
}
