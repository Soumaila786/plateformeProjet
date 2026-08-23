<?php $attributes = $attributes->exceptProps(['label', 'valeur', 'icon' => null, 'couleur' => 'var(--color-primary)', 'href' => null]); ?>
<?php foreach (array_filter((['label', 'valeur', 'icon' => null, 'couleur' => 'var(--color-primary)', 'href' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $tag = $href ? 'a' : 'div';
?>

<<?php echo e($tag); ?> <?php if($href): ?> href="<?php echo e($href); ?>" <?php endif; ?>
    <?php echo e($attributes->merge(['class' => 'card border-0 text-decoration-none text-reset'])); ?>

    style="box-shadow: var(--shadow-md); border-radius: var(--radius-xl);">
    <div class="card-body d-flex align-items-center gap-3">
        <?php if($icon): ?>
            <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                 style="width:44px; height:44px; border-radius: var(--radius-md); background: color-mix(in srgb, <?php echo e($couleur); ?> 15%, white); color:<?php echo e($couleur); ?>;">
                <i class="fas <?php echo e($icon); ?>" aria-hidden="true"></i>
            </div>
        <?php endif; ?>

        <div>
            <div class="fw-bold" style="font-size: var(--font-xl); line-height:1; color: var(--color-text);"><?php echo e($valeur); ?></div>
            <div class="text-muted small mt-1"><?php echo e($label); ?></div>
        </div>
    </div>
</<?php echo e($tag); ?>>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\components\cards\stat.blade.php ENDPATH**/ ?>