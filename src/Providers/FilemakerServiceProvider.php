<?php

namespace EquineSolutions\IOCFilemaker\Providers;

use Illuminate\Support\ServiceProvider;

class FilemakerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/filemaker.php', 'filemaker');
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
            __DIR__ . '/../config/ioc-filemaker.php' => config_path('filemaker.php'),
        ], 'resource');
    }
}
