<?php

namespace jobvink\tools\Http\Controllers\Auth;

use Illuminate\Auth\DatabaseUserProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use jobvink\tools\Events\UserRegistered;
use jobvink\tools\Models\FlashMessage;
use jobvink\tools\Models\User;
use jobvink\tools\Requests\Auth\CompleteTwoFactorAuthenticationRequest;
use jobvink\tools\Requests\Auth\VerificationRequest;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;

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
     * @param \Illuminate\Http\Request $request
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

        event(new UserRegistered($user));

        session()->flash('toast', [new FlashMessage(FlashMessage::SUCCESS, 'De gebruiker met de naam ' . $user->name . ' Heeft een email ontvangen, deze is 24 uur geldig.')]);

        return redirect('/admin');
    }

    public function register(Request $request)
    {
        return view('tools::auth.complete', compact('request'));
    }

    public function completeRegistration(VerificationRequest $request)
    {
        if ($request->validated()) {
            $user = User::find($request->route('id'));
            $user->password = Hash::make($request->get('password'));
            $user->markEmailAsVerified();
            $user->save();
        }

        return redirect()->route('register.2fa', [
            'id' => $request->route('id'),
            'hash' => $request->route('hash')
        ]);
    }

    /**
     * Lets the user configure 2fa
     *
     * @param Request $request
     * @return mixed
     */
    public function twoFactorAuthentication(CompleteTwoFactorAuthenticationRequest $request)
    {
        // Initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

        $user = User::find($request->route('id'));

        // Save the registration data in an array
        $registration_data = [
            'email' => $user->getEmailForVerification()
        ];

        // Add the secret key to the registration data
        try {
            $registration_data["google2fa_secret"] = $google2fa->generateSecretKey();
        } catch (IncompatibleWithGoogleAuthenticatorException $e) {
        } catch (InvalidCharactersException $e) {
        } catch (SecretKeyTooShortException $e) {
        }

        // Save the registration data to the user session for just the next request
        $request->session()->flash('registration_data', $registration_data);

        // Generate the QR image. This is the image the user will scan with their app
        // to set up two factor authentication
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $registration_data['email'],
            $registration_data['google2fa_secret']
        );

        $user->google2fa_secret = $registration_data['google2fa_secret'];
        $user->save();

        // Pass the QR barcode image to our view
        return view('tools::auth.2fa', [
            'QR_Image' => $QR_Image,
            'secret' => $registration_data['google2fa_secret'],
            'request' => $request
        ]);
    }

    public function done(CompleteTwoFactorAuthenticationRequest $request)
    {
        Auth::login(User::find($request->route('id')));

        return redirect('/admin');
    }
}
