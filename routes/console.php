<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('rhmi:check', function () {
    $checks = [];

    try {
        \Illuminate\Support\Facades\DB::select('select 1');
        $checks['Database'] = true;
    } catch (\Throwable $exception) {
        $checks['Database'] = false;
        $this->error('Database: '.$exception->getMessage());
    }

    try {
        $key = 'rhmi:health:'.bin2hex(random_bytes(4));
        \Illuminate\Support\Facades\Cache::put($key, 'ok', 10);
        $checks['Cache'] = \Illuminate\Support\Facades\Cache::get($key) === 'ok';
        \Illuminate\Support\Facades\Cache::forget($key);
    } catch (\Throwable $exception) {
        $checks['Cache'] = false;
        $this->error('Cache: '.$exception->getMessage());
    }

    $checks['APP_KEY'] = filled(config('app.key'));
    $checks['Production debug disabled'] = ! app()->isProduction() || ! config('app.debug');
    $checks['Storage writable'] = is_writable(storage_path()) && is_writable(base_path('bootstrap/cache'));
    $checks['Public storage link'] = is_link(public_path('storage')) || file_exists(public_path('storage'));

    foreach ($checks as $name => $passed) {
        $this->line(($passed ? '<info>PASS</info>' : '<error>FAIL</error>').'  '.$name);
    }

    return in_array(false, $checks, true) ? self::FAILURE : self::SUCCESS;
})->purpose('Check the RHMI production environment');
