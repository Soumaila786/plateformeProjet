

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

    <?php echo $__env->make('projets.partials._liste_filtres', ['secteurs' => $secteurs], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <?php echo $__env->make('projets.partials._liste_lignes', [
        'routeShow' => 'validateur.projets.show',
        'routeValider' => 'validateur.projets.valider',
        'routeRejeter' => 'validateur.projets.rejeter',
        'routeDemanderModif' => 'validateur.projets.demande-modification',
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\projets\liste-a-valider.blade.php ENDPATH**/ ?>