<?php

namespace EquineSolutions\IOCFilemaker\Providers;

use Illuminate\Support\ServiceProvider;

class IOCFilemakerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/ioc-filemaker.php', 'ioc-filemaker');
        $this->mergeConfigFrom(__DIR__ . '/../../config/layouts/show.php', 'show');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();
        }
    }

    /**
     * Setup the resource publishing groups.
     */
    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config/ioc-filemaker.php' => config_path('ioc-filemaker.php'),
        ], 'resource');
    }
}
