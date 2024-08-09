<?php

namespace Mohamedahmed01\FeatureFlag;

use Illuminate\Support\ServiceProvider;
use Mohamedahmed01\FeatureFlag\Models\RedisFeatureFlag;
use Mohamedahmed01\FeatureFlag\Models\EloquentFeatureFlag;
use Mohamedahmed01\FeatureFlag\Interfaces\FeatureFlagInterface;
use Mohamedahmed01\FeatureFlag\Console\ManageFeatureFlagsCommand;
use Illuminate\Support\Facades\Route;

class FeatureFlagServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Handle publishing and commands if running in console
        if ($this->app->runningInConsole()) {
            $this->publishConfig();
            $this->publishResources();
            $this->registerCommands();
        }

        $this->loadResources();
    }

    protected function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/config/config.php' => config_path('feature-flag.php'),
        ], 'config');
    }

    protected function publishResources()
    {
        $this->publishes([
            __DIR__ . '/Http/Controllers' => app_path('Http/Controllers/FeatureFlag'),
        ], 'controllers');

        $this->publishes([
            __DIR__ . '/routes/api.php' => base_path('routes/api-feature-flag.php'),
            __DIR__ . '/routes/web.php' => base_path('routes/web-feature-flag.php'),
        ], 'routes');

        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/feature-flag'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/database/factories' => database_path('factories'),
        ], 'feature-flag-factories');
    }

    protected function registerCommands()
    {
        $this->commands([
            ManageFeatureFlagsCommand::class,
        ]);
    }

    protected function loadResources()
    {
        if (config('feature-flag.load_routes', true)) {
            $this->loadRoutes();
        }

        if (config('feature-flag.load_views', true)) {
            $this->loadViews();
        }

        if (config('feature-flag.load_migrations', true)) {
            $this->loadMigrations();
            $this->loadLegacyFactories();
        }
    }

    protected function loadRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        Route::middleware('api')->prefix('api')->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        });
    }

    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'feature-flag');
    }

    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
    }

    protected function loadLegacyFactories()
    {
        $factory = $this->app->make(\Illuminate\Database\Eloquent\Factory::class);
        $factory->load(__DIR__.'/database/factories');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Merge package configuration
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'feature-flag');

        // Register the main class to use with the facade
        $this->app->bind(FeatureFlagInterface::class, function ($app) {
            $driver = config('feature-flag.driver', 'eloquent');

            switch ($driver) {
                case 'eloquent':
                default:
                    return new EloquentFeatureFlag();
            }
        });
    }
}
