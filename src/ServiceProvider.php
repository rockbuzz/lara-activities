<?php

namespace Rockbuzz\LaraActivities;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider as SupportServiceProvider;
use Rockbuzz\LaraActivities\Console\PruneCommand;

class ServiceProvider extends SupportServiceProvider
{
    public function boot(Filesystem $filesystem)
    {
        $projectPath = database_path('migrations') . '/';
        $localPath = __DIR__ . '/../database/migrations/';

        if (! $this->hasMigrationInProject($projectPath, $filesystem)) {
            $this->loadMigrationsFrom($localPath . '2019_02_21_000000_create_activities_table.php');

            $this->publishes([
                $localPath . '2019_02_21_000000_create_activities_table.php' =>
                    $projectPath . now()->format('Y_m_d_his') . '_create_activities_table.php'
            ], 'migrations');
        }

        $this->publishes([
            __DIR__ . '/../config/activities.php' => config_path('activities.php')
        ], 'config');

        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->loadViewsFrom(__DIR__.'/views', 'activities');

        $this->loadTranslationsFrom(__DIR__.'/lang', 'activities');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/activities'),
        ], 'views');

        $this->publishes([
            __DIR__.'/lang' => resource_path('lang/vendor/activities'),
        ], 'lang');

        if ($this->app->runningInConsole()) {
            $this->commands([PruneCommand::class]);
        }
    }

    public function register()
    {
        $this->app->bind(Activities::class);

        $this->mergeConfigFrom(__DIR__ . '/../config/activities.php', 'activities');
    }

    private function hasMigrationInProject(string $path, Filesystem $filesystem)
    {
        return count($filesystem->glob($path . '*_create_activities_table.php')) > 0;
    }
}
