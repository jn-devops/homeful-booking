<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisclaimerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $disclaimer_agree = $request->session()->get(key: 'disclaimer-agree', default: false);

        if (!$disclaimer_agree) {
            app('redirect')->setIntendedUrl($request->path());

            return redirect(route('disclaimer.index'));
        }

        return $next($request);
    }
}
