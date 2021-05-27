<?php

namespace App\Providers;

use Appus\Admin\Services\Admin\Facades\Admin;
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
        Admin::css([
            '/css/main.css',
        ]);
    }
}
