@extends('emails.layout')

@section('status_band')
<div class="status-band teal">
    <div class="status-icon teal"></div>
    <div>
        <div class="status-label">Projet validé — Félicitations !</div>
        <div class="status-sub">{{ $projet->codeProjet }} — Acceptation officielle</div>
    </div>
    </div>
    @endsection

    @section('body')
    <p class="greeting">Bonjour {{ $projet->porteur->nomComplet }},</p>
    <p class="text">
    Félicitations ! Votre projet a été <strong>validé</strong> avec succès.
    Il est désormais officiellement accepté sur la plateforme <strong>ProjetGov</strong>.
    </p>

    <div class="info-box">
    <div class="info-box-header">Détails du projet</div>
    <div class="info-row">
        <span class="info-label">Code projet</span>
        <span class="info-value"><strong>{{ $projet->codeProjet }}</strong></span>
    </div>
    <div class="info-row">
        <span class="info-label">Titre</span>
        <span class="info-value">{{ $projet->titre }}</span>
    </div>
    @if($projet->secteur)
    <div class="info-row">
        <span class="info-label">Secteur</span>
        <span class="info-value">{{ $projet->secteur->nomSecteur }}</span>
    </div>
    @endif
    <div class="info-row">
        <span class="info-label">Statut</span>
        <span class="info-value"><span class="badge badge-teal">Validé</span></span>
    </div>
    <div class="info-row">
        <span class="info-label">Date de validation</span>
        <span class="info-value">{{ now()->format('d/m/Y à H:i') }}</span>
    </div>
</div>

<p class="text">
    Nous vous félicitons chaleureusement pour ce résultat.
    Vous pouvez consulter les détails de votre projet ainsi que les prochaines étapes
    depuis votre espace porteur.
</p>


<div class="divider"></div>
<p class="text" style="font-size:.78rem;color:#94a3b8;text-align:center;">
    Merci pour votre confiance envers la plateforme ProjetGov.
</p>
@endsection
