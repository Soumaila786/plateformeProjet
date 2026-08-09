<?php $attributes = $attributes->exceptProps(['titre' => null, 'icon' => null]); ?>
<?php foreach (array_filter((['titre' => null, 'icon' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div <?php echo e($attributes->merge(['class' => 'card border-0'])); ?> style="box-shadow: var(--shadow-md); border-radius: var(--radius-xl);">
    <div class="card-body">
        <?php if($titre): ?>
            <div class="d-flex align-items-center gap-2 pb-3 mb-3" style="border-bottom: 1px solid var(--color-border-light);">
                <?php if($icon): ?>
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:32px; height:32px; border-radius: var(--radius-md); background: var(--color-primary-light); color: var(--color-primary);">
                        <i class="fas <?php echo e($icon); ?>" aria-hidden="true"></i>
                    </div>
                <?php endif; ?>
                <h5 class="mb-0 fw-bold" style="color: var(--color-text); font-size: var(--font-lg);"><?php echo e($titre); ?></h5>
            </div>
        <?php endif; ?>

        <?php echo e($slot); ?>

    </div>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/components/cards/info.blade.php ENDPATH**/ ?>