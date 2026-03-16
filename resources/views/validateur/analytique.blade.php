@extends('layouts.app')
@section('title', 'Analytique — Validateur')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/validDash.css') }}">
<link rel="stylesheet" href="{{ asset('css/analytique.css') }}">
@endpush

@section('content')
<div class="an-wrap">

{{-- Header --}}
<div class="an-header">
    <div>
        <h1 class="an-title">Tableau analytique</h1>
        <p class="an-sub">Données en temps réel · {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>
    <a href="{{ route('validateur.dashboard') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Tableau de bord
    </a>
</div>

{{-- ════ 7. PERFORMANCE ════ --}}
<div class="an-perf-grid">
    <div class="perf-card perf-main">
        <div class="perf-icon"><i class="fas fa-tachometer-alt"></i></div>
        <div>
            <p class="perf-label">Projets traités aujourd'hui</p>
            <p class="perf-val">{{ $perf['aujourd_hui'] }}</p>
        </div>
    </div>
    <div class="perf-card">
        <div class="perf-icon"><i class="fas fa-calendar-week"></i></div>
        <div>
            <p class="perf-label">Cette semaine</p>
            <p class="perf-val">{{ $perf['semaine'] }}</p>
        </div>
    </div>
    <div class="perf-card">
        <div class="perf-icon"><i class="fas fa-check-double"></i></div>
        <div>
            <p class="perf-label">Total traités</p>
            <p class="perf-val">{{ $perf['total_traites'] }}</p>
        </div>
    </div>
    <div class="perf-card">
        <div class="perf-icon"><i class="fas fa-percentage"></i></div>
        <div>
            <p class="perf-label">Taux de validation</p>
            <p class="perf-val">{{ $perf['taux_validation'] }}<span class="perf-unit">%</span></p>
        </div>
    </div>
    <div class="perf-card perf-warn">
        <div class="perf-icon"><i class="fas fa-clock"></i></div>
        <div>
            <p class="perf-label">En attente d'action</p>
            <p class="perf-val">{{ $perf['en_attente'] }}</p>
        </div>
    </div>
</div>

{{-- ════ LIGNE 1 : Entonnoir + Jauge ════ --}}
<div class="an-row-2">

    {{-- Entonnoir --}}
    <div class="an-card an-card-lg">
        <div class="an-card-head">
            <h3 class="an-card-title">Vue d'ensemble — Entonnoir des financements</h3>
            <p class="an-card-sub">Progression des projets de la soumission au financement</p>
        </div>
        <div class="funnel-wrap">
            @php
                $total = max(1, $entonnoir['soumis'] + $entonnoir['approuve'] + $entonnoir['valide'] + $entonnoir['rejete']);
                $maxVal = max(1, $entonnoir['soumis'], $entonnoir['approuve'], $entonnoir['valide'], $entonnoir['rejete']);
                $steps = [
                    ['lbl'=>'Soumis',   'val'=>$entonnoir['soumis'],   'color'=>'#6366f1'],
                    ['lbl'=>'Approuvés','val'=>$entonnoir['approuve'], 'color'=>'#22c55e'],
                    ['lbl'=>'Validés',  'val'=>$entonnoir['valide'],   'color'=>'#0d9488'],
                    ['lbl'=>'Rejetés',  'val'=>$entonnoir['rejete'],   'color'=>'#ef4444'],
                ];
            @endphp
            @foreach($steps as $step)
            @php
                $val    = (int)($step['val'] ?? 0);
                $barPct = (int)round($val / $maxVal * 100);
                $pct    = (int)round($val / $total * 100);
            @endphp
            <div class="funnel-step">
                <span class="funnel-lbl-txt">{{ $step['lbl'] }}</span>
                <div class="funnel-bar-wrap">
                    <div class="funnel-bar" style="background:{{ $step['color'] }};opacity:.15;"></div>
                    <div class="funnel-bar funnel-bar-fill"
                         style="width:{{ $barPct }}%;background:{{ $step['color'] }};"></div>
                </div>
                <div class="funnel-label">
                    <span class="funnel-lbl-val" style="color:{{ $step['color'] }};">{{ $val }}</span>
                    <span class="funnel-lbl-pct">{{ $pct }}%</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Jauge --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Couverture financière</h3>
            <p class="an-card-sub">Montant demandé vs budget total déclaré</p>
        </div>
        <div class="gauge-wrap">
            <div class="gauge-circle">
                <svg viewBox="0 0 120 120" class="gauge-svg">
                    <circle cx="60" cy="60" r="50" fill="none" stroke="#f3f4f6" stroke-width="10"/>
                    <circle cx="60" cy="60" r="50" fill="none" stroke="#0d9488" stroke-width="10"
                            stroke-dasharray="{{ round($pctJauge * 3.14159) }} 314"
                            stroke-dashoffset="78.5"
                            stroke-linecap="round"
                            transform="rotate(-90 60 60)"/>
                </svg>
                <div class="gauge-inner">
                    <p class="gauge-pct">{{ $pctJauge }}<span>%</span></p>
                    <p class="gauge-sub-lbl">couvert</p>
                </div>
            </div>
            <div class="gauge-legend">
                <div class="gauge-leg-item">
                    <span class="gauge-dot" style="background:#0d9488;"></span>
                    <div>
                        <p class="gauge-leg-lbl">Montant demandé</p>
                        <p class="gauge-leg-val">{{ number_format($totalDemande, 0, ',', ' ') }} F CFA</p>
                    </div>
                </div>
                <div class="gauge-leg-item">
                    <span class="gauge-dot" style="background:#e5e7eb;"></span>
                    <div>
                        <p class="gauge-leg-lbl">Budget total déclaré</p>
                        <p class="gauge-leg-val">{{ number_format($totalBudget, 0, ',', ' ') }} F CFA</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ════ LIGNE 2 : Donut + Délais ════ --}}
<div class="an-row-2">

    {{-- Donut statuts --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Répartition par statut</h3>
            <p class="an-card-sub">Distribution actuelle de tous les projets</p>
        </div>
        <div class="chart-box"><canvas id="donutChart"></canvas></div>
    </div>

    {{-- Délais --}}
    <div class="an-card an-card-lg">
        <div class="an-card-head">
            <h3 class="an-card-title">Délais de traitement</h3>
            <p class="an-card-sub">Temps moyen en jours à chaque étape · {{ $retard }} projet(s) en retard (+30j)</p>
        </div>
        <div class="chart-box"><canvas id="delaiChart"></canvas></div>
        @if($retard > 0)
        <div class="retard-alert">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ $retard }} projet(s) sans décision depuis plus de 30 jours</span>
            <a href="{{ route('validateur.projets.index') }}">Voir</a>
        </div>
        @endif
    </div>

</div>

{{-- ════ LIGNE 3 : Barres secteurs + Courbe évolution ════ --}}
<div class="an-row-2">

    {{-- Barres empilées par secteur --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Analyse financière par secteur</h3>
            <p class="an-card-sub">Budget déclaré vs montant demandé</p>
        </div>
        <div class="chart-box"><canvas id="secteurChart"></canvas></div>
    </div>

    {{-- Courbe cumulative --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Évolution cumulative des demandes</h3>
            <p class="an-card-sub">Cumul des montants demandés — 12 derniers mois</p>
        </div>
        <div class="chart-box"><canvas id="evolutionChart"></canvas></div>
    </div>

</div>

{{-- ════ LIGNE 4 : Heatmap secteurs ════ --}}
<div class="an-card" style="margin-bottom:0;">
    <div class="an-card-head">
        <h3 class="an-card-title">Concentration des projets par secteur</h3>
        <p class="an-card-sub">Nombre de projets par secteur d'activité</p>
    </div>
    <div class="heatmap-wrap">
        @php $maxHeat = max(1, max($heatData ?: [1])); @endphp
        @foreach($heatSecteurs as $i => $sect)
        @php
            $val    = $heatData[$i] ?? 0;
            $pct    = round($val / $maxHeat * 100);
            $alpha  = 0.1 + ($pct / 100 * 0.85);
        @endphp
        <div class="heat-cell" style="background:rgba(13,148,136,{{ number_format($alpha, 2) }});">
            <p class="heat-sect">{{ $sect }}</p>
            <p class="heat-val" style="color:{{ $pct > 50 ? '#fff' : '#0d9488' }};">{{ $val }}</p>
            <p class="heat-lbl" style="color:{{ $pct > 50 ? 'rgba(255,255,255,.7)' : '#9ca3af' }};">projet(s)</p>
        </div>
        @endforeach
        @if(empty($heatSecteurs))
        <p style="color:#9ca3af;font-size:.8rem;padding:20px;">Aucune donnée disponible.</p>
        @endif
    </div>
</div>

</div>

@push('scripts')
<script>
const TEAL    = '#0d9488';
const TEAL_T  = 'rgba(13,148,136,.12)';
const GRAY    = '#e5e7eb';
const INDIGO  = '#6366f1';
const GREEN   = '#22c55e';
const RED     = '#ef4444';

const PALETTE = [TEAL,'#6366f1','#22c55e','#f97316','#ef4444','#9ca3af','#1d4ed8'];

// ── Donut ──
new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        labels:   @json($donutLabels),
        datasets: [{
            data:            @json($donutValues),
            backgroundColor: PALETTE,
            borderWidth:     2,
            borderColor:     '#fff',
            hoverOffset:     6,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false, cutout: '65%',
        plugins: {
            legend: { position:'bottom', labels:{ font:{size:11}, color:'#6b7280', padding:14, boxWidth:12 } }
        }
    }
});

// ── Délais ──
new Chart(document.getElementById('delaiChart'), {
    type: 'bar',
    data: {
        labels:   @json($delais['labels']),
        datasets: [{
            label: 'Jours (moyenne)',
            data:  @json($delais['values']),
            backgroundColor: [TEAL_T, 'rgba(99,102,241,.12)', 'rgba(249,115,22,.12)'],
            borderColor:     [TEAL,   INDIGO,                  '#f97316'],
            borderWidth: 2, borderRadius: 6, borderSkipped: false,
        }]
    },
    options: {
        responsive:true, maintainAspectRatio:false, indexAxis:'y',
        plugins:{ legend:{display:false} },
        scales:{
            x:{ beginAtZero:true, grid:{color:'#f3f4f6'}, ticks:{color:'#9ca3af',font:{size:11}},
                title:{display:true,text:'Jours',color:'#9ca3af',font:{size:11}} },
            y:{ grid:{display:false}, ticks:{color:'#374151',font:{size:11}} }
        }
    }
});

// ── Secteurs barres groupées ──
new Chart(document.getElementById('secteurChart'), {
    type: 'bar',
    data: {
        labels: @json($secteurLabels),
        datasets: [
            {
                label: 'Budget déclaré',
                data:  @json($secteurBudget),
                backgroundColor: TEAL_T, borderColor: TEAL,
                borderWidth:2, borderRadius:4,
            },
            {
                label: 'Montant demandé',
                data:  @json($secteurDemande),
                backgroundColor: 'rgba(99,102,241,.12)', borderColor: INDIGO,
                borderWidth:2, borderRadius:4,
            }
        ]
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ position:'bottom', labels:{font:{size:11},color:'#6b7280',boxWidth:12,padding:14} } },
        scales:{
            x:{ grid:{display:false}, ticks:{color:'#9ca3af',font:{size:11}} },
            y:{ grid:{color:'#f3f4f6'}, ticks:{color:'#9ca3af',font:{size:11},
                callback: v => v >= 1000000 ? (v/1000000).toFixed(1)+'M' : v } }
        }
    }
});

// ── Évolution cumulative ──
new Chart(document.getElementById('evolutionChart'), {
    type: 'line',
    data: {
        labels: @json($evolution['labels']),
        datasets: [{
            label: 'Cumul demandes (F CFA)',
            data:  @json($evolution['values']),
            borderColor: TEAL, backgroundColor: TEAL_T,
            borderWidth:2.5, pointBackgroundColor:TEAL,
            pointRadius:4, pointHoverRadius:6,
            tension:0.4, fill:true,
        }]
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{display:false} },
        scales:{
            x:{ grid:{display:false}, ticks:{color:'#9ca3af',font:{size:11}} },
            y:{ grid:{color:'#f3f4f6'}, beginAtZero:true,
                ticks:{ color:'#9ca3af', font:{size:11},
                    callback: v => v >= 1000000 ? (v/1000000).toFixed(1)+'M' : v }}
        }
    }
});
</script>
@endpush
@endsection
