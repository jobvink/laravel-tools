<?php

namespace jobvink\tools;

use Illuminate\Support\ServiceProvider;

class ToolsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'tools');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

    }

}