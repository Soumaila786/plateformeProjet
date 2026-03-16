@extends('layouts.app')
@section('title', 'Analytique — Administration')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/adminAnalytique.css') }}">
@endpush

@section('content')
<div class="an-wrap">

{{-- Header --}}
<div class="an-header">
    <div>
        <h1 class="an-title">Tableau analytique</h1>
        <p class="an-sub">Vue globale en temps réel · {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Tableau de bord
    </a>
</div>

{{-- ════ 1. KPIs ════ --}}
<div class="kpi-grid">
    @php
        $kpiItems = [
            ['lbl'=>'Total projets', 'val'=>$kpis['total'],     'icon'=>'fa-folder',       'cls'=>''],
            ['lbl'=>'Brouillons',    'val'=>$kpis['brouillon'], 'icon'=>'fa-edit',         'cls'=>''],
            ['lbl'=>'Soumis',        'val'=>$kpis['soumis'],    'icon'=>'fa-paper-plane',  'cls'=>'kpi-indigo'],
            ['lbl'=>'En examen',     'val'=>$kpis['en_examen'], 'icon'=>'fa-search',       'cls'=>'kpi-orange'],
            ['lbl'=>'Approuvés',     'val'=>$kpis['approuve'],  'icon'=>'fa-check-circle', 'cls'=>'kpi-green'],
            ['lbl'=>'Rejetés',       'val'=>$kpis['rejete'],    'icon'=>'fa-times-circle', 'cls'=>'kpi-red'],
            ['lbl'=>'Validés',       'val'=>$kpis['valide'],    'icon'=>'fa-medal',        'cls'=>'kpi-teal'],
        ];
    @endphp
    @foreach($kpiItems as $k)
    <div class="kpi-card {{ $k['cls'] }}">
        <div class="kpi-top">
            <span class="kpi-lbl">{{ $k['lbl'] }}</span>
            <div class="kpi-icon"><i class="fas {{ $k['icon'] }}"></i></div>
        </div>
        <p class="kpi-val">{{ $k['val'] }}</p>
    </div>
    @endforeach
</div>

{{-- ════ DÉLAIS KPI ════ --}}
<div class="delai-grid">
    <div class="delai-card">
        <i class="fas fa-stopwatch delai-ic"></i>
        <div>
            <p class="delai-lbl">Délai moyen approbation</p>
            <p class="delai-val">{{ $delaiAppro }}<span> jours</span></p>
        </div>
    </div>
    <div class="delai-card">
        <i class="fas fa-hourglass-half delai-ic"></i>
        <div>
            <p class="delai-lbl">Délai moyen validation</p>
            <p class="delai-val">{{ $delaiValid }}<span> jours</span></p>
        </div>
    </div>
    <div class="delai-card delai-total">
        <i class="fas fa-flag-checkered delai-ic"></i>
        <div>
            <p class="delai-lbl">Délai total (soumission → validation)</p>
            <p class="delai-val">{{ $delaiTotal }}<span> jours</span></p>
        </div>
    </div>
</div>

{{-- ════ LIGNE 1 : Entonnoir + Donut ════ --}}
<div class="an-row-2">

    {{-- Entonnoir --}}
    <div class="an-card an-card-lg">
        <div class="an-card-head">
            <h3 class="an-card-title">Entonnoir complet du processus</h3>
            <p class="an-card-sub">De la création à la validation finale</p>
        </div>
        <div class="funnel-wrap">
            @foreach($entonnoir as $i => $step)
            @php
                $stepVal  = (int)($step['val'] ?? 0);
                $maxRef   = (int)($maxEntonnoir ?? 1);
                $barPct   = $maxRef > 0 ? (int)round($stepVal / $maxRef * 100) : 0;
                $ref0     = (int)($entonnoir[0]['val'] ?? 1);
                $totalRef = $ref0 > 0 ? $ref0 : 1;
                $conv     = (int)round($stepVal / $totalRef * 100);
            @endphp
            <div class="funnel-step">
                <span class="funnel-lbl-txt">{{ $step['lbl'] }}</span>
                <div class="funnel-bar-wrap">
                    <div class="funnel-bar" style="background:{{ $step['color'] }};opacity:.12;"></div>
                    <div class="funnel-bar funnel-bar-fill" style="width:{{ $barPct }}%;background:{{ $step['color'] }};"></div>
                </div>
                <div class="funnel-label">
                    <span class="funnel-lbl-val" style="color:{{ $step['color'] }};">{{ $stepVal }}</span>
                    <span class="funnel-lbl-pct">{{ $conv }}%</span>
                </div>
            </div>
            @endforeach
            <div class="funnel-rejet">
                <i class="fas fa-times-circle" style="color:#ef4444;font-size:.75rem;"></i>
                <span>Rejetés : <strong style="color:#ef4444;">{{ $kpis['rejete'] }}</strong> projet(s) sur l'ensemble du processus</span>
            </div>
        </div>
    </div>

    {{-- Donut répartition --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Répartition par statut</h3>
            <p class="an-card-sub">Distribution de tous les projets</p>
        </div>
        <div class="chart-box"><canvas id="donutChart"></canvas></div>
    </div>

</div>

{{-- ════ LIGNE 2 : Évolution + Rejets ════ --}}
<div class="an-row-2">

    {{-- Évolution mensuelle --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Évolution mensuelle</h3>
            <p class="an-card-sub">Soumissions vs validations — 12 derniers mois</p>
        </div>
        <div class="chart-box"><canvas id="evolutionChart"></canvas></div>
    </div>

    {{-- Analyse rejets --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Motifs de rejet</h3>
            <p class="an-card-sub">Regroupement par mots-clés</p>
        </div>
        <div class="chart-box"><canvas id="rejetChart"></canvas></div>
    </div>

</div>

{{-- ════ LIGNE 3 : Secteurs ════ --}}
<div class="an-card">
    <div class="an-card-head">
        <h3 class="an-card-title">Top secteurs d'activité</h3>
        <p class="an-card-sub">Nombre de projets et montants demandés par secteur</p>
    </div>
    <div class="chart-box" style="height:260px;"><canvas id="secteurChart"></canvas></div>
</div>

{{-- ════ LIGNE 4 : Performance porteurs + Charge équipes ════ --}}
<div class="an-row-2">

    {{-- Top porteurs --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Performance des porteurs</h3>
            <p class="an-card-sub">Top 10 par nombre de projets et taux de réussite</p>
        </div>
        <div class="porteurs-list">
            @foreach($porteurs as $i => $p)
            <div class="porteur-row">
                <div class="porteur-rank {{ $i < 3 ? 'top-'.($i+1) : '' }}">{{ $i + 1 }}</div>
                <div class="porteur-info">
                    <div class="porteur-head">
                        <p class="porteur-nom">{{ $p['nom'] }}</p>
                        <div class="porteur-badges">
                            <span class="porteur-badge">{{ $p['total'] }} proj.</span>
                            @if($p['rejete'] > 0)
                            <span class="porteur-badge porteur-badge-red">{{ $p['rejete'] }} rej.</span>
                            @endif
                        </div>
                    </div>
                    <div class="porteur-bar-wrap">
                        <div class="porteur-bar" style="width:{{ $p['taux'] }}%;"></div>
                    </div>
                    <p class="porteur-taux-lbl">{{ $p['taux'] }}% de réussite</p>
                </div>
            </div>
            @endforeach
            @if($porteurs->isEmpty())
            <p class="empty-text">Aucune donnée disponible.</p>
            @endif
        </div>
    </div>

    {{-- Charge équipes --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Charge de travail des équipes</h3>
            <p class="an-card-sub">Projets traités par approbateur et validateur</p>
        </div>
        <div class="chart-box"><canvas id="equipeChart"></canvas></div>
    </div>

</div>

{{-- ════ 9. PROJETS BLOQUÉS ════ --}}
<div class="an-card" style="margin-bottom:0;">
    <div class="an-card-head">
        <h3 class="an-card-title">
            Projets en attente critique
            @if($projetsBloque->count() > 0)
            <span class="bloque-badge">{{ $projetsBloque->count() }}</span>
            @endif
        </h3>
        <p class="an-card-sub">Bloqués depuis plus de 10 jours sans changement de statut</p>
    </div>

    @if($projetsBloque->isEmpty())
    <div class="empty-state" style="padding:24px;">
        <i class="fas fa-check-circle" style="color:#22c55e;font-size:1.8rem;"></i>
        <p>Aucun projet bloqué. Tout est traité dans les délais.</p>
    </div>
    @else
    <div class="bloque-table-wrap">
        <table class="bloque-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Titre</th>
                    <th>Statut</th>
                    <th>Porteur</th>
                    <th>Secteur</th>
                    <th>Bloqué depuis</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projetsBloque as $p)
                @php
                    $mapStatut = [
                        'soumis'    => ['lbl'=>'Soumis',   'bg'=>'#eef2ff','color'=>'#4338ca','dot'=>'#6366f1'],
                        'en_examen' => ['lbl'=>'En examen','bg'=>'#fff7ed','color'=>'#c2410c','dot'=>'#f97316'],
                        'approuve'  => ['lbl'=>'Approuvé', 'bg'=>'#f0fdf4','color'=>'#15803d','dot'=>'#22c55e'],
                    ];
                    $st = $mapStatut[$p['statut']] ?? $mapStatut['soumis'];
                    $urgence = $p['jours'] >= 30 ? 'row-danger' : ($p['jours'] >= 20 ? 'row-warn' : '');
                @endphp
                <tr class="{{ $urgence }}">
                    <td><span class="bloque-code">{{ $p['code'] }}</span></td>
                    <td class="bloque-titre">{{ Str::limit($p['titre'], 40) }}</td>
                    <td>
                        <span class="status-badge" style="background:{{ $st['bg'] }};color:{{ $st['color'] }};">
                            <span class="dot" style="background:{{ $st['dot'] }};"></span>{{ $st['lbl'] }}
                        </span>
                    </td>
                    <td class="td-muted">{{ $p['porteur'] }}</td>
                    <td class="td-muted">{{ $p['secteur'] }}</td>
                    <td>
                        <span class="jours-badge {{ $p['jours'] >= 30 ? 'jours-danger' : ($p['jours'] >= 20 ? 'jours-warn' : 'jours-normal') }}">
                            <i class="fas fa-clock"></i> {{ $p['jours'] }} j
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

</div>

@push('scripts')
<script>
const C = {
    indigo:'#6366f1', orange:'#f97316', green:'#22c55e',
    teal:'#0d9488', red:'#ef4444', gray:'#9ca3af'
};

// ── Donut ──
new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        labels:   @json($statutLabels),
        datasets: [{
            data:            @json($statutValues),
            backgroundColor: @json($statutColors),
            borderWidth: 2, borderColor: '#fff', hoverOffset: 6
        }]
    },
    options: {
        responsive:true, maintainAspectRatio:false, cutout:'65%',
        plugins:{ legend:{ position:'bottom', labels:{ font:{size:11}, color:'#6b7280', padding:12, boxWidth:12 } } }
    }
});

// ── Évolution mensuelle ──
new Chart(document.getElementById('evolutionChart'), {
    type: 'line',
    data: {
        labels: @json($moisLabels),
        datasets: [
            {
                label: 'Soumissions',
                data: @json($moisSoumis),
                borderColor: C.indigo, backgroundColor: 'rgba(99,102,241,.1)',
                borderWidth:2, pointRadius:4, tension:0.4, fill:true,
            },
            {
                label: 'Validations',
                data: @json($moisValides),
                borderColor: C.teal, backgroundColor: 'rgba(13,148,136,.08)',
                borderWidth:2, borderDash:[5,4], pointRadius:4, tension:0.4, fill:false,
            }
        ]
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ position:'bottom', labels:{ font:{size:11}, color:'#6b7280', padding:12, boxWidth:12 } } },
        scales:{
            x:{ grid:{display:false}, ticks:{color:'#9ca3af',font:{size:11}} },
            y:{ beginAtZero:true, grid:{color:'#f3f4f6'}, ticks:{color:'#9ca3af',font:{size:11},stepSize:1} }
        }
    }
});

// ── Motifs rejet ──
new Chart(document.getElementById('rejetChart'), {
    type: 'bar',
    data: {
        labels: @json($motifsLabels),
        datasets: [{
            label: 'Occurrences',
            data: @json($motifsValues),
            backgroundColor: 'rgba(239,68,68,.12)',
            borderColor: C.red, borderWidth:2, borderRadius:6, borderSkipped:false,
        }]
    },
    options: {
        responsive:true, maintainAspectRatio:false, indexAxis:'y',
        plugins:{ legend:{display:false} },
        scales:{
            x:{ beginAtZero:true, grid:{color:'#f3f4f6'}, ticks:{color:'#9ca3af',font:{size:11},stepSize:1} },
            y:{ grid:{display:false}, ticks:{color:'#374151',font:{size:11}} }
        }
    }
});

// ── Secteurs double axe ──
new Chart(document.getElementById('secteurChart'), {
    type: 'bar',
    data: {
        labels: @json($sectLabels),
        datasets: [
            {
                label:'Nb projets', data:@json($sectNb),
                backgroundColor:'rgba(99,102,241,.12)', borderColor:C.indigo,
                borderWidth:2, borderRadius:4, yAxisID:'y'
            },
            {
                label:'Nb validés', data:@json($sectValide),
                backgroundColor:'rgba(13,148,136,.12)', borderColor:C.teal,
                borderWidth:2, borderRadius:4, yAxisID:'y'
            },
            {
                label:'Montant demandé (M)', data: @json($sectDemande).map(v => +(v/1000000).toFixed(1)),
                backgroundColor:'rgba(249,115,22,.12)', borderColor:C.orange,
                borderWidth:2, borderRadius:4, yAxisID:'y2', type:'line',
                pointRadius:4, tension:0.3,
            }
        ]
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ position:'bottom', labels:{ font:{size:11}, color:'#6b7280', padding:12, boxWidth:12 } } },
        scales:{
            x:  { grid:{display:false}, ticks:{color:'#9ca3af',font:{size:11}} },
            y:  { position:'left',  beginAtZero:true, grid:{color:'#f3f4f6'}, ticks:{color:'#9ca3af',font:{size:11},stepSize:1} },
            y2: { position:'right', beginAtZero:true, grid:{display:false},
                  ticks:{ color:'#9ca3af', font:{size:11}, callback: v => v+'M' } }
        }
    }
});

// ── Charge équipes ──
const equipeColors = @json($equipeRoles).map(r =>
    r === 'Approbateur' ? 'rgba(99,102,241,.2)' : 'rgba(13,148,136,.2)'
);
const equipeBorders = @json($equipeRoles).map(r =>
    r === 'Approbateur' ? C.indigo : C.teal
);
new Chart(document.getElementById('equipeChart'), {
    type: 'bar',
    data: {
        labels: @json($equipeLabels),
        datasets: [{
            label: 'Projets traités',
            data: @json($equipeNb),
            backgroundColor: equipeColors,
            borderColor: equipeBorders,
            borderWidth: 2, borderRadius: 6, borderSkipped: false,
        }]
    },
    options: {
        responsive:true, maintainAspectRatio:false, indexAxis:'y',
        plugins:{
            legend:{display:false},
            tooltip:{
                callbacks:{
                    label: ctx => {
                        const role = @json($equipeRoles)[ctx.dataIndex];
                        return ` ${ctx.parsed.x} projets traités (${role})`;
                    }
                }
            }
        },
        scales:{
            x:{ beginAtZero:true, grid:{color:'#f3f4f6'}, ticks:{color:'#9ca3af',font:{size:11},stepSize:1} },
            y:{ grid:{display:false}, ticks:{color:'#374151',font:{size:11}} }
        }
    }
});
</script>
@endpush
@endsection
