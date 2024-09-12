<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        //If the status is not approved redirect to login
        if (Auth::check() && Auth::user()->is_active != 1) {
            Auth::logout();
            return redirect('/login')->with('error', 'Your account is inactive. Please contact support.');
        }
        return $response;
    }
}
