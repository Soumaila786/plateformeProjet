<!-- Tableau de bord -->
<li class="nav-item mb-2">
    <a href="{{ route('validateur.dashboard') }}" class="nav-link {{ request()->routeIs('validateur.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt me-3"></i>
        <span>Tableau de bord</span>
    </a>
</li>

<!-- Projets -->
<li class="nav-item mb-2">
    <a href="{{ route('validateur.projets.index') }}" class="nav-link {{ request()->routeIs('validateur.projets.*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram me-3"></i>
        <span>Projets</span>
    </a>
</li>

<!-- Notifications -->
<li class="nav-item mb-2">
    <a href="{{ route('validateur.notifications.index') }}" class="nav-link {{ request()->routeIs('validateur.notifications.*') ? 'active' : '' }}">
        <i class="fas fa-bell me-3"></i>
        <span>Notifications</span>
    </a>
</li>

<!-- Paramètres -->
<li class="nav-item mb-2">
    <a href="{{ route('validateur.parametres.index') }}" class="nav-link {{ request()->routeIs('validateur.parametres.*') ? 'active' : '' }}">
        <i class="fas fa-cog me-3"></i>
        <span>Paramètres</span>
    </a>
</li>
