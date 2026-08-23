<?php $attributes = $attributes->exceptProps(['contexte' => 'accueil']); ?>
<?php foreach (array_filter((['contexte' => 'accueil']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $getConf = fn ($cle, $defaut = null) => isset($sysConfig) ? ($sysConfig->get($cle, $defaut) ?? $defaut) : $defaut;
?>

<header class="ac-header">
    <div class="ac-header-inner">
        
        <a href="<?php echo e(route('accueil')); ?>" class="d-inline-flex align-items-center gap-2 text-decoration-none">
            <img src="<?php echo e(asset('images/logo-cifeu.jpg')); ?>" alt="CIFEU" style="height:38px; width:auto;">
            <span class="fw-bold" style="font-size:1.05rem; color: var(--color-text);">
                <?php echo e($getConf('nom_app', config('app.name'))); ?>

            </span>
        </a>

        <nav class="ac-nav">
            <?php if($contexte === 'accueil'): ?>
                <a href="#apropos">À propos</a>
                <a href="#domaines">Domaines</a>
                <a href="#contact">Contact</a>
                <a href="<?php echo e(route('login')); ?>" class="ac-btn-login">Connexion</a>
            <?php else: ?>
                <a href="<?php echo e(route('accueil')); ?>#apropos">À propos</a>
                <a href="<?php echo e(route('accueil')); ?>#domaines">Domaines</a>
                <a href="<?php echo e(route('accueil')); ?>#contact">Contact</a>
                <a href="<?php echo e(route('accueil')); ?>" class="ac-btn-login">
                    <i class="fas fa-arrow-left"></i> Accueil
                </a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\components\site-header.blade.php ENDPATH**/ ?>