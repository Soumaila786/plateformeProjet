

<?php $__env->startSection('title', 'Secteurs d\'activité'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('admin.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <span>Secteurs d'activité</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Secteurs d'activité</h1>
            <p class="page-header-sub"><?php echo e($secteurs->total()); ?> secteur<?php echo e($secteurs->total() > 1 ? 's' : ''); ?> au total</p>
        </div>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('secteurs.gerer')): ?>
            <button type="button" class="btn btn-primary btn-sm"
                    data-modal-new="modalSecteurForm"
                    data-modal-action="<?php echo e(route('admin.secteurs.store')); ?>"
                    data-modal-titre-creation="Nouveau secteur">
                <i class="fas fa-plus"></i> Nouveau secteur
            </button>
        <?php endif; ?>
    </div>

    <?php echo $__env->make('secteurs.partials._liste_filtres', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('secteurs.partials._liste_lignes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('secteurs.gerer')): ?>
        <?php echo $__env->make('modals.secteur-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/secteurs/index.blade.php ENDPATH**/ ?>