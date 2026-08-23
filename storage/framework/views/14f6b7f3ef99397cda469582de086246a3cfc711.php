

<?php $__env->startSection('title', 'Notifications'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route(auth()->user()->role.'.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <span>Notifications</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Notifications</h1>
            <p class="page-header-sub"><?php echo e($notifications->total()); ?> notification<?php echo e($notifications->total() > 1 ? 's' : ''); ?> au total</p>
        </div>

        <div class="d-flex gap-2">
            <form method="POST" action="<?php echo e(route($role.'.notifications.toutes-lues')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-check-double"></i> Tout marquer comme lu
                </button>
            </form>
            <form method="POST" action="<?php echo e(route($role.'.notifications.destroy-lues')); ?>"
                onsubmit="return confirm('Supprimer toutes les notifications déjà lues ?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-trash"></i> Supprimer les lues
                </button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/notifications.css')); ?>">
    <?php $__env->stopPush(); ?>

    <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="notif-item <?php echo e($notif->statut === 'non_lu' ? 'is-unread' : ''); ?>">
            <div class="notif-icon" style="background: color-mix(in srgb, <?php echo e($notif->couleur()); ?> 15%, white); color: <?php echo e($notif->couleur()); ?>;">
                <i class="fas <?php echo e($notif->icone()); ?>"></i>
            </div>

            <div class="notif-body">
                <p class="notif-message"><?php echo e($notif->message); ?></p>
                <div class="notif-date"><?php echo e(optional($notif->dateEnvoi)->format('d/m/Y à H:i')); ?></div>
            </div>

            <div class="notif-actions">
                <?php if($notif->projet && Route::has($role.'.projets.show')): ?>
                    <a href="<?php echo e(route($role.'.projets.show', $notif->projet)); ?>" class="btn btn-sm btn-link text-decoration-none" title="Voir le projet">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route($role.'.notifications.destroy', $notif)); ?>"
                    onsubmit="return confirm('Supprimer cette notification ?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-sm btn-link text-danger text-decoration-none" title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center text-muted py-5">
            <i class="fas fa-bell-slash" style="font-size:2rem; color: var(--color-border); display:block; margin-bottom:.5rem;"></i>
            <p class="mb-0">Aucune notification pour l'instant.</p>
        </div>
    <?php endif; ?>

    <div class="mt-3">
        <?php echo e($notifications->withQueryString()->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/notifications/index.blade.php ENDPATH**/ ?>