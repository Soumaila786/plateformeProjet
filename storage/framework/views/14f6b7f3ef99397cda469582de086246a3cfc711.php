<?php $__env->startSection('title', 'Notifications'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/notification.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="notif-page">

    
    <div class="notif-header">
        <div>
            <h1 class="notif-page-title">
                <i class="fas fa-bell" style="color:var(--primary);margin-right:10px;"></i>Notifications
            </h1>
            <p class="notif-page-sub">
                <?php $nonLues = $notifications->where('statut','non_lu')->count(); ?>
                <?php if($nonLues > 0): ?>
                    <span style="color:var(--primary);font-weight:600;"><?php echo e($nonLues); ?> non lue<?php echo e($nonLues > 1 ? 's' : ''); ?></span>
                    · <?php echo e($notifications->total()); ?> au total
                <?php else: ?>
                    <?php echo e($notifications->total()); ?> notification<?php echo e($notifications->total() > 1 ? 's' : ''); ?>

                <?php endif; ?>
            </p>
        </div>

        <div class="notif-actions">
            <form method="POST" action="<?php echo e(route($role . '.notifications.toutes-lues')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-mark-read">
                    <i class="fas fa-check-double"></i> Tout marquer lu
                </button>
            </form>
            <form method="POST" action="<?php echo e(route($role . '.notifications.destroy-lues')); ?>"
                    onsubmit="return confirm('Supprimer toutes les notifications lues ?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn-delete-read">
                    <i class="fas fa-trash"></i> Supprimer les lues
                </button>
            </form>
        </div>
    </div>

    
    <?php if(session('success')): ?>
    <div class="notif-alert-success">
        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    
    <?php if($notifications->count() > 0): ?>
    <div class="notif-list">
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $isNonLue = $notif->statut === 'non_lu';
            $icons = [
                'statut_change' => ['icon'=>'fa-exchange-alt', 'bg'=>'#eff6ff', 'color'=>'#2563eb'],
                'approbation'   => ['icon'=>'fa-check-circle',  'bg'=>'#f0fdf4', 'color'=>'#16a34a'],
                'validation'    => ['icon'=>'fa-badge-check',   'bg'=>'#f0fdfa', 'color'=>'#0d9488'],
                'rejet'         => ['icon'=>'fa-times-circle',  'bg'=>'#fef2f2', 'color'=>'#dc2626'],
                'modification'  => ['icon'=>'fa-edit',          'bg'=>'#fffbeb', 'color'=>'#d97706'],
                'soumission'    => ['icon'=>'fa-paper-plane',   'bg'=>'#eef2ff', 'color'=>'#6366f1'],
                'info'          => ['icon'=>'fa-info-circle',   'bg'=>'#f9fafb', 'color'=>'#6b7280'],
            ];
            $ic = $icons[$notif->type] ?? $icons['info'];
        ?>

        <div class="notif-item <?php echo e($isNonLue ? 'non-lue' : 'lue'); ?>">

            <div class="notif-icon" style="background:<?php echo e($ic['bg']); ?>;color:<?php echo e($ic['color']); ?>;">
                <i class="fas <?php echo e($ic['icon']); ?>"></i>
            </div>

            <div class="notif-body">
                <p class="notif-message"><?php echo e($notif->message); ?></p>
                <div class="notif-meta">
                    <span class="notif-date">
                        <i class="fas fa-clock"></i>
                        <?php echo e($notif->dateEnvoi ? $notif->dateEnvoi->diffForHumans() : '—'); ?>

                    </span>
                    <?php if($notif->projet): ?>
                    <a href="<?php echo e(route($role . '.projets.show', $notif->projet)); ?>" class="notif-projet-link">
                        <i class="fas fa-folder-open"></i>
                        <?php echo e($notif->projet->codeProjet); ?> — <?php echo e(Str::limit($notif->projet->titre, 40)); ?>

                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="notif-side">
                <?php if($isNonLue): ?>
                <span class="notif-dot" title="Non lue"></span>
                <?php endif; ?>
                <form method="POST"
                        action="<?php echo e(route($role . '.notifications.destroy', $notif)); ?>"
                        onsubmit="return confirm('Supprimer cette notification ?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="notif-del-btn" title="Supprimer">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
            </div>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($notifications->hasPages()): ?>
    <div class="notif-pagination">
        <?php echo e($notifications->links()); ?>

    </div>
    <?php endif; ?>

    <?php else: ?>
    <div class="notif-list">
        <div class="notif-empty">
            <i class="fas fa-bell-slash"></i>
            <p>Aucune notification pour le moment.</p>
        </div>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/notifications/index.blade.php ENDPATH**/ ?>