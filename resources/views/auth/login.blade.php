@extends('layouts.app')

@section('title', 'Connexion')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
<div class="login-wrapper">
    <div class="login-card">

        {{-- En-tête --}}
        <div class="login-header">
            <div class="login-logo">GP</div>
            <h1 class="login-title">{{ config('app.name') }}</h1>
            <p class="login-subtitle">Gestion de projets — Accès réservé</p>
        </div>

        <div class="login-body">

            {{-- ── Blocage définitif (email bloqué seulement) ── --}}
            @if(isset($permanentBlock) && $permanentBlock)
            <div class="alert-block alert-permanent">
                <div class="alert-icon"><i class="fas fa-ban"></i></div>
                <div class="alert-content">
                    <p class="alert-title">Compte désactivé</p>
                    <p class="alert-text">Ce compte a été désactivé suite à de trop nombreuses tentatives. Contactez l'administrateur système.</p>
                </div>
            </div>
            @endif

            {{-- ── Blocage temporaire (email bloqué seulement) ── --}}
            @if(isset($blockExpiresAt) && $blockExpiresAt > now()->timestamp)
            <div class="alert-block alert-temp">
                <div class="alert-icon"><i class="fas fa-lock"></i></div>
                <div class="alert-content">
                    <p class="alert-title">Accès temporairement suspendu</p>
                    <p class="alert-text">Trop de tentatives incorrectes. Réessayez dans :</p>
                    <div class="countdown-wrap">
                        <span class="countdown-timer" id="countdown">--:--</span>
                    </div>
                    <div class="countdown-bar-wrap">
                        <div class="countdown-bar" id="countdownBar"></div>
                    </div>
                </div>
            </div>
            @endif

            {{-- ── Erreur normale ── --}}
            @if($errors->any() && !(isset($blockExpiresAt) && $blockExpiresAt > now()->timestamp))
            <div class="login-alert">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            {{-- ── Formulaire TOUJOURS visible sauf blocage temporaire actif ── --}}
            @if(!(isset($blockExpiresAt) && $blockExpiresAt > now()->timestamp))
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Sélecteur de rôle --}}
                <div class="form-group">
                    <label class="form-label-top">Profil</label>
                    <div class="role-grid">
                        <label class="role-option {{ old('role') == 'admin' ? 'selected' : '' }}">
                            <input type="radio" name="role" value="admin" {{ old('role') == 'admin' ? 'checked' : '' }} required>
                            <i class="fas fa-user-shield"></i>
                            <span>Administrateur</span>
                        </label>
                        <label class="role-option {{ old('role') == 'approbateur' ? 'selected' : '' }}">
                            <input type="radio" name="role" value="approbateur" {{ old('role') == 'approbateur' ? 'checked' : '' }} required>
                            <i class="fas fa-user-check"></i>
                            <span>Approbateur</span>
                        </label>
                        <label class="role-option {{ old('role') == 'validateur' ? 'selected' : '' }}">
                            <input type="radio" name="role" value="validateur" {{ old('role') == 'validateur' ? 'checked' : '' }} required>
                            <i class="fas fa-user-cog"></i>
                            <span>Validateur</span>
                        </label>
                        <label class="role-option {{ old('role') == 'porteur' ? 'selected' : '' }}">
                            <input type="radio" name="role" value="porteur" {{ old('role') == 'porteur' ? 'checked' : '' }} required>
                            <i class="fas fa-user-tie"></i>
                            <span>Porteur</span>
                        </label>
                    </div>
                    @error('role')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label-top" for="email">Adresse e-mail</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}"
                               class="input-field @error('email') error @enderror"
                               placeholder="exemple@domaine.com"
                               required autofocus>
                    </div>
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                {{-- Mot de passe --}}
                <div class="form-group">
                    <label class="form-label-top" for="password">Mot de passe</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password"
                               class="input-field @error('password') error @enderror"
                               placeholder="••••••••" required>
                        <button type="button" class="toggle-pwd" onclick="togglePassword()">
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                    @error('password')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                {{-- Options --}}
                <div class="login-options">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Se souvenir de moi</span>
                    </label>
                    <a href="#" class="forgot-link">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn-submit">
                    Se connecter <i class="fas fa-arrow-right ms-2"></i>
                </button>

            </form>
            @endif

        </div>

        <div class="login-footer">
            <i class="fas fa-shield-alt"></i>
            Connexion sécurisée &nbsp;·&nbsp; &copy; {{ date('Y') }} {{ config('app.name') }}
        </div>

    </div>
</div>

@push('scripts')
<script>
    // ── Afficher/masquer mot de passe ──
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('togglePasswordIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // ── Sélecteur de rôle ──
    document.querySelectorAll('.role-option input').forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.role-option').forEach(el => el.classList.remove('selected'));
            this.closest('.role-option').classList.add('selected');
        });
    });

    // ── Compte à rebours basé sur le timestamp réel ──
    @if(isset($blockExpiresAt) && $blockExpiresAt > now()->timestamp)
    (function() {
        const expiresAt  = {{ $blockExpiresAt }};        // timestamp Unix côté serveur
        const totalSecs  = expiresAt - Math.floor(Date.now() / 1000);
        const timerEl    = document.getElementById('countdown');
        const barEl      = document.getElementById('countdownBar');

        if (!timerEl || totalSecs <= 0) {
            location.reload();
            return;
        }

        function tick() {
            const remaining = expiresAt - Math.floor(Date.now() / 1000);

            if (remaining <= 0) {
                // Blocage expiré → recharger proprement
                location.reload();
                return;
            }

            const m = Math.floor(remaining / 60).toString().padStart(2, '0');
            const s = (remaining % 60).toString().padStart(2, '0');
            timerEl.textContent = m + ':' + s;

            const pct = Math.max(0, (remaining / totalSecs) * 100);
            barEl.style.width = pct + '%';

            setTimeout(tick, 1000);
        }

        tick();
    })();
    @endif
</script>
@endpush

@endsection