<?php $__env->startSection('title', 'Projets à valider'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('validateur.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <span>Projets à valider</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Projets à valider</h1>
            <p class="page-header-sub"><?php echo e($projets->total()); ?> projet<?php echo e($projets->total() > 1 ? 's' : ''); ?> au total</p>
        </div>
        <a href="<?php echo e(route('validateur.projets.mes_projets')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-history"></i> Mes projets traités
        </a>
    </div>

    <?php echo $__env->make('projets.partials._liste_filtres', ['secteurs' => $secteurs], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('projets.partials._liste_lignes', [
        'routeShow' => 'validateur.projets.show',
        'routeValider' => 'validateur.projets.valider',
        'routeRejeter' => 'validateur.projets.rejeter',
        'routeDemanderModif' => 'validateur.projets.demande-modification',
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\projets\partials\liste\_validateur.blade.php ENDPATH**/ ?>