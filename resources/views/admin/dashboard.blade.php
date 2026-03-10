@extends('layouts.app')
@section('title', 'Tableau de bord — Admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/adminDash.css') }}">
@endpush

@section('content')

{{-- ── Welcome Banner ── --}}
<div class="welcome-banner mb-4">
    <div>
        <div class="welcome-sub">Bienvenue,</div>
        <h2 class="welcome-name">{{ auth()->user()->nomComplet }}</h2>
        <div class="welcome-role">Administrateur · {{ now()->isoFormat('D MMMM YYYY') }}</div>
    </div>
    <div class="welcome-icon">
        <i class="fas fa-shield-alt"></i>
    </div>
</div>

{{-- ── Stats Projets ── --}}
<p class="dash-section-label">Projets</p>
<div class="admin-stats-grid">
    <div class="stat-card">
        <div class="stat-top"><span class="stat-label">Total</span><div class="stat-icon icon-blue"><i class="fas fa-folder"></i></div></div>
        <div class="stat-value">{{ $totalProjets }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-top"><span class="stat-label">Soumis</span><div class="stat-icon icon-indigo"><i class="fas fa-paper-plane"></i></div></div>
        <div class="stat-value">{{ $projetsSoumis }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-top"><span class="stat-label">En examen</span><div class="stat-icon icon-yellow"><i class="fas fa-search"></i></div></div>
        <div class="stat-value">{{ $projetsEnExamen }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-top"><span class="stat-label">Approuvés</span><div class="stat-icon icon-green"><i class="fas fa-check-circle"></i></div></div>
        <div class="stat-value">{{ $projetsApprouves }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-top"><span class="stat-label">Validés</span><div class="stat-icon icon-teal"><i class="fas fa-medal"></i></div></div>
        <div class="stat-value">{{ $projetsValides }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-top"><span class="stat-label">Rejetés</span><div class="stat-icon icon-red"><i class="fas fa-times-circle"></i></div></div>
        <div class="stat-value">{{ $projetsRejetes }}</div>
    </div>
</div>

{{-- ── Stats Utilisateurs ── --}}
<p class="dash-section-label" style="margin-top:24px;">Utilisateurs & Secteurs</p>
<div class="admin-stats-grid-4">
    <div class="stat-card">
        <div class="stat-top"><span class="stat-label">Total users</span><div class="stat-icon icon-purple"><i class="fas fa-users"></i></div></div>
        <div class="stat-value">{{ $totalUsers }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-top"><span class="stat-label">Actifs</span><div class="stat-icon icon-green"><i class="fas fa-user-check"></i></div></div>
        <div class="stat-value">{{ $usersActifs }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-top"><span class="stat-label">Inactifs</span><div class="stat-icon icon-red"><i class="fas fa-user-times"></i></div></div>
        <div class="stat-value">{{ $usersInactifs }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-top"><span class="stat-label">Secteurs actifs</span><div class="stat-icon icon-orange"><i class="fas fa-tags"></i></div></div>
        <div class="stat-value">
            {{ $secteursActifs }}<span class="stat-sub">/{{ $totalSecteurs }}</span>
        </div>
    </div>
</div>

{{-- ── Layout principal ── --}}
<div class="admin-main-grid">

    {{-- Colonne gauche ── --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Projets récents --}}
        <div class="form-card">
            <div class="form-card-header" style="justify-content:space-between;">
                <span><i class="fas fa-folder-open"></i> Projets récents</span>
                <a href="{{ route('admin.projets.index') }}" class="dash-table-link">Voir tout →</a>
            </div>
            <div class="form-card-body p-0">
                <table class="admindash-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Titre</th>
                            <th>Porteur</th>
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projetsRecents as $projet)
                        @php
                            $sc = ['brouillon'=>'status-gray','soumis'=>'status-blue','en_examen'=>'status-yellow','approuve'=>'status-green','valide'=>'status-teal','rejete'=>'status-red'];
                            $sl = ['brouillon'=>'Brouillon','soumis'=>'Soumis','en_examen'=>'En examen','approuve'=>'Approuvé','valide'=>'Validé','rejete'=>'Rejeté'];
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ route('admin.projets.show', $projet) }}" class="admindash-link">
                                    {{ $projet->codeProjet }}
                                </a>
                            </td>
                            <td class="admindash-titre">{{ Str::limit($projet->titre, 38) }}</td>
                            <td class="admindash-muted">{{ optional($projet->porteur)->nomComplet ?? '—' }}</td>
                            <td><span class="status-badge {{ $sc[$projet->statutProjet] ?? 'status-gray' }}">{{ $sl[$projet->statutProjet] ?? $projet->statutProjet }}</span></td>
                            <td class="admindash-muted">{{ optional($projet->dateCreation)->format('d/m/Y') ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="admindash-empty">Aucun projet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Utilisateurs récents --}}
        <div class="form-card">
            <div class="form-card-header" style="justify-content:space-between;">
                <span><i class="fas fa-users"></i> Utilisateurs récents</span>
                <a href="{{ route('admin.users.index') }}" class="dash-table-link">Voir tout →</a>
            </div>
            <div class="form-card-body p-0">
                <table class="admindash-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usersRecents as $user)
                        <tr>
                            <td>
                                <a href="{{ route('admin.users.show', $user) }}" class="admindash-link">
                                    {{ $user->nomComplet }}
                                </a>
                            </td>
                            <td class="admindash-muted">{{ $user->email }}</td>
                            <td><span class="role-badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                            <td>
                                <span class="status-badge {{ $user->actif ? 'status-green' : 'status-red' }}">
                                    {{ $user->actif ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="admindash-empty">Aucun utilisateur.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Colonne droite ── --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Graphique statuts --}}
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-chart-pie"></i>
                <span>Répartition par statut</span>
            </div>
            <div class="form-card-body" style="padding:16px;">
                <canvas id="chartStatuts" height="200"></canvas>
            </div>
        </div>

        {{-- Graphique rôles --}}
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-chart-bar"></i>
                <span>Utilisateurs par rôle</span>
            </div>
            <div class="form-card-body" style="padding:16px;">
                <canvas id="chartRoles" height="180"></canvas>
            </div>
        </div>

        {{-- Raccourcis --}}
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-bolt"></i>
                <span>Raccourcis</span>
            </div>
            <div class="form-card-body" style="padding:12px 16px;display:flex;flex-direction:column;gap:8px;">
                <a href="{{ route('admin.users.create') }}" class="shortcut-btn shortcut-blue">
                    <i class="fas fa-user-plus"></i> Nouvel utilisateur
                </a>
                <a href="{{ route('admin.secteurs.create') }}" class="shortcut-btn shortcut-indigo">
                    <i class="fas fa-plus"></i> Nouveau secteur
                </a>
                <a href="{{ route('admin.projets.index') }}" class="shortcut-btn shortcut-teal">
                    <i class="fas fa-folder"></i> Tous les projets
                </a>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Statuts ──
new Chart(document.getElementById('chartStatuts'), {
    type: 'doughnut',
    data: {
        labels: ['Brouillon','Soumis','En examen','Approuvé','Validé','Rejeté'],
        datasets: [{
            data: [{{ $projetsBrouillon }},{{ $projetsSoumis }},{{ $projetsEnExamen }},{{ $projetsApprouves }},{{ $projetsValides }},{{ $projetsRejetes }}],
            backgroundColor: ['#9ca3af','#3b82f6','#f59e0b','#16a34a','#0d9488','#dc2626'],
            borderWidth: 2, borderColor: '#fff',
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { font: { family:'Outfit', size:11 }, padding:12, usePointStyle:true } }
        }
    }
});

// ── Rôles ──
new Chart(document.getElementById('chartRoles'), {
    type: 'bar',
    data: {
        labels: ['Admin','Porteur','Approbateur','Validateur'],
        datasets: [{
            label: 'Utilisateurs',
            data: [{{ $usersByRole->get('admin',0) }},{{ $usersByRole->get('porteur',0) }},{{ $usersByRole->get('approbateur',0) }},{{ $usersByRole->get('validateur',0) }}],
            backgroundColor: ['rgba(99,102,241,.5)','rgba(59,130,246,.5)','rgba(245,158,11,.5)','rgba(13,148,136,.5)'],
            borderColor:     ['#6366f1','#3b82f6','#f59e0b','#0d9488'],
            borderWidth: 2, borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero:true, ticks:{ stepSize:1, font:{ family:'Outfit', size:11 } }, grid:{ color:'#f3f4f6' } },
            x: { ticks:{ font:{ family:'Outfit', size:11 } }, grid:{ display:false } }
        }
    }
});
</script>
@endpush
