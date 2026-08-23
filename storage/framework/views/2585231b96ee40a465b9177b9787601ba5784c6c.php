

<?php $__env->startSection('title', 'Tableau analytique'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route(auth()->user()->role.'.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <span>Analytique</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Tableau analytique</h1>
            <p class="page-header-sub">Statistiques et tendances de vos projets</p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <?php echo $__env->make('analytique.partials._' . auth()->user()->role, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/analytique/index.blade.php ENDPATH**/ ?>