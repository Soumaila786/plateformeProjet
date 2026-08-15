@extends('layouts.guest')

@section('title', 'Connexion')

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
                <h1 class="ac-auth-title">Connexion</h1>
                <p class="ac-auth-sub">Accédez à votre espace CIFEU</p>
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

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="exemple@domaine.com" required autofocus>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Mot de passe</label>
                    <div class="ac-auth-pwd-wrap">
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="••••••••" required>
                        <button type="button" class="ac-auth-pwd-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <label class="d-flex align-items-center gap-2 small mb-0" style="color:var(--color-text-gray);">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Se souvenir de moi
                    </label>
                    <a href="{{ route('password.request') }}" class="small" style="color:var(--color-primary); text-decoration:none;">
                        Mot de passe oublié ?
                    </a>
                </div>

                <button type="submit" class="ac-btn-hero w-100 justify-content-center" style="background:var(--color-primary); color:#fff !important; box-shadow:none;">
                    Se connecter
                </button>
            </form>
        </div>
    </section>

@endsection

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
