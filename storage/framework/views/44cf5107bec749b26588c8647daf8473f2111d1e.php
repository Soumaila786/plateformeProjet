<?php $__env->startSection('title', 'Utilisateurs'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('admin.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <a href="<?php echo e(route('parametres.index')); ?>">Paramètres</a>
    <span>/</span>
    <span>Utilisateurs</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/parametres.css')); ?>">
    <?php $__env->stopPush(); ?>

    <?php echo $__env->make('parametres.partials._tabs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Utilisateurs</h1>
            <p class="page-header-sub"><?php echo e($users->total()); ?> utilisateur<?php echo e($users->total() > 1 ? 's' : ''); ?> au total</p>
        </div>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('utilisateurs.gerer')): ?>
            <button type="button" class="btn btn-primary btn-sm"
                    data-modal-new="modalUserForm"
                    data-modal-action="<?php echo e(route('admin.users.store')); ?>"
                    data-modal-titre-creation="Nouvel utilisateur">
                <i class="fas fa-plus"></i> Nouvel utilisateur
            </button>
        <?php endif; ?>
    </div>

    <?php echo $__env->make('users.partials._liste_filtres', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('users.partials._liste_lignes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('utilisateurs.gerer')): ?>
        <?php echo $__env->make('modals.user-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\users\index.blade.php ENDPATH**/ ?>