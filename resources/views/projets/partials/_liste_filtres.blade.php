@php
    // Variables attendues à l'@include :
    // - $secteurs (optionnel)      : pour afficher le select secteur
    // - $statutOptions (optionnel) : [valeur => libellé] pour les puces de statut
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/listes-projets.css') }}">
@endpush

<div class="lp-filtres">
    <div class="lp-search-wrap">
        <i class="fas fa-search"></i>
        <input type="text" id="lpSearchInput" placeholder="Rechercher par titre ou code..." value="{{ request('search') }}">
    </div>

    @isset($statutOptions)
        <select id="lpStatutSelect" class="lp-select">
            <option value="">Tous les statuts</option>
            @foreach ($statutOptions as $valeur => $libelle)
                <option value="{{ $valeur }}" {{ request('statut') === $valeur ? 'selected' : '' }}>{{ $libelle }}</option>
            @endforeach
        </select>
    @endisset

    @isset($secteurs)
        <select id="lpSecteurSelect" class="lp-select">
            <option value="">Tous les secteurs</option>
            @foreach ($secteurs as $secteur)
                <option value="{{ $secteur->id }}" {{ (string) request('secteur_id') === (string) $secteur->id ? 'selected' : '' }}>
                    {{ $secteur->nomSecteur }}
                </option>
            @endforeach
        </select>
    @endisset

    @if (request('search') || request('secteur_id') || request('statut'))
        <a href="{{ request()->url() }}" class="lp-reset-btn"><i class="fas fa-times"></i> Réinitialiser</a>
    @endif
</div>
