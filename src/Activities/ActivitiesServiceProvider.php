<?php

namespace Phwebs\Activities;

use Illuminate\Support\ServiceProvider;

class ActivitiesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../config/activities.php' => config_path('activities.php')
        ], 'config');
    }

    public function register()
    {
        $this->app->bind(Activities::class);

        $this->mergeConfigFrom(__DIR__ . '/../config/activities.php', 'activities');
    }
}