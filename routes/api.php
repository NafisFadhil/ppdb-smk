<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/reset/{type}', function($type) {
//     Artisan::call($type.':clear');
//     Artisan::call($type.':cache');
//     return 'OK';
// });

Route::get('/remigrate', function() {
    Artisan::call('migrate:fresh --seed');
    return 'OK';
});

// Route::get('/remigrate', function() {
//     Artisan::call('migrate:fresh --seed');
//     return 'OK';
// });

Route::get('/optimize', function() {
    Artisan::call('optimize:clear');
    Artisan::call('optimize');
    Artisan::call('view:cache');
    return 'SUCCESS';
});

Route::get('/repull', function() {
    $path = base_path();
    exec('cd '.$path.' && git pull');
    return 'SUCCESS';
});

Route::get('/renew', function() {
    $path = base_path();
    exec('cd '.$path.' && git pull');
    Artisan::call('optimize:clear');
    Artisan::call('optimize');
    Artisan::call('view:cache');
    return 'SUCCESS';
});

// Route::get('/run-production', function() {
//     Artisan::call('config:clear');
//     Artisan::call('config:cache');
//     Artisan::call('view:clear');
//     Artisan::call('view:cache');
//     return 'OK';
// });