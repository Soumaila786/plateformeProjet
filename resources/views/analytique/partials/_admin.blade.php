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
    $dataEvolution = [
        'labels' => $moisLabels,
        'datasets' => [
            ['label' => 'Soumis', 'data' => $moisSoumis, 'borderColor' => '#6366f1', 'backgroundColor' => '#6366f1'],
            ['label' => 'Validés', 'data' => $moisValides, 'borderColor' => '#0d9488', 'backgroundColor' => '#0d9488'],
        ],
    ];
    $dataStatuts = ['labels' => $statutLabels, 'values' => $statutValues, 'colors' => $statutColors];
    $dataSecteurs = ['labels' => $sectLabels, 'values' => $sectNb, 'label' => 'Projets'];
    $dataMotifs = [
        'labels' => $motifsLabels,
        'values' => $motifsValues,
        'colors' => ['#ef4444', '#f97316', '#eab308', '#6366f1', '#9ca3af', '#0d9488'],
    ];
    $dataEquipes = ['labels' => $equipeLabels, 'values' => $equipeNb, 'label' => 'Dossiers traités'];
@endphp

<div class="dash-stats-grid mb-3">
    <x-cards.stat label="Total projets" :valeur="$kpis['total']" icon="fa-folder" />
    <x-cards.stat label="Soumis" :valeur="$kpis['soumis']" icon="fa-paper-plane" couleur="var(--status-soumis)" />
    <x-cards.stat label="En examen" :valeur="$kpis['en_examen']" icon="fa-magnifying-glass" couleur="var(--status-en-examen)" />
    <x-cards.stat label="Approuvés" :valeur="$kpis['approuve']" icon="fa-check" couleur="var(--status-approuve)" />
    <x-cards.stat label="Validés" :valeur="$kpis['valide']" icon="fa-check-double" couleur="var(--status-valide)" />
    <x-cards.stat label="Rejetés" :valeur="$kpis['rejete']" icon="fa-xmark" couleur="var(--status-rejete)" />
</div>

<div class="an-grid">
    <div class="an-card an-full">
        <h6><i class="fas fa-filter me-1"></i>Entonnoir du circuit</h6>
        <canvas id="anAdminEntonnoir" data-chart="{{ json_encode($dataEntonnoir) }}"></canvas>
    </div>

    <div class="an-card an-full">
        <h6><i class="fas fa-chart-line me-1"></i>Évolution sur 12 mois (soumis vs validés)</h6>
        <canvas id="anAdminEvolution" data-chart="{{ json_encode($dataEvolution) }}"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-chart-pie me-1"></i>Répartition par statut</h6>
        <canvas id="anAdminStatuts" data-chart="{{ json_encode($dataStatuts) }}"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-building me-1"></i>Top secteurs (par nombre de projets)</h6>
        <canvas id="anAdminSecteurs" data-chart="{{ json_encode($dataSecteurs) }}"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-comment-slash me-1"></i>Analyse des motifs de rejet</h6>
        <canvas id="anAdminMotifs" data-chart="{{ json_encode($dataMotifs) }}"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-users-gear me-1"></i>Charge de travail des équipes</h6>
        <canvas id="anAdminEquipes" data-chart="{{ json_encode($dataEquipes) }}"></canvas>
    </div>
</div>

<div class="an-grid">
    <div class="an-card">
        <h6><i class="fas fa-stopwatch me-1"></i>Délais moyens de traitement (jours)</h6>
        <div class="d-flex justify-content-between py-1 small"><span class="text-muted">Soumission → Approbation</span><strong>{{ $delaiAppro }} j</strong></div>
        <div class="d-flex justify-content-between py-1 small"><span class="text-muted">Approbation → Validation</span><strong>{{ $delaiValid }} j</strong></div>
        <div class="d-flex justify-content-between py-1 small"><span class="text-muted">Total du processus</span><strong>{{ $delaiTotal }} j</strong></div>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-triangle-exclamation me-1"></i>Projets bloqués (&gt; 10 jours)</h6>
        @forelse ($projetsBloque as $p)
            <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }} small">
                <div>
                    <div class="fw-semibold">{{ $p['titre'] }}</div>
                    <div class="text-muted" style="font-size:.72rem;">{{ $p['porteur'] }} · {{ $p['secteur'] }}</div>
                </div>
                <span class="badge bg-warning-subtle text-warning">{{ $p['jours'] }} j</span>
            </div>
        @empty
            <p class="text-muted small mb-0 py-2 text-center">Aucun projet bloqué actuellement.</p>
        @endforelse
    </div>

    <div class="an-card">
        <h6><i class="fas fa-ranking-star me-1"></i>Performance des porteurs</h6>
        @forelse ($porteurs as $p)
            <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }} small">
                <span>{{ $p['nom'] }}</span>
                <span class="text-muted">{{ $p['total'] }} projet(s) · <strong>{{ $p['taux'] }}%</strong> réussite</span>
            </div>
        @empty
            <p class="text-muted small mb-0 py-2 text-center">Pas encore de données.</p>
        @endforelse
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/charts-utils.js') }}"></script>
    <script src="{{ asset('js/analytique-admin.js') }}"></script>
@endpush
