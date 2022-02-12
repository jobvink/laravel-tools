<?php

namespace jobvink\tools\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use jobvink\tools\Requests\Auth\CompleteTwoFactorAuthenticationRequest;

class TwoFactorQrCodeController extends Controller
{
    /**
     * Get the SVG element for the user's two factor authentication QR code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(CompleteTwoFactorAuthenticationRequest $request)
    {
        if (is_null($request->user()->two_factor_secret)) {
            return [];
        }

        return view('tools::auth.2fa', compact('request'));
    }
}
