<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller {

    public function showLoginForm() {

        $blockExpiresAt = null;
        $permanentBlock = false;
        $blockEmail     = session('blocked_email');

        if ($blockEmail) {
            $permanentBlockKey = 'login_permanent_block_' . $blockEmail;
            $blockKey          = 'login_block_' . $blockEmail;

            $blockedUser = User::where('email', $blockEmail)->first();

            // Si admin a réactivé le compte
            if ($blockedUser && $blockedUser->actif) {
                Cache::forget($permanentBlockKey);
                Cache::forget($blockKey);
                Cache::forget('login_attempts_' . $blockEmail);
                Cache::forget('block_count_' . $blockEmail);

                session()->forget([
                    'blocked_email',
                    'block_expires_at',
                    'permanent_block'
                ]);
            }
            elseif (Cache::get($permanentBlockKey)) {
                $permanentBlock = true;
            }
            elseif (Cache::has($blockKey)) {
                $blockExpiresAt = session('block_expires_at');

                if (!$blockExpiresAt || $blockExpiresAt <= now()->timestamp) {
                    session()->forget(['blocked_email', 'block_expires_at']);
                    $blockExpiresAt = null;
                }
            }
            else {
                session()->forget(['blocked_email', 'block_expires_at']);
            }
        }

        return view('auth.login', compact('blockExpiresAt', 'permanentBlock'));
    }

    public function login(Request $request) {

        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;

        $cacheKey          = 'login_attempts_' . $email;
        $blockKey          = 'login_block_' . $email;
        $permanentBlockKey = 'login_permanent_block_' . $email;

        $user = User::where('email', $email)->first();

        // Si compte réactivé → reset sécurité
        if ($user && $user->actif) {
            Cache::forget($permanentBlockKey);
            Cache::forget($blockKey);
            Cache::forget($cacheKey);
            Cache::forget('block_count_' . $email);

            session()->forget([
                'blocked_email',
                'block_expires_at',
                'permanent_block'
            ]);
        }

        // Blocage temporaire
        if (Cache::has($blockKey)) {
            return back()->withErrors([
                'email' => 'Compte temporairement suspendu. Réessayez plus tard.',
            ])->onlyInput('email');
        }

        // Compte désactivé
        if ($user && !$user->actif) {
            session([
                'permanent_block' => true,
                'blocked_email'   => $email
            ]);

            return back()->withErrors([
                'email' => 'Compte désactivé. Contactez l’administrateur.',
            ])->onlyInput('email');
        }

        // Mauvais identifiants
        if (!$user || !Hash::check($request->password, $user->motDePasse)) {

            $this->incrementAttempts($cacheKey, $blockKey, $permanentBlockKey, $email);

            return back()->withErrors([
                'email' => 'Email ou mot de passe incorrect.',
            ])->onlyInput('email');
        }

        // Connexion réussie
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Reset sécurité
        Cache::forget($cacheKey);
        Cache::forget($blockKey);
        Cache::forget($permanentBlockKey);
        Cache::forget('block_count_' . $email);

        session()->forget([
            'blocked_email',
            'block_expires_at',
            'permanent_block'
        ]);

        return redirect($this->redirectTo($user->role));
    }

    private function incrementAttempts($cacheKey, $blockKey, $permanentBlockKey, $email) {
        // CONFIG ADMIN (dynamique)
        $maxAttempts   = (int) Configuration::get('tentatives_connexion', 3);
        $blockDuration = (int) Configuration::get('duree_blocage', 5);
        $maxBlocks     = (int) Configuration::get('max_blocages', 3);

        $attempts = Cache::get($cacheKey, 0) + 1;

        Cache::put($cacheKey, $attempts, now()->addMinutes(30));

        // Debug (optionnel)
        \Log::info('Tentative login', [
            'email' => $email,
            'attempts' => $attempts
        ]);

        if ($attempts >= $maxAttempts) {

            $blockCountKey = 'block_count_' . $email;
            $blockCount = Cache::get($blockCountKey, 0) + 1;

            Cache::put($blockCountKey, $blockCount, now()->addDays(7));
            Cache::forget($cacheKey);

            // Blocage définitif
            if ($blockCount >= $maxBlocks) {

                Cache::put($permanentBlockKey, true, now()->addYears(10));

                User::where('email', $email)->update(['actif' => false]);

                session([
                    'permanent_block' => true,
                    'blocked_email'   => $email
                ]);

                \Log::warning('Compte définitivement bloqué', ['email' => $email]);

                return;
            }

            // Blocage temporaire
            $expiresAt = now()->addMinutes($blockDuration)->timestamp;

            Cache::put($blockKey, true, now()->addMinutes($blockDuration));

            session([
                'blocked_email'    => $email,
                'block_expires_at' => $expiresAt,
            ]);
        }
    }

    private function redirectTo($role) {

        switch ($role) {
            case 'admin':       return '/admin/dashboard';
            case 'approbateur': return '/approbateur/dashboard';
            case 'validateur':  return '/validateur/dashboard';
            case 'porteur':     return '/porteur/dashboard';
            default:            return '/login';
        }
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
