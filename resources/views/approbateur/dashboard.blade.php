@extends('layouts.app')
@section('title', 'Tableau de bord — Approbateur')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/approbDash.css') }}">
@endpush

@section('content')

{{-- ── Welcome Banner ── --}}
<div class="welcome-banner">
    <div>
        <div class="welcome-sub">Bienvenue,</div>
        <h2 class="welcome-name">{{ auth()->user()->nomComplet }}</h2>
        <div class="welcome-role">Approbateur · {{ now()->isoFormat('D MMMM YYYY') }}</div>
    </div>
    <div class="welcome-icon"><i class="fas fa-check-double"></i></div>
</div>

{{-- ── Stats : 6 cards ── --}}
<p class="adash-section-label">Vue d'ensemble</p>
<div class="adash-stats-grid">
    <div class="adash-stat-card">
        <div class="adash-stat-top">
            <span class="adash-stat-label">Total reçus</span>
            <div class="adash-stat-icon icon-blue"><i class="fas fa-folder"></i></div>
        </div>
        <div class="adash-stat-value">{{ $totalProjets }}</div>
    </div>
    <div class="adash-stat-card">
        <div class="adash-stat-top">
            <span class="adash-stat-label">Soumis</span>
            <div class="adash-stat-icon icon-indigo"><i class="fas fa-paper-plane"></i></div>
        </div>
        <div class="adash-stat-value">{{ $soumis }}</div>
    </div>
    <div class="adash-stat-card">
        <div class="adash-stat-top">
            <span class="adash-stat-label">En examen</span>
            <div class="adash-stat-icon icon-yellow"><i class="fas fa-search"></i></div>
        </div>
        <div class="adash-stat-value">{{ $enExamen }}</div>
    </div>
    <div class="adash-stat-card">
        <div class="adash-stat-top">
            <span class="adash-stat-label">Approuvés</span>
            <div class="adash-stat-icon icon-green"><i class="fas fa-check-circle"></i></div>
        </div>
        <div class="adash-stat-value">{{ $approuves }}</div>
    </div>
    <div class="adash-stat-card">
        <div class="adash-stat-top">
            <span class="adash-stat-label">Rejetés</span>
            <div class="adash-stat-icon icon-red"><i class="fas fa-times-circle"></i></div>
        </div>
        <div class="adash-stat-value">{{ $rejetes }}</div>
    </div>
    <div class="adash-stat-card">
        <div class="adash-stat-top">
            <span class="adash-stat-label">Mes projets</span>
            <div class="adash-stat-icon icon-teal"><i class="fas fa-briefcase"></i></div>
        </div>
        <div class="adash-stat-value">{{ $enAttente }}</div>
    </div>
</div>

{{-- ── Actions requises ── --}}
<div class="adash-card mb-4" style="margin-bottom:28px;">
    <div class="adash-card-header adash-header-orange">
        <div class="adash-card-header-left">
            <div class="adash-header-icon bg-orange"><i class="fas fa-exclamation-triangle"></i></div>
            <span>Actions requises</span>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            @if($projetsUrgents->count() > 0)
            <span class="adash-count-badge">{{ $projetsUrgents->count() }}</span>
            @endif
            <a href="{{ route('approbateur.projets.index') }}" class="adash-link">Voir tout →</a>
        </div>
    </div>
    <div class="adash-card-body" style="padding:8px 0;">
        @forelse($projetsUrgents as $p)
        <a href="{{ route('approbateur.projets.show', $p) }}" class="adash-action-item">
            <div class="adash-action-left">
                <div class="adash-action-dot {{ $p->statutProjet === 'en_examen' ? 'dot-orange' : 'dot-blue' }}"></div>
                <div style="min-width:0;">
                    <p class="adash-action-titre">{{ Str::limit($p->titre, 60) }}</p>
                    <p class="adash-action-sub">
                        {{ $p->codeProjet }} · {{ optional($p->porteur)->nomComplet ?? '—' }} · {{ optional($p->secteur)->nomSecteur ?? '—' }}
                    </p>
                </div>
            </div>
            @if($p->statutProjet === 'en_examen')
                <span class="adash-badge adash-badge-orange"><i class="fas fa-search"></i> En examen</span>
            @else
                <span class="adash-badge adash-badge-blue"><i class="fas fa-paper-plane"></i> Soumis</span>
            @endif
        </a>
        @empty
        <div class="adash-empty">
            <i class="fas fa-check-circle"></i>
            <p>Aucune action requise pour le moment.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- ── Projets récents (grid 3 colonnes) ── --}}
<p class="adash-section-label">Projets récents</p>
<div class="adash-projets-grid">
    @forelse($projetsRecents as $projet)
    @php
        $cfg = [
            'soumis'    => ['border'=>'#3b82f6','bg'=>'#eff6ff','cls'=>'adash-badge-blue',  'icon'=>'fa-paper-plane', 'lbl'=>'Soumis'],
            'en_examen' => ['border'=>'#f97316','bg'=>'#fff7ed','cls'=>'adash-badge-orange','icon'=>'fa-search',      'lbl'=>'En examen'],
            'approuve'  => ['border'=>'#22c55e','bg'=>'#f0fdf4','cls'=>'adash-badge-green', 'icon'=>'fa-check-circle','lbl'=>'Approuvé'],
            'rejete'    => ['border'=>'#ef4444','bg'=>'#fef2f2','cls'=>'adash-badge-red',   'icon'=>'fa-times-circle','lbl'=>'Rejeté'],
            'brouillon' => ['border'=>'#9ca3af','bg'=>'#f9fafb','cls'=>'adash-badge-gray',  'icon'=>'fa-file',        'lbl'=>'Brouillon'],
        ];
        $c = $cfg[$projet->statutProjet] ?? $cfg['brouillon'];
    @endphp
    <a href="{{ route('approbateur.projets.show', $projet) }}" class="adash-projet-card"
        style="border-left:4px solid {{ $c['border'] }};">
        <div class="adash-projet-card-body">
            <div class="adash-projet-card-head">
                <span class="adash-projet-code">{{ $projet->codeProjet }}</span>
                <span class="adash-badge {{ $c['cls'] }}">
                    <i class="fas {{ $c['icon'] }}"></i> {{ $c['lbl'] }}
                </span>
            </div>
            <p class="adash-projet-titre">{{ Str::limit($projet->titre, 50) }}</p>
            <div class="adash-projet-meta">
                <span><i class="fas fa-user"></i> {{ optional($projet->porteur)->nomComplet ?? '—' }}</span>
                <span><i class="fas fa-tag"></i> {{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
            </div>
            <div class="adash-projet-footer">
                <span class="adash-projet-date">
                    <i class="fas fa-calendar-alt"></i>
                    {{ optional($projet->dateCreation)->format('d/m/Y') ?? '—' }}
                </span>
                <span class="adash-voir-btn">Voir <i class="fas fa-arrow-right"></i></span>
            </div>
        </div>
    </a>
    @empty
    <div class="adash-empty" style="grid-column:1/-1;padding:40px;">
        <i class="fas fa-folder-open"></i>
        <p>Aucun projet récent.</p>
    </div>
    @endforelse
</div>

@endsection
