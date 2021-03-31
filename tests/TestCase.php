<?php

namespace Tests;

use Carbon\Carbon;
use Rockbuzz\LaraActivities\ServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testing']);

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--path' => realpath(__DIR__ . '/../src/database/migrations'),
        ]);

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--path' => realpath(__DIR__ . '/database/migrations'),
        ]);

        $this->withFactories(__DIR__ . '/database/factories');
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
    }

    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function knownDate(
        $year = '2030',
        $month = '12',
        $day = '30',
        $hour = '00',
        $minutes = '00',
        $second = '00'
    ): Carbon {
        $knownDate = Carbon::create(
            $year,
            $month,
            $day,
            $hour,
            $minutes,
            $second
        );

        Carbon::setTestNow($knownDate);

        return $knownDate;
    }
}
