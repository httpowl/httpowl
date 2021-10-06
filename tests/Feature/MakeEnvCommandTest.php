<?php

use Illuminate\Support\Facades\File;

test('make:env command', function () {
    $fileName = 'test-pest';

    $this->artisan("make:env {$fileName}")
        ->expectsOutput(\App\Classes\Emoji::CHECK.' Env file created')
        ->assertExitCode(0);

    expect(File::exists(config('owl.env_folder')."/{$fileName}.json"))->toBe(true);
});
