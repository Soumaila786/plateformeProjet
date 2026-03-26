@auth
<div class="sidebar" id="mainSidebar">

    <!-- Header logo -->
    <div class="sidebar-header d-flex align-items-center px-3 py-3">
        <div class="logo-container me-2">
            <div style="width: 38px; height: 38px; background: linear-gradient(135deg, #3b82f6, #8b5cf6);
                        border-radius: 10px; display: flex; align-items: center; justify-content: center;
                        color: white; font-weight: 800; font-size: 0.95rem; letter-spacing: 0.5px;">
                GP
            </div>
        </div>
        <div class="app-name-container">
            <h5 class="fw-bold mb-0" style="color: #1e293b; font-size: 1.1rem;">{{ config('app.name') }}</h5>
            <small class="text-muted" style="font-size: 0.7rem;">Gestion de projets</small>
        </div>
    </div>

    @php
        $role = Auth::user()->role;
    @endphp

    <ul class="nav-menu flex-grow-1">

        <!-- Tableau de bord -->
        <li class="nav-item">
            <a href="{{ url($role . '/dashboard') }}"
                class="nav-link {{ request()->is($role . '/dashboard') ? 'active' : '' }}"
                data-tooltip="Tableau de bord">
                <i class="fas fa-home"></i>
                <span>Tableau de bord</span>
            </a>
        </li>

        {{-- ══ ADMIN ══ --}}
        @if($role === 'admin')
            <li class="nav-item">
                <a href="{{ route('admin.analytique') }}"
                    class="nav-link {{ request()->routeIs('admin.analytique') ? 'active' : '' }}"
                    data-tooltip="Tableau Analytique">
                    <i class="fas fa-chart-pie"></i>
                    <span>Tableau Analytique</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}"
                    class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                    data-tooltip="Utilisateurs">
                    <i class="fas fa-users"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.projets.index') }}"
                    class="nav-link {{ request()->routeIs('admin.projets.*') ? 'active' : '' }}"
                    data-tooltip="Projets">
                    <i class="fas fa-project-diagram"></i>
                    <span>Projets</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.secteurs.index') }}"
                    class="nav-link {{ request()->routeIs('admin.secteurs.*') ? 'active' : '' }}"
                    data-tooltip="Secteurs">
                    <i class="fas fa-building"></i>
                    <span>Secteurs</span>
                </a>
            </li>
        @endif

        {{-- ══ PORTEUR ══ --}}
        @if($role === 'porteur')
            <li class="nav-item">
                <a href="{{ route('porteur.projets.index') }}"
                    class="nav-link {{ request()->routeIs('porteur.projets.index') ? 'active' : '' }}"
                    data-tooltip="Mes projets">
                    <i class="fas fa-folder-open"></i>
                    <span>Mes projets</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('porteur.projets.create') }}"
                    class="nav-link {{ request()->routeIs('porteur.projets.create') ? 'active' : '' }}"
                    data-tooltip="Nouveau projet">
                    <i class="fas fa-plus-circle"></i>
                    <span>Nouveau projet</span>
                </a>
            </li>
        @endif

        {{-- ══ APPROBATEUR ══ --}}
        @if($role === 'approbateur')
            <li class="nav-item">
                <a href="{{ route('approbateur.analytique') }}"
                    class="nav-link {{ request()->routeIs('approbateur.analytique') ? 'active' : '' }}"
                    data-tooltip="Tableau Analytique">
                    <i class="fas fa-chart-pie"></i>
                    <span>Tableau Analytique</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('approbateur.projets.index') }}"
                    class="nav-link {{ request()->routeIs('approbateur.projets.index') ? 'active' : '' }}"
                    data-tooltip="À approuver">
                    <i class="fas fa-tasks"></i>
                    <span>À approuver</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('approbateur.projets.mes_projets') }}"
                    class="nav-link {{ request()->routeIs('approbateur.projets.mes_projets') ? 'active' : '' }}"
                    data-tooltip="Mes projets">
                    <i class="fas fa-folder-open"></i>
                    <span>Mes projets</span>
                </a>
            </li>
        @endif

        {{-- ══ VALIDATEUR ══ --}}
        @if($role === 'validateur')
            <li class="nav-item">
                <a href="{{ route('validateur.analytique') }}"
                    class="nav-link {{ request()->routeIs('validateur.analytique') ? 'active' : '' }}"
                    data-tooltip="Tableau Analytique">
                    <i class="fas fa-chart-pie"></i>
                    <span>Tableau Analytique</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('validateur.projets.index') }}"
                    class="nav-link {{ request()->routeIs('validateur.projets.index') ? 'active' : '' }}"
                    data-tooltip="À valider">
                    <i class="fas fa-check-double"></i>
                    <span>À valider</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('validateur.projets.mes_projets') }}"
                    class="nav-link {{ request()->routeIs('validateur.projets.mes_projets') ? 'active' : '' }}"
                    data-tooltip="Mes projets traités">
                    <i class="fas fa-folder-open"></i>
                    <span>Mes projets traités</span>
                </a>
            </li>
        @endif

        {{-- ══ COMMUN ══ --}}
        <li class="nav-item">
            @php
                $notifCount = \App\Models\Notification::where('destinataire_id', auth()->id())
                    ->where('statut', 'non_lu')->count();
            @endphp
            <a href="{{ route($role . '.notifications.index') }}"
                class="nav-link {{ request()->routeIs($role . '.notifications*') ? 'active' : '' }}"
                data-tooltip="Notifications">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
                @if($notifCount > 0)
                    <span class="badge">{{ $notifCount > 99 ? '99+' : $notifCount }}</span>
                @endif
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('parametres.index') }}"
                class="nav-link {{ request()->routeIs('parametres.*') ? 'active' : '' }}"
                data-tooltip="Paramètres">
                <i class="fas fa-cog"></i>
                <span>Paramètres</span>
            </a>
        </li>

        <div class="trait"></div>

        <!-- Déconnexion -->
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link w-100 border-0 bg-transparent text-start"
                        data-tooltip="Déconnexion">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </li>

        <!-- Toggle -->
        <li class="nav-item">
            <button class="nav-link w-100 border-0 bg-transparent text-start"
                    id="toggleSidebar" data-tooltip="Réduire">
                <i class="fas fa-chevron-left" id="toggleIcon"></i>
                <span class="toggle-text">Réduire</span>
            </button>
        </li>

        <div class="trait"></div>

        <!-- Utilisateur connecté -->
        <li class="nav-item" id="userInfo" data-tooltip="{{ Auth::user()->nomComplet }}">
            <div class="nav-link" style="cursor: default;">
                <div class="user-avatar-sm">
                    {{ strtoupper(substr(Auth::user()->nomComplet, 0, 2)) }}
                </div>
                <div class="user-info-text">
                    <div class="fw-bold">{{ Auth::user()->nomComplet }}</div>
                    <div class="user-role">{{ ucfirst($role) }}</div>
                </div>
            </div>
        </li>

    </ul>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar    = document.getElementById('mainSidebar');
    const toggleBtn  = document.getElementById('toggleSidebar');
    const toggleIcon = document.getElementById('toggleIcon');
    const toggleText = document.querySelector('.toggle-text');

    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        sidebar.classList.add('collapsed');
        toggleIcon.classList.replace('fa-chevron-left', 'fa-chevron-right');
        if (toggleText) toggleText.textContent = 'Agrandir';
    }

    toggleBtn.addEventListener('click', function (e) {
        e.preventDefault();
        sidebar.classList.toggle('collapsed');
        const collapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', collapsed);
        if (collapsed) {
            toggleIcon.classList.remove('fa-chevron-left');
            toggleIcon.classList.add('fa-chevron-right');
            if (toggleText) toggleText.textContent = 'Agrandir';
        } else {
            toggleIcon.classList.remove('fa-chevron-right');
            toggleIcon.classList.add('fa-chevron-left');
            if (toggleText) toggleText.textContent = 'Réduire';
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth <= 768) sidebar.classList.remove('collapsed');
    });
});
</script>
@endpush
@endauth
