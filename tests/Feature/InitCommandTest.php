<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

test('init command', function () {
    exec('rm -rf .owl-test'); // delete folder if exists!

    $this->artisan('init')
        ->expectsOutput('You are ready to go '.\App\Classes\Emoji::ROCKET)
        ->assertExitCode(0);

    expect(Storage::exists(config('owl.base_folder')))->toBe(true);
    expect(Storage::exists(config('owl.env_folder')))->toBe(true);
    expect(File::exists(config('owl.default_env_file')))->toBe(true);
});
