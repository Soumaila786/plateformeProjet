<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();

            switch ($user->role) {
                case 'admin':       return redirect('/admin/dashboard');
                case 'approbateur': return redirect('/approbateur/dashboard');
                case 'validateur':  return redirect('/validateur/dashboard');
                case 'porteur':     return redirect('/porteur/dashboard');
                case 'planificateur': return redirect('/planificateur/dashboard');
                default:            return redirect('/');
            }
        }

        $response = $next($request);

        return $response
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate, private')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
