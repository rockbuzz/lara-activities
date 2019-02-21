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
            __DIR__ . '/../config/laravel-activities.php' => config_path('laravel-activities')
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-activities.php', 'laravel-activities');
    }
}