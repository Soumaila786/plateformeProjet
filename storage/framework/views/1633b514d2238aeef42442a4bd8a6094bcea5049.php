<?php $attributes = $attributes->exceptProps([
    'id',
    'titre',
    'action',
    'method'        => 'POST',
    'boutonLabel'   => 'Confirmer',
    'boutonVariant' => 'primary',
    'icon'          => null,
]); ?>
<?php foreach (array_filter(([
    'id',
    'titre',
    'action',
    'method'        => 'POST',
    'boutonLabel'   => 'Confirmer',
    'boutonVariant' => 'primary',
    'icon'          => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $iconesParVariant = [
        'success' => 'fa-check',
        'danger'  => 'fa-triangle-exclamation',
        'primary' => 'fa-circle-info',
    ];
    $icone = $icon ?? ($iconesParVariant[$boutonVariant] ?? 'fa-circle-info');
?>

<div class="modal fade" id="<?php echo e($id); ?>" tabindex="-1" aria-labelledby="<?php echo e($id); ?>-titre" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pf-modal-content">
            <form action="<?php echo e($action); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php if(strtoupper($method) !== 'POST'): ?>
                    <?php echo method_field($method); ?>
                <?php endif; ?>

                <div class="modal-header pf-modal-header">
                    <div class="pf-modal-icon pf-modal-icon-<?php echo e($boutonVariant); ?>">
                        <i class="fas <?php echo e($icone); ?>"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="modal-title pf-modal-title" id="<?php echo e($id); ?>-titre"><?php echo e($titre); ?></h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <div class="modal-body pf-modal-body">
                    <?php echo e($slot); ?>

                </div>

                <div class="modal-footer pf-modal-footer">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.button','data' => ['type' => 'button','variant' => 'ghost','dataBsDismiss' => 'modal']]); ?>
<?php $component->withName('buttons.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'button','variant' => 'ghost','data-bs-dismiss' => 'modal']); ?>
                        Annuler
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.button','data' => ['type' => 'submit','variant' => $boutonVariant]]); ?>
<?php $component->withName('buttons.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'submit','variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($boutonVariant)]); ?>
                        <?php echo e($boutonLabel); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\components\modals\confirm.blade.php ENDPATH**/ ?>