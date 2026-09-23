@push('styles')
    <link rel="stylesheet" href="{{ asset('css/analytique.css') }}">
@endpush

<div class="dash-stats-grid mb-3">
    <x-cards.stat label="Mes projets" :valeur="$total" icon="fa-folder-open" />
    <x-cards.stat label="Validés" :valeur="$valides" icon="fa-check-double" couleur="var(--status-valide)" />
    <x-cards.stat label="En cours" :valeur="$enCours" icon="fa-spinner" couleur="var(--status-en-examen)" />
    <x-cards.stat label="Taux de validation" :valeur="$tauxValidation.'%'" icon="fa-chart-line" couleur="var(--color-primary)" />
    <x-cards.stat label="Brouillons" :valeur="$brouillons" icon="fa-pen" couleur="var(--status-brouillon)" />
</div>

@php
    $dataStatuts = ['labels' => array_keys($statuts), 'values' => array_values($statuts), 'colors' => ['#9ca3af', '#6366f1', '#f97316', '#0d9488', '#ef4444']];
    $dataEvolution = ['labels' => $moisLabels, 'datasets' => [
        ['label' => 'Projets créés', 'data' => $moisCrees, 'borderColor' => '#6366f1', 'backgroundColor' => '#6366f1'],
        ['label' => 'Projets soumis', 'data' => $moisSoumis, 'borderColor' => '#0d9488', 'backgroundColor' => '#0d9488'],
    ]];
    $dataSecteurs = ['labels' => $secteursLabels, 'values' => $secteursValues, 'label' => 'Projets'];
    $dataBudgets = ['labels' => $devises, 'datasets' => [
        ['label' => 'Budget total', 'data' => $budgetValues, 'backgroundColor' => '#0d9488', 'borderColor' => '#0d9488'],
        ['label' => 'Montant demandé', 'data' => $demandeValues, 'backgroundColor' => '#6366f1', 'borderColor' => '#6366f1'],
    ]];
@endphp

<div class="an-grid">
    <div class="an-card"><h6><i class="fas fa-chart-pie me-1"></i>État de mes projets</h6><canvas id="anPorteurStatuts" data-chart="{{ json_encode($dataStatuts) }}"></canvas></div>
    <div class="an-card"><h6><i class="fas fa-building me-1"></i>Projets par secteur</h6><canvas id="anPorteurSecteurs" data-chart="{{ json_encode($dataSecteurs) }}"></canvas></div>
    <div class="an-card an-full"><h6><i class="fas fa-chart-line me-1"></i>Évolution de mon activité sur 12 mois</h6><canvas id="anPorteurEvolution" data-chart="{{ json_encode($dataEvolution) }}"></canvas></div>
    <div class="an-card an-full"><h6><i class="fas fa-coins me-1"></i>Budgets par devise</h6><canvas id="anPorteurBudgets" data-chart="{{ json_encode($dataBudgets) }}"></canvas></div>
</div>

<div class="an-grid">
    <div class="an-card">
        <h6><i class="fas fa-bullseye me-1"></i>Avancement</h6>
        <div class="d-flex justify-content-between py-1 small"><span class="text-muted">Projets validés</span><strong>{{ $valides }} / {{ $total }}</strong></div>
        <div class="progress mb-3" style="height:10px"><div class="progress-bar" style="width: {{ $tauxValidation }}%; background:var(--color-primary)"></div></div>
        <div class="d-flex justify-content-between py-1 small"><span class="text-muted">Taux de rejet</span><strong class="text-danger">{{ $tauxRejet }}%</strong></div>
    </div>
    <div class="an-card">
        <h6><i class="fas fa-clock me-1"></i>Projets récents</h6>
        @forelse($projetsRecents as $projet)
            <div class="d-flex justify-content-between align-items-center py-2 small {{ !$loop->last ? 'border-bottom' : '' }}"><span class="text-truncate me-2">{{ $projet->titre }}</span><span class="badge bg-light text-dark">{{ str_replace('_', ' ', $projet->statutProjet) }}</span></div>
        @empty
            <p class="text-muted small mb-0">Aucun projet pour ces filtres.</p>
        @endforelse
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/charts-utils.js') }}"></script>
    <script src="{{ asset('js/analytique-porteur.js') }}"></script>
@endpush
