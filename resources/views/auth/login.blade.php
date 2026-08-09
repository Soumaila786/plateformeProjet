@extends('layouts.guest')

@section('title', 'Connexion')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
<div class="login-wrapper">
    <div class="login-card">

        {{-- En-tête (logo retiré à la demande — affiché uniquement sur la page d'accueil) --}}
        <div class="login-header">
            <h1 class="login-title">{{ config('app.name') }}</h1>
            <p class="login-subtitle">Gestion de projets — Accès réservé</p>
        </div>

        <div class="login-body">

            {{--
                NOTE : le blocage temporaire/définitif après tentatives échouées
                (alert-permanent / alert-temp / countdown) est désactivé pour
                l'instant — il reposait sur $permanentBlock/$blockExpiresAt
                fournis par l'ancien LoginController custom. À réintégrer dans
                AuthenticatedSessionController::store() une fois la logique
                d'origine récupérée.
            --}}

            {{-- ── Erreur normale (identifiants invalides, etc.) ── --}}
            @if($errors->any())
            <div class="login-alert">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            @if(session('status'))
            <div class="login-alert" style="background:#f0fdf4;color:#15803d;border-color:#bbf7d0;">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('status') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

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
                    <a href="{{ route('password.request') }}" class="forgot-link">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn-submit">
                    Se connecter
                </button>

            </form>

        </div>

        <div class="login-footer">
            <i class="fas fa-shield-alt"></i>
            Connexion sécurisée &nbsp;·&nbsp; &copy; {{ date('Y') }} {{ config('app.name') }}
        </div>

    </div>
</div>

@push('scripts')
<script>
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
</script>
@endpush

@endsection
