<?php $__env->startSection('title', 'Paramètres'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/parametre.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="parametres-page">
    <div class="param-header">
        <h1 class="param-title">Paramètres</h1>
        <p class="param-subtitle">Configuration de votre compte</p>
    </div>
    <div class="param-list">
        <a href="<?php echo e(route('parametres.profil')); ?>" class="param-card">
            <div class="param-icon"><i class="fas fa-user"></i></div>
            <div class="param-info">
                <p class="param-label">Profil</p>
                <p class="param-desc">Modifier vos informations personnelles</p>
            </div>
            <i class="fas fa-chevron-right param-arrow"></i>
        </a>
        <a href="<?php echo e(route('parametres.securite')); ?>" class="param-card">
            <div class="param-icon"><i class="fas fa-shield-alt"></i></div>
            <div class="param-info">
                <p class="param-label">Sécurité</p>
                <p class="param-desc">Mot de passe et authentification</p>
            </div>
            <i class="fas fa-chevron-right param-arrow"></i>
        </a>
        <a href="<?php echo e(route('parametres.notifications')); ?>" class="param-card">
            <div class="param-icon"><i class="fas fa-bell"></i></div>
            <div class="param-info">
                <p class="param-label">Notifications</p>
                <p class="param-desc">Préférences de notification</p>
            </div>
            <i class="fas fa-chevron-right param-arrow"></i>
        </a>
        <a href="<?php echo e(route('parametres.general')); ?>" class="param-card">
            <div class="param-icon"><i class="fas fa-cog"></i></div>
            <div class="param-info">
                <p class="param-label">Général</p>
                <p class="param-desc">Langue, fuseau horaire</p>
            </div>
            <i class="fas fa-chevron-right param-arrow"></i>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/parametres/index.blade.php ENDPATH**/ ?>