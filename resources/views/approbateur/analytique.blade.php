@extends('layouts.app')
@section('title', 'Analytique — Approbateur')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/approbDash.css') }}">
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
    <a href="{{ route('approbateur.dashboard') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Tableau de bord
    </a>
</div>

{{-- ════ DÉLAIS KPI ════ --}}
<div class="an-kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon"><i class="fas fa-stopwatch"></i></div>
        <div>
            <p class="kpi-label">Délai moyen approbation</p>
            <p class="kpi-val">{{ $delaiAppro }}<span class="kpi-unit"> j</span></p>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon"><i class="fas fa-hourglass-half"></i></div>
        <div>
            <p class="kpi-label">Délai moyen validation</p>
            <p class="kpi-val">{{ $delaiValid }}<span class="kpi-unit"> j</span></p>
        </div>
    </div>
    <div class="kpi-card {{ $retard15 > 0 ? 'kpi-warn' : '' }}">
        <div class="kpi-icon"><i class="fas fa-clock"></i></div>
        <div>
            <p class="kpi-label">En retard (+15 jours)</p>
            <p class="kpi-val">{{ $retard15 }}</p>
        </div>
    </div>
    <div class="kpi-card {{ $retard30 > 0 ? 'kpi-danger' : '' }}">
        <div class="kpi-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <div>
            <p class="kpi-label">En retard (+30 jours)</p>
            <p class="kpi-val">{{ $retard30 }}</p>
        </div>
    </div>
    <div class="kpi-card kpi-budget">
        <div class="kpi-icon"><i class="fas fa-coins"></i></div>
        <div>
            <p class="kpi-label">Demandes en attente</p>
            <p class="kpi-val" style="font-size:1rem;">{{ number_format($cumulAttente, 0, ',', ' ') }}<span class="kpi-unit"> F CFA</span></p>
        </div>
    </div>
</div>

{{-- ════ LIGNE 1 : Entonnoir + Donut ════ --}}
<div class="an-row-2">

    {{-- Entonnoir --}}
    <div class="an-card an-card-lg">
        <div class="an-card-head">
            <h3 class="an-card-title">Entonnoir des statuts</h3>
            <p class="an-card-sub">De la soumission à la validation — goulots d'étranglement</p>
        </div>
        <div class="funnel-wrap">
            @php $maxVal = max(1, collect($entonnoir)->max('val')); @endphp
            @foreach($entonnoir as $i => $step)
            @php
                $barPct = $maxVal > 0 ? (int)round((int)($step['val'] ?? 0) / $maxVal * 100) : 0;
            @endphp
            <div class="funnel-step">
                <span class="funnel-lbl-txt">{{ $step['lbl'] }}</span>
                <div class="funnel-bar-wrap">
                    <div class="funnel-bar" style="background:{{ $step['color'] }};opacity:.12;"></div>
                    <div class="funnel-bar funnel-bar-fill"
                         style="width:{{ $barPct }}%;background:{{ $step['color'] }};"></div>
                </div>
                <div class="funnel-label">
                    <span class="funnel-lbl-val" style="color:{{ $step['color'] }};">{{ (int)($step['val'] ?? 0) }}</span>
                    <span class="funnel-lbl-pct">{{ (int)($step['pct'] ?? 0) }}%</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Donut --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Répartition par statut</h3>
            <p class="an-card-sub">Distribution de tous les projets</p>
        </div>
        <div class="chart-box"><canvas id="donutChart"></canvas></div>
    </div>

</div>

{{-- ════ LIGNE 2 : Temporel + Motifs rejet ════ --}}
<div class="an-row-2">

    {{-- Courbe temporelle --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Activité — 12 derniers mois</h3>
            <p class="an-card-sub">Créations vs soumissions · Délai moyen : {{ round($delaiMoyenAppro, 1) }} j</p>
        </div>
        <div class="chart-box"><canvas id="tempoChart"></canvas></div>
    </div>

    {{-- Motifs rejet --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Motifs de rejet</h3>
            <p class="an-card-sub">Regroupement par mots-clés dans les motifs</p>
        </div>
        <div class="chart-box"><canvas id="rejetChart"></canvas></div>
    </div>

</div>

{{-- ════ LIGNE 3 : Budget projets + Distribution ════ --}}
<div class="an-row-2">

    {{-- Budget vs demande --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Budget déclaré vs montant demandé</h3>
            <p class="an-card-sub">Top 8 projets par montant demandé</p>
        </div>
        <div class="chart-box"><canvas id="budgetChart"></canvas></div>
    </div>

    {{-- Distribution tranches --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Distribution des montants demandés</h3>
            <p class="an-card-sub">Répartition par tranche (F CFA)</p>
        </div>
        <div class="chart-box"><canvas id="trancheChart"></canvas></div>
    </div>

</div>

{{-- ════ LIGNE 4 : Secteurs ════ --}}
<div class="an-card">
    <div class="an-card-head">
        <h3 class="an-card-title">Analyse par secteur</h3>
        <p class="an-card-sub">Nombre de projets et montants demandés par secteur d'activité</p>
    </div>
    <div class="chart-box" style="height:260px;"><canvas id="secteurChart"></canvas></div>
</div>

{{-- ════ LIGNE 5 : Timeline + Top porteurs ════ --}}
<div class="an-row-2">

    {{-- Timeline --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Timeline des projets approuvés</h3>
            <p class="an-card-sub">Dates de début prévues</p>
        </div>
        <div style="padding:12px 16px;">
            @forelse($timeline as $p)
            @php
                $pct = 0;
                if ($p->dateDebut && $p->dateFin) {
                    $total = max(1, \Carbon\Carbon::parse($p->dateDebut)->diffInDays(\Carbon\Carbon::parse($p->dateFin)));
                    $done  = min($total, max(0, \Carbon\Carbon::parse($p->dateDebut)->diffInDays(now())));
                    $pct   = round($done / $total * 100);
                }
            @endphp
            <div class="timeline-item">
                <div class="timeline-head">
                    <p class="timeline-name">{{ Str::limit($p->titre, 40) }}</p>
                    <span class="timeline-dates">
                        {{ optional($p->dateDebut)->format('d/m/Y') ?? '—' }}
                        → {{ optional($p->dateFin)->format('d/m/Y') ?? '—' }}
                    </span>
                </div>
                <div class="timeline-bar">
                    <div class="timeline-fill" style="width:{{ $pct }}%;"></div>
                </div>
                <p class="timeline-pct">{{ $pct }}% écoulé</p>
            </div>
            @empty
            <p class="empty-text">Aucun projet approuvé avec dates renseignées.</p>
            @endforelse
        </div>
    </div>

    {{-- Top porteurs --}}
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Top porteurs de projets</h3>
            <p class="an-card-sub">Activité et taux d'approbation</p>
        </div>
        <div style="padding:8px 0;">
            @foreach($topPorteurs as $i => $p)
            <div class="porteur-row">
                <div class="porteur-rank">{{ $i + 1 }}</div>
                <div class="porteur-info">
                    <p class="porteur-nom">{{ $p['nom'] }}</p>
                    <div class="porteur-bar-wrap">
                        <div class="porteur-bar" style="width:{{ $p['taux'] }}%;"></div>
                    </div>
                </div>
                <div class="porteur-stats">
                    <span class="porteur-total">{{ $p['total'] }} proj.</span>
                    <span class="porteur-taux">{{ $p['taux'] }}%</span>
                </div>
            </div>
            @endforeach
            @if($topPorteurs->isEmpty())
            <p class="empty-text">Aucune donnée disponible.</p>
            @endif
        </div>
    </div>

</div>

{{-- ════ MATRICE PRIORISATION ════ --}}
<div class="an-card" style="margin-bottom:0;">
    <div class="an-card-head">
        <h3 class="an-card-title">Matrice de priorisation</h3>
        <p class="an-card-sub">Projets en attente · X = Montant demandé (M F CFA) · Y = Durée (mois) · Taille = Ancienneté</p>
    </div>
    <div class="chart-box" style="height:300px;"><canvas id="matriceChart"></canvas></div>
</div>

</div>

@push('scripts')
<script>
const C = {
    indigo: '#6366f1', orange: '#f97316', green: '#22c55e',
    teal: '#0d9488', red: '#ef4444', gray: '#9ca3af', blue: '#1d4ed8'
};
const T = v => v + '1a'; // transparence ~10%

// ── Donut ──
new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        labels:   @json($labels),
        datasets: [{ data: @json($donutValues), backgroundColor: @json($colors), borderWidth:2, borderColor:'#fff', hoverOffset:6 }]
    },
    options: {
        responsive:true, maintainAspectRatio:false, cutout:'65%',
        plugins:{ legend:{ position:'bottom', labels:{ font:{size:11}, color:'#6b7280', padding:12, boxWidth:12 } } }
    }
});

// ── Courbe temporelle ──
new Chart(document.getElementById('tempoChart'), {
    type: 'line',
    data: {
        labels: @json($tempLabels),
        datasets: [
            {
                label: 'Soumissions',
                data: @json($tempSoumis),
                borderColor: C.indigo, backgroundColor: 'rgba(99,102,241,.1)',
                borderWidth:2, pointRadius:4, tension:0.4, fill:true,
            },
            {
                label: 'Créations',
                data: @json($tempCreation),
                borderColor: C.gray, backgroundColor: 'rgba(156,163,175,.07)',
                borderWidth:2, borderDash:[5,4], pointRadius:3, tension:0.4,
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
            label: 'Nombre de rejets',
            data: @json($motifsValues),
            backgroundColor: 'rgba(239,68,68,.12)',
            borderColor: C.red, borderWidth:2, borderRadius:6, borderSkipped:false,
        }]
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{display:false} },
        scales:{
            x:{ grid:{display:false}, ticks:{color:'#9ca3af',font:{size:11}} },
            y:{ beginAtZero:true, grid:{color:'#f3f4f6'}, ticks:{color:'#9ca3af',font:{size:11},stepSize:1} }
        }
    }
});

// ── Budget vs demande ──
new Chart(document.getElementById('budgetChart'), {
    type: 'bar',
    data: {
        labels: @json($budgetLabels),
        datasets: [
            { label:'Budget déclaré', data:@json($budgetTotaux),  backgroundColor:'rgba(99,102,241,.12)', borderColor:C.indigo, borderWidth:2, borderRadius:4 },
            { label:'Montant demandé',data:@json($budgetDemande), backgroundColor:'rgba(13,148,136,.12)',  borderColor:C.teal,   borderWidth:2, borderRadius:4 }
        ]
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ position:'bottom', labels:{ font:{size:11}, color:'#6b7280', padding:12, boxWidth:12 } } },
        scales:{
            x:{ grid:{display:false}, ticks:{color:'#9ca3af',font:{size:10},maxRotation:30} },
            y:{ grid:{color:'#f3f4f6'}, ticks:{ color:'#9ca3af', font:{size:11},
                callback: v => v>=1000000 ? (v/1000000).toFixed(1)+'M' : v }}
        }
    }
});

// ── Distribution tranches ──
const trancheData = @json(array_values($tranches));
const trancheLabels = @json(array_keys($tranches));
new Chart(document.getElementById('trancheChart'), {
    type: 'bar',
    data: {
        labels: trancheLabels,
        datasets: [{
            label: 'Nb projets',
            data: trancheData,
            backgroundColor: 'rgba(99,102,241,.12)',
            borderColor: C.indigo, borderWidth:2, borderRadius:6, borderSkipped:false,
        }]
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{display:false} },
        scales:{
            x:{ grid:{display:false}, ticks:{color:'#9ca3af',font:{size:11}} },
            y:{ beginAtZero:true, grid:{color:'#f3f4f6'}, ticks:{color:'#9ca3af',font:{size:11},stepSize:1} }
        }
    }
});

// ── Secteurs ──
new Chart(document.getElementById('secteurChart'), {
    type: 'bar',
    data: {
        labels: @json($sectLabels),
        datasets: [
            { label:'Nb projets',      data:@json($sectNb),      backgroundColor:'rgba(99,102,241,.12)', borderColor:C.indigo, borderWidth:2, borderRadius:4, yAxisID:'y' },
            { label:'Montant demandé', data:@json($sectDemande), backgroundColor:'rgba(13,148,136,.12)',  borderColor:C.teal,   borderWidth:2, borderRadius:4, yAxisID:'y2' }
        ]
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ position:'bottom', labels:{ font:{size:11}, color:'#6b7280', padding:12, boxWidth:12 } } },
        scales:{
            x:  { grid:{display:false}, ticks:{color:'#9ca3af',font:{size:11}} },
            y:  { position:'left',  beginAtZero:true, grid:{color:'#f3f4f6'}, ticks:{color:'#9ca3af',font:{size:11},stepSize:1} },
            y2: { position:'right', beginAtZero:true, grid:{display:false},
                    ticks:{ color:'#9ca3af', font:{size:11}, callback: v => v>=1000000 ? (v/1000000).toFixed(0)+'M' : v }}
        }
    }
});

// ── Matrice scatter ──
const matriceData = @json($matrice);
new Chart(document.getElementById('matriceChart'), {
    type: 'bubble',
    data: {
        datasets: [{
            label: 'Projets en attente',
            data: matriceData.map(p => ({ x: p.x, y: p.y, r: Math.max(5, Math.min(20, p.age / 3)) })),
            backgroundColor: 'rgba(99,102,241,.2)',
            borderColor: C.indigo, borderWidth:2,
        }]
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins:{
            legend:{display:false},
            tooltip:{
                callbacks:{
                    label: ctx => {
                        const p = matriceData[ctx.dataIndex];
                        return [`${p.label}`, `Montant: ${p.x}M F CFA`, `Durée: ${p.y} mois`, `Age: ${p.age} j`];
                    }
                }
            }
        },
        scales:{
            x:{ title:{display:true,text:'Montant demandé (M F CFA)',color:'#9ca3af',font:{size:11}}, grid:{color:'#f3f4f6'}, ticks:{color:'#9ca3af',font:{size:11}} },
            y:{ title:{display:true,text:'Durée (mois)',color:'#9ca3af',font:{size:11}}, beginAtZero:true, grid:{color:'#f3f4f6'}, ticks:{color:'#9ca3af',font:{size:11}} }
        }
    }
});
</script>
@endpush
@endsection
