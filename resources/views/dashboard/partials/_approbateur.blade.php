@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

<div class="dash-stats-grid">
    <x-cards.stat label="En attente de décision" :valeur="$enAttente" icon="fa-hourglass-half" couleur="var(--color-warning)" href="{{ route('approbateur.projets.index') }}" />
    <x-cards.stat label="Soumis" :valeur="$soumis" icon="fa-paper-plane" couleur="var(--status-soumis)" />
    <x-cards.stat label="En examen" :valeur="$enExamen" icon="fa-magnifying-glass" couleur="var(--status-en-examen)" />
    <x-cards.stat label="Approuvés" :valeur="$approuve" icon="fa-check" couleur="var(--status-approuve)" />
    <x-cards.stat label="Validés" :valeur="$valide" icon="fa-check-double" couleur="var(--status-valide)" />
    <x-cards.stat label="Rejetés" :valeur="$rejete" icon="fa-xmark" couleur="var(--status-rejete)" />
</div>

<div class="dash-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Projets à traiter en priorité</h6>
        <a href="{{ route('approbateur.projets.index') }}" class="small">Voir tout</a>
    </div>
    @include('dashboard.partials._projets_recents', ['projetsRecents' => $projetsUrgents, 'routeShow' => 'approbateur.projets.show'])
</div>
