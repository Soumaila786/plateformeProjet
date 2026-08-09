
<?php $u = auth()->user(); ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.info','data' => ['titre' => 'Préférences de notification','icon' => 'fa-bell']]); ?>
<?php $component->withName('cards.info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['titre' => 'Préférences de notification','icon' => 'fa-bell']); ?>
    <form action="<?php echo e(route('parametres.notifications.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="notif_email_actif" id="notifEmail"
                   value="1" <?php echo e(old('notif_email_actif', $u->notif_email_actif ?? true) ? 'checked' : ''); ?>>
            <label class="form-check-label small" for="notifEmail">
                Recevoir les notifications importantes par email (soumission, approbation, rejet...)
            </label>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check me-1"></i>Enregistrer</button>
        </div>
    </form>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/parametres/partials/_notifications.blade.php ENDPATH**/ ?>