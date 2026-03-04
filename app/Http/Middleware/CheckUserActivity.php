<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckUserActivity
{
    /**
     * Temps d'inactivité maximum en minutes
     */
    protected $maxIdleTime = 30;

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $lastActivity = $user->last_activity;

            if ($lastActivity && Carbon::parse($lastActivity)->diffInMinutes(now()) > $this->maxIdleTime) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login')->withErrors([
                    'email' => 'Session expirée pour cause d\'inactivité.'
                ]);
            }

            // Mettre à jour la dernière activité
            $user->update(['last_activity' => now()]);
        }

        return $next($request);
    }
}