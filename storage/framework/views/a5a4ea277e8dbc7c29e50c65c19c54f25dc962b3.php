<?php $__env->startSection('title', 'Modifier le profil'); ?>
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
            <h1 class="param-subpage-title">Modifier le profil</h1>
            <p class="param-subpage-sub">Informations personnelles de votre compte</p>
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
            <i class="fas fa-user-circle"></i><span>Identité</span>
        </div>
        <div class="param-section-body">
            <div class="param-avatar-row">
                <div class="param-avatar"><?php echo e(strtoupper(substr(Auth::user()->nomComplet, 0, 2))); ?></div>
                <div>
                    <p class="param-avatar-name"><?php echo e(Auth::user()->nomComplet); ?></p>
                    <p class="param-avatar-role"><?php echo e(ucfirst(Auth::user()->role)); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="param-section-card">
        <div class="param-section-header">
            <i class="fas fa-edit"></i><span>Informations</span>
        </div>
        <div class="param-section-body">
            <form action="<?php echo e(route('parametres.profil.update')); ?>" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="param-form-grid">
                    <div class="param-field">
                        <label class="param-field-label">Nom complet <span class="required">*</span></label>
                        <input type="text" name="nomComplet"
                                class="param-field-input <?php $__errorArgs = ['nomComplet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('nomComplet', Auth::user()->nomComplet)); ?>" required>
                        <?php $__errorArgs = ['nomComplet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="param-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="param-field">
                        <label class="param-field-label">Email <span class="required">*</span></label>
                        <input type="email" name="email"
                                class="param-field-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('email', Auth::user()->email)); ?>" required>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="param-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="param-field">
                        <label class="param-field-label">Matricule</label>
                        <input type="text" name="matricule"
                                class="param-field-input <?php $__errorArgs = ['matricule'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('matricule', Auth::user()->matricule)); ?>">
                        <?php $__errorArgs = ['matricule'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="param-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="param-field">
                        <label class="param-field-label">Fonction</label>
                        <input type="text" name="fonction"
                                class="param-field-input <?php $__errorArgs = ['fonction'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('fonction', Auth::user()->fonction)); ?>">
                        <?php $__errorArgs = ['fonction'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="param-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="param-field">
                        <label class="param-field-label">Contact</label>
                        <input type="text" name="contact"
                                class="param-field-input <?php $__errorArgs = ['contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('contact', Auth::user()->contact)); ?>"
                                placeholder="+226 XX XX XX XX">
                        <?php $__errorArgs = ['contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="param-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <?php
    $user = Auth::user();
?>


<?php if($user->role == 'porteur'): ?>
    <div class="param-field">
        <label>Structure</label>
        <input type="text" name="structure"
            value="<?php echo e(old('structure', optional($user->porteur)->structure)); ?>">
    </div>

    <div class="param-field">
        <label>Spécialité</label>
        <input type="text" name="specialite"
            value="<?php echo e(old('specialite', optional($user->porteur)->specialite)); ?>">
    </div>
<?php endif; ?>


<?php if($user->role == 'approbateur'): ?>
    <div class="param-field">
        <label>Service</label>
        <input type="text" name="service"
            value="<?php echo e(old('service', optional($user->approbateur)->service)); ?>">
    </div>

    <div class="param-field">
        <label>Poste</label>
        <input type="text" name="poste"
            value="<?php echo e(old('poste', optional($user->approbateur)->poste)); ?>">
    </div>
<?php endif; ?>


<?php if($user->role == 'validateur'): ?>
    <div class="param-field">
        <label>Date début mandat</label>
        <input type="date" name="dateDebutMandat"
            value="<?php echo e(old('dateDebutMandat', optional($user->validateur)->dateDebutMandat)); ?>">
    </div>

    <div class="param-field">
        <label>Date fin mandat</label>
        <input type="date" name="dateFinMandat"
            value="<?php echo e(old('dateFinMandat', optional($user->validateur)->dateFinMandat)); ?>">
    </div>
<?php endif; ?>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/parametres/profil.blade.php ENDPATH**/ ?>