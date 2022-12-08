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

Route::get('/reset/{type}', function($type) {
    Artisan::call($type.':clear');
    Artisan::call($type.':cache');
    return 'OK';
});

Route::get('/migrate', function() {
    Artisan::call('migrate:fresh --seed');
    return 'OK';
});

Route::get('/run-production', function() {
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('view:cache');
    Artisan::call('optimize:clear');
    Artisan::call('optimize');
    return 'OK';
});