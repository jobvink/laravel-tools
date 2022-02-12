<?php

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use Illuminate\Support\Facades\Route;
use jobvink\tools\Http\Controllers\Auth\AuthenticatedSessionController;
use jobvink\tools\Http\Controllers\Auth\ConfirmablePasswordController;
use jobvink\tools\Http\Controllers\Auth\EmailVerificationNotificationController;
use jobvink\tools\Http\Controllers\Auth\EmailVerificationPromptController;
use jobvink\tools\Http\Controllers\Auth\RegisterController;
use jobvink\tools\Http\Controllers\Auth\RegisteredUserController;
use jobvink\tools\Http\Controllers\Auth\VerifyEmailController;

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('auth')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('auth');


Route::get('/complete-registration/password/{id}/{hash}', [RegisteredUserController::class, 'register'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('register.complete');

Route::post('/complete-registration/password/{id}/{hash}', [RegisteredUserController::class, 'completeRegistration'])
    ->middleware(['throttle:6,1'])
    ->name('register.completed');

Route::get('/complete-registration/2fa/{id}/{hash}', [RegisteredUserController::class, 'twoFactorAuthentication'])
    ->middleware(['throttle:6,1'])
    ->name('register.2fa');

Route::post('/complete-registration/2fa/{id}/{hash}', [RegisteredUserController::class, 'done'])
    ->middleware(['throttle:6,1'])
    ->name('register.done');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/2fa', function () {
    return redirect(URL()->previous());
})->middleware('2fa')->name('2fa');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware('auth')
    ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware('auth');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');