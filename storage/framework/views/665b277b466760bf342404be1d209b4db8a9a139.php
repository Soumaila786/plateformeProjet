<?php $__env->startSection('title', 'Sécurité'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route(auth()->user()->role.'.dashboard')); ?>">Tableau de bord</a><span>/</span>
    <a href="<?php echo e(route('parametres.index')); ?>">Paramètres</a><span>/</span><span>Sécurité</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="page-header-top"><div><h1 class="page-header-title">Sécurité</h1><p class="page-header-sub">Protégez l’accès à votre compte.</p></div><a href="<?php echo e(route('parametres.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a></div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?><link rel="stylesheet" href="<?php echo e(asset('css/parametres.css')); ?>"><?php $__env->stopPush(); ?>
    <?php echo $__env->make('parametres.partials._securite', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\parametres\securite.blade.php ENDPATH**/ ?>