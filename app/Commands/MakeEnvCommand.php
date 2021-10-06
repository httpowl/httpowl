<?php

namespace App\Commands;

use App\Classes\Emoji;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use LaravelZero\Framework\Commands\Command;

class MakeEnvCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:env {name}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Creates enw env file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $envFolder = config('owl.env_folder');
        if (!Storage::exists($envFolder)) {
            $this->error('Env folder not exists. Run "owl init" first');
            return 1;
        }

        $envFile = $envFolder.'/'.$this->argument('name').'.json';
        if (File::exists($envFile)) {
            $this->error('Env file already exists');
            return 1;
        }

        File::copy('stubs/env.stub', $envFile);
        $this->info(Emoji::CHECK.' Env file created');

        return 0;
    }
}
