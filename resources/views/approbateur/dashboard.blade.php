@extends('layouts.app')
@section('title', 'Tableau de bord')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/approbDash.css') }}">
@endpush

@section('content')

<div class="adash">

{{-- Banner --}}
<div class="ad-banner">
    <div>
        <p class="ad-banner-sub">Bienvenue,</p>
        <h2 class="ad-banner-name">{{ Auth::user()->nomComplet }}</h2>
        <p class="ad-banner-role">Approbateur &middot; {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>
    <div class="ad-banner-icon"><i class="fas fa-check-double"></i></div>
    <div class="ad-banner-circle c1"></div>
    <div class="ad-banner-circle c2"></div>
</div>

{{-- Stats 6 cards --}}
<div class="ad-stats">
    <div class="ad-stat">
        <div class="ad-stat-top"><span class="ad-stat-lbl">Total</span><div class="ad-stat-ic"><i class="fas fa-folder"></i></div></div>
        <p class="ad-stat-val">{{ $totalProjets }}</p>
        <p class="ad-stat-hint">Tous projets</p>
    </div>
    <div class="ad-stat">
        <div class="ad-stat-top"><span class="ad-stat-lbl">Soumis</span><div class="ad-stat-ic"><i class="fas fa-paper-plane"></i></div></div>
        <p class="ad-stat-val">{{ $soumis }}</p>
        <p class="ad-stat-hint">En attente</p>
    </div>
    <div class="ad-stat">
        <div class="ad-stat-top"><span class="ad-stat-lbl">En examen</span><div class="ad-stat-ic"><i class="fas fa-search"></i></div></div>
        <p class="ad-stat-val">{{ $enExamen }}</p>
        <p class="ad-stat-hint">En cours</p>
    </div>
    <div class="ad-stat">
        <div class="ad-stat-top"><span class="ad-stat-lbl">Approuvés</span><div class="ad-stat-ic"><i class="fas fa-check-circle"></i></div></div>
        <p class="ad-stat-val">{{ $approuve }}</p>
        <p class="ad-stat-hint">Transmis au validateur</p>
    </div>
    <div class="ad-stat">
        <div class="ad-stat-top"><span class="ad-stat-lbl">Validés</span><div class="ad-stat-ic"><i class="fas fa-medal"></i></div></div>
        <p class="ad-stat-val">{{ $valide }}</p>
        <p class="ad-stat-hint">Finalisés</p>
    </div>
    <div class="ad-stat">
        <div class="ad-stat-top"><span class="ad-stat-lbl">Rejetés</span><div class="ad-stat-ic"><i class="fas fa-times-circle"></i></div></div>
        <p class="ad-stat-val">{{ $rejete }}</p>
        <p class="ad-stat-hint">Non retenus</p>
    </div>
</div>

{{-- Lien analytique --}}
<a href="{{ route('approbateur.analytique') }}" class="analytique-link">
    <div class="analytique-link-left">
        <div class="analytique-link-ic"><i class="fas fa-chart-bar"></i></div>
        <div>
            <p class="analytique-link-title">Tableau analytique</p>
            <p class="analytique-link-sub">Entonnoir, délais, budgets, motifs de rejet, secteurs, top porteurs…</p>
        </div>
    </div>
    <span class="analytique-link-cta">Accéder <i class="fas fa-arrow-right"></i></span>
</a>

{{-- Zone principale --}}
<div class="ad-main-grid">

    {{-- Projets récents --}}
    <div class="card">
        <div class="card-head">
            <h3 class="card-title">Projets récents</h3>
            <a href="{{ route('approbateur.projets.index') }}" class="link-more">Voir tous <i class="fas fa-arrow-right"></i></a>
        </div>
        @forelse($projetsRecents as $projet)
        @php
            $map = [
                'soumis'    => ['lbl'=>'Soumis',   'dot'=>'#6366f1','bg'=>'#eef2ff','color'=>'#4338ca'],
                'en_examen' => ['lbl'=>'En examen','dot'=>'#f97316','bg'=>'#fff7ed','color'=>'#c2410c'],
                'approuve'  => ['lbl'=>'Approuvé', 'dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d'],
                'rejete'    => ['lbl'=>'Rejeté',   'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c'],
            ];
            $s = $map[$projet->statutProjet] ?? $map['soumis'];
        @endphp
        <a href="{{ route('approbateur.projets.show', $projet) }}" class="projet-row">
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
    <div class="ad-aside">

        {{-- Actions urgentes --}}
        @if($projetsUrgents->count() > 0)
        <div class="card action-card">
            <div class="card-head action-head">
                <i class="fas fa-exclamation-circle"></i>
                <h3 class="card-title">À traiter ({{ $projetsUrgents->count() }})</h3>
            </div>
            @foreach($projetsUrgents->take(4) as $p)
            <a href="{{ route('approbateur.projets.show', $p) }}" class="action-row">
                <span class="dot" style="background:{{ $p->statutProjet === 'en_examen' ? '#f97316' : '#6366f1' }};margin-top:4px;flex-shrink:0;"></span>
                <p class="action-title">{{ Str::limit($p->titre, 46) }}</p>
            </a>
            @endforeach
            @if($projetsUrgents->count() > 4)
            <div style="padding:6px 14px 10px;">
                <a href="{{ route('approbateur.projets.index') }}" class="link-more">
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
                <a href="{{ route('approbateur.projets.index') }}" class="link-more">Voir tout</a>
            </div>
            @foreach([
                ['statut'=>'soumis',   'lbl'=>'Soumis',   'dot'=>'#6366f1','bg'=>'#eef2ff','color'=>'#4338ca','val'=>$soumis],
                ['statut'=>'en_examen','lbl'=>'En examen','dot'=>'#f97316','bg'=>'#fff7ed','color'=>'#c2410c','val'=>$enExamen],
                ['statut'=>'approuve', 'lbl'=>'Approuvés','dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d','val'=>$approuve],
                ['statut'=>'rejete',   'lbl'=>'Rejetés',  'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c','val'=>$rejete],
            ] as $item)
            @if($item['val'] > 0)
            <a href="{{ route('approbateur.projets.index', ['statut'=>$item['statut']]) }}" class="mp-row">
                <span class="status-badge" style="background:{{ $item['bg'] }};color:{{ $item['color'] }};">
                    <span class="dot" style="background:{{ $item['dot'] }};"></span>{{ $item['lbl'] }}
                </span>
                <span class="mp-count">{{ $item['val'] }}</span>
            </a>
            @endif
            @endforeach
            <div style="padding:10px 16px 12px;">
                <a href="{{ route('approbateur.projets.index', ['statut'=>'soumis']) }}" class="btn-primary">
                    <i class="fas fa-inbox"></i>&nbsp;Voir les projets soumis
                </a>
            </div>
        </div>

    </div>
</div>

</div>
@endsection
