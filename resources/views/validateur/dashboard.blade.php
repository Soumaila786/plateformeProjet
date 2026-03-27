@extends('layouts.app')
@section('title', 'Tableau de bord')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/validDash.css') }}">
@endpush

@section('content')
<div class="vdash">

{{-- Banner --}}
<div class="vd-banner">
    <div>
        <p class="vd-banner-sub">Bienvenue,</p>
        <h2 class="vd-banner-name">{{ Auth::user()->nomComplet }}</h2>
        <p class="vd-banner-role">Validateur &middot; {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>
    <div class="vd-banner-icon"><i class="fas fa-medal"></i></div>
    <div class="vd-banner-circle c1"></div>
    <div class="vd-banner-circle c2"></div>
</div>

{{-- Stats 5 cards --}}
<div class="vd-stats">
    <div class="vd-stat">
        <div class="vd-stat-top"><span class="vd-stat-lbl">Total projets</span><div class="vd-stat-ic"><i class="fas fa-folder"></i></div></div>
        <p class="vd-stat-val">{{ $totalProjets }}</p>
        <p class="vd-stat-hint">Tous projets confondus</p>
    </div>
    <div class="vd-stat">
        <div class="vd-stat-top"><span class="vd-stat-lbl">Soumis</span><div class="vd-stat-ic"><i class="fas fa-paper-plane"></i></div></div>
        <p class="vd-stat-val">{{ $soumis }}</p>
        <p class="vd-stat-hint">En attente d'approbation</p>
    </div>
    <div class="vd-stat">
        <div class="vd-stat-top"><span class="vd-stat-lbl">Approuvés</span><div class="vd-stat-ic"><i class="fas fa-check-circle"></i></div></div>
        <p class="vd-stat-val">{{ $enAttente }}</p>
        <p class="vd-stat-hint">Prêts à être validés</p>
    </div>
    <div class="vd-stat">
        <div class="vd-stat-top"><span class="vd-stat-lbl">Validés</span><div class="vd-stat-ic"><i class="fas fa-medal"></i></div></div>
        <p class="vd-stat-val">{{ $valides }}</p>
        <p class="vd-stat-hint">Validés définitivement</p>
    </div>
    <div class="vd-stat">
        <div class="vd-stat-top"><span class="vd-stat-lbl">Rejetés</span><div class="vd-stat-ic"><i class="fas fa-times-circle"></i></div></div>
        <p class="vd-stat-val">{{ $rejetes }}</p>
        <p class="vd-stat-hint">Projets non retenus</p>
    </div>
</div>

{{-- Lien analytique --}}
<a href="{{ route('validateur.analytique') }}" class="analytique-banner">
    <div class="analytique-banner-left">
        <div class="analytique-icon"><i class="fas fa-chart-line"></i></div>
        <div>
            <p class="analytique-title">Tableau analytique</p>
            <p class="analytique-sub">Entonnoir, délais, répartition, évolution financière, heatmap secteurs…</p>
        </div>
    </div>
    <span class="analytique-cta">Accéder <i class="fas fa-arrow-right"></i></span>
</a>

{{-- Zone principale --}}
<div class="vd-main-grid">

    {{-- Projets récents --}}
    <div class="card">
        <div class="card-head">
            <h3 class="card-title">Projets récents</h3>
            <a href="{{ route('validateur.projets.index') }}" class="link-more">Voir tous <i class="fas fa-arrow-right"></i></a>
        </div>
        @forelse($projetsRecents as $projet)
        @php
            $map = [
                'approuve' => ['lbl'=>'Approuvé','dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d'],
                'valide'   => ['lbl'=>'Validé',  'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e'],
                'rejete'   => ['lbl'=>'Rejeté',  'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c'],
            ];
            $s = $map[$projet->statutProjet] ?? $map['approuve'];
        @endphp
        <a href="{{ route('validateur.projets.show', $projet) }}" class="projet-row">
            <div class="projet-avatar">
                {{ strtoupper(substr(optional($projet->secteur)->nomSecteur ?? $projet->titre, 0, 1)) }}
            </div>
            <div class="projet-info">
                <p class="projet-name">{{ $projet->titre }}</p>
                <p class="projet-sub">
                    {{ optional($projet->porteur)->nomComplet ?? '—' }}
                    &middot; {{ optional($projet->updated_at)->translatedFormat('d F Y') }}
                </p>
            </div>
            <span class="status-badge" style="background:{{ $s['bg'] }};color:{{ $s['color'] }};">
                <span class="dot" style="background:{{ $s['dot'] }};"></span>{{ $s['lbl'] }}
            </span>
        </a>
        @empty
        <div class="empty-state">
            <i class="fas fa-folder-open"></i>
            <p>Aucun projet à traiter pour le moment</p>
        </div>
        @endforelse
    </div>

    {{-- Aside --}}
    <div class="vd-aside">

        {{-- À valider en urgence --}}
        @if($projetsUrgents->count() > 0)
        <div class="card action-card">
            <div class="card-head action-head">
                <i class="fas fa-exclamation-circle"></i>
                <h3 class="card-title">À valider ({{ $projetsUrgents->count() }})</h3>
            </div>
            @foreach($projetsUrgents->take(4) as $p)
            <a href="{{ route('validateur.projets.show', $p) }}" class="action-row">
                <span class="dot" style="background:#0d419474;margin-top:4px;flex-shrink:0;"></span>
                <p class="action-title">{{ Str::limit($p->titre, 48) }}</p>
            </a>
            @endforeach
            @if($projetsUrgents->count() > 4)
            <div style="padding:6px 14px 10px;">
                <a href="{{ route('validateur.projets.index', ['statut'=>'approuve']) }}" class="link-more">
                    +{{ $projetsUrgents->count() - 4 }} autres <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif
        </div>
        @endif

        {{-- Suivi --}}
        <div class="card">
            <div class="card-head" style="border-bottom:none;">
                <h3 class="card-title">Suivi</h3>
                <a href="{{ route('validateur.projets.index') }}" class="link-more">Voir tout</a>
            </div>
            @foreach([
                ['statut'=>'approuve','lbl'=>'Approuvés','dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d','val'=>$enAttente],
                ['statut'=>'valide',  'lbl'=>'Validés',  'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e','val'=>$valides],
                ['statut'=>'rejete',  'lbl'=>'Rejetés',  'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c','val'=>$rejetes],
            ] as $item)
            @if($item['val'] > 0)
            <a href="{{ route('validateur.projets.index', ['statut'=>$item['statut']]) }}" class="mp-row">
                <span class="status-badge" style="background:{{ $item['bg'] }};color:{{ $item['color'] }};">
                    <span class="dot" style="background:{{ $item['dot'] }};"></span>{{ $item['lbl'] }}
                </span>
                <span class="mp-count">{{ $item['val'] }}</span>
            </a>
            @endif
            @endforeach
            @if($enAttente === 0 && $valides === 0 && $rejetes === 0)
            <p class="empty-text">Aucun projet</p>
            @endif
            <div style="padding:10px 16px 12px;">
                <a href="{{ route('validateur.projets.index', ['statut'=>'approuve']) }}" class="btn-primary">
                    <i class="fas fa-inbox"></i>&nbsp;Voir les projets à valider
                </a>
            </div>
        </div>

    </div>
</div>

</div>
@endsection
