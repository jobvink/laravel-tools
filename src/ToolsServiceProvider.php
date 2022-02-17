<?php

namespace jobvink\tools;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use jobvink\tools\Events\UserRegistered;
use jobvink\tools\Listeners\SendUserRegisteredNotification;

class ToolsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/fortify.php', 'fortify'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'tools');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        Event::listen(
            UserRegistered::class,
            [SendUserRegisteredNotification::class, 'handle']
        );

    }

}