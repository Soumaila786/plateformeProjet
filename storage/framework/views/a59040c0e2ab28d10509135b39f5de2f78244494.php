<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/listes-projets.css')); ?>">
<?php $__env->stopPush(); ?>

<div class="lp-filtres">
    <div class="lp-search-wrap">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Rechercher par nom ou email..." value="<?php echo e(request('search')); ?>"
               data-filter-search="search">
    </div>

    <select class="lp-select" name="role" data-filter-select>
        <option value="">Tous les rôles</option>
        <?php $__currentLoopData = ['admin' => 'Admin', 'porteur' => 'Porteur', 'approbateur' => 'Approbateur', 'validateur' => 'Validateur', 'planificateur' => 'Planificateur']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($val); ?>" <?php echo e(request('role') === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <select class="lp-select" name="actif" data-filter-select>
        <option value="">Tous les statuts</option>
        <option value="1" <?php echo e(request('actif') === '1' ? 'selected' : ''); ?>>Actifs</option>
        <option value="0" <?php echo e(request('actif') === '0' ? 'selected' : ''); ?>>Inactifs</option>
    </select>

    <?php if(request('search') || request('role') || request('actif')): ?>
        <a href="<?php echo e(request()->url()); ?>" class="lp-reset-btn"><i class="fas fa-times"></i> Réinitialiser</a>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/users/partials/_liste_filtres.blade.php ENDPATH**/ ?>