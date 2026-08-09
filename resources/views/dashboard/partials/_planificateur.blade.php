@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

<div class="dash-stats-grid">
    <x-cards.stat label="Demandes en attente" :valeur="$demandesEnAttente" icon="fa-inbox" couleur="var(--color-warning)" href="{{ route('planificateur.projets.index') }}" />
    <x-cards.stat label="Projets traités" :valeur="$projetsTraites" icon="fa-check" couleur="var(--status-approuve)" href="{{ route('planificateur.projets.traites') }}" />
    <x-cards.stat label="Activités ce mois" :valeur="$activitesCeMois" icon="fa-calendar-check" />
    <x-cards.stat label="Coût total planifié" :valeur="number_format($coutTotalPlanifie, 0, ',', ' ').' FCFA'" icon="fa-coins" couleur="var(--color-info)" />
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="dash-card">
            <h6 class="fw-bold mb-3">Dernières demandes de planification</h6>
            @include('dashboard.partials._projets_recents', ['projetsRecents' => $dernieresDemandes, 'routeShow' => 'planificateur.projets.show'])
        </div>
    </div>
    <div class="col-lg-6">
        <div class="dash-card">
            <h6 class="fw-bold mb-3">Projets récemment planifiés</h6>
            @include('dashboard.partials._projets_recents', ['projetsRecents' => $projetsRecentsTraites, 'routeShow' => 'planificateur.projets.show'])
        </div>
    </div>
</div>
