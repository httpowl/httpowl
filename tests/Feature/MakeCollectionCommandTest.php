<?php

use Illuminate\Support\Facades\File;

test('make:collection command', function () {
    $fileName = 'test-pest';

    $this->artisan("make:collection {$fileName}")
        ->expectsOutput(\App\Classes\Emoji::CHECK.' Collection file created')
        ->assertExitCode(0);

    expect(File::exists(config('owl.base_folder')."/{$fileName}.json"))->toBe(true);
});
