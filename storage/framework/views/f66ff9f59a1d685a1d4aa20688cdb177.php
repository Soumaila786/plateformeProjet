<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/listes-projets.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/secteurs.css')); ?>">
<?php $__env->stopPush(); ?>

<div class="lp-filtres">
    <div class="lp-search-wrap">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Rechercher un secteur..." value="<?php echo e(request('search')); ?>"
               data-filter-search="search">
    </div>

    <select class="lp-select" name="statut" data-filter-select>
        <option value="">Tous les statuts</option>
        <option value="1" <?php echo e(request('statut') === '1' ? 'selected' : ''); ?>>Actifs</option>
        <option value="0" <?php echo e(request('statut') === '0' ? 'selected' : ''); ?>>Inactifs</option>
    </select>

    <?php if(request('search') || request('statut')): ?>
        <a href="<?php echo e(request()->url()); ?>" class="lp-reset-btn"><i class="fas fa-times"></i> Réinitialiser</a>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\secteurs\partials\_liste_filtres.blade.php ENDPATH**/ ?>