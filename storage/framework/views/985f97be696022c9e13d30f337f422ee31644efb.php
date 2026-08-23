<?php $attributes = $attributes->exceptProps([
    'user' => null,       // instance User ; par défaut auth()->user()
    'size' => 38,          // taille en pixels
    'nom' => null,         // permet de forcer un nom sans instance User (ex: aperçu)
    'photo' => null,       // permet de forcer une URL de photo
]); ?>
<?php foreach (array_filter(([
    'user' => null,       // instance User ; par défaut auth()->user()
    'size' => 38,          // taille en pixels
    'nom' => null,         // permet de forcer un nom sans instance User (ex: aperçu)
    'photo' => null,       // permet de forcer une URL de photo
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $u = $user ?? auth()->user();
    $nomComplet = $nom ?? ($u->nomComplet ?? '?');
    $cheminPhoto = $photo ?? ($u->photo ?? null);
    $initiales = collect(explode(' ', trim($nomComplet)))
        ->map(fn ($m) => mb_strtoupper(mb_substr($m, 0, 1)))
        ->take(2)
        ->implode('');
?>

<?php if($cheminPhoto): ?>
    <img src="<?php echo e(asset('storage/'.$cheminPhoto)); ?>" alt="<?php echo e($nomComplet); ?>"
         <?php echo e($attributes->merge(['class' => 'rounded-circle'])); ?>

         style="width:<?php echo e($size); ?>px; height:<?php echo e($size); ?>px; object-fit:cover; flex-shrink:0;">
<?php else: ?>
    <div <?php echo e($attributes->merge(['class' => 'rounded-circle d-flex align-items-center justify-content-center fw-bold text-white'])); ?>

         style="width:<?php echo e($size); ?>px; height:<?php echo e($size); ?>px; background:var(--color-primary); font-size:<?php echo e(round($size * 0.4)); ?>px; flex-shrink:0;">
        <?php echo e($initiales ?: '?'); ?>

    </div>
<?php endif; ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\components\avatars\avatar.blade.php ENDPATH**/ ?>