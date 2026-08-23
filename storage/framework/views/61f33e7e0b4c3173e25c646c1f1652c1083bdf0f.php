<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/listes-projets.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/motifs.css')); ?>">
<?php $__env->stopPush(); ?>

<div class="lp-filtres">
    <div class="lp-search-wrap">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Rechercher un motif..." value="<?php echo e(request('search')); ?>"
               data-filter-search="search">
    </div>

    <?php if(request('search')): ?>
        <a href="<?php echo e(request()->url()); ?>" class="lp-reset-btn"><i class="fas fa-times"></i> Réinitialiser</a>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\motifs\partials\_liste_filtres.blade.php ENDPATH**/ ?>