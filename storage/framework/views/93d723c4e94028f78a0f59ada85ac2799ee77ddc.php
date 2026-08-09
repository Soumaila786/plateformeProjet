<?php $__env->startSection('title', 'Mes projets'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('porteur.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <span>Mes projets</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Mes projets</h1>
            <p class="page-header-sub"><?php echo e($projets->total()); ?> projet<?php echo e($projets->total() > 1 ? 's' : ''); ?> au total</p>
        </div>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('projets.creer')): ?>
            <button type="button" class="btn btn-primary btn-sm"
                    data-modal-new="modalProjetForm"
                    data-modal-action="<?php echo e(route('porteur.projets.store')); ?>"
                    data-modal-titre-creation="Nouveau projet">
                <i class="fas fa-plus"></i> Nouveau projet
            </button>
        <?php endif; ?>
    </div>

    <?php echo $__env->make('projets.partials._liste_filtres', [
        'statutOptions' => [
            'brouillon' => 'Brouillon', 'soumis' => 'Soumis', 'en_examen' => 'En examen',
            'approuve' => 'Approuvé', 'valide' => 'Validé', 'rejete' => 'Rejeté',
        ],
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('projets.partials._liste_lignes', ['routeShow' => 'porteur.projets.show'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('projets.creer')): ?>
        <?php echo $__env->make('modals.projet-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/projets/partials/liste/_porteur.blade.php ENDPATH**/ ?>