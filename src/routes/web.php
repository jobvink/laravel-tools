<?php

use Illuminate\Support\Facades\Route;
use jobvink\tools\Http\Controllers\Auth\RegisterController;

Route::group(['middleware' => ['fw-only-whitelisted', '2fa']], function () {

    Route::get('/complete-registration', [RegisterController::class, 'completeRegistration'])
        ->name('complete-registration');

    Route::post('/2fa', function () {
        return redirect(URL()->previous());
    })->name('2fa');
});

