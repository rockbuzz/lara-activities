<?php

namespace Phwebs\Activities\Test;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Phwebs\Activities\ActivitiesServiceProvider;

class TestCase extends OrchestraTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testing']);

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--path' => realpath(__DIR__ . '/../src/database/migrations'),
        ]);

        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--path' => realpath(__DIR__ . '/migrations'),
        ]);
    }


    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
    }


    protected function getPackageProviders($app)
    {
        return [ActivitiesServiceProvider::class];
    }
}