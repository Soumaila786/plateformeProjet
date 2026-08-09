<?php $__env->startSection('title', 'Journal des activités'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('admin.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <span>Journal des activités</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Journal des activités</h1>
            <p class="page-header-sub"><?php echo e(count($logs)); ?> entrée<?php echo e(count($logs) > 1 ? 's' : ''); ?> (200 dernières lignes max)</p>
        </div>
    </div>

    <div class="lp-filtres">
        <div class="lp-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Rechercher dans les logs..." value="<?php echo e(request('search')); ?>"
                   data-filter-search="search">
        </div>

        <select class="lp-select" name="type" data-filter-select>
            <option value="">Tous les niveaux</option>
            <option value="error" <?php echo e(request('type') === 'error' ? 'selected' : ''); ?>>Erreur</option>
            <option value="warning" <?php echo e(request('type') === 'warning' ? 'selected' : ''); ?>>Avertissement</option>
            <option value="info" <?php echo e(request('type') === 'info' ? 'selected' : ''); ?>>Info</option>
            <option value="debug" <?php echo e(request('type') === 'debug' ? 'selected' : ''); ?>>Debug</option>
        </select>

        <?php if(request('search') || request('type')): ?>
            <a href="<?php echo e(request()->url()); ?>" class="lp-reset-btn"><i class="fas fa-times"></i> Réinitialiser</a>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/listes-projets.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/logs.css')); ?>">
    <?php $__env->stopPush(); ?>

    

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.info','data' => []]); ?>
<?php $component->withName('cards.info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entree): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $niveau = is_array($entree) ? ($entree['niveau'] ?? $entree['level'] ?? 'info') : ($entree->niveau ?? $entree->level ?? 'info');
                $message = is_array($entree) ? ($entree['message'] ?? '') : ($entree->message ?? (string) $entree);
                $date = is_array($entree) ? ($entree['date'] ?? null) : ($entree->date ?? null);
                $niveauLower = strtolower($niveau);

                if (strpos($niveauLower, 'error') !== false) {
                    $classeNiveau = 'log-level-error';
                } elseif (strpos($niveauLower, 'warning') !== false) {
                    $classeNiveau = 'log-level-warning';
                } elseif (strpos($niveauLower, 'debug') !== false) {
                    $classeNiveau = 'log-level-debug';
                } else {
                    $classeNiveau = 'log-level-info';
                }
            ?>
            <div class="log-entry">
                <span class="log-level <?php echo e($classeNiveau); ?>"><?php echo e(strtoupper($niveau)); ?></span>
                <span class="log-message"><?php echo e($message); ?></span>
                <?php if($date): ?>
                    <span class="log-date"><?php echo e($date); ?></span>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-muted small text-center py-4 mb-0">Aucune entrée de log trouvée.</p>
        <?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <?php $__env->startPush('scripts'); ?>
        <script src="<?php echo e(asset('js/filtres-liste.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/logs/index.blade.php ENDPATH**/ ?>