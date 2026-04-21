<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::get('is_logged_in') || !Session::get('refresh_token')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }
        return $next($request);
    }
}
