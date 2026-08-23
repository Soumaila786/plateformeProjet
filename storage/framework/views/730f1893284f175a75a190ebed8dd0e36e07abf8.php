<?php $__env->startSection('title', 'Demandes à planifier'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('planificateur.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <span>Demandes à planifier</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Demandes de planification</h1>
            <p class="page-header-sub"><?php echo e($projets->total()); ?> projet<?php echo e($projets->total() > 1 ? 's' : ''); ?> au total</p>
        </div>
        <a href="<?php echo e(route('planificateur.projets.traites')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-history"></i> Projets traités
        </a>
    </div>

    <?php echo $__env->make('projets.partials._liste_filtres', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('projets.partials._liste_lignes', ['routeShow' => 'planificateur.projets.show'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\projets\partials\liste\_planificateur.blade.php ENDPATH**/ ?>