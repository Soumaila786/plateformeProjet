<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'href',
    'variant' => 'outline',
    'size'    => null,
    'icon'    => null,
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
    'href',
    'variant' => 'outline',
    'size'    => null,
    'icon'    => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

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

<a href="<?php echo e($href); ?>" <?php echo e($attributes->merge(['class' => 'btn '.$classe.($size === 'sm' ? ' btn-sm' : '')])); ?>>
    <?php if($icon): ?>
        <i class="fas <?php echo e($icon); ?>" aria-hidden="true"></i>
    <?php endif; ?>
    <?php echo e($slot); ?>

</a>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/components/buttons/link.blade.php ENDPATH**/ ?>