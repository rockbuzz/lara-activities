<?php

namespace Rockbuzz\LaraActivities;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider
{
    public function boot(Filesystem $filesystem)
    {
        $projectPath = database_path('migrations') . '/';
        $localPath = __DIR__ . '/database/migrations/';

        if (! $this->hasMigrationInProject($projectPath, $filesystem)) {
            $this->loadMigrationsFrom($localPath . '2019_02_21_000000_create_activities_table.php.stub');

            $this->publishes([
                $localPath . '2019_02_21_000000_create_activities_table.php.stub' =>
                    $projectPath . now()->format('Y_m_d_his') . '_create_activities_table.php'
            ], 'migrations');
        }

        $this->publishes([
            __DIR__ . '/config/activities.php' => config_path('activities.php')
        ], 'config'); 

        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->loadViewsFrom(__DIR__.'/views', 'activities');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/activities'),
        ], 'views');
    }

    public function register()
    {
        $this->app->bind(Activities::class);

        $this->mergeConfigFrom(__DIR__ . '/config/activities.php', 'activities');
    }

    private function hasMigrationInProject(string $path, Filesystem $filesystem)
    {
        return count($filesystem->glob($path . '*_create_activities_table.php')) > 0;
    }
}
