<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $blockExpiresAt = null;
        $permanentBlock = false;
        $blockEmail     = session('blocked_email');

        if ($blockEmail) {
            $permanentBlockKey = 'login_permanent_block_' . $blockEmail;
            $blockKey          = 'login_block_'           . $blockEmail;

            if (Cache::get($permanentBlockKey)) {
                $permanentBlock = true;
            } elseif (Cache::has($blockKey)) {
                $blockExpiresAt = session('block_expires_at');
                if (!$blockExpiresAt || $blockExpiresAt <= now()->timestamp) {
                    session()->forget(['blocked_email', 'block_expires_at']);
                    $blockExpiresAt = null;
                }
            } else {
                // Blocage expiré -> nettoyer
                session()->forget(['blocked_email', 'block_expires_at']);
            }
        }

        return view('auth.login', compact('blockExpiresAt', 'permanentBlock'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'role'     => 'required|in:admin,approbateur,validateur,porteur',
        ]);

        $email              = $request->email;
        $cacheKey           = 'login_attempts_'       . $email;
        $blockKey           = 'login_block_'          . $email;
        $permanentBlockKey  = 'login_permanent_block_' . $email;

        // ── Blocage définitif ──
        if (Cache::get($permanentBlockKey)) {
            session(['permanent_block' => true]);
            return back()->withErrors([
                'email' => 'Compte définitivement bloqué. Contactez l\'administrateur.',
            ])->onlyInput('email');
        }

        // ── Blocage temporaire ──
        if (Cache::has($blockKey)) {
            return back()->withErrors([
                'email' => 'Compte temporairement suspendu. Attendez la fin du délai.',
            ])->onlyInput('email');
        }

        // ── Vérifier l'utilisateur ──
        $user = User::where('email', $email)
                    ->where('role', $request->role)
                    ->first();

        if (!$user) {
            $this->incrementAttempts($cacheKey, $blockKey, $permanentBlockKey, $email);
            return back()->withErrors([
                'email' => 'Email, mot de passe ou rôle incorrect.',
            ])->onlyInput('email');
        }

        if (!$user->actif) {
            return back()->withErrors([
                'email' => 'Ce compte est désactivé. Contactez l\'administrateur.',
            ])->onlyInput('email');
        }

        // ── Vérifier le mot de passe ──
        if (!Hash::check($request->password, $user->motDePasse)) {
            $this->incrementAttempts($cacheKey, $blockKey, $permanentBlockKey, $email);
            return back()->withErrors([
                'email' => 'Email, mot de passe ou rôle incorrect.',
            ])->onlyInput('email');
        }

        // ── Connexion réussie ──
        Cache::forget($cacheKey);
        Cache::forget($blockKey);

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Vider les sessions de blocage
        session()->forget(['blocked_email', 'block_expires_at', 'permanent_block']);

        return redirect($this->redirectTo($user->role));
    }

    private function incrementAttempts($cacheKey, $blockKey, $permanentBlockKey, $email)
    {
        $attempts = Cache::get($cacheKey, 0) + 1;
        Cache::put($cacheKey, $attempts, now()->addMinutes(30));

        if ($attempts >= 3) {
            // Compteur de cycles de blocage
            $blockCountKey = 'block_count_' . $email;
            $blockCount    = Cache::get($blockCountKey, 0) + 1;
            Cache::put($blockCountKey, $blockCount, now()->addDays(7));

            // Réinitialiser les tentatives pour le prochain cycle
            Cache::forget($cacheKey);

            if ($blockCount >= 3) {
                // Blocage définitif après 3 cycles (9 tentatives)
                Cache::put($permanentBlockKey, true, now()->addYears(10));
                session(['permanent_block' => true]);

                // Désactiver le compte en base de données
                User::where('email', $email)->update(['actif' => false]);

                \Log::warning('Compte définitivement bloqué et désactivé', ['email' => $email]);
                return;
            }

            // Blocage temporaire 5 min — stocker le timestamp d'expiration
            $blockMinutes   = 5;
            $expiresAt      = now()->addMinutes($blockMinutes)->timestamp;

            Cache::put($blockKey, $blockMinutes, now()->addMinutes($blockMinutes));

            // Stocker en session le timestamp exact pour le countdown
            session([
                'blocked_email'    => $email,
                'block_expires_at' => $expiresAt,
            ]);
        }
    }

    // Redirection selon le rôle
    private function redirectTo($role){
        switch($role) {
            case 'admin':
                return '/admin/dashboard';
            case 'approbateur':
                return '/approbateur/dashboard';
            case 'validateur':
                return '/validateur/dashboard';
            case 'porteur':
                return '/porteur/dashboard';
            default:
                return '/login';
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}