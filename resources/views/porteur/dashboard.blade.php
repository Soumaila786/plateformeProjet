@extends('layouts.app')
@section('title', 'Mon tableau de bord')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/portDash.css') }}">
@endpush

@section('content')

{{-- ── Welcome Banner ── --}}
<div class="welcome-banner">
    <div>
        <div class="welcome-sub">Bienvenue,</div>
        <h2 class="welcome-name">{{ Auth::user()->nomComplet }}</h2>
        <div class="welcome-role">Porteur de projet · {{ now()->isoFormat('D MMMM YYYY') }}</div>
    </div>
    <div class="welcome-icon"><i class="fas fa-folder-open"></i></div>
</div>

{{-- ── Stats 7 cards ── --}}
<p class="pdash-section-label">Mes projets</p>
<div class="pdash-stats-grid">
    <div class="pdash-stat-card">
        <div class="pdash-stat-top"><span class="pdash-stat-label">Total</span><div class="pdash-stat-icon icon-blue"><i class="fas fa-folder"></i></div></div>
        <div class="pdash-stat-value">{{ $total }}</div>
    </div>
    
    <div class="pdash-stat-card">
        <div class="pdash-stat-top"><span class="pdash-stat-label">Brouillon</span><div class="pdash-stat-icon icon-gray"><i class="fas fa-edit"></i></div></div>
        <div class="pdash-stat-value">{{ $brouillon }}</div>
    </div>
    <div class="pdash-stat-card">
        <div class="pdash-stat-top"><span class="pdash-stat-label">Soumis</span><div class="pdash-stat-icon icon-indigo"><i class="fas fa-paper-plane"></i></div></div>
        <div class="pdash-stat-value">{{ $soumis }}</div>
    </div>
    <div class="pdash-stat-card">
        <div class="pdash-stat-top"><span class="pdash-stat-label">En examen</span><div class="pdash-stat-icon icon-yellow"><i class="fas fa-search"></i></div></div>
        <div class="pdash-stat-value">{{ $enExamen }}</div>
    </div>
    <div class="pdash-stat-card">
        <div class="pdash-stat-top"><span class="pdash-stat-label">Approuvés</span><div class="pdash-stat-icon icon-green"><i class="fas fa-check-circle"></i></div></div>
        <div class="pdash-stat-value">{{ $approuve }}</div>
    </div>
    <div class="pdash-stat-card">
        <div class="pdash-stat-top"><span class="pdash-stat-label">Validés</span><div class="pdash-stat-icon icon-teal"><i class="fas fa-medal"></i></div></div>
        <div class="pdash-stat-value">{{ $valide }}</div>
    </div>
    <div class="pdash-stat-card">
        <div class="pdash-stat-top"><span class="pdash-stat-label">Rejetés</span><div class="pdash-stat-icon icon-red"><i class="fas fa-times-circle"></i></div></div>
        <div class="pdash-stat-value">{{ $rejete }}</div>
    </div>
</div>

{{-- ── Budgets ── --}}
<p class="pdash-section-label">Finances</p>
<div class="pdash-budget-grid">
    <div class="pdash-budget-card">
        <div class="pdash-budget-top">
            <div class="pdash-budget-icon" style="background:#eff6ff;color:#1d4ed8;"><i class="fas fa-wallet"></i></div>
            <div>
                <p class="pdash-budget-label">Budget total</p>
                <p class="pdash-budget-amount">{{ number_format($budgetTotal, 0, ',', ' ') }} <span class="pdash-budget-unit">F CFA</span></p>
                <p class="pdash-budget-sub">Tous projets confondus</p>
            </div>
        </div>
        <div class="pdash-budget-bar"><div class="pdash-budget-fill" style="width:100%;background:#1d4ed8;"></div></div>
    </div>
    <div class="pdash-budget-card">
        <div class="pdash-budget-top">
            <div class="pdash-budget-icon" style="background:#fffbeb;color:#d97706;"><i class="fas fa-hand-holding-usd"></i></div>
            <div>
                <p class="pdash-budget-label">Montant demandé</p>
                <p class="pdash-budget-amount">{{ number_format($montantDemande, 0, ',', ' ') }} <span class="pdash-budget-unit">F CFA</span></p>
                @php $pctDemande = $budgetTotal > 0 ? min(100, round($montantDemande / $budgetTotal * 100)) : 0; @endphp
                <p class="pdash-budget-sub">{{ $pctDemande }}% du budget total</p>
            </div>
        </div>
        <div class="pdash-budget-bar"><div class="pdash-budget-fill" style="width:{{ $pctDemande }}%;background:#d97706;"></div></div>
    </div>
    <div class="pdash-budget-card">
        <div class="pdash-budget-top">
            <div class="pdash-budget-icon" style="background:#f0fdf4;color:#16a34a;"><i class="fas fa-coins"></i></div>
            <div>
                <p class="pdash-budget-label">Montant financé</p>
                <p class="pdash-budget-amount">{{ number_format($montantFinance, 0, ',', ' ') }} <span class="pdash-budget-unit">F CFA</span></p>
                @php $pctFinance = $montantDemande > 0 ? min(100, round($montantFinance / $montantDemande * 100)) : 0; @endphp
                <p class="pdash-budget-sub">{{ $pctFinance }}% du montant demandé</p>
            </div>
        </div>
        <div class="pdash-budget-bar"><div class="pdash-budget-fill" style="width:{{ $pctFinance }}%;background:#16a34a;"></div></div>
    </div>
</div>

{{-- ── Projets récents (pleine largeur, grid 3 col) ── --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
    <p class="pdash-section-label" style="margin:0;">Projets récents</p>
    <a href="{{ route('porteur.projets.index') }}" class="pdash-link">Voir tous →</a>
</div>
<div class="pdash-projets-grid">
    @forelse($projetsRecents as $projet)
    @php
        $cfg = [
            'brouillon' => ['border'=>'#9ca3af','cls'=>'pdash-badge-gray',  'icon'=>'fa-edit',        'lbl'=>'Brouillon'],
            'soumis'    => ['border'=>'#6366f1','cls'=>'pdash-badge-indigo','icon'=>'fa-paper-plane', 'lbl'=>'Soumis'],
            'en_examen' => ['border'=>'#f97316','cls'=>'pdash-badge-orange','icon'=>'fa-search',      'lbl'=>'En examen'],
            'approuve'  => ['border'=>'#22c55e','cls'=>'pdash-badge-green', 'icon'=>'fa-check-circle','lbl'=>'Approuvé'],
            'valide'    => ['border'=>'#0d9488','cls'=>'pdash-badge-teal',  'icon'=>'fa-medal',       'lbl'=>'Validé'],
            'rejete'    => ['border'=>'#ef4444','cls'=>'pdash-badge-red',   'icon'=>'fa-times-circle','lbl'=>'Rejeté'],
        ];
        $c = $cfg[$projet->statutProjet] ?? $cfg['brouillon'];
    @endphp
    <a href="{{ route('porteur.projets.show', $projet) }}" class="pdash-projet-card"
        style="border-left:4px solid {{ $c['border'] }};">
        <div class="pdash-projet-card-body">
            <div class="pdash-projet-card-head">
                <span class="pdash-projet-code">{{ $projet->codeProjet }}</span>
                <span class="pdash-badge {{ $c['cls'] }}">
                    <i class="fas {{ $c['icon'] }}"></i> {{ $c['lbl'] }}
                </span>
            </div>
            <p class="pdash-projet-titre">{{ Str::limit($projet->titre, 50) }}</p>
            <div class="pdash-projet-meta">
                <span><i class="fas fa-tag"></i> {{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
            </div>
            <div class="pdash-projet-footer">
                <span class="pdash-projet-date">
                    <i class="fas fa-calendar-alt"></i>
                    {{ $projet->updated_at->format('d/m/Y') }}
                </span>
                <span class="pdash-voir-btn">Voir <i class="fas fa-arrow-right"></i></span>
            </div>
        </div>
    </a>
    @empty
    <div class="pdash-empty" style="grid-column:1/-1;padding:40px;">
        <i class="fas fa-folder-open"></i>
        <p>Aucun projet pour le moment.</p>
        <a href="{{ route('porteur.projets.create') }}" class="pdash-btn-primary" style="margin-top:12px;">
            <i class="fas fa-plus"></i> Créer mon premier projet
        </a>
    </div>
    @endforelse
</div>

@endsection
