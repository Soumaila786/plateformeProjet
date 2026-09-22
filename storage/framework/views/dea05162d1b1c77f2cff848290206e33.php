<div id="modalSousDomaineForm" class="lp-modal-overlay">
    <div class="lp-modal-box">
        <div class="lp-modal-head">
            <h3 class="lp-modal-title" data-modal-titre>Modifier le sous-domaine</h3>
            <button type="button" onclick="closeModal('modalSousDomaineForm')" class="lp-modal-close"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="lp-modal-body">
                <div class="mb-3"><label class="form-label">Secteur parent</label><select name="secteur_id" class="form-select" required><?php $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($secteur->id); ?>"><?php echo e($secteur->nomSecteur); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
                <div class="mb-3"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" required maxlength="255"></div>
                <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3" maxlength="1000"></textarea></div>
            </div>
            <div class="lp-modal-foot"><button type="button" onclick="closeModal('modalSousDomaineForm')" class="btn btn-light btn-sm">Annuler</button><button type="submit" class="btn btn-primary btn-sm">Enregistrer</button></div>
        </form>
    </div>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\modals\sous-domaine-form.blade.php ENDPATH**/ ?>