
<?php $u = auth()->user(); ?>
<?php if (isset($component)) { $__componentOriginal10bc9ab4bc16e5be58d7bd824e42dc1a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal10bc9ab4bc16e5be58d7bd824e42dc1a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.info','data' => ['titre' => 'Préférences de notification','icon' => 'fa-bell']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
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
<?php if (isset($__attributesOriginal10bc9ab4bc16e5be58d7bd824e42dc1a)): ?>
<?php $attributes = $__attributesOriginal10bc9ab4bc16e5be58d7bd824e42dc1a; ?>
<?php unset($__attributesOriginal10bc9ab4bc16e5be58d7bd824e42dc1a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal10bc9ab4bc16e5be58d7bd824e42dc1a)): ?>
<?php $component = $__componentOriginal10bc9ab4bc16e5be58d7bd824e42dc1a; ?>
<?php unset($__componentOriginal10bc9ab4bc16e5be58d7bd824e42dc1a); ?>
<?php endif; ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\parametres\partials\_notifications.blade.php ENDPATH**/ ?>