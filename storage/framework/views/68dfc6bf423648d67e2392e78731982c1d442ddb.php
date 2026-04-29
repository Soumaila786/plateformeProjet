<?php $__env->startSection('title', 'Modifier le secteur'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="projets-page">
    <div class="page-header">
        <a href="<?php echo e(route('admin.secteurs.index')); ?>" class="btn-back"><i class="fas fa-arrow-left"></i></a>
        <div>
            <h1 class="projets-title">Modifier le secteur</h1>
            <p class="projets-subtitle"><?php echo e($secteur->nomSecteur); ?></p>
        </div>
    </div>
    <form action="<?php echo e(route('admin.secteurs.update', $secteur)); ?>" method="POST" class="projet-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="form-card">
            <div class="form-card-header"><i class="fas fa-tags"></i><span>Informations</span></div>
            <div class="form-card-body">
                <div class="form-row">
                    <div class="form-col form-col-full">
                        <label class="field-label">Nom du secteur <span class="required">*</span></label>
                        <input type="text" name="nomSecteur"
                                value="<?php echo e(old('nomSecteur', $secteur->nomSecteur)); ?>"
                                class="field-input <?php $__errorArgs = ['nomSecteur'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <?php $__errorArgs = ['nomSecteur'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-col form-col-full">
                        <label class="field-label">Description</label>
                        <textarea name="description" rows="3"
                                    class="field-input field-textarea <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description', $secteur->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-col">
                        <label class="field-label">Statut</label>
                        <label class="toggle-switch">
                            <input type="checkbox" name="statutSecteur"
                                    <?php echo e(old('statut', $secteur->statutSecteur) ? 'checked' : ''); ?>>
                            <span class="toggle-slider"></span>
                            <span class="toggle-label">Actif</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <a href="<?php echo e(route('admin.secteurs.index')); ?>" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-save"><i class="fas fa-save"></i> Mettre à jour</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/admin/secteurs/edit.blade.php ENDPATH**/ ?>