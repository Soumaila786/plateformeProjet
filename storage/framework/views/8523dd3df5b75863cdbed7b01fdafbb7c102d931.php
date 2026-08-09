<div id="modalProjetForm" class="lp-modal-overlay">
    <div class="lp-modal-box lp-modal-lg">
        <div class="lp-modal-head">
            <h3 class="lp-modal-title" data-modal-titre>Nouveau projet</h3>
            <button onclick="closeModal('modalProjetForm')"
                class="lp-modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>

        
        <form method="POST" action="<?php echo e(route('porteur.projets.store')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" value="" data-modal-method>

            <div class="lp-modal-body">
                <?php $projet = null; ?>
                <?php echo $__env->make('projets.partials._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="lp-modal-foot">
                <button type="button" onclick="closeModal('modalProjetForm')" class="btn btn-light btn-sm">Annuler</button>
                <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/modals/projet-form.blade.php ENDPATH**/ ?>