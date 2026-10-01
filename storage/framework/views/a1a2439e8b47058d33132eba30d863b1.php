<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/analytique.css')); ?>">
<?php $__env->stopPush(); ?>

<div class="dash-stats-grid mb-3">
    <?php if (isset($component)) { $__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'Mes projets','valeur' => $total,'icon' => 'fa-folder-open']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Mes projets','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($total),'icon' => 'fa-folder-open']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5)): ?>
<?php $attributes = $__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5; ?>
<?php unset($__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5)): ?>
<?php $component = $__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5; ?>
<?php unset($__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'Validés','valeur' => $valides,'icon' => 'fa-check-double','couleur' => 'var(--status-valide)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Validés','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($valides),'icon' => 'fa-check-double','couleur' => 'var(--status-valide)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5)): ?>
<?php $attributes = $__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5; ?>
<?php unset($__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5)): ?>
<?php $component = $__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5; ?>
<?php unset($__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'En cours','valeur' => $enCours,'icon' => 'fa-spinner','couleur' => 'var(--status-en-examen)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'En cours','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($enCours),'icon' => 'fa-spinner','couleur' => 'var(--status-en-examen)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5)): ?>
<?php $attributes = $__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5; ?>
<?php unset($__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5)): ?>
<?php $component = $__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5; ?>
<?php unset($__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'Taux de validation','valeur' => $tauxValidation.'%','icon' => 'fa-chart-line','couleur' => 'var(--color-primary)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Taux de validation','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tauxValidation.'%'),'icon' => 'fa-chart-line','couleur' => 'var(--color-primary)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5)): ?>
<?php $attributes = $__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5; ?>
<?php unset($__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5)): ?>
<?php $component = $__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5; ?>
<?php unset($__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'Brouillons','valeur' => $brouillons,'icon' => 'fa-pen','couleur' => 'var(--status-brouillon)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Brouillons','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($brouillons),'icon' => 'fa-pen','couleur' => 'var(--status-brouillon)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5)): ?>
<?php $attributes = $__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5; ?>
<?php unset($__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5)): ?>
<?php $component = $__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5; ?>
<?php unset($__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5); ?>
<?php endif; ?>
</div>

<?php
    $dataStatuts = ['labels' => array_keys($statuts), 'values' => array_values($statuts), 'colors' => ['#9ca3af', '#6366f1', '#f97316', '#0d9488', '#ef4444']];
    $dataEvolution = ['labels' => $moisLabels, 'datasets' => [
        ['label' => 'Projets créés', 'data' => $moisCrees, 'borderColor' => '#6366f1', 'backgroundColor' => '#6366f1'],
        ['label' => 'Projets soumis', 'data' => $moisSoumis, 'borderColor' => '#0d9488', 'backgroundColor' => '#0d9488'],
    ]];
    $dataSecteurs = ['labels' => $secteursLabels, 'values' => $secteursValues, 'label' => 'Projets'];
    $dataBudgets = ['labels' => $devises, 'datasets' => [
        ['label' => 'Budget total', 'data' => $budgetValues, 'backgroundColor' => '#0d9488', 'borderColor' => '#0d9488'],
        ['label' => 'Montant demandé', 'data' => $demandeValues, 'backgroundColor' => '#6366f1', 'borderColor' => '#6366f1'],
    ]];
?>

<div class="an-grid">
    <div class="an-card"><h6><i class="fas fa-chart-pie me-1"></i>État de mes projets</h6><canvas id="anPorteurStatuts" data-chart="<?php echo e(json_encode($dataStatuts)); ?>"></canvas></div>
    <div class="an-card"><h6><i class="fas fa-building me-1"></i>Projets par secteur</h6><canvas id="anPorteurSecteurs" data-chart="<?php echo e(json_encode($dataSecteurs)); ?>"></canvas></div>
    <div class="an-card an-full"><h6><i class="fas fa-chart-line me-1"></i>Évolution de mon activité sur 12 mois</h6><canvas id="anPorteurEvolution" data-chart="<?php echo e(json_encode($dataEvolution)); ?>"></canvas></div>
    <div class="an-card an-full"><h6><i class="fas fa-coins me-1"></i>Budgets par devise</h6><canvas id="anPorteurBudgets" data-chart="<?php echo e(json_encode($dataBudgets)); ?>"></canvas></div>
</div>

<div class="an-grid">
    <div class="an-card">
        <h6><i class="fas fa-bullseye me-1"></i>Avancement</h6>
        <div class="d-flex justify-content-between py-1 small"><span class="text-muted">Projets validés</span><strong><?php echo e($valides); ?> / <?php echo e($total); ?></strong></div>
        <div class="progress mb-3" style="height:10px"><div class="progress-bar" style="width: <?php echo e($tauxValidation); ?>%; background:var(--color-primary)"></div></div>
        <div class="d-flex justify-content-between py-1 small"><span class="text-muted">Taux de rejet</span><strong class="text-danger"><?php echo e($tauxRejet); ?>%</strong></div>
    </div>
    <div class="an-card">
        <h6><i class="fas fa-clock me-1"></i>Projets récents</h6>
        <?php $__empty_1 = true; $__currentLoopData = $projetsRecents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="d-flex justify-content-between align-items-center py-2 small <?php echo e(!$loop->last ? 'border-bottom' : ''); ?>"><span class="text-truncate me-2"><?php echo e($projet->titre); ?></span><span class="badge bg-light text-dark"><?php echo e(str_replace('_', ' ', $projet->statutProjet)); ?></span></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-muted small mb-0">Aucun projet pour ces filtres.</p>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/charts-utils.js')); ?>"></script>
    <script src="<?php echo e(asset('js/analytique-porteur.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/analytique/partials/_porteur.blade.php ENDPATH**/ ?>