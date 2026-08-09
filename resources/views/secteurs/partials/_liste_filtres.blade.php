@push('styles')
    <link rel="stylesheet" href="{{ asset('css/listes-projets.css') }}">
    <link rel="stylesheet" href="{{ asset('css/secteurs.css') }}">
@endpush

<div class="lp-filtres">
    <div class="lp-search-wrap">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Rechercher un secteur..." value="{{ request('search') }}"
               data-filter-search="search">
    </div>

    <select class="lp-select" name="statut" data-filter-select>
        <option value="">Tous les statuts</option>
        <option value="1" {{ request('statut') === '1' ? 'selected' : '' }}>Actifs</option>
        <option value="0" {{ request('statut') === '0' ? 'selected' : '' }}>Inactifs</option>
    </select>

    @if (request('search') || request('statut'))
        <a href="{{ request()->url() }}" class="lp-reset-btn"><i class="fas fa-times"></i> Réinitialiser</a>
    @endif
</div>
