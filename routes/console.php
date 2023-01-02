<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('refresh', function () {
    $path = base_path();
    Artisan::call('down');
    exec('cd '.$path.' && git stash && git pull && rm -f .env && cp ../ppdb-smk-backup/.env .env');
    Artisan::call('optimize:clear');
    Artisan::call('optimize');
    Artisan::call('up');
});
