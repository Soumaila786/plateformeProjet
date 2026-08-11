@extends('layouts.guest')

@section('title', 'Réinitialiser le mot de passe')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/accueil.css') }}">
@endpush

@section('content')

    <x-site-header contexte="auth" />

    <section class="ac-auth-section">
        <div class="ac-auth-card">
            <div class="text-center mb-4">
                <h1 class="ac-auth-title">Nouveau mot de passe</h1>
                <p class="ac-auth-sub">Choisissez un mot de passe fort d'au moins 8 caractères</p>
            </div>

            @if($errors->any())
                <div class="ac-contact-alert ac-contact-alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') ?? $token ?? '' }}">

                <div class="mb-3">
                    <label class="form-label" for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $email ?? '') }}"
                           class="form-control @error('email') is-invalid @enderror" required autofocus>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Nouveau mot de passe</label>
                    <input type="password" id="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password_confirmation">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="ac-btn-hero w-100 justify-content-center" style="background:var(--color-primary); color:#fff !important; box-shadow:none;">
                    <i class="fas fa-key"></i> Réinitialiser le mot de passe
                </button>
            </form>
        </div>
    </section>

@endsection
