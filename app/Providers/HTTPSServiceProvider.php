<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use URL;

class HTTPSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->app['request']->server->set('HTTPS', true);
//        URL::forceScheme('https');
    }
}
