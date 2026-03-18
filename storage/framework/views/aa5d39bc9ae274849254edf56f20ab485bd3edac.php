<?php if(auth()->guard()->check()): ?>
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
            <h5 class="fw-bold mb-0" style="color: #1e293b; font-size: 1.1rem;"><?php echo e(config('app.name')); ?></h5>
            <small class="text-muted" style="font-size: 0.7rem;">Gestion de projets</small>
        </div>
    </div>

    <?php
        $role = Auth::user()->role;
    ?>

    <ul class="nav-menu flex-grow-1">

        <!-- Tableau de bord -->
        <li class="nav-item">
            <a href="<?php echo e(url($role . '/dashboard')); ?>"
                class="nav-link <?php echo e(request()->is($role . '/dashboard') ? 'active' : ''); ?>"
                data-tooltip="Tableau de bord">
                <i class="fas fa-home"></i>
                <span>Tableau de bord</span>
            </a>
        </li>

        
        <?php if($role === 'admin'): ?>

            <li class="nav-item">
                <a href="<?php echo e(route('admin.analytique')); ?>"
                    class="nav-link <?php echo e(request()->routeIs('admin.projets.*') ? 'active' : ''); ?>"
                    data-tooltip="À valider">
                    <i class="fas fa-chart-pie"></i>
                    <span>Tableau Analytique</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('admin.users.index')); ?>"
                    class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>"
                    data-tooltip="Utilisateurs">
                    <i class="fas fa-users"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('admin.projets.index')); ?>"
                    class="nav-link <?php echo e(request()->routeIs('admin.projets.*') ? 'active' : ''); ?>"
                    data-tooltip="Projets">
                    <i class="fas fa-project-diagram"></i>
                    <span>Projets</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('admin.secteurs.index')); ?>"
                    class="nav-link <?php echo e(request()->routeIs('admin.secteurs.*') ? 'active' : ''); ?>"
                    data-tooltip="Secteurs">
                    <i class="fas fa-building"></i>
                    <span>Secteurs</span>
                </a>
            </li>
        <?php endif; ?>

        
        <?php if($role === 'porteur'): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('porteur.projets.index')); ?>"
                    class="nav-link <?php echo e(request()->routeIs('porteur.projets.*') ? 'active' : ''); ?>"
                    data-tooltip="Mes projets">
                    <i class="fas fa-folder-open"></i>
                    <span>Mes projets</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('porteur.projets.create')); ?>"
                    class="nav-link <?php echo e(request()->routeIs('porteur.projets.create') ? 'active' : ''); ?>"
                    data-tooltip="Nouveau projet">
                    <i class="fas fa-plus-circle"></i>
                    <span>Nouveau projet</span>
                </a>
            </li>
        <?php endif; ?>

        
        <?php if($role === 'approbateur'): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('approbateur.analytique')); ?>"
                    class="nav-link <?php echo e(request()->routeIs('approbateur.projets.*') ? 'active' : ''); ?>"
                    data-tooltip="À valider">
                    <i class="fas fa-chart-pie"></i>
                    <span>Tableau Analytique</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('approbateur.projets.index')); ?>"
                    class="nav-link <?php echo e(request()->routeIs('approbateur.projets.index') ? 'active' : ''); ?>"
                    data-tooltip="À approuver">
                    <i class="fas fa-tasks"></i>
                    <span>À approuver</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('approbateur.projets.mes_projets')); ?>"
                    class="nav-link <?php echo e(request()->routeIs('approbateur.projets.mes_projets') ? 'active' : ''); ?>"
                    data-tooltip="Mes projets">
                    <i class="fas fa-folder-open"></i>
                    <span>Mes projets</span>
                </a>
            </li>
        <?php endif; ?>

        
        <?php if($role === 'validateur'): ?>

            <li class="nav-item">
                <a href="<?php echo e(route('validateur.analytique')); ?>"
                    class="nav-link <?php echo e(request()->routeIs('validateur.projets.*') ? 'active' : ''); ?>"
                    data-tooltip="À valider">
                    <i class="fas fa-chart-pie"></i>
                    <span>Tableau Analytique</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('validateur.projets.index')); ?>"
                    class="nav-link <?php echo e(request()->routeIs('validateur.projets.*') ? 'active' : ''); ?>"
                    data-tooltip="À valider">
                    <i class="fas fa-check-double"></i>
                    <span>À valider</span>
                </a>
            </li>

        <?php endif; ?>

        
        <li class="nav-item">
            <?php
                $notifCount = \App\Models\Notification::where('destinataire_id', auth()->id())
                    ->where('statut', 'non_lu')->count();
            ?>
            <a href="<?php echo e(route($role . '.notifications.index')); ?>"
                class="nav-link  <?php echo e(request()->routeIs($role . '.notifications*') ? 'active' : ''); ?>"
                data-tooltip="Notifications">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
                <?php if($notifCount > 0): ?>
                    <span class="badge"><?php echo e($notifCount > 99 ? '99+' : $notifCount); ?></span>
                <?php endif; ?>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo e(route('parametres.index')); ?>"
                class="nav-link <?php echo e(request()->routeIs('parametres.*') ? 'active' : ''); ?>"
                data-tooltip="Paramètres">
                <i class="fas fa-cog"></i>
                <span>Paramètres</span>
            </a>
        </li>

        <div class="trait"></div>

        <!-- Déconnexion -->
        <li class="nav-item">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
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
        <li class="nav-item" id="userInfo" data-tooltip="<?php echo e(Auth::user()->nomComplet); ?>">
            <div class="nav-link" style="cursor: default;">
                <div class="user-avatar-sm">
                    <?php echo e(strtoupper(substr(Auth::user()->nomComplet, 0, 2))); ?>

                </div>
                <div class="user-info-text">
                    <div class="fw-bold"><?php echo e(Auth::user()->nomComplet); ?></div>
                    <div class="user-role"><?php echo e(ucfirst($role)); ?></div>
                </div>
            </div>
        </li>

    </ul>
</div>

<?php $__env->startPush('scripts'); ?>
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
        toggleIcon.classList.replace(
            collapsed ? 'fa-chevron-left'  : 'fa-chevron-right',
            collapsed ? 'fa-chevron-right' : 'fa-chevron-left'
        );
        if (toggleText) toggleText.textContent = collapsed ? 'Agrandir' : 'Réduire';
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth <= 768) sidebar.classList.remove('collapsed');
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>