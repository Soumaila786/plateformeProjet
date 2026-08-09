<?php $__env->startSection('title', 'Paramètres'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route(auth()->user()->role.'.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <span>Paramètres</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Paramètres</h1>
            <p class="page-header-sub">Gérez votre profil, votre sécurité et vos notifications</p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/parametres.css')); ?>">
    <?php $__env->stopPush(); ?>

    <?php $onglet = request('onglet', 'profil'); ?>

    <div class="param-tabs">
        <a href="<?php echo e(route('parametres.index', ['onglet' => 'profil'])); ?>" class="param-tab <?php echo e($onglet === 'profil' ? 'active' : ''); ?>">
            <i class="fas fa-user me-1"></i> Profil
        </a>
        <a href="<?php echo e(route('parametres.index', ['onglet' => 'securite'])); ?>" class="param-tab <?php echo e($onglet === 'securite' ? 'active' : ''); ?>">
            <i class="fas fa-shield-halved me-1"></i> Sécurité
        </a>
        <a href="<?php echo e(route('parametres.index', ['onglet' => 'notifications'])); ?>" class="param-tab <?php echo e($onglet === 'notifications' ? 'active' : ''); ?>">
            <i class="fas fa-bell me-1"></i> Notifications
        </a>
    </div>

    <?php if($onglet === 'securite'): ?>
        <?php echo $__env->make('parametres.partials._securite', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php elseif($onglet === 'notifications'): ?>
        <?php echo $__env->make('parametres.partials._notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('parametres.partials._profil', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/parametres/index.blade.php ENDPATH**/ ?>