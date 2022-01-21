<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * singleton binding so that, there is only one instance throughout the application
         */
        $this->app->singleton('App\Repositories\Car\CarRepositoryInterface', 'App\Repositories\Car\CarRepository');
        $this->app->singleton('App\Repositories\User\UserRepositoryInterface', 'App\Repositories\User\UserRepository');
    }
}
