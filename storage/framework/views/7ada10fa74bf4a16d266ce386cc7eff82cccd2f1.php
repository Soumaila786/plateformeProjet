<div id="modalUserForm" class="lp-modal-overlay">
    <div class="lp-modal-box lp-modal-lg">
        <div class="lp-modal-head">
            <h3 class="lp-modal-title" data-modal-titre>Nouvel utilisateur</h3>
            <button onclick="closeModal('modalUserForm')" class="lp-modal-close"><i class="fas fa-times"></i></button>
        </div>

        
        <form method="POST" action="<?php echo e(route('admin.users.store')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" value="" data-modal-method>

            <div class="lp-modal-body">
                <?php echo $__env->make('users.partials._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="lp-modal-foot">
                <button type="button" onclick="closeModal('modalUserForm')" class="btn btn-light btn-sm">Annuler</button>
                <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/users-form.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\modals\user-form.blade.php ENDPATH**/ ?>