<?php

namespace App\Commands;

use App\Classes\Emoji;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class MakeEnvCommand extends Command
{
    protected $signature = 'make:env {name}';

    protected $description = 'Creates new new file';

    public function handle(): int
    {
        if ($this->envFileExists($this->argument('name'))) {
            $this->error('Env file already exists');
            return 1;
        }

        $this->createEnvFile($this->argument('name'));

        $this->info(Emoji::CHECK.' Env file created');

        return 0;
    }

    protected function envFileExists($envFile): bool
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
