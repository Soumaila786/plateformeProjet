<?php $attributes = $attributes->exceptProps([
    'size' => 48,          // taille en pixels (carré)
    'showText' => false,   // afficher le nom de l'appli à côté
    'textSize' => 'md',    // 'md' ou 'lg'
]); ?>
<?php foreach (array_filter(([
    'size' => 48,          // taille en pixels (carré)
    'showText' => false,   // afficher le nom de l'appli à côté
    'textSize' => 'md',    // 'md' ou 'lg'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $logoImage = isset($sysConfig) ? $sysConfig->get('logo_image') : null;
    $logoTexte = isset($sysConfig) ? $sysConfig->get('logo_texte', 'GP') : 'GP';
    $nomApp = isset($sysConfig) ? $sysConfig->get('nom_app', config('app.name')) : config('app.name');
    $couleur = isset($sysConfig) ? $sysConfig->get('couleur_primaire', '#3b82f6') : '#3b82f6';
?>


<div class="d-inline-flex align-items-center gap-2 mb-2">
    <?php if($logoImage): ?>
        <img src="<?php echo e(asset('storage/'.$logoImage)); ?>" alt="<?php echo e($nomApp); ?>"
             style="width:<?php echo e($size); ?>px; height:<?php echo e($size); ?>px; object-fit:contain; border-radius:12px; flex-shrink:0;">
    <?php else: ?>
        <div class="d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
             style="width:<?php echo e($size); ?>px; height:<?php echo e($size); ?>px; border-radius:12px; background:<?php echo e($couleur); ?>; font-size:<?php echo e(round($size * 0.38)); ?>px;">
            <?php echo e($logoTexte); ?>

        </div>
    <?php endif; ?>

    <?php if($showText): ?>
        <span class="fw-bold" style="font-size: <?php echo e($textSize === 'lg' ? '1.4rem' : '1.05rem'); ?>; color: var(--color-text, #111827);">
            <?php echo e($nomApp); ?>

        </span>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\components\brand\logo.blade.php ENDPATH**/ ?>