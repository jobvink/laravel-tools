<?php

namespace jobvink\tools\Providers;

use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Route;
use jobvink\tools\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use jobvink\tools\Actions\Fortify\ResetUserPassword;
use jobvink\tools\Actions\Fortify\UpdateUserPassword;
use jobvink\tools\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Fortify::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Fortify::createUsersUsing(CreateNewUser::class);
//        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
//        Fortify::confirmPasswordsUsing();

        RateLimiter::for('login', function (Request $request) {
            $email = (string)$request->email;

            return Limit::perMinute(5)->by($email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateThrough(function (Request $request) {
            return array_filter([
                config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
                Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class,
            ]);
        });

        Fortify::loginView(function () {
            return view('tools::auth.login');
        });

        Fortify::registerView(function () {
            return view('tools::auth.register');
        });

        Fortify::twoFactorChallengeView(function () {
            return view('tools::auth.code');
        });

        Fortify::confirmPasswordView(function () {
            return view('tools::auth.confirm-password');
        });

        $this->configureRoutes();
    }

    /**
     * Configure the routes offered by the application.
     *
     * @return void
     */
    protected function configureRoutes()
    {
        Route::group([
            'namespace' => 'Laravel\Fortify\Http\Controllers',
            'domain' => config('fortify.domain', null),
            'prefix' => config('fortify.prefix'),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/fortify.php');
        });
    }
}
