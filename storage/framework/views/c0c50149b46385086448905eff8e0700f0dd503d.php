<?php $__env->startSection('title', 'Mes projets traités'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('approbateur.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <span>Mes projets traités</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Mes projets traités</h1>
            <p class="page-header-sub"><?php echo e($projets->total()); ?> projet<?php echo e($projets->total() > 1 ? 's' : ''); ?> au total</p>
        </div>
        <a href="<?php echo e(route('approbateur.projets.index')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-inbox"></i> Projets à examiner
        </a>
    </div>

    <?php echo $__env->make('projets.partials._liste_filtres', [
        'secteurs' => $secteurs,
        'statutOptions' => ['approuve' => 'Approuvé', 'rejete' => 'Rejeté'],
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('projets.partials._liste_lignes', ['routeShow' => 'approbateur.projets.show'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\projets\partials\historique\_approbateur.blade.php ENDPATH**/ ?>