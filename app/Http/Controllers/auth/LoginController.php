<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller {

    public function showLoginForm() {

        try{

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

        }catch (\Exception $e) {

            Log::error('Erreur lors de l\'affichage du formulaire de connexion', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return view('auth.login');
        }
    }

    public function login(Request $request) {

        try{

            $request->validate([
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            $email = $request->email;
            Log::info('Tentative de connexion', [
                'email' => $email,
                'ip' => $request->ip()
            ]);

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
                Log::warning('Tentative de connexion sur un compte temporairement bloqué', [
                    'email' => $email,
                    'ip' => $request->ip()
                ]);
                return back()->withErrors([
                    'email' => 'Compte temporairement suspendu. Réessayez plus tard.',
                ])->onlyInput('email');
            }

            // Compte désactivé
            if ($user && !$user->actif) {
                Log::warning('Tentative de connexion sur un compte désactivé', [
                    'email' => $email,
                    'ip' => $request->ip()
                ]);
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
                Log::warning('Echec de connexion : Identifiants incorrects', [
                    'email' => $email,
                    'ip'    => $request->ip()
                ]);
                $this->incrementAttempts(
                    $cacheKey,
                    $blockKey,
                    $permanentBlockKey,
                    $email
                );
                return back()->withErrors([
                    'email' => 'Email ou mot de passe incorrect.',
                ])->onlyInput('email');
            }

            // Connexion réussie
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            Log::info('Connexion réussie', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'ip' => $request->ip()
            ]);
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

        }catch(\Exception $e){
            Log::error('Erreur lors de la connexion',[
                'message' => $e->getMessage(),
            ]);
            return redirect()->back()
                ->with('error', 'Une erreur est survenue ');
        }
    }

    private function incrementAttempts($cacheKey, $blockKey, $permanentBlockKey, $email) {

        try{

            // CONFIG ADMIN (dynamique)
            $maxAttempts   = (int) Configuration::get('tentatives_connexion', 3);
            $blockDuration = (int) Configuration::get('duree_blocage', 5);
            $maxBlocks     = (int) Configuration::get('max_blocages', 3);

            $attempts = Cache::get($cacheKey, 0) + 1;

            Cache::put($cacheKey, $attempts, now()->addMinutes(30));

            if ($attempts >= $maxAttempts) {
                $blockCountKey = 'block_count_' . $email;
                $blockCount = Cache::get($blockCountKey, 0) + 1;
                Cache::put($blockCountKey, $blockCount, now()->addDays(7));
                Cache::forget($cacheKey);
                // Blocage définitif
                if ($blockCount >= $maxBlocks) {
                    Log::critical('Blocage définitif du compte', [
                        'email' => $email,
                        'nombre_blocages' => $blockCount
                    ]);
                    Cache::put($permanentBlockKey, true, now()->addYears(10));
                    User::where('email', $email)->update(['actif' => false]);
                    session([
                        'permanent_block' => true,
                        'blocked_email'   => $email
                    ]);
                    return;
                }
                // Blocage temporaire
                $expiresAt = now()->addMinutes($blockDuration)->timestamp;
                Log::warning('Blocage temporaire du compte', [
                    'email' => $email,
                    'duree' => $blockDuration . ' minutes',
                    'ip' => request()->ip()
                ]);
                Cache::put($blockKey, true, now()->addMinutes($blockDuration));
                session([
                    'blocked_email'    => $email,
                    'block_expires_at' => $expiresAt,
                ]);
            }
            
        }catch(\Exception $e){
            Log::error("Erreur lors de l'incrementation du temps", [
                'message' => $e->getMessage()
            ]);
        }
    }

    private function redirectTo($role) {

        switch ($role) {
            case 'admin':
                $redirect = '/admin/dashboard';
                break;

            case 'approbateur':
                $redirect = '/approbateur/dashboard';
                break;

            case 'validateur':
                $redirect = '/validateur/dashboard';
                break;

            case 'porteur':
                $redirect = '/porteur/dashboard';
                break;
            
            case 'planificateur':
                $redirect = '/planificateur/dashboard';
                break;

            default:
                $redirect = '/login';
                break;
        }

        Log::info('Redirection après connexion', [
            'role' => $role,
            'redirect_to' => $redirect,
            'user_id' => Auth::id()
        ]);

        return $redirect;
    }

    public function logout(Request $request) {

        Log::info('Déconnexion utilisateur', [
            'user_id' => Auth::id(),
            'ip' => $request->ip()
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
