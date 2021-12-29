<?php

namespace jobvink\tools\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function register(Request $request)
    {
        // Initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

        // Save the registration data in an array
        $registration_data = $request->all();

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

        // Pass the QR barcode image to our view
        return view('tools::google2fa.register', ['QR_Image' => $QR_Image, 'secret' => $registration_data['google2fa_secret']]);
    }

    public function completeRegistration(Request $request)
    {
        // add the session data back to the request input
        $request->merge(session('registration_data'));

        // Call the default laravel authentication
        return $this->registration($request);
    }
}
