<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {

            View::share('config_helpers', new \App\Helpers\Config());
            
        } catch (\Throwable $th) {
            echo 'Error happen in AppServiceProvider';
        }
    }
}
