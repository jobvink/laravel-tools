<?php

namespace jobvink\tools\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use jobvink\tools\Actions\Fortify\PasswordValidationRules;
use jobvink\tools\Models\User;
use jobvink\tools\Requests\Auth\SetPasswordRequest;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;

class RegisterPasswordController extends Controller
{
    use PasswordValidationRules;

    /**
     * Show the confirm password view.
     *
     * @return \Illuminate\View\View
     */
    public function crate()
    {
        return view('tools::auth.password-complete');
    }

    /**
     * Confirm the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(SetPasswordRequest $request, EnableTwoFactorAuthentication $enable)
    {
        if ($request->validated()) {
            $user = User::find($request->route('id'));
            $user->password = Hash::make($request->get('password'));
            $user->markEmailAsVerified();
            $user->save();

            $enable($user);

            Auth::login($user);

            return redirect()->route('register.two-factor.qr-code', [
                'id' => $request->route('id'),
                'hash' => $request->route('hash'),
            ]);
        }

        return redirect()->route('home');
    }
}
