<?php $__env->startSection('title', 'Préférences de notifications'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/parametre.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="param-subpage">

    <div class="param-subpage-header">
        <a href="<?php echo e(route('parametres.index')); ?>" class="param-back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="param-subpage-title">Préférences de notifications</h1>
            <p class="param-subpage-sub">Choisissez comment être notifié</p>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="param-alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="param-section-card">
        <div class="param-section-header">
            <i class="fas fa-bell"></i><span>Canaux de notification</span>
        </div>
        <div class="param-section-body">
            <form action="<?php echo e(route('parametres.notifications.update')); ?>" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="param-toggle-list">
                    <div class="param-toggle-item">
                        <div class="param-toggle-info">
                            <p class="param-toggle-label">Notifications par email</p>
                            <p class="param-toggle-desc">Recevoir les alertes sur votre adresse email</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="email_notifications" value="1" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="param-toggle-item">
                        <div class="param-toggle-info">
                            <p class="param-toggle-label">Notifications projets</p>
                            <p class="param-toggle-desc">Soumissions, approbations, validations</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="projet_notifications" value="1" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="param-toggle-item">
                        <div class="param-toggle-info">
                            <p class="param-toggle-label">Notifications commentaires</p>
                            <p class="param-toggle-desc">Demandes de modification et observations</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="commentaire_notifications" value="1" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
                <div class="param-form-actions">
                    <button type="submit" class="param-btn-save">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <a href="<?php echo e(route('parametres.index')); ?>" class="param-btn-cancel">Annuler</a>
                </div>
            </form>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/parametres/notifications.blade.php ENDPATH**/ ?>