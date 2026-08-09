<div id="modalSecteurForm" class="lp-modal-overlay">
    <div class="lp-modal-box">
        <div class="lp-modal-head">
            <h3 class="lp-modal-title" data-modal-titre>Nouveau secteur</h3>
            <button onclick="closeModal('modalSecteurForm')" class="lp-modal-close"><i class="fas fa-times"></i></button>
        </div>

        <form method="POST" action="<?php echo e(route('admin.secteurs.store')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" value="" data-modal-method>

            <div class="lp-modal-body">
                <div class="mb-3">
                    <label class="form-label small">Nom du secteur</label>
                    <input type="text" name="nomSecteur" class="form-control <?php $__errorArgs = ['nomSecteur'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required maxlength="255">
                    <?php $__errorArgs = ['nomSecteur'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="mb-3">
                    <label class="form-label small">Description</label>
                    <textarea name="description" rows="3" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" maxlength="500"></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="statutSecteur" value="1" class="form-check-input" id="secteurStatutActif" checked>
                    <label class="form-check-label small" for="secteurStatutActif">Secteur actif</label>
                </div>
            </div>

            <div class="lp-modal-foot">
                <button type="button" onclick="closeModal('modalSecteurForm')" class="btn btn-light btn-sm">Annuler</button>
                <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/modals/secteur-form.blade.php ENDPATH**/ ?>