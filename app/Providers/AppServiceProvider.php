<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\SiteSetting;
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
        view()->composer('*', function($view){
            $view->with('site_settings', SiteSetting::first());
        });
    }
}
