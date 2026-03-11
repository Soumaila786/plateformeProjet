<h1>Bienvenue {{ $user->name }} !</h1>

<p>Votre compte a été créé avec succès.</p>

@if($temporaryPassword)
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Mot de passe temporaire:</strong> {{ $temporaryPassword }}</p>
@endif

<a href="{{ url('/login') }}">Se connecter</a>