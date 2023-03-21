<?php

namespace Mohamedahmed01\FeatureFlag\Tests;

use Mohamedahmed01\FeatureFlag\FeatureFlagServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan(
            'migrate',
            ['--database' => 'testbench']
        )->run();
    }

    protected function getPackageProviders($app)
    {
        return [
            FeatureFlagServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => 'database/database.sqlite',
            'prefix' => '',
        ]);
    }
}