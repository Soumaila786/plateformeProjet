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

    {{-- Passer les données PHP au JavaScript --}}
    <script>
        window.approbateurData = {
            donut: {
                labels: @json($labels),
                values: @json($donutValues),
                colors: @json($colors)
            },
            temporel: {
                labels: @json($tempLabels),
                soumis: @json($tempSoumis),
                creation: @json($tempCreation)
            },
            motifs: {
                labels: @json($motifsLabels),
                values: @json($motifsValues)
            },
            budget: {
                labels: @json($budgetLabels),
                totaux: @json($budgetTotaux),
                demande: @json($budgetDemande)
            },
            tranches: {
                labels: @json(array_keys($tranches)),
                values: @json(array_values($tranches))
            },
            secteurs: {
                labels: @json($sectLabels),
                nb: @json($sectNb),
                demande: @json($sectDemande)
            },
            matrice: @json($matrice)
        };
    </script>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
        <script src="{{ asset('js/approbateurAnalytique.js') }}"></script>
    @endpush
@endsection
