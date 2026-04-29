@extends('layouts.app')
@section('title', 'Tableau de bord')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/adminDash.css') }}">
@endpush

@section('content')
<div class="adm-wrap">

{{-- Banner --}}
<div class="adm-banner">
    <div>
        <p class="adm-banner-sub">Bienvenue,</p>
        <h2 class="adm-banner-name">{{ Auth::user()->nomComplet }}</h2>
        <p class="adm-banner-role">{{ Auth::user()->email }} &middot; {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>
    <div class="adm-banner-icon"><i class="fas fa-shield-alt"></i></div>
    <div class="adm-banner-circle c1"></div>
    <div class="adm-banner-circle c2"></div>
</div>

{{-- Stats projets --}}
<div class="adm-stats mb-2">
    @php
        $statItems = [
            ['lbl'=>'Total projets', 'val'=>$totalProjets,     'icon'=>'fa-folder',       'hint'=>'Tous confondus'],
            ['lbl'=>'Soumis',        'val'=>$projetsSoumis,    'icon'=>'fa-paper-plane',  'hint'=>'En attente'],
            ['lbl'=>'En examen',     'val'=>$projetsEnExamen,  'icon'=>'fa-search',       'hint'=>'En cours'],
            ['lbl'=>'Approuvés',     'val'=>$projetsApprouves, 'icon'=>'fa-check-circle', 'hint'=>'À valider'],
            ['lbl'=>'Validés',       'val'=>$projetsValides,   'icon'=>'fa-medal',        'hint'=>'Finalisés'],
            ['lbl'=>'Rejetés',       'val'=>$projetsRejetes,   'icon'=>'fa-times-circle', 'hint'=>'Non retenus'],
        ];
    @endphp
    @foreach($statItems as $s)
    <div class="adm-stat">
        <div class="adm-stat-top">
            <span class="adm-stat-lbl">{{ $s['lbl'] }}</span>
            <div class="adm-stat-ic"><i class="fas {{ $s['icon'] }}"></i></div>
        </div>
        <p class="adm-stat-val">{{ $s['val'] }}</p>
        <p class="adm-stat-hint">{{ $s['hint'] }}</p>
    </div>
    @endforeach
</div>

{{-- Stats users + secteurs --}}
<div class="adm-meta-grid">
    <div class="adm-meta-card">
        <div class="adm-meta-ic"><i class="fas fa-users"></i></div>
        <div>
            <p class="adm-meta-lbl">Utilisateurs</p>
            <p class="adm-meta-val">{{ $totalUsers }}</p>
            <p class="adm-meta-hint">{{ $usersActifs }} actifs · {{ $usersInactifs }} inactifs</p>
        </div>
    </div>
    <div class="adm-meta-card">
        <div class="adm-meta-ic"><i class="fas fa-tags"></i></div>
        <div>
            <p class="adm-meta-lbl">Secteurs</p>
            <p class="adm-meta-val">{{ $totalSecteurs }}</p>
            <p class="adm-meta-hint">{{ $secteursActifs }} actifs</p>
        </div>
    </div>
    <div class="adm-meta-card">
        <div class="adm-meta-ic"><i class="fas fa-user-tie"></i></div>
        <div>
            <p class="adm-meta-lbl">Porteurs</p>
            <p class="adm-meta-val">{{ $usersByRole->get('porteur', 0) }}</p>
            <p class="adm-meta-hint">Porteurs de projet</p>
        </div>
    </div>
    <div class="adm-meta-card {{ $projetsBloquesCount > 0 ? 'adm-meta-warn' : '' }}">
        <div class="adm-meta-ic"><i class="fas fa-exclamation-triangle"></i></div>
        <div>
            <p class="adm-meta-lbl">Bloqués</p>
            <p class="adm-meta-val">{{ $projetsBloquesCount }}</p>
            <p class="adm-meta-hint">Sans action depuis +10j</p>
        </div>
    </div>
</div>

{{-- Lien analytique --}}
<a href="{{ route('admin.analytique') }}" class="analytique-link">
    <div class="analytique-link-left">
        <div class="analytique-link-ic"><i class="fas fa-chart-bar"></i></div>
        <div>
            <p class="analytique-link-title">Tableau analytique</p>
            <p class="analytique-link-sub">Entonnoir · Délais · Secteurs · Porteurs · Rejets · Projets bloqués · Charge équipes</p>
        </div>
    </div>
    <span class="analytique-link-cta">Accéder <i class="fas fa-arrow-right"></i></span>
</a>

{{-- Zone principale --}}
<div class="adm-main-grid">

    {{-- Projets récents --}}
    <div class="card">
        <div class="card-head">
            <h3 class="card-title">Projets récents</h3>
            <a href="{{ route('admin.projets.index') }}" class="link-more">Voir tous <i class="fas fa-arrow-right"></i></a>
        </div>
        @forelse($projetsRecents as $projet)
        @php
            $map = [
                'brouillon' => ['lbl'=>'Brouillon', 'dot'=>'#9ca3af','bg'=>'#f3f4f6','color'=>'#6b7280'],
                'soumis'    => ['lbl'=>'Soumis',    'dot'=>'#6366f1','bg'=>'#eef2ff','color'=>'#4338ca'],
                'en_examen' => ['lbl'=>'En examen', 'dot'=>'#f97316','bg'=>'#fff7ed','color'=>'#c2410c'],
                'approuve'  => ['lbl'=>'Approuvé',  'dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d'],
                'valide'    => ['lbl'=>'Validé',    'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e'],
                'rejete'    => ['lbl'=>'Rejeté',    'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c'],
            ];
            $s = $map[$projet->statutProjet] ?? $map['brouillon'];
        @endphp
        <a href="{{ route('admin.projets.show', $projet) }}" class="projet-row">
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
            <p>Aucun projet pour le moment</p>
        </div>
        @endforelse
    </div>

    {{-- Colonne droite --}}
    <div class="adm-aside">

        {{-- Utilisateurs récents --}}
        <div class="card">
            <div class="card-head">
                <h3 class="card-title">Utilisateurs récents</h3>
                <a href="{{ route('admin.users.index') }}" class="link-more">Voir tous <i class="fas fa-arrow-right"></i></a>
            </div>
            @forelse($usersRecents as $user)
            @php
                $roleMap = [
                    'admin'       => ['lbl'=>'Admin',      'bg'=>'#faf5ff','color'=>'#7e22ce'],
                    'approbateur' => ['lbl'=>'Approbateur','bg'=>'#eef2ff','color'=>'#4338ca'],
                    'validateur'  => ['lbl'=>'Validateur', 'bg'=>'#f0fdfa','color'=>'#0f766e'],
                    'porteur'     => ['lbl'=>'Porteur',    'bg'=>'#f0fdf4','color'=>'#15803d'],
                ];
                $r = $roleMap[$user->role] ?? ['lbl'=>ucfirst($user->role),'bg'=>'#f3f4f6','color'=>'#6b7280'];
            @endphp
            <a href="{{ route('admin.users.show', $user) }}" class="user-row">
                <div class="user-avatar">
                    {{ strtoupper(substr($user->nomComplet ?? 'U', 0, 1)) }}
                </div>
                <div class="projet-info">
                    <p class="projet-name">{{ $user->nomComplet }}</p>
                    <p class="projet-sub">{{ $user->email }}</p>
                </div>
                <span class="status-badge" style="background:{{ $r['bg'] }};color:{{ $r['color'] }};">
                    {{ $r['lbl'] }}
                </span>
            </a>
            @empty
            <div class="empty-state"><i class="fas fa-users"></i><p>Aucun utilisateur</p></div>
            @endforelse
        </div>

        {{-- Raccourcis --}}
        <div class="card">
            <div class="card-head" style="border-bottom:none;">
                <h3 class="card-title">Raccourcis</h3>
            </div>
            <div class="adm-shortcuts">
                <a href="{{ route('admin.users.create') }}" class="shortcut-item">
                    <div class="shortcut-ic"><i class="fas fa-user-plus"></i></div>
                    <span>Nouvel utilisateur</span>
                </a>
                <a href="{{ route('admin.secteurs.create') }}" class="shortcut-item">
                    <div class="shortcut-ic"><i class="fas fa-plus-circle"></i></div>
                    <span>Nouveau secteur</span>
                </a>
                <a href="{{ route('admin.projets.index') }}" class="shortcut-item">
                    <div class="shortcut-ic"><i class="fas fa-folder-open"></i></div>
                    <span>Tous les projets</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="shortcut-item">
                    <div class="shortcut-ic"><i class="fas fa-users-cog"></i></div>
                    <span>Gérer les users</span>
                </a>
            </div>
        </div>

    </div>
</div>

</div>
@endsection
