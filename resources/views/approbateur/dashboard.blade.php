@extends('layouts.app')
@section('title', 'Tableau de bord — Approbateur')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/approbDash.css') }}">
@endpush

@section('content')

{{-- ── Welcome Banner ── --}}
<div class="welcome-banner mb-4">
    <div>
        <div class="welcome-sub">Bienvenue,</div>
        <h2 class="welcome-name">{{ auth()->user()->nomComplet }}</h2>
        <div class="welcome-role">Approbateur</div>
    </div>
    <div class="welcome-icon">
        <i class="fas fa-check-double"></i>
    </div>
</div>

<div class="trait"></div>

{{-- ── Stats ── --}}
<p class="dash-section-label">Vue d'ensemble</p>
<div class="aprob-stats-grid">
    <div class="stat-card">
        <div class="stat-top">
            <span class="stat-label">Total reçus</span>
            <div class="stat-icon icon-blue"><i class="fas fa-folder"></i></div>
        </div>
        <div class="stat-value">{{ $totalProjets }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-top">
            <span class="stat-label">En attente</span>
            <div class="stat-icon icon-orange"><i class="fas fa-clock"></i></div>
        </div>
        <div class="stat-value">{{ $enAttente }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-top">
            <span class="stat-label">En examen</span>
            <div class="stat-icon icon-yellow"><i class="fas fa-search"></i></div>
        </div>
        <div class="stat-value">{{ $enExamen }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-top">
            <span class="stat-label">Approuvés</span>
            <div class="stat-icon icon-green"><i class="fas fa-check-circle"></i></div>
        </div>
        <div class="stat-value">{{ $approuves }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-top">
            <span class="stat-label">Rejetés</span>
            <div class="stat-icon icon-red"><i class="fas fa-times-circle"></i></div>
        </div>
        <div class="stat-value">{{ $rejetes }}</div>
    </div>
</div>

{{-- ── Layout principal ── --}}
<div class="aprob-main-grid">

    {{-- Colonne gauche : Projets récents --}}
    <div class="form-card">
        <div class="form-card-header" style="justify-content:space-between;">
            <span><i class="fas fa-clock"></i> Projets récents</span>
            <a href="{{ route('approbateur.projets.index') }}" class="dash-table-link">Voir tous →</a>
        </div>
        <div class="form-card-body" style="padding:8px 16px;">
            @forelse($projetsRecents as $projet)
            @php
                $sc = ['soumis'=>'status-blue','en_examen'=>'status-yellow','approuve'=>'status-green','rejete'=>'status-red','brouillon'=>'status-gray'][$projet->statutProjet] ?? 'status-gray';
                $sl = ['soumis'=>'Soumis','en_examen'=>'En examen','approuve'=>'Approuvé','rejete'=>'Rejeté','brouillon'=>'Brouillon'][$projet->statutProjet] ?? $projet->statutProjet;
            @endphp
            <a href="{{ route('approbateur.projets.show', $projet) }}" class="projet-mini-item">
                <div class="projet-mini-initial">{{ strtoupper(substr($projet->titre, 0, 1)) }}</div>
                <div class="projet-mini-info">
                    <p class="projet-mini-titre">{{ $projet->titre }}</p>
                    <p class="projet-mini-sub">
                        {{ optional($projet->porteur)->nomComplet ?? '—' }} ·
                        {{ optional($projet->secteur)->nomSecteur ?? '—' }}
                    </p>
                </div>
                <span class="status-badge {{ $sc }}">{{ $sl }}</span>
            </a>
            @empty
            <div class="info-empty-box">
                <i class="fas fa-folder-open"></i>
                <p>Aucun projet à traiter.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Colonne droite : Actions requises + Suivi --}}
    <div class="aprob-side-col">

        {{-- Actions requises --}}
        @if($projetsUrgents->count() > 0)
        <div class="form-card aprob-urgent-card">
            <div class="form-card-header" style="background:#fff7ed;border-bottom:1.5px solid #fed7aa;">
                <i class="fas fa-exclamation-circle" style="color:#ea580c;"></i>
                <span style="color:#c2410c;font-weight:700;">
                    Actions requises ({{ $projetsUrgents->count() }})
                </span>
            </div>
            <div class="form-card-body" style="padding:8px 16px;">
                @foreach($projetsUrgents as $p)
                <a href="{{ route('approbateur.projets.show', $p) }}" class="urgent-item">
                    <i class="fas fa-arrow-right urgent-arrow"></i>
                    <span class="urgent-titre">{{ Str::limit($p->titre, 45) }}</span>
                    <span class="status-badge {{ $p->statutProjet === 'soumis' ? 'status-blue' : 'status-yellow' }}">
                        {{ $p->statutProjet === 'soumis' ? 'Soumis' : 'En examen' }}
                    </span>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Suivi statuts --}}
        <div class="form-card">
            <div class="form-card-header" style="justify-content:space-between;">
                <span><i class="fas fa-chart-pie"></i> Suivi</span>
                <a href="{{ route('approbateur.projets.index') }}" class="dash-table-link">Voir tous</a>
            </div>
            <div class="form-card-body" style="padding:8px 16px;">
                @foreach([
                    ['label'=>'Soumis',    'value'=>$soumis,    'color'=>'#3b82f6'],
                    ['label'=>'En examen', 'value'=>$enExamen,  'color'=>'#f97316'],
                    ['label'=>'Approuvés', 'value'=>$approuves, 'color'=>'#22c55e'],
                    ['label'=>'Rejetés',   'value'=>$rejetes,   'color'=>'#ef4444'],
                ] as $item)
                @if($item['value'] > 0)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f3f4f6;">
                    <span style="display:flex;align-items:center;gap:8px;font-size:.82rem;color:#374151;">
                        <span style="width:8px;height:8px;border-radius:50%;background:{{ $item['color'] }};display:inline-block;"></span>
                        {{ $item['label'] }}
                    </span>
                    <span style="font-size:.82rem;font-weight:700;color:#111827;">{{ $item['value'] }}</span>
                </div>
                @endif
                @endforeach
                @if($totalProjets === 0)
                <div class="info-empty-box">
                    <i class="fas fa-inbox"></i>
                    <p>Aucun projet.</p>
                </div>
                @endif
                <a href="{{ route('approbateur.projets.index', ['statut'=>'soumis']) }}"
                   class="btn-add w-100" style="margin-top:12px;justify-content:center;">
                    <i class="fas fa-inbox"></i> Voir les projets soumis
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
