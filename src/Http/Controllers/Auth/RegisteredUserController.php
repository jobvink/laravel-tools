<?php

namespace jobvink\tools\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use jobvink\tools\Requests\Auth\TwoFactorAuthenticationRequest;
use jobvink\tools\Requests\Auth\VerificationRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('tools::auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        event(new Registered($user));

        return redirect('/admin');
    }

    public function completeRegistration(VerificationRequest $request) {
        /** @var User $user */
        $user = $request->user();
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return view('tools::auth.confirm');
    }


    /**
     * Lets the user configure 2fa
     *
     * @param Request $request
     * @return mixed
     */
    public function twoFactorAuthenticatoin(TwoFactorAuthenticationRequest $request)
    {
        // add the session data back to the request input
        $request->merge(session('registration_data'));

        // Initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

        // Generate the QR image. This is the image the user will scan with their app
        // to set up two factor authentication
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $request->user()->email,
            $request->get('google2fa_secret')
        );

        // Pass the QR barcode image to our view
        return view('tools::auth.2fa', ['QR_Image' => $QR_Image, 'secret' => $request->get('google2fa_secret')]);
    }

    public function complete(Request $request) {
        Auth::login($request->user());

        return redirect('/');
    }
}
