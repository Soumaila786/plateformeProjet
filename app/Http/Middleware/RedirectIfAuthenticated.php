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

            if (in_array($user->role, ['admin', 'approbateur', 'validateur', 'porteur', 'planificateur'])) {
                return redirect()->route($user->role . '.dashboard');
            }

            return redirect('/');
        }

        $response = $next($request);

        return $response
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate, private')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
