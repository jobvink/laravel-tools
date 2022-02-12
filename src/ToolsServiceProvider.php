<?php

namespace jobvink\tools;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
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

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'tools');
        Route::group([
            'namespace' => 'tools',
            'middleware' => 'web',
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        });
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->mergeConfigFrom(
            __DIR__.'/config/google2fa.php', 'google2fa'
        );

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('2fa', \PragmaRX\Google2FALaravel\Middleware::class);

        Event::listen(
            UserRegistered::class,
            [SendUserRegisteredNotification::class, 'handle']
        );

    }

}