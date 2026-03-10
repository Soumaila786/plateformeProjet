@extends('layouts.app')
@section('title', 'Mon tableau de bord')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/portDash.css') }}">
@endpush

@section('content')
<div class="projets-page">

    {{-- ── Hero (même style approbateur) ── --}}
    <div class="welcome-banner mb-4">
        <div>
            <div class="welcome-sub">Bienvenue,</div>
            <h2 class="welcome-name">{{ Auth::user()->nomComplet }}</h2>
            <div class="welcome-role">Porteur de projet</div>
        </div>
        <div class="welcome-icon">
            <i class="fas fa-folder-open"></i>
        </div>
    </div>

    <div class="trait"></div>

    {{-- ── Stats projets ── --}}
    <p class="dash-section-label">Mes projets</p>
    <div class="stats-grid" style="margin-bottom:24px;">
        <div class="stat-card">
            <div class="stat-top"><span class="stat-label">Total</span><div class="stat-icon icon-blue"><i class="fas fa-folder"></i></div></div>
            <div class="stat-value">{{ $total }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-top"><span class="stat-label">Brouillon</span><div class="stat-icon icon-indigo"><i class="fas fa-edit"></i></div></div>
            <div class="stat-value">{{ $brouillon }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-top"><span class="stat-label">Soumis</span><div class="stat-icon icon-yellow"><i class="fas fa-paper-plane"></i></div></div>
            <div class="stat-value">{{ $soumis }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-top"><span class="stat-label">En examen</span><div class="stat-icon icon-orange"><i class="fas fa-search"></i></div></div>
            <div class="stat-value">{{ $enExamen }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-top"><span class="stat-label">Approuvés</span><div class="stat-icon icon-green"><i class="fas fa-check-circle"></i></div></div>
            <div class="stat-value">{{ $approuve }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-top"><span class="stat-label">Validés</span><div class="stat-icon icon-teal"><i class="fas fa-badge-check"></i></div></div>
            <div class="stat-value">{{ $valide }}</div>
        </div>
    </div>

    <div class="trait"></div>

    {{-- ── Budgets ── --}}
    <p class="dash-section-label">Finances</p>
    <div class="budget-grid">

        <div class="budget-card total">
            <div class="budget-card-top">
                <div class="budget-card-icon" style="background:#eff6ff;color:#1d4ed8;">
                    <i class="fas fa-wallet"></i>
                </div>
                <div>
                    <p class="budget-label">Budget total</p>
                    <p class="budget-amount">{{ number_format($budgetTotal, 0, ',', ' ') }} <span class="budget-unit">F CFA</span></p>
                    <p class="budget-sub">Tous projets confondus</p>
                </div>
            </div>
            <div class="budget-bar"><div class="budget-bar-fill" style="width:100%;background:#1d4ed8;"></div></div>
        </div>

        <div class="budget-card demande">
            <div class="budget-card-top">
                <div class="budget-card-icon" style="background:#fffbeb;color:#d97706;">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div>
                    <p class="budget-label">Montant demandé</p>
                    <p class="budget-amount">{{ number_format($montantDemande, 0, ',', ' ') }} <span class="budget-unit">F CFA</span></p>
                    <p class="budget-sub">Subvention sollicitée</p>
                </div>
            </div>
            @php $pctDemande = $budgetTotal > 0 ? min(100, round($montantDemande / $budgetTotal * 100)) : 0; @endphp
            <div class="budget-bar"><div class="budget-bar-fill" style="width:{{ $pctDemande }}%;background:#d97706;"></div></div>
            <p class="budget-pct" style="color:#d97706;">{{ $pctDemande }}% du budget total</p>
        </div>

        <div class="budget-card finance">
            <div class="budget-card-top">
                <div class="budget-card-icon" style="background:#f0fdf4;color:#16a34a;">
                    <i class="fas fa-coins"></i>
                </div>
                <div>
                    <p class="budget-label">Montant financé</p>
                    <p class="budget-amount">{{ number_format($montantFinance, 0, ',', ' ') }} <span class="budget-unit">F CFA</span></p>
                    <p class="budget-sub">Activités financées</p>
                </div>
            </div>
            @php $pctFinance = $montantDemande > 0 ? min(100, round($montantFinance / $montantDemande * 100)) : 0; @endphp
            <div class="budget-bar"><div class="budget-bar-fill" style="width:{{ $pctFinance }}%;background:#16a34a;"></div></div>
            <p class="budget-pct" style="color:#16a34a;">{{ $pctFinance }}% du montant demandé</p>
        </div>

    </div>

    <div class="trait"></div>

    {{-- ── Projets récents (gauche) + Notifications & Résumé (droite) ── --}}
    <div class="section-grid-main">

        {{-- Projets récents — colonne gauche large --}}
        <div class="form-card">
            <div class="form-card-header" style="justify-content:space-between;">
                <span><i class="fas fa-clock"></i> Projets récents</span>
                <a href="{{ route('porteur.projets.index') }}" class="dash-table-link">Voir tous →</a>
            </div>
            <div class="form-card-body" style="padding:8px 16px;">
                @forelse($projetsRecents as $projet)
                @php
                    $sc = ['brouillon'=>'status-gray','soumis'=>'status-blue','en_examen'=>'status-yellow','approuve'=>'status-green','valide'=>'status-teal','rejete'=>'status-red'];
                    $sl = ['brouillon'=>'Brouillon','soumis'=>'Soumis','en_examen'=>'En examen','approuve'=>'Approuvé','valide'=>'Validé','rejete'=>'Rejeté'];
                @endphp
                <a href="{{ route('porteur.projets.show', $projet) }}" class="projet-mini-item">
                    <div class="projet-mini-initial">{{ strtoupper(substr($projet->titre, 0, 1)) }}</div>
                    <div class="projet-mini-info">
                        <p class="projet-mini-titre">{{ $projet->titre }}</p>
                        <p class="projet-mini-sub">{{ optional($projet->secteur)->nomSecteur ?? '—' }} · {{ $projet->updated_at->format('d M Y') }}</p>
                    </div>
                    <span class="status-badge {{ $sc[$projet->statutProjet] ?? 'status-gray' }}">
                        {{ $sl[$projet->statutProjet] ?? $projet->statutProjet }}
                    </span>
                </a>
                @empty
                <div class="info-empty-box">
                    <i class="fas fa-folder-open"></i>
                    <p>Aucun projet pour le moment.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Colonne droite : Notifications + Résumé empilés --}}
        <div class="side-col">

            {{-- Notifications --}}
            <div class="form-card">
                <div class="form-card-header" style="justify-content:space-between;">
                    <span><i class="fas fa-bell"></i> Notifications</span>
                    <a href="{{ route('porteur.notifications.index') }}" class="dash-table-link">Voir tout</a>
                </div>
                <div class="form-card-body" style="padding:8px 16px;">
                    @forelse($notifications as $notif)
                    @php
                        $colors = ['approbation'=>'#16a34a','rejet'=>'#dc2626','validation'=>'#0d9488','soumission'=>'#6366f1','statut_change'=>'#1d4ed8','info'=>'#9ca3af'];
                        $c = $colors[$notif->type] ?? '#9ca3af';
                    @endphp
                    <div class="notif-mini-item">
                        <span class="notif-mini-dot" style="background:{{ $c }};"></span>
                        <div>
                            <p class="notif-mini-msg">{{ Str::limit($notif->message, 80) }}</p>
                            <p class="notif-mini-date">{{ $notif->dateEnvoi ? $notif->dateEnvoi->diffForHumans() : '' }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="info-empty-box">
                        <i class="fas fa-bell-slash"></i>
                        <p>Aucune nouvelle notification.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Résumé statuts --}}
            <div class="form-card">
                <div class="form-card-header" style="justify-content:space-between;">
                    <span><i class="fas fa-folder"></i> Mes projets</span>
                    <a href="{{ route('porteur.projets.index') }}" class="dash-table-link">Voir tous</a>
                </div>
                <div class="form-card-body" style="padding:8px 16px;">
                    @foreach([
                        ['label'=>'Brouillon', 'count'=>$brouillon, 'color'=>'#9ca3af'],
                        ['label'=>'Soumis',    'count'=>$soumis,    'color'=>'#3b82f6'],
                        ['label'=>'En examen', 'count'=>$enExamen,  'color'=>'#f97316'],
                        ['label'=>'Approuvés', 'count'=>$approuve,  'color'=>'#22c55e'],
                        ['label'=>'Validés',   'count'=>$valide,    'color'=>'#0d9488'],
                        ['label'=>'Rejetés',   'count'=>$rejete,    'color'=>'#ef4444'],
                    ] as $item)
                    @if($item['count'] > 0)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f3f4f6;">
                        <span style="display:flex;align-items:center;gap:8px;font-size:.82rem;color:#374151;">
                            <span style="width:8px;height:8px;border-radius:50%;background:{{ $item['color'] }};display:inline-block;"></span>
                            {{ $item['label'] }}
                        </span>
                        <span style="font-size:.82rem;font-weight:700;color:#111827;">{{ $item['count'] }}</span>
                    </div>
                    @endif
                    @endforeach
                    <a href="{{ route('porteur.projets.create') }}" class="btn-add w-100" style="margin-top:12px;justify-content:center;">
                        <i class="fas fa-plus"></i> Nouveau projet
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
