<?php

namespace Mohamedahmed01\FeatureFlag;

use Illuminate\Support\ServiceProvider;
use Mohamedahmed01\FeatureFlag\Models\RedisFeatureFlag;
use Mohamedahmed01\FeatureFlag\Models\EloquentFeatureFlag;
use Mohamedahmed01\FeatureFlag\Interfaces\FeatureFlagInterface;
use Mohamedahmed01\FeatureFlag\Console\ManageFeatureFlagsCommand;

class FeatureFlagServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/config/config.php' => config_path('feature-flag.php'),
            ], 'config');

            // Registering package commands.
            $this->commands([ManageFeatureFlagsCommand::class]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'feature-flag');

        // Register the main class to use with the facade
        $this->app->bind(FeatureFlagInterface::class, function ($app) {
            $implementation = config('feature_flag.driver');

            switch ($implementation) {
                case 'eloquent':
                    return new EloquentFeatureFlag();
                case 'default':
                default:
                    return new EloquentFeatureFlag();
            }
        });
    }
}