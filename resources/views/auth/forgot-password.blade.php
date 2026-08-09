@extends('layouts.guest')

@section('title', 'Mot de passe oublié')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
<div class="login-wrapper">
    <div class="login-card">

        <div class="login-header">
            <h1 class="login-title">Mot de passe oublié</h1>
            <p class="login-subtitle">Entrez votre email pour recevoir un lien de réinitialisation</p>
        </div>

        <div class="login-body">

            @if(session('status'))
            <div class="login-alert" style="background:#f0fdf4;color:#15803d;border-color:#bbf7d0;">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('status') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="login-alert">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
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

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Envoyer le lien de réinitialisation
                </button>
            </form>

            <div style="text-align:center;margin-top:16px;">
                <a href="{{ route('login') }}" class="forgot-link">
                    <i class="fas fa-arrow-left"></i> Retour à la connexion
                </a>
            </div>

        </div>

        <div class="login-footer">
            <i class="fas fa-shield-alt"></i>
            Connexion sécurisée &nbsp;·&nbsp; &copy; {{ date('Y') }} {{ config('app.name') }}
        </div>

    </div>
</div>
@endsection
