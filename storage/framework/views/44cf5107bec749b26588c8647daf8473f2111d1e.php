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

    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Utilisateurs</h1>
            <p class="page-header-sub"><?php echo e($users->total()); ?> utilisateur<?php echo e($users->total() > 1 ? 's' : ''); ?> au total</p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="<?php echo e(route('parametres.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('utilisateurs.gerer')): ?>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#form-ajout-utilisateur" aria-expanded="false"><i class="fas fa-plus me-1"></i>Créer un utilisateur</button>
            <?php endif; ?>
        </div>
    </div>

    <?php echo $__env->make('users.partials._liste_filtres', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('utilisateurs.gerer')): ?>
        <div class="collapse mb-4" id="form-ajout-utilisateur"><div class="card border-0"><div class="card-body">
            <h5 class="fw-bold mb-3">Ajouter un utilisateur</h5>
            <form method="POST" action="<?php echo e(route('admin.users.store')); ?>"><?php echo csrf_field(); ?>
                <?php echo $__env->make('users.partials._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="d-flex justify-content-end mt-3"><button class="btn btn-primary" type="submit"><i class="fas fa-plus me-1"></i>Créer le compte</button></div>
            </form>
        </div></div></div>
    <?php endif; ?>
    <?php echo $__env->make('users.partials._liste_lignes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('utilisateurs.gerer')): ?>
        <?php echo $__env->make('modals.user-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/users-form.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\users\index.blade.php ENDPATH**/ ?>