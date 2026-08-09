@push('styles')
    <link rel="stylesheet" href="{{ asset('css/analytique.css') }}">
@endpush

@php
    $dataEntonnoir = [
        'labels' => ['Soumis', 'Approuvés', 'Validés', 'Rejetés'],
        'values' => [$entonnoir['soumis'], $entonnoir['approuve'], $entonnoir['valide'], $entonnoir['rejete']],
        'colors' => ['#6366f1', '#22c55e', '#0d9488', '#ef4444'],
        'label' => 'Projets',
    ];
    $dataStatuts = ['labels' => $donutLabels, 'values' => $donutValues];
    $dataEvolution = [
        'labels' => $evolution['labels'],
        'datasets' => [['label' => 'Cumul FCFA', 'data' => $evolution['values'], 'borderColor' => '#6366f1', 'backgroundColor' => '#6366f1']],
    ];
    $dataDelais = ['labels' => $delais['labels'], 'values' => $delais['values'], 'label' => 'Jours'];
    $dataSecteurs = ['labels' => $heatSecteurs, 'values' => $heatData, 'label' => 'Projets'];
@endphp

<div class="dash-stats-grid mb-3">
    <x-cards.stat label="Aujourd'hui" :valeur="$perf['aujourd_hui']" icon="fa-calendar-day" />
    <x-cards.stat label="Cette semaine" :valeur="$perf['semaine']" icon="fa-calendar-week" />
    <x-cards.stat label="Total traités" :valeur="$perf['total_traites']" icon="fa-check-double" couleur="var(--status-valide)" />
    <x-cards.stat label="Taux de validation" :valeur="$perf['taux_validation'].'%'" icon="fa-percent" />
    <x-cards.stat label="En attente" :valeur="$perf['en_attente']" icon="fa-hourglass-half" couleur="var(--color-warning)" />
</div>

<div class="an-grid">
    <div class="an-card">
        <h6><i class="fas fa-filter me-1"></i>Entonnoir</h6>
        <canvas id="anValidEntonnoir" data-chart="{{ json_encode($dataEntonnoir) }}"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-chart-pie me-1"></i>Répartition par statut</h6>
        <canvas id="anValidStatuts" data-chart="{{ json_encode($dataStatuts) }}"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-gauge-high me-1"></i>Taux d'utilisation du budget</h6>
        <div class="progress mb-2" style="height:10px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $pctJauge }}%; background: var(--color-primary);"></div>
        </div>
        <div class="d-flex justify-content-between small text-muted">
            <span>{{ number_format($totalDemande, 0, ',', ' ') }} FCFA demandés</span>
            <span>{{ number_format($totalBudget, 0, ',', ' ') }} FCFA disponibles</span>
        </div>
        @if ($retard > 0)
            <div class="mt-2 small text-danger"><i class="fas fa-triangle-exclamation"></i> {{ $retard }} projet(s) en attente depuis plus de 30 jours</div>
        @endif
    </div>

    <div class="an-card an-full">
        <h6><i class="fas fa-chart-line me-1"></i>Cumul des montants demandés (12 mois)</h6>
        <canvas id="anValidEvolution" data-chart="{{ json_encode($dataEvolution) }}"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-stopwatch me-1"></i>Délais de traitement (jours)</h6>
        <canvas id="anValidDelais" data-chart="{{ json_encode($dataDelais) }}"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-building me-1"></i>Volume de projets par secteur</h6>
        <canvas id="anValidSecteurs" data-chart="{{ json_encode($dataSecteurs) }}"></canvas>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/charts-utils.js') }}"></script>
    <script src="{{ asset('js/analytique-validateur.js') }}"></script>
@endpush
