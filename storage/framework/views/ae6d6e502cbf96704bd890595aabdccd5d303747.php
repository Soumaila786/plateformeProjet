

<?php $__env->startSection('title', 'Projets planifiés'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('planificateur.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <span>Projets planifiés</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Projets déjà planifiés</h1>
            <p class="page-header-sub"><?php echo e($projets->total()); ?> projet<?php echo e($projets->total() > 1 ? 's' : ''); ?> au total</p>
        </div>
        <a href="<?php echo e(route('planificateur.projets.index')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-inbox"></i> Demandes à planifier
        </a>
    </div>

    <?php echo $__env->make('projets.partials._liste_filtres', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('projets.partials._liste_lignes', ['routeShow' => 'planificateur.projets.show'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\projets\projets-planifies.blade.php ENDPATH**/ ?>