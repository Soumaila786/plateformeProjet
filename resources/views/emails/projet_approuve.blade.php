@extends('emails.layout')

@section('status_band')
<div class="status-band green">
    <div class="status-icon green"></div>
    <div>
        <div class="status-label">Projet approuvé</div>
        <div class="status-sub">{{ $projet->codeProjet }} — En attente de validation</div>
    </div>
</div>
@endsection

@section('body')
<p class="greeting">Bonjour {{ $projet->porteur->nomComplet }},</p>
<p class="text">
    Nous avons le plaisir de vous informer que votre projet a été <strong>approuvé</strong>
    par l'équipe d'approbation. Il est désormais transmis aux validateurs pour la décision finale.
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
        <span class="info-value"><span class="badge badge-green">Approuvé</span></span>
    </div>
    <div class="info-row">
        <span class="info-label">Date d'approbation</span>
        <span class="info-value">{{ now()->format('d/m/Y à H:i') }}</span>
    </div>
</div>

<p class="text">
    Votre projet est maintenant en attente de la <strong>validation finale</strong>.
    Vous recevrez un email dès qu'une décision sera prise.
</p>

@endsection
