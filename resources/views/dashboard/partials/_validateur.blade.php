@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

<div class="dash-stats-grid">
    <x-cards.stat label="En attente de validation" :valeur="$enAttente" icon="fa-hourglass-half" couleur="var(--color-warning)" href="{{ route('validateur.projets.index') }}" />
    <x-cards.stat label="Soumis (global)" :valeur="$soumis" icon="fa-paper-plane" couleur="var(--status-soumis)" />
    <x-cards.stat label="Validés" :valeur="$valides" icon="fa-check-double" couleur="var(--status-valide)" />
    <x-cards.stat label="Rejetés" :valeur="$rejetes" icon="fa-xmark" couleur="var(--status-rejete)" />
</div>

<div class="dash-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Projets à valider en priorité</h6>
        <a href="{{ route('validateur.projets.index') }}" class="small">Voir tout</a>
    </div>
    @include('dashboard.partials._projets_recents', ['projetsRecents' => $projetsUrgents, 'routeShow' => 'validateur.projets.show'])
</div>
