<?php

namespace N7olkachev\RouteHelpers;

use Illuminate\Support\ServiceProvider;

class RouteHelpersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/route-helpers.php' => config_path('route-helpers.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/route-helpers.php', 'backup');

        $this->commands([
            RouteHelpers::class,
        ]);
    }
}