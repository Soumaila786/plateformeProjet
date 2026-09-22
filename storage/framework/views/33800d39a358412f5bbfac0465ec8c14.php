<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id',
    'titre',
    'action',
    'method'        => 'POST',
    'boutonLabel'   => 'Confirmer',
    'boutonVariant' => 'primary',
    'icon'          => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'id',
    'titre',
    'action',
    'method'        => 'POST',
    'boutonLabel'   => 'Confirmer',
    'boutonVariant' => 'primary',
    'icon'          => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

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
                    <?php if (isset($component)) { $__componentOriginal33e4f43b1fe2812447ac9bb0c2eb15df = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal33e4f43b1fe2812447ac9bb0c2eb15df = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons.button','data' => ['type' => 'button','variant' => 'ghost','dataBsDismiss' => 'modal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','variant' => 'ghost','data-bs-dismiss' => 'modal']); ?>
                        Annuler
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal33e4f43b1fe2812447ac9bb0c2eb15df)): ?>
<?php $attributes = $__attributesOriginal33e4f43b1fe2812447ac9bb0c2eb15df; ?>
<?php unset($__attributesOriginal33e4f43b1fe2812447ac9bb0c2eb15df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal33e4f43b1fe2812447ac9bb0c2eb15df)): ?>
<?php $component = $__componentOriginal33e4f43b1fe2812447ac9bb0c2eb15df; ?>
<?php unset($__componentOriginal33e4f43b1fe2812447ac9bb0c2eb15df); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal33e4f43b1fe2812447ac9bb0c2eb15df = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal33e4f43b1fe2812447ac9bb0c2eb15df = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons.button','data' => ['type' => 'submit','variant' => $boutonVariant]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($boutonVariant)]); ?>
                        <?php echo e($boutonLabel); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal33e4f43b1fe2812447ac9bb0c2eb15df)): ?>
<?php $attributes = $__attributesOriginal33e4f43b1fe2812447ac9bb0c2eb15df; ?>
<?php unset($__attributesOriginal33e4f43b1fe2812447ac9bb0c2eb15df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal33e4f43b1fe2812447ac9bb0c2eb15df)): ?>
<?php $component = $__componentOriginal33e4f43b1fe2812447ac9bb0c2eb15df; ?>
<?php unset($__componentOriginal33e4f43b1fe2812447ac9bb0c2eb15df); ?>
<?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\components\modals\confirm.blade.php ENDPATH**/ ?>