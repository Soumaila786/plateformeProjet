@push('styles')
    <link rel="stylesheet" href="{{ asset('css/analytique.css') }}">
@endpush

@php
    $dataEntonnoir = [
        'labels' => array_column($entonnoir, 'lbl'),
        'values' => array_column($entonnoir, 'val'),
        'colors' => array_column($entonnoir, 'color'),
        'label' => 'Projets',
    ];
    $dataStatuts = ['labels' => $labels, 'values' => $donutValues, 'colors' => $colors];
    $dataTemporel = [
        'labels' => $tempLabels,
        'datasets' => [
            ['label' => 'Soumissions', 'data' => $tempSoumis, 'borderColor' => '#6366f1', 'backgroundColor' => '#6366f1'],
            ['label' => 'Créations', 'data' => $tempCreation, 'borderColor' => '#9ca3af', 'backgroundColor' => '#9ca3af'],
        ],
    ];
    $dataBudget = [
        'labels' => $budgetLabels,
        'datasets' => [
            ['label' => 'Budget total', 'data' => $budgetTotaux, 'borderColor' => '#0d9488', 'backgroundColor' => '#0d9488'],
            ['label' => 'Montant demandé', 'data' => $budgetDemande, 'borderColor' => '#6366f1', 'backgroundColor' => '#6366f1'],
        ],
    ];
    $dataSecteurs = ['labels' => $sectLabels, 'values' => $sectNb, 'label' => 'Projets'];
    $dataMotifs = [
        'labels' => $motifsLabels,
        'values' => $motifsValues,
        'colors' => ['#ef4444', '#f97316', '#eab308', '#6366f1', '#9ca3af'],
    ];
@endphp

<div class="an-grid">
    <div class="an-card">
        <h6><i class="fas fa-filter me-1"></i>Entonnoir de traitement</h6>
        <canvas id="anAprobEntonnoir" data-chart="{{ json_encode($dataEntonnoir) }}"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-chart-pie me-1"></i>Répartition par statut</h6>
        <canvas id="anAprobStatuts" data-chart="{{ json_encode($dataStatuts) }}"></canvas>
    </div>

    <div class="an-card an-full">
        <h6><i class="fas fa-chart-line me-1"></i>Évolution sur 12 mois (soumissions vs créations)</h6>
        <canvas id="anAprobTemporel" data-chart="{{ json_encode($dataTemporel) }}"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-coins me-1"></i>Budget vs demande (top projets)</h6>
        <canvas id="anAprobBudget" data-chart="{{ json_encode($dataBudget) }}"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-building me-1"></i>Projets par secteur</h6>
        <canvas id="anAprobSecteurs" data-chart="{{ json_encode($dataSecteurs) }}"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-comment-slash me-1"></i>Motifs de rejet</h6>
        <canvas id="anAprobMotifs" data-chart="{{ json_encode($dataMotifs) }}"></canvas>
    </div>
</div>

<div class="an-grid">
    <div class="an-card">
        <h6><i class="fas fa-stopwatch me-1"></i>Délais &amp; retards</h6>
        <div class="d-flex justify-content-between py-1 small"><span class="text-muted">Délai moyen d'approbation</span><strong>{{ $delaiAppro }} j</strong></div>
        <div class="d-flex justify-content-between py-1 small"><span class="text-muted">Délai moyen de validation</span><strong>{{ $delaiValid }} j</strong></div>
        <div class="d-flex justify-content-between py-1 small"><span class="text-muted">En attente depuis &gt; 15 jours</span><strong class="text-warning">{{ $retard15 }}</strong></div>
        <div class="d-flex justify-content-between py-1 small"><span class="text-muted">En attente depuis &gt; 30 jours</span><strong class="text-danger">{{ $retard30 }}</strong></div>
        <div class="d-flex justify-content-between py-1 small"><span class="text-muted">Montant cumulé en attente</span><strong class="font-monospace">{{ number_format($cumulAttente, 0, ',', ' ') }} FCFA</strong></div>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-ranking-star me-1"></i>Top porteurs</h6>
        @forelse ($topPorteurs as $p)
            <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }} small">
                <span>{{ $p['nom'] }}</span>
                <span class="text-muted">{{ $p['total'] }} projet(s) · <strong>{{ $p['taux'] }}%</strong></span>
            </div>
        @empty
            <p class="text-muted small mb-0 py-2 text-center">Pas encore de données.</p>
        @endforelse
    </div>

    <div class="an-card">
        <h6><i class="fas fa-calendar-check me-1"></i>Projets démarrant prochainement</h6>
        @forelse ($timeline as $t)
            <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }} small">
                <span>{{ \Illuminate\Support\Str::limit($t->titre, 30) }}</span>
                <span class="text-muted">{{ optional($t->dateDebut)->format('d/m/Y') }}</span>
            </div>
        @empty
            <p class="text-muted small mb-0 py-2 text-center">Aucun projet à venir.</p>
        @endforelse
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/charts-utils.js') }}"></script>
    <script src="{{ asset('js/analytique-approbateur.js') }}"></script>
@endpush
