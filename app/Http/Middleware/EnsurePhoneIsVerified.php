<?php

namespace App\Http\Middleware;

use Closure;

class EnsurePhoneIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->user() || ! $request->user()->hasVerifiedPhone()) {
            return redirect()->route('phoneverification.notice');
        }

        return $next($request);
    }
}
