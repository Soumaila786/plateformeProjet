

<?php $__env->startSection('title', $projet->titre); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route(auth()->user()->role.'.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <span><?php echo e($projet->codeProjet); ?></span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/projet-show.css')); ?>">
    <?php $__env->stopPush(); ?>

    <?php echo $__env->make('projets.partials._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row g-4">
        <div class="col-lg-8 ps-main">
            <?php echo $__env->make('projets.partials._main_info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('projets.partials._activities', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('projets.partials._documents', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-lg-4">
            <?php echo $__env->make('projets.partials._history', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\projets\show.blade.php ENDPATH**/ ?>