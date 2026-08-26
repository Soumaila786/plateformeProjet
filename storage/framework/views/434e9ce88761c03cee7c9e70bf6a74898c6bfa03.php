<?php if(auth()->guard()->check()): ?>
<?php
    $role = Auth::user()->role;
    $notifCount = \App\Models\Notification::where('destinataire_id', Auth::id())
        ->where('statut', 'non_lu')->count();

    $estActif = function (string $route) {
        if (request()->routeIs($route)) {
            return true;
        }
        if (\Illuminate\Support\Str::endsWith($route, '.index')) {
            $prefixe = \Illuminate\Support\Str::beforeLast($route, '.index');
            return request()->routeIs($prefixe . '.show');
        }
        return false;
    };

    $menusParRole = [
        'admin' => [
            ['label' => 'Tableau Analytique', 'icon' => 'fa-chart-pie',        'route' => 'admin.analytique'],
            ['label' => 'Projets',             'icon' => 'fa-project-diagram', 'route' => 'admin.projets.index',      'permission' => 'projets.voir'],
            ['label' => 'Configuration système','icon' => 'fa-cogs',           'route' => 'admin.configuration.index','permission' => 'configurations.gerer'],
        ],
        'porteur' => [
            ['label' => 'Mes projets',    'icon' => 'fa-folder-open',  'route' => 'porteur.projets.index'],
            ['label' => 'Nouveau projet', 'icon' => 'fa-plus-circle',  'route' => 'porteur.projets.create', 'permission' => 'projets.creer'],
        ],
        'approbateur' => [
            ['label' => 'Tableau Analytique', 'icon' => 'fa-chart-pie',   'route' => 'approbateur.analytique'],
            ['label' => 'À approuver',        'icon' => 'fa-tasks',       'route' => 'approbateur.projets.index'],
            ['label' => 'Mes projets',        'icon' => 'fa-folder-open','route' => 'approbateur.projets.mes_projets'],
        ],
        'validateur' => [
            ['label' => 'Tableau Analytique',    'icon' => 'fa-chart-pie',    'route' => 'validateur.analytique'],
            ['label' => 'À valider',             'icon' => 'fa-check-double', 'route' => 'validateur.projets.index'],
            ['label' => 'Mes projets traités',   'icon' => 'fa-folder-open',  'route' => 'validateur.projets.mes_projets'],
        ],
        'planificateur' => [
            ['label' => 'Projets à traiter', 'icon' => 'fa-inbox',       'route' => 'planificateur.projets.index'],
            ['label' => 'Projets traités',   'icon' => 'fa-folder-open','route' => 'planificateur.projets.traites'],
        ],
    ];

    $items = $menusParRole[$role] ?? [];

    // FIX : vrais noms de route admin.users.*/admin.secteurs.*/admin.motifs.*
    // (pas users.*/secteurs.*/motifs.* — ce sont des noms de vue, pas de route)
    $parametresActif = request()->routeIs('parametres.*')
        || request()->routeIs('admin.users.*')
        || request()->routeIs('admin.secteurs.*')
        || request()->routeIs('admin.types-projets.*')
        || request()->routeIs('admin.sous-domaines.*')
        || request()->routeIs('admin.configuration.*')
        || request()->routeIs('admin.motifs.*')
        || request()->routeIs('admin.logs.*');
?>

<div class="sidebar" id="mainSidebar">

    <!-- Header logo -->
    <div class="sidebar-header d-flex align-items-center px-3 py-3">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.brand.logo','data' => ['size' => 36,'showText' => true]]); ?>
<?php $component->withName('brand.logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => 36,'show-text' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    </div>

    <ul class="nav-menu flex-grow-1">

        <!-- Tableau de bord -->
        <li class="nav-item">
            <a href="<?php echo e(route($role . '.dashboard')); ?>"
                class="nav-link <?php echo e(request()->routeIs($role . '.dashboard') ? 'active' : ''); ?>"
                data-tooltip="Tableau de bord">
                <i class="fas fa-home"></i>
                <span>Tableau de bord</span>
            </a>
        </li>

        
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($item['permission']) && !auth()->user()->can($item['permission'])) continue; ?>
            <?php if(!Route::has($item['route'])) continue; ?>
            <li class="nav-item">
                <a href="<?php echo e(route($item['route'])); ?>"
                    class="nav-link <?php echo e($estActif($item['route']) ? 'active' : ''); ?>"
                    data-tooltip="<?php echo e($item['label']); ?>">
                    <i class="fas <?php echo e($item['icon']); ?>"></i>
                    <span><?php echo e($item['label']); ?></span>
                </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        

        <li class="nav-item">
            <a href="<?php echo e(route($role . '.notifications.index')); ?>"
                class="nav-link <?php echo e(request()->routeIs($role . '.notifications*') ? 'active' : ''); ?>"
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
                class="nav-link <?php echo e($parametresActif ? 'active' : ''); ?>"
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
        <li class="nav-item sidebar-user-info" id="userInfo" data-tooltip="<?php echo e(Auth::user()->nomComplet); ?>">
            <div class="nav-link sidebar-user-link">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.avatars.avatar','data' => ['size' => 34,'class' => 'user-avatar-sm']]); ?>
<?php $component->withName('avatars.avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => 34,'class' => 'user-avatar-sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <div class="user-info-text">
                    <div class="fw-bold"><?php echo e(Auth::user()->nomComplet); ?></div>
                    <div class="user-role"><?php echo e(Auth::user()->email); ?></div>
                </div>
            </div>
        </li>

    </ul>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/sidebar-toggle.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\partials\sidebar.blade.php ENDPATH**/ ?>