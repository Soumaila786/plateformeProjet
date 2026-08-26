<?php $__env->startSection('title', "Secteurs d'activité"); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('admin.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <a href="<?php echo e(route('parametres.index')); ?>">Paramètres</a>
    <span>/</span>
    <span>Secteurs d'activité</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/parametres.css')); ?>">
    <?php $__env->stopPush(); ?>

    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Secteurs d'activité</h1>
            <p class="page-header-sub"><?php echo e($secteurs->total()); ?> secteur<?php echo e($secteurs->total() > 1 ? 's' : ''); ?> au total</p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="<?php echo e(route('parametres.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('secteurs.gerer')): ?><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#form-ajout-secteur"><i class="fas fa-plus me-1"></i>Créer un secteur</button><?php endif; ?>
        </div>
    </div>

    <?php echo $__env->make('secteurs.partials._liste_filtres', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('secteurs.gerer')): ?>
        <div class="collapse mb-4" id="form-ajout-secteur"><div class="card border-0"><div class="card-body"><h5 class="fw-bold mb-3">Ajouter un secteur d’activité</h5><form method="POST" action="<?php echo e(route('admin.secteurs.store')); ?>" class="row g-2 align-items-end"><?php echo csrf_field(); ?><div class="col-md-4"><label class="form-label">Nom</label><input name="nomSecteur" class="form-control" required maxlength="255"></div><div class="col-md-6"><label class="form-label">Description</label><input name="description" class="form-control" maxlength="500"></div><div class="col-md-2"><button class="btn btn-primary w-100" type="submit"><i class="fas fa-plus me-1"></i>Ajouter</button></div></form></div></div></div>
    <?php endif; ?>
    <?php echo $__env->make('secteurs.partials._liste_lignes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('secteurs.gerer')): ?>
        <?php echo $__env->make('modals.secteur-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\secteurs\index.blade.php ENDPATH**/ ?>