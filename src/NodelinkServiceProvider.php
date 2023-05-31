<?php

namespace Singlephon\Nodelink;

use Illuminate\Support\ServiceProvider;
use Singlephon\Nodelink\Commands\CreateServiceRequestCommand;
use Singlephon\Nodelink\Commands\RegisterNodeCommand;

class NodelinkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if (file_exists($file = __DIR__ . '/Helpers/service_helpers.php')) {
            require_once $file;
        }
        if (file_exists($file = __DIR__ . '/Helpers/http_common_status.php')) {
            require_once $file;
        }

        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'nodelink');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'nodelink');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
         $this->loadRoutesFrom(__DIR__.'/Routes/routes.php');


        if ($this->app->runningInConsole()) {
//            $this->publishes([
//                __DIR__.'/../config/config.php' => config_path('nodelink.php'),
//            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/nodelink'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/nodelink'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/nodelink'),
            ], 'lang');*/

            // Registering package commands.
             $this->registerCommands();
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'nodelink');

        // Register the main class to use with the facade
        $this->app->singleton('nodelink', function () {
            return new Nodelink;
        });
    }


    protected function registerCommands(): void
    {
        $this->commands([
            CreateServiceRequestCommand::class
        ]);
    }
}
