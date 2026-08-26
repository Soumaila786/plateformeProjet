<?php $__env->startSection('title', 'Motifs de rejet'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('admin.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <a href="<?php echo e(route('parametres.index')); ?>">Paramètres</a>
    <span>/</span>
    <span>Motifs de rejet</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/parametres.css')); ?>">
    <?php $__env->stopPush(); ?>

    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Motifs de rejet</h1>
            <p class="page-header-sub"><?php echo e(count($motifs)); ?> motif<?php echo e(count($motifs) > 1 ? 's' : ''); ?> configuré<?php echo e(count($motifs) > 1 ? 's' : ''); ?></p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="<?php echo e(route('parametres.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('motifs.gerer')): ?><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#form-ajout-motif"><i class="fas fa-plus me-1"></i>Créer un motif</button><?php endif; ?>
        </div>
    </div>

    <?php echo $__env->make('motifs.partials._liste_filtres', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('motifs.gerer')): ?>
        <div class="collapse mb-4" id="form-ajout-motif"><div class="card border-0"><div class="card-body"><h5 class="fw-bold mb-3">Ajouter un motif de rejet</h5><form method="POST" action="<?php echo e(route('admin.motifs.store')); ?>" class="row g-2 align-items-end"><?php echo csrf_field(); ?><div class="col-md-10"><label class="form-label">Libellé</label><input name="libelle" class="form-control" required maxlength="255"></div><div class="col-md-2"><button class="btn btn-primary w-100" type="submit"><i class="fas fa-plus me-1"></i>Ajouter</button></div></form></div></div></div>
    <?php endif; ?>
    <?php echo $__env->make('motifs.partials._liste_lignes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('motifs.gerer')): ?>
        <?php echo $__env->make('modals.motif-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/motifs/index.blade.php ENDPATH**/ ?>