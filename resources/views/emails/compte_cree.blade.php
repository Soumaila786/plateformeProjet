@extends('emails.layout')

@section('status_band')
<div class="status-band blue">
    <div class="status-icon blue"></div>
    <div>
        <div class="status-label">Compte créé avec succès</div>
        <div class="status-sub">Bienvenue sur GesProjet</div>
    </div>
</div>
@endsection

@section('body')
<p class="greeting">Salut {{ $user->nomComplet }},</p>
<p class="text">
    Votre compte a été créé par un administrateur sur la plateforme <strong>GesProjet</strong>.
    Voici vos informations de connexion :
</p>

<div class="info-box">
    <div class="info-box-header">Informations du compte</div>
    <div class="info-row">
        <span class="info-label">Nom complet</span>
        <span class="info-value">{{ $user->nomComplet }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Adresse email</span>
        <span class="info-value">{{ $user->email }}</span>
    </div>


    @if($user->matricule)
        <div class="info-row">
            <span class="info-label">Matricule</span>
            <span class="info-value">{{ $user->matricule }}</span>
        </div>
    @endif

    @if($user->fonction)
        <div class="info-row">
            <span class="info-label">Fonction</span>
            <span class="info-value">{{ $user->fonction }}</span>
        </div>
    @endif
</div>

<div class="password-box">
    <div class="password-icon"></div>
    <div>
        <div class="password-label">Mot de passe temporaire</div>
        <div class="password-value">{{ $password }}</div>
    </div>
</div>

<div class="security-note">
    <div class="security-note-icon"></div>
    <div class="security-note-text">
        Pour des raisons de sécurité, veuillez changer votre mot de passe dès votre première connexion
        dans <strong>Paramètres → Sécurité</strong>.
    </div>
</div>

<div class="btn-wrap">
    <a href="http://localhost:8000/login" class="btn">Se connecter à GesProjet</a>
</div>

<div class="divider"></div>
<p class="text" style="font-size:.78rem;color:#94a3b8;text-align:center;">
    Si vous n'êtes pas à l'origine de cette demande, ignorez cet email ou contactez l'administrateur.
</p>
@endsection
