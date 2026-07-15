<?php $__env->startSection('title', 'Sécurité'); ?>
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
            <h1 class="param-subpage-title">Sécurité</h1>
            <p class="param-subpage-sub">Gérez votre mot de passe</p>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="param-alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
    <div class="param-alert-error"><i class="fas fa-exclamation-circle"></i> Veuillez corriger les erreurs.</div>
    <?php endif; ?>

    <div class="param-section-card">
        <div class="param-section-header">
            <i class="fas fa-lock"></i><span>Changer le mot de passe</span>
        </div>
        <div class="param-section-body">
            <div class="param-info-box">
                <i class="fas fa-info-circle"></i>
                Choisissez un mot de passe fort d'au moins 8 caractères.
            </div>
            <form action="<?php echo e(route('parametres.securite.update')); ?>" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="param-form-grid-1">
                    <div class="param-field">
                        <label class="param-field-label">Mot de passe actuel <span class="required">*</span></label>
                        <input type="password" name="current_password"
                                class="param-field-input <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="••••••••" required>
                        <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="param-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="param-field">
                        <label class="param-field-label">Nouveau mot de passe <span class="required">*</span></label>
                        <input type="password" name="new_password"
                                class="param-field-input <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="••••••••" required>
                        <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="param-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="param-field">
                        <label class="param-field-label">Confirmer le nouveau mot de passe <span class="required">*</span></label>
                        <input type="password" name="new_password_confirmation"
                                class="param-field-input"
                                placeholder="••••••••" required>
                    </div>
                </div>
                <div class="param-form-actions">
                    <button type="submit" class="param-btn-save">
                        <i class="fas fa-key"></i> Mettre à jour
                    </button>
                    <a href="<?php echo e(route('parametres.index')); ?>" class="param-btn-cancel">Annuler</a>
                </div>
            </form>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/parametres/securite.blade.php ENDPATH**/ ?>