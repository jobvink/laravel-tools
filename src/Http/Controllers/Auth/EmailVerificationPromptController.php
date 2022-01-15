<?php

namespace jobvink\tools\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended('/admin')
                    : view('auth.verify-email');
    }
}
