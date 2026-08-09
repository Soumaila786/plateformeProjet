<?php $__env->startSection('title', 'Projets'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('admin.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <span>Projets</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Tous les projets</h1>
            <p class="page-header-sub"><?php echo e($projets->total()); ?> projet<?php echo e($projets->total() > 1 ? 's' : ''); ?> au total</p>
        </div>
    </div>

    <?php echo $__env->make('projets.partials._liste_filtres', [
        'statutOptions' => [
            'brouillon' => 'Brouillon', 'soumis' => 'Soumis', 'en_examen' => 'En examen',
            'approuve' => 'Approuvé', 'valide' => 'Validé', 'rejete' => 'Rejeté',
        ],
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('projets.partials._liste_lignes', ['routeShow' => 'admin.projets.show'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/projets/partials/liste/_admin.blade.php ENDPATH**/ ?>