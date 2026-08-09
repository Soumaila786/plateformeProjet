@push('styles')
    <link rel="stylesheet" href="{{ asset('css/listes-projets.css') }}">
    <link rel="stylesheet" href="{{ asset('css/motifs.css') }}">
@endpush

<div class="lp-filtres">
    <div class="lp-search-wrap">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Rechercher un motif..." value="{{ request('search') }}"
               data-filter-search="search">
    </div>

    @if (request('search'))
        <a href="{{ request()->url() }}" class="lp-reset-btn"><i class="fas fa-times"></i> Réinitialiser</a>
    @endif
</div>
