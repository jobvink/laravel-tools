<?php

namespace jobvink\tools\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use jobvink\tools\Models\FailedSignupAttempt;
use ReCaptcha\ReCaptcha;

class VerifyRecaptia
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = (new ReCaptcha(env('RECAPTIA_SECRET')))
            ->setExpectedAction('participants_register')
            ->verify($request->input('_recaptcha'), $request->ip());

        if (!$response->isSuccess()) {
            FailedSignupAttempt::createRecaptiaFailed();
            abort(401);
        }

        return $next($request);
    }
}
