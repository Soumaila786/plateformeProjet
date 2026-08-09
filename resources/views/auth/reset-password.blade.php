@extends('layouts.guest')

@section('title', 'Réinitialiser le mot de passe')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
<div class="login-wrapper">
    <div class="login-card">

        <div class="login-header">
            <h1 class="login-title">Nouveau mot de passe</h1>
            <p class="login-subtitle">Choisissez un mot de passe fort d'au moins 8 caractères</p>
        </div>

        <div class="login-body">

            @if($errors->any())
            <div class="login-alert">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') ?? $token ?? '' }}">

                <div class="form-group">
                    <label class="form-label-top" for="email">Adresse e-mail</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email"
                            value="{{ old('email', $email ?? '') }}"
                            class="input-field @error('email') error @enderror"
                            required autofocus>
                    </div>
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label-top" for="password">Nouveau mot de passe</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password"
                            class="input-field @error('password') error @enderror"
                            placeholder="••••••••" required>
                    </div>
                    @error('password')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label-top" for="password_confirmation">Confirmer le mot de passe</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="input-field" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-key"></i> Réinitialiser le mot de passe
                </button>
            </form>

        </div>

        <div class="login-footer">
            <i class="fas fa-shield-alt"></i>
            Connexion sécurisée &nbsp;·&nbsp; &copy; {{ date('Y') }} {{ config('app.name') }}
        </div>

    </div>
</div>
@endsection
