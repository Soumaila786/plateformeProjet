<?php
    $ongletsPerso = [
        'profil'        => ['label' => 'Profil', 'subtitle' => 'Vos informations personnelles', 'icon' => 'fa-user', 'route' => 'parametres.profil', 'params' => []],
        'notifications' => ['label' => 'Notifications', 'subtitle' => 'Vos préférences d’alerte', 'icon' => 'fa-bell', 'route' => 'parametres.notifications', 'params' => []],
        'securite'      => ['label' => 'Sécurité', 'subtitle' => 'Mot de passe et protection', 'icon' => 'fa-shield-halved', 'route' => 'parametres.securite', 'params' => []],
    ];

    // FIX : ce sont les vrais NOMS DE ROUTE (admin.users.index, etc.), pas les
    // noms de vue (users.index) — les deux sont différents, seul le view()
    // appelé par les controllers a été renommé, pas les routes elles-mêmes.
    $ongletsAdmin = [
        'utilisateurs' => ['label' => 'Utilisateurs', 'subtitle' => 'Comptes et accès', 'icon' => 'fa-users', 'route' => 'admin.users.index'],
        'secteurs' => ['label' => 'Secteurs d’activité', 'subtitle' => 'Domaines principaux des projets', 'icon' => 'fa-building', 'route' => 'admin.secteurs.index'],
        'types' => ['label' => 'Types de projets', 'subtitle' => 'Catégories de projets CIFEU', 'icon' => 'fa-layer-group', 'route' => 'admin.types-projets.index'],
        'sous-domaines' => ['label' => 'Sous-domaines', 'subtitle' => 'Précision par secteur d’activité', 'icon' => 'fa-diagram-project', 'route' => 'admin.sous-domaines.index'],
        'configuration' => ['label' => 'Configuration système', 'subtitle' => 'Logo, identité et règles de l’application', 'icon' => 'fa-cogs', 'route' => 'admin.configuration.index'],
        'motifs' => ['label' => 'Motifs de rejet', 'subtitle' => 'Motifs proposés lors des contrôles', 'icon' => 'fa-list-check', 'route' => 'admin.motifs.index'],
        'journal' => ['label' => 'Journal', 'subtitle' => 'Traçabilité des actions système', 'icon' => 'fa-clipboard-list', 'route' => 'admin.logs.index'],
    ];

    // Détecte l'onglet actif selon la route/le paramètre courant
    $ongletActifPerso = request()->routeIs('parametres.profil') ? 'profil'
        : (request()->routeIs('parametres.notifications') ? 'notifications'
        : (request()->routeIs('parametres.securite') ? 'securite' : null));
?>

<div class="param-tabs">

    <?php $__currentLoopData = $ongletsPerso; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cle => $onglet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route($onglet['route'], $onglet['params'])); ?>"
            class="param-tab <?php echo e($ongletActifPerso === $cle ? 'active' : ''); ?>">
            <span class="param-tab-icon"><i class="fas <?php echo e($onglet['icon']); ?>"></i></span>
            <span><strong><?php echo e($onglet['label']); ?></strong><small><?php echo e($onglet['subtitle']); ?></small></span>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('utilisateurs.gerer')): ?>
        <span class="param-tabs-sep"></span>
        <?php $__currentLoopData = $ongletsAdmin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $onglet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(!Route::has($onglet['route'])) continue; ?>
            <a href="<?php echo e(route($onglet['route'])); ?>"
                class="param-tab <?php echo e(request()->routeIs($onglet['route']) ? 'active' : ''); ?>">
                <span class="param-tab-icon"><i class="fas <?php echo e($onglet['icon']); ?>"></i></span>
                <span><strong><?php echo e($onglet['label']); ?></strong><small><?php echo e($onglet['subtitle']); ?></small></span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/parametres/partials/_tabs.blade.php ENDPATH**/ ?>