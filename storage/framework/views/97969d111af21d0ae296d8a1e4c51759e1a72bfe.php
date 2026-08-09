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
    $etapes = [
        ['key' => 'soumis',    'label' => 'Soumis',    'color' => 'var(--status-soumis)'],
        ['key' => 'en_examen', 'label' => 'En examen', 'color' => 'var(--status-en-examen)'],
        ['key' => 'approuve',  'label' => 'Approuvé',  'color' => 'var(--status-approuve)'],
        ['key' => 'valide',    'label' => 'Validé',    'color' => 'var(--status-valide)'],
    ];
    $ordre = array_column($etapes, 'key');
    $positionActuelle = array_search($statut, $ordre);
    $estRejete = $statut === 'rejete';
?>

<div class="d-flex align-items-center py-2" role="img" aria-label="Progression du projet : <?php echo e($statut); ?>">
    <?php $__currentLoopData = $etapes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $etape): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $estFait   = !$estRejete && $positionActuelle !== false && $i < $positionActuelle;
            $estActuel = !$estRejete && $i === $positionActuelle;
            $couleur   = $estRejete ? 'var(--status-rejete)' : $etape['color'];
        ?>

        <div class="d-flex flex-column align-items-center">
            <div style="width:13px; height:13px; border-radius:50%; flex-shrink:0;
                        border:2px solid <?php echo e(($estFait || $estActuel) ? $couleur : '#dee2e6'); ?>;
                        background: <?php echo e($estFait ? $couleur : '#fff'); ?>;
                        <?php echo e($estActuel ? 'box-shadow:0 0 0 3px color-mix(in srgb, '.$couleur.' 25%, transparent);' : ''); ?>">
            </div>
            <span class="text-muted mt-1" style="font-size:.72rem; width:90px; text-align:center;"><?php echo e($etape['label']); ?></span>
        </div>

        <?php if(!$loop->last): ?>
            <div style="flex:1; height:2px; margin:0 .3rem;
                        background: <?php echo e($estFait ? $etape['color'] : '#dee2e6'); ?>;"></div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if($estRejete): ?>
        <div class="ms-3 d-flex align-items-center gap-1 fw-bold" style="color:var(--status-rejete); font-size:.8rem;">
            <i class="fas fa-circle-xmark"></i> Rejeté
        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/components/circuit/stepper.blade.php ENDPATH**/ ?>