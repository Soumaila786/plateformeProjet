@push('styles')
    <link rel="stylesheet" href="{{ asset('css/listes-projets.css') }}">
@endpush

<div class="lp-filtres">
    <div class="lp-search-wrap">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Rechercher par nom ou email..." value="{{ request('search') }}"
               data-filter-search="search">
    </div>

    <select class="lp-select" name="role" data-filter-select>
        <option value="">Tous les rôles</option>
        @foreach (['admin' => 'Admin', 'porteur' => 'Porteur', 'approbateur' => 'Approbateur', 'validateur' => 'Validateur', 'planificateur' => 'Planificateur'] as $val => $label)
            <option value="{{ $val }}" {{ request('role') === $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>

    <select class="lp-select" name="actif" data-filter-select>
        <option value="">Tous les statuts</option>
        <option value="1" {{ request('actif') === '1' ? 'selected' : '' }}>Actifs</option>
        <option value="0" {{ request('actif') === '0' ? 'selected' : '' }}>Inactifs</option>
    </select>

    @if (request('search') || request('role') || request('actif'))
        <a href="{{ request()->url() }}" class="lp-reset-btn"><i class="fas fa-times"></i> Réinitialiser</a>
    @endif
</div>
