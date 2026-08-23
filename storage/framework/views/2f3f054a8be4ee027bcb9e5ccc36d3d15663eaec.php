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

    <?php echo $__env->make('parametres.partials._tabs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Motifs de rejet</h1>
            <p class="page-header-sub"><?php echo e(count($motifs)); ?> motif<?php echo e(count($motifs) > 1 ? 's' : ''); ?> configuré<?php echo e(count($motifs) > 1 ? 's' : ''); ?></p>
        </div>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('motifs.gerer')): ?>
            <button type="button" class="btn btn-primary btn-sm"
                    data-modal-new="modalMotifForm"
                    data-modal-action="<?php echo e(route('admin.motifs.store')); ?>"
                    data-modal-titre-creation="Nouveau motif">
                <i class="fas fa-plus"></i> Nouveau motif
            </button>
        <?php endif; ?>
    </div>

    <?php echo $__env->make('motifs.partials._liste_filtres', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('motifs.partials._liste_lignes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('motifs.gerer')): ?>
        <?php echo $__env->make('modals.motif-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\motifs\index.blade.php ENDPATH**/ ?>