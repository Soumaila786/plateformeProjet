

<?php $__env->startSection('title', 'Tableau de bord'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <span>Tableau de bord</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Bonjour, <?php echo e(explode(' ', auth()->user()->nomComplet)[0] ?? ''); ?></h1>
            <p class="page-header-sub">Voici un aperçu de votre espace <?php echo e(ucfirst(auth()->user()->role)); ?></p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <?php echo $__env->make('dashboard.partials._' . auth()->user()->role, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/dashboard/index.blade.php ENDPATH**/ ?>