@auth
<div class="sidebar" id="mainSidebar">

    <!-- Header avec logo et nom de l'application -->
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

    <!-- Menu de navigation principal -->
    <ul class="nav-menu flex-grow-1">

        <!-- Tableau de bord -->
        <li class="nav-item">
            <a href="/{{ Auth::user()->role }}/dashboard"
                class="nav-link {{ request()->is('*/dashboard') ? 'active' : '' }}"
                data-tooltip="Tableau de bord">
                <i class="fas fa-tachometer-alt"></i>
                <span>Tableau de bord</span>
            </a>
        </li>

        <!-- Utilisateurs (Admin seulement) -->
        @if(Auth::user()->role == 'admin')
        <li class="nav-item">
            <a href="/admin/users"
                class="nav-link {{ request()->is('admin/users/index') ? 'active' : '' }}"
                data-tooltip="Utilisateurs">
                <i class="fas fa-users"></i>
                <span>Utilisateurs</span>
            </a>
        </li>
        @endif

        <!-- Projets -->
        <li class="nav-item">
            <a href="/{{ Auth::user()->role }}/projets"
                class="nav-link {{ request()->is('amin/projets/index') ? 'active' : '' }}"
                data-tooltip="Projets">
                <i class="fas fa-project-diagram"></i>
                <span>Projets</span>
            </a>
        </li>

        <!-- Secteurs (Admin seulement) -->
        @if(Auth::user()->role == 'admin')
        <li class="nav-item">
            <a href="/admin/secteurs"
                class="nav-link {{ request()->is('admin/secteurs/index') ? 'active' : '' }}"
                data-tooltip="Secteurs">
                <i class="fas fa-building"></i>
                <span>Secteurs</span>
            </a>
        </li>
        @endif

        <!-- Notifications -->
        <li class="nav-item">
            <a href="/{{ Auth::user()->role }}/notifications"
                class="nav-link {{ request()->is('*/notifications*') ? 'active' : '' }} position-relative"
                data-tooltip="Notifications">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
                @php
                    $notificationsCount = Auth::user()->notifications()->where('statut', 'non_lu')->count() ?? 0;
                @endphp
                @if($notificationsCount > 0)
                    <span class="badge">{{ $notificationsCount }}</span>
                @endif
            </a>
        </li>

        <!-- Paramètres (maintenant commun) -->
        <li class="nav-item">
            <a href="{{ route('parametres.index') }}"
                class="nav-link {{ request()->routeIs('parametres.*') ? 'active' : '' }}"
                data-tooltip="Paramètres">
                <i class="fas fa-cog"></i>
                <span>Paramètres</span>
            </a>
        </li>

        
        <!-- Séparateur -->
        <li class="nav-separator" style="flex: 1; border-top: 1px solid #e2e8f0; margin: 0.5rem 0.3rem;"></li>
        

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

        <!-- Toggle Réduire -->
        <li class="nav-item">
            <button class="nav-link w-100 border-0 bg-transparent text-start"
                    id="toggleSidebar"
                    data-tooltip="Réduire">
                <i class="fas fa-chevron-left" id="toggleIcon"></i>
                <span class="toggle-text">Réduire</span>
            </button>
        </li>

        <!-- Séparateur -->
        <li class="nav-separator" style="flex: 1; border-top: 1px solid #e2e8f0; margin: 0.5rem 0.3rem;"></li>
        <!-- Utilisateur connecté -->
        <li class="nav-item " id="userInfo" data-tooltip="{{ Auth::user()->nomComplet }}">
            <div class="nav-link" style="cursor: default;">
                <div class="user-avatar-sm">
                    {{ substr(Auth::user()->nomComplet, 0, 2) }}
                </div>
                <div class="user-info-text">
                    <div class="fw-bold">{{ Auth::user()->nomComplet }}</div>
                    <div class="user-role">Administrateur</div>
                </div>
            </div>
        </li>


    </ul>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('mainSidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const toggleIcon = document.getElementById('toggleIcon');
        const toggleText = document.querySelector('.toggle-text');

        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            toggleIcon.classList.replace('fa-chevron-left', 'fa-chevron-right');
            if (toggleText) toggleText.textContent = 'Agrandir';
        }

        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('collapsed');
            const collapsed = sidebar.classList.contains('collapsed');

            localStorage.setItem('sidebarCollapsed', collapsed);

            if (collapsed) {
                toggleIcon.classList.replace('fa-chevron-left', 'fa-chevron-right');
                if (toggleText) toggleText.textContent = 'Agrandir';
            } else {
                toggleIcon.classList.replace('fa-chevron-right', 'fa-chevron-left');
                if (toggleText) toggleText.textContent = 'Réduire';
            }
        });

        function handleMobileView() {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('collapsed');
                sidebar.classList.remove('show');
            }
        }

        window.addEventListener('resize', handleMobileView);
        handleMobileView();
    });
</script>
@endpush
@endauth