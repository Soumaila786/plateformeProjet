<?php $attributes = $attributes->exceptProps([
    'href',
    'variant' => 'outline',
    'size'    => null,
    'icon'    => null,
]); ?>
<?php foreach (array_filter(([
    'href',
    'variant' => 'outline',
    'size'    => null,
    'icon'    => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $classesParVariant = [
        'primary' => 'btn-primary',
        'outline' => 'btn-outline-secondary',
        'danger'  => 'btn-danger',
        'success' => 'btn-success',
        'ghost'   => 'btn-link text-decoration-none',
    ];
    $classe = $classesParVariant[$variant] ?? 'btn-outline-secondary';
?>

<a
    href="<?php echo e($href); ?>"
    <?php echo e($attributes->merge(['class' => 'btn '.$classe.($size === 'sm' ? ' btn-sm' : '')])); ?>

>
    <?php if($icon): ?>
        <i class="fas <?php echo e($icon); ?>" aria-hidden="true"></i>
    <?php endif; ?>
    <?php echo e($slot); ?>

</a>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/components/buttons/link.blade.php ENDPATH**/ ?>