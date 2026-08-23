<?php $attributes = $attributes->exceptProps(['statut']); ?>
<?php foreach (array_filter((['statut']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $config = [
        'brouillon' => ['label' => 'Brouillon',  'color' => 'var(--status-brouillon)'],
        'soumis'    => ['label' => 'Soumis',     'color' => 'var(--status-soumis)'],
        'en_examen' => ['label' => 'En examen',  'color' => 'var(--status-en-examen)'],
        'approuve'  => ['label' => 'Approuvé',   'color' => 'var(--status-approuve)'],
        'rejete'    => ['label' => 'Rejeté',     'color' => 'var(--status-rejete)'],
        'valide'    => ['label' => 'Validé',     'color' => 'var(--status-valide)'],
    ];
    $c = $config[$statut] ?? ['label' => ucfirst($statut ?? '—'), 'color' => '#6b7280'];
?>

<span <?php echo e($attributes->merge(['class' => 'badge rounded-pill'])); ?>

      style="background-color: color-mix(in srgb, <?php echo e($c['color']); ?> 16%, white); color: <?php echo e($c['color']); ?>; font-weight:600;">
    <?php echo e($c['label']); ?>

</span>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\components\badges\statut-projet.blade.php ENDPATH**/ ?>