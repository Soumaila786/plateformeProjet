@extends('layouts.guest')

@section('title', 'Mot de passe oublié')

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
                <h1 class="ac-auth-title">Mot de passe oublié</h1>
                <p class="ac-auth-sub">Entrez votre email pour recevoir un lien de réinitialisation</p>
            </div>

            @if(session('status'))
                <div class="ac-contact-alert ac-contact-alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('status') }}
                </div>
            @endif
            @if($errors->any())
                <div class="ac-contact-alert ac-contact-alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-4">
                    <label class="form-label" for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="exemple@domaine.com" required autofocus>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="ac-btn-hero w-100 justify-content-center" style="background:var(--color-primary); color:#fff !important; box-shadow:none;">
                    <i class="fas fa-paper-plane"></i> Envoyer le lien de réinitialisation
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="small" style="color:var(--color-primary); text-decoration:none;">
                    <i class="fas fa-arrow-left"></i> Retour à la connexion
                </a>
            </div>
        </div>
    </section>

@endsection
