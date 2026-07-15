@extends('layouts.app')

@section('title', 'Tableau de bord')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/porteur.css') }}">
@endpush

@section('content')
<div class="dash">

    {{-- Banner --}}
    <div class="banner">
        <div>
            <p class="banner-sub">Bienvenue,</p>
            <h2 class="banner-name">{{ Auth::user()->nomComplet }}</h2>
            <p class="banner-role">{{ Auth::user()->email }} &middot; {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        </div>
        <div class="banner-icon"><i class="fas fa-folder-open"></i></div>
        <div class="banner-circle c1"></div>
        <div class="banner-circle c2"></div>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total projets</span>
                <div class="stat-icon"><i class="fas fa-folder"></i></div>
            </div>
            <p class="stat-val">{{ $total }}</p>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Soumis</span>
                <div class="stat-icon"><i class="fas fa-paper-plane"></i></div>
            </div>
            <p class="stat-val">{{ $soumis }}</p>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Approuvés</span>
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            </div>
            <p class="stat-val">{{ $approuve }}</p>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Validés</span>
                <div class="stat-icon"><i class="fas fa-medal"></i></div>
            </div>
            <p class="stat-val">{{ $valide }}</p>
        </div>
    </div>

    {{-- Finances --}}
    <div class="finance-grid">
        <div class="finance-card">
            <div class="finance-icon"><i class="fas fa-wallet"></i></div>
            <div>
                <p class="finance-label">Budget total</p>
                <p class="finance-amount">{{ number_format($budgetTotal, 0, ',', ' ') }} <span>F CFA</span></p>
                <p class="finance-sub">Tous projets confondus</p>
                <div class="finance-bar"><div style="width:100%;"></div></div>
            </div>
        </div>
        <div class="finance-card">
            <div class="finance-icon"><i class="fas fa-hand-holding-usd"></i></div>
            <div>
                @php $pctD = $budgetTotal > 0 ? min(100, round($montantDemande / $budgetTotal * 100)) : 0; @endphp
                <p class="finance-label">Montant demandé</p>
                <p class="finance-amount">{{ number_format($montantDemande, 0, ',', ' ') }} <span>F CFA</span></p>
                <p class="finance-sub">{{ $pctD }}% du budget total</p>
                <div class="finance-bar"><div style="width:{{ $pctD }}%;"></div></div>
            </div>
        </div>
        <div class="finance-card">
            <div class="finance-icon"><i class="fas fa-coins"></i></div>
            <div>
                <p class="finance-label">Montant financé</p>
                <p class="finance-amount"> — <span>F CFA</span></p>
                <p class="finance-sub">Non disponible</p>
                <div class="finance-bar"><div style="width:0%;"></div></div>
            </div>
        </div>
        <div class="finance-card">
            <div class="finance-icon"><i class="fas fa-hourglass-half"></i></div>
            <div>
                @php $restant = max(0, $montantDemande - 0); $pctR = $montantDemande > 0 ? 100 : 0; @endphp
                <p class="finance-label">Restant à financer</p>
                <p class="finance-amount">{{ number_format($restant, 0, ',', ' ') }} <span>F CFA</span></p>
                <p class="finance-sub">Montant non encore financé</p>
                <div class="finance-bar"><div style="width:{{ $pctR }}%;"></div></div>
            </div>
        </div>
    </div>

    {{-- Zone principale --}}
    <div class="main-grid">

        {{-- Projets récents --}}
        <div class="card">
            <div class="card-head">
                <h3 class="card-title">Projets récents</h3>
                <a href="{{ route('porteur.projets.index') }}" class="link-more">
                    Voir tous <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @forelse($projetsRecents as $projet)
            @php
                $map = [
                    'brouillon' => ['lbl'=>'Brouillon','dot'=>'#9ca3af','bg'=>'#f3f4f6','color'=>'#6b7280'],
                    'soumis'    => ['lbl'=>'Soumis',   'dot'=>'#6366f1','bg'=>'#eef2ff','color'=>'#4338ca'],
                    'en_examen' => ['lbl'=>'En examen','dot'=>'#f97316','bg'=>'#fff7ed','color'=>'#c2410c'],
                    'approuve'  => ['lbl'=>'Approuvé', 'dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d'],
                    'valide'    => ['lbl'=>'Validé',   'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e'],
                    'rejete'    => ['lbl'=>'Rejeté',   'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c'],
                ];
                $s = $map[$projet->statutProjet] ?? $map['brouillon'];
            @endphp
            <a href="{{ route('porteur.projets.show', $projet) }}" class="projet-row">
                <div class="projet-avatar">
                    {{ strtoupper(substr(optional($projet->secteur)->nomSecteur ?? $projet->titre, 0, 1)) }}
                </div>
                <div class="projet-info">
                    <p class="projet-name">{{ $projet->titre }}</p>
                    <p class="projet-sub">
                        {{ optional($projet->secteur)->nomSecteur ?? '—' }}
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
                <p>Aucun projet pour le moment</p>
                <a href="{{ route('porteur.projets.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i> Créer un projet
                </a>
            </div>
            @endforelse
        </div>

        {{-- Colonne droite --}}
        <div class="aside">

            {{-- Mes projets --}}
            <div class="card">
                <div class="card-head" style="border-bottom:none;">
                    <h3 class="card-title">Mes projets</h3>
                    <a href="{{ route('porteur.projets.index') }}" class="link-more">Voir tout</a>
                </div>
                @foreach([
                    ['statut'=>'brouillon','lbl'=>'Brouillon','dot'=>'#9ca3af','bg'=>'#f3f4f6','color'=>'#6b7280','val'=>$brouillon],
                    ['statut'=>'en_examen','lbl'=>'En examen','dot'=>'#f97316','bg'=>'#fff7ed','color'=>'#c2410c','val'=>$enExamen],
                    ['statut'=>'valide',   'lbl'=>'Validé',   'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e','val'=>$valide],
                    ['statut'=>'rejete',   'lbl'=>'Rejeté',   'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c','val'=>$rejete],
                ] as $item)
                @if($item['val'] > 0)
                <a href="{{ route('porteur.projets.index', ['statut'=>$item['statut']]) }}" class="mp-row">
                    <span class="status-badge" style="background:{{ $item['bg'] }};color:{{ $item['color'] }};">
                        <span class="dot" style="background:{{ $item['dot'] }};"></span>{{ $item['lbl'] }}
                    </span>
                    <span class="mp-count">{{ $item['val'] }}</span>
                </a>
                @endif
                @endforeach
                @if($total === 0)<p class="empty-text">Aucun projet</p>@endif
            </div>

            {{-- Notifications --}}
            <div class="card">
                <div class="card-head">
                    <h3 class="card-title">Notifications</h3>
                    <a href="{{ route('porteur.notifications.index') }}" class="link-more">Voir tout</a>
                </div>
                @forelse(($notifications ?? collect())->take(3) as $notif)
                @php
                    $ndot = ['success'=>'#22c55e','danger'=>'#ef4444','warning'=>'#f97316'][$notif->type ?? ''] ?? '#1d4ed8';
                @endphp
                <div class="notif-row">
                    <span class="dot" style="background:{{ $ndot }};margin-top:5px;flex-shrink:0;"></span>
                    <div>
                        <p class="notif-title">{{ $notif->titre ?? $notif->title ?? 'Notification' }}</p>
                        <p class="notif-sub">{{ Str::limit($notif->message ?? '', 65) }}</p>
                    </div>
                </div>
                @empty
                <p class="empty-text">Aucune notification</p>
                @endforelse
            </div>

        </div>
    </div>

</div>
@endsection
