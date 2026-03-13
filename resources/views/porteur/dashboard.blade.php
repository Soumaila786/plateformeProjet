@extends('layouts.app')
@section('title', 'Mon tableau de bord')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/portDash.css') }}">
@endpush

@section('content')

{{-- ── Welcome Banner ── --}}
<div class="pd-banner">
    <div class="pd-banner-left">
        <p class="pd-banner-sub">Tableau de bord</p>
        <h2 class="pd-banner-name">{{ Auth::user()->nomComplet }}</h2>
        <p class="pd-banner-role">Porteur de projet &middot; {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>
    <div class="pd-banner-icon"><i class="fas fa-folder-open"></i></div>
</div>

{{-- ── Zone top : Stats + Raccourcis ── --}}
<div class="pd-top-grid">

    {{-- Stats --}}
    <div class="pd-card pd-stats-block">
        <p class="pd-section-label">Mes statistiques des projets</p>
        <div class="pd-stats-grid">
            <div class="pd-stat-item">
                <div class="pd-stat-icon icon-blue"><i class="fas fa-folder"></i></div>
                <div>
                    <div class="pd-stat-val">{{ $total }}</div>
                    <div class="pd-stat-lbl">Total</div>
                </div>
            </div>
            <div class="pd-stat-item">
                <div class="pd-stat-icon icon-teal"><i class="fas fa-medal"></i></div>
                <div>
                    <div class="pd-stat-val">{{ $valide }}</div>
                    <div class="pd-stat-lbl">Validés</div>
                </div>
            </div>
            <div class="pd-stat-item">
                <div class="pd-stat-icon icon-indigo"><i class="fas fa-paper-plane"></i></div>
                <div>
                    <div class="pd-stat-val">{{ $soumis }}</div>
                    <div class="pd-stat-lbl">Soumis</div>
                </div>
            </div>
            <div class="pd-stat-item">
                <div class="pd-stat-icon icon-green"><i class="fas fa-check-circle"></i></div>
                <div>
                    <div class="pd-stat-val">{{ $approuve }}</div>
                    <div class="pd-stat-lbl">Approuvés</div>
                </div>
            </div>
            <div class="pd-stat-item">
                <div class="pd-stat-icon icon-orange"><i class="fas fa-coins"></i></div>
                <div>
                    <div class="pd-stat-val">{{ $finance ?? 0 }}</div>
                    <div class="pd-stat-lbl">Financés</div>
                </div>
            </div>
            <div class="pd-stat-item">
                <div class="pd-stat-icon icon-red"><i class="fas fa-times-circle"></i></div>
                <div>
                    <div class="pd-stat-val">{{ $rejete }}</div>
                    <div class="pd-stat-lbl">Rejetés</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Raccourcis --}}
    <div class="pd-card pd-raccourcis-block">
        <p class="pd-section-label">Raccourcis</p>
        <div class="pd-raccourcis-grid">
            <a href="{{ route('porteur.projets.create') }}" class="pd-raccourci-card pd-rc-blue">
                <div class="pd-rc-icon"><i class="fas fa-plus-circle"></i></div>
                <span>Nouveau projet</span>
            </a>
            <a href="{{ route('porteur.projets.index') }}" class="pd-raccourci-card pd-rc-indigo">
                <div class="pd-rc-icon"><i class="fas fa-folder-open"></i></div>
                <span>Mes projets</span>
            </a>
            <a href="{{ route('porteur.notifications.index') }}" class="pd-raccourci-card pd-rc-orange">
                <div class="pd-rc-icon"><i class="fas fa-bell"></i></div>
                <span>Notifications</span>
            </a>
            <a href="{{ route('parametres.profil') }}" class="pd-raccourci-card pd-rc-teal">
                <div class="pd-rc-icon"><i class="fas fa-user-cog"></i></div>
                <span>Mon profil</span>
            </a>
        </div>
    </div>

</div>

{{-- ── Finances (4 cards) ── --}}
<p class="pd-section-label">Finances</p>
<div class="pd-finances-grid">

    <div class="pd-finance-card">
        <div class="pd-finance-icon" style="background:#eff6ff;color:#1d4ed8;">
            <i class="fas fa-wallet"></i>
        </div>
        <div>
            <p class="pd-finance-label">Budget total</p>
            <p class="pd-finance-amount">
                {{ number_format($budgetTotal, 0, ',', ' ') }}&nbsp;<span>F CFA</span>
            </p>
            <p class="pd-finance-sub">Tous projets confondus</p>
            <div class="pd-finance-bar"><div style="width:100%;background:#1d4ed8;"></div></div>
        </div>
    </div>

    <div class="pd-finance-card">
        <div class="pd-finance-icon" style="background:#fffbeb;color:#d97706;">
            <i class="fas fa-hand-holding-usd"></i>
        </div>
        <div>
            @php $pctD = $budgetTotal > 0 ? min(100, round($montantDemande / $budgetTotal * 100)) : 0; @endphp
            <p class="pd-finance-label">Montant demandé</p>
            <p class="pd-finance-amount">
                {{ number_format($montantDemande, 0, ',', ' ') }}&nbsp;<span>F CFA</span>
            </p>
            <p class="pd-finance-sub">{{ $pctD }}% du budget total</p>
            <div class="pd-finance-bar"><div style="width:{{ $pctD }}%;background:#d97706;"></div></div>
        </div>
    </div>

    <div class="pd-finance-card">
        <div class="pd-finance-icon" style="background:#f0fdf4;color:#16a34a;">
            <i class="fas fa-coins"></i>
        </div>
        <div>
            @php $pctF = $montantDemande > 0 ? min(100, round($montantFinance / $montantDemande * 100)) : 0; @endphp
            <p class="pd-finance-label">Montant financé</p>
            <p class="pd-finance-amount">
                {{ number_format($montantFinance, 0, ',', ' ') }}&nbsp;<span>F CFA</span>
            </p>
            <p class="pd-finance-sub">{{ $pctF }}% du montant demandé</p>
            <div class="pd-finance-bar"><div style="width:{{ $pctF }}%;background:#16a34a;"></div></div>
        </div>
    </div>

    <div class="pd-finance-card">
        <div class="pd-finance-icon" style="background:#fef2f2;color:#dc2626;">
            <i class="fas fa-hourglass-half"></i>
        </div>
        <div>
            @php
                $restant = max(0, $montantDemande - $montantFinance);
                $pctR    = $montantDemande > 0 ? min(100, round($restant / $montantDemande * 100)) : 0;
            @endphp
            <p class="pd-finance-label">Restant à financer</p>
            <p class="pd-finance-amount">
                {{ number_format($restant, 0, ',', ' ') }}&nbsp;<span>F CFA</span>
            </p>
            <p class="pd-finance-sub">{{ $pctR }}% non encore financé</p>
            <div class="pd-finance-bar"><div style="width:{{ $pctR }}%;background:#dc2626;"></div></div>
        </div>
    </div>

</div>

{{-- ── Projets récents (scrollable max 4) ── --}}
<div class="pd-section-header">
    <p class="pd-section-label" style="margin:0;">Projets récents</p>
    <a href="{{ route('porteur.projets.index') }}" class="pd-voir-tout">
        Voir tout&nbsp;<i class="fas fa-arrow-right"></i>
    </a>
</div>

<div class="pd-projets-scroll">
    @forelse($projetsRecents as $projet)
    @php
        $cfg = [
            'brouillon' => ['cls'=>'pd-badge-gray',  'icon'=>'fa-edit',        'lbl'=>'Brouillon','border'=>'#9ca3af'],
            'soumis'    => ['cls'=>'pd-badge-indigo','icon'=>'fa-paper-plane', 'lbl'=>'Soumis',   'border'=>'#6366f1'],
            'en_examen' => ['cls'=>'pd-badge-orange','icon'=>'fa-search',      'lbl'=>'En examen','border'=>'#f97316'],
            'approuve'  => ['cls'=>'pd-badge-green', 'icon'=>'fa-check-circle','lbl'=>'Approuvé', 'border'=>'#22c55e'],
            'valide'    => ['cls'=>'pd-badge-teal',  'icon'=>'fa-medal',       'lbl'=>'Validé',   'border'=>'#0d9488'],
            'rejete'    => ['cls'=>'pd-badge-red',   'icon'=>'fa-times-circle','lbl'=>'Rejeté',   'border'=>'#ef4444'],
        ];
        $c         = $cfg[$projet->statutProjet] ?? $cfg['brouillon'];
        $dateDebut = optional($projet->dateDebut)->format('d/m/Y') ?? '—';
        $dateFin   = optional($projet->dateFin)->format('d/m/Y')   ?? '—';
    @endphp
    <div class="pd-projet-card">
        <div class="pd-projet-card-head">
            <span class="pd-badge {{ $c['cls'] }}">
                <i class="fas {{ $c['icon'] }}"></i>&nbsp;{{ $c['lbl'] }}
            </span>
            <a href="{{ route('porteur.projets.show', $projet) }}" class="pd-voir-btn" title="Voir détails">
                <i class="fas fa-eye"></i>
            </a>
        </div>
        <h3 class="pd-projet-titre">{{ Str::limit($projet->titre, 48) }}</h3>
        <p class="pd-projet-objectif">{{ Str::limit($projet->objectif ?? '—', 70) }}</p>
        <div class="pd-projet-details">
            <div class="pd-projet-detail-item">
                <i class="fas fa-wallet"></i>
                <span>Budget&nbsp;: <strong>{{ number_format($projet->budgetTotal ?? 0, 0, ',', ' ') }} F CFA</strong></span>
            </div>
            <div class="pd-projet-detail-item">
                <i class="fas fa-hand-holding-usd"></i>
                <span>Demandé&nbsp;: <strong>{{ number_format($projet->montantDemande ?? 0, 0, ',', ' ') }} F CFA</strong></span>
            </div>
            <div class="pd-projet-detail-item">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ $dateDebut }} → {{ $dateFin }}</span>
            </div>
            <div class="pd-projet-detail-item">
                <i class="fas fa-tag"></i>
                <span>{{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
            </div>
        </div>
    </div>
    @empty
    <div class="pd-empty">
        <i class="fas fa-folder-open"></i>
        <p>Aucun projet pour le moment.</p>
        <a href="{{ route('porteur.projets.create') }}" class="pd-btn-primary">
            <i class="fas fa-plus"></i>&nbsp;Créer mon premier projet
        </a>
    </div>
    @endforelse
</div>

@endsection
