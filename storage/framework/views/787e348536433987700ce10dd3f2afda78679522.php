<?php
    $ongletsPerso = [
        'profil'        => ['label' => 'Profil',        'icon' => 'fa-user',            'route' => 'parametres.index', 'params' => ['onglet' => 'profil']],
        'notifications' => ['label' => 'Notifications',  'icon' => 'fa-bell',            'route' => 'parametres.index', 'params' => ['onglet' => 'notifications']],
        'securite'      => ['label' => 'Sécurité',       'icon' => 'fa-shield-halved',   'route' => 'parametres.index', 'params' => ['onglet' => 'securite']],
    ];

    // FIX : ce sont les vrais NOMS DE ROUTE (admin.users.index, etc.), pas les
    // noms de vue (users.index) — les deux sont différents, seul le view()
    // appelé par les controllers a été renommé, pas les routes elles-mêmes.
    $ongletsAdmin = [
        'utilisateurs' => ['label' => 'Utilisateurs',    'icon' => 'fa-users',           'route' => 'admin.users.index'],
        'secteurs'     => ['label' => 'Secteurs',        'icon' => 'fa-building',        'route' => 'admin.secteurs.index'],
        'motifs'       => ['label' => 'Motifs de rejet', 'icon' => 'fa-list-check',      'route' => 'admin.motifs.index'],
        'journal'      => ['label' => 'Journal',         'icon' => 'fa-clipboard-list',  'route' => 'admin.logs.index'],
    ];

    // Détecte l'onglet actif selon la route/le paramètre courant
    $ongletActifPerso = request()->routeIs('parametres.index') ? request('onglet', 'profil') : null;
?>

<div class="param-tabs">

    <?php $__currentLoopData = $ongletsPerso; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cle => $onglet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route($onglet['route'], $onglet['params'])); ?>"
            class="param-tab <?php echo e($ongletActifPerso === $cle ? 'active' : ''); ?>">
            <i class="fas <?php echo e($onglet['icon']); ?> me-1"></i> <?php echo e($onglet['label']); ?>

        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('utilisateurs.gerer')): ?>
        <span class="param-tabs-sep"></span>
        <?php $__currentLoopData = $ongletsAdmin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $onglet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(!Route::has($onglet['route'])) continue; ?>
            <a href="<?php echo e(route($onglet['route'])); ?>"
                class="param-tab <?php echo e(request()->routeIs($onglet['route']) ? 'active' : ''); ?>">
                <i class="fas <?php echo e($onglet['icon']); ?> me-1"></i> <?php echo e($onglet['label']); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/parametres/partials/_tabs.blade.php ENDPATH**/ ?>