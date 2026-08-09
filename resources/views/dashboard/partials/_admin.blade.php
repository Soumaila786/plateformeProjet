@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@if ($projetsBloquesCount > 0)
    <div class="dash-alert-bloque">
        <i class="fas fa-triangle-exclamation"></i>
        <strong>{{ $projetsBloquesCount }}</strong> projet{{ $projetsBloquesCount > 1 ? 's' : '' }}
        bloqué{{ $projetsBloquesCount > 1 ? 's' : '' }} depuis plus de 10 jours sans traitement.
    </div>
@endif

<div class="dash-stats-grid">
    <x-cards.stat label="Projets au total" :valeur="$totalProjets" icon="fa-folder" href="{{ route('admin.projets.index') }}" />
    <x-cards.stat label="Soumis" :valeur="$projetsSoumis" icon="fa-paper-plane" couleur="var(--status-soumis)" />
    <x-cards.stat label="En examen" :valeur="$projetsEnExamen" icon="fa-magnifying-glass" couleur="var(--status-en-examen)" />
    <x-cards.stat label="Approuvés" :valeur="$projetsApprouves" icon="fa-check" couleur="var(--status-approuve)" />
    <x-cards.stat label="Validés" :valeur="$projetsValides" icon="fa-check-double" couleur="var(--status-valide)" />
    <x-cards.stat label="Rejetés" :valeur="$projetsRejetes" icon="fa-xmark" couleur="var(--status-rejete)" />
</div>

<div class="dash-stats-grid">
    <x-cards.stat label="Utilisateurs actifs" :valeur="$usersActifs" icon="fa-users" href="{{ route('admin.users.index') }}" />
    <x-cards.stat label="Utilisateurs inactifs" :valeur="$usersInactifs" icon="fa-user-slash" couleur="var(--color-text-muted)" />
    <x-cards.stat label="Secteurs actifs" :valeur="$secteursActifs" icon="fa-building" couleur="var(--color-info)" href="{{ route('admin.secteurs.index') }}" />
    <x-cards.stat label="Total secteurs" :valeur="$totalSecteurs" icon="fa-building-columns" couleur="var(--color-text-muted)" />
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="dash-card">
            <h6 class="fw-bold mb-3">Projets récents</h6>
            @include('dashboard.partials._projets_recents', ['projetsRecents' => $projetsRecents, 'routeShow' => 'admin.projets.show'])
        </div>
    </div>
    <div class="col-lg-5">
        <div class="dash-card">
            <h6 class="fw-bold mb-3">Nouveaux utilisateurs</h6>
            @forelse ($usersRecents as $u)
                <div class="d-flex align-items-center gap-2 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <x-avatars.avatar :user="$u" :size="32" />
                    <div class="min-w-0">
                        <div class="small fw-semibold text-truncate">{{ $u->nomComplet }}</div>
                        <div class="text-muted text-truncate" style="font-size:.72rem;">{{ ucfirst($u->role) }}</div>
                    </div>
                </div>
            @empty
                <p class="text-muted small mb-0 py-3 text-center">Aucun utilisateur récent.</p>
            @endforelse
        </div>
    </div>
</div>
