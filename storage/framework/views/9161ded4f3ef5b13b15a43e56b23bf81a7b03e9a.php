<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/analytique.css')); ?>">
<?php $__env->stopPush(); ?>

<?php
    $dataEntonnoir = [
        'labels' => array_column($entonnoir, 'lbl'),
        'values' => array_column($entonnoir, 'val'),
        'colors' => array_column($entonnoir, 'color'),
        'label' => 'Projets',
    ];
    $dataEvolution = [
        'labels' => $moisLabels,
        'datasets' => [
            ['label' => 'Soumis', 'data' => $moisSoumis, 'borderColor' => '#6366f1', 'backgroundColor' => '#6366f1'],
            ['label' => 'Validés', 'data' => $moisValides, 'borderColor' => '#0d9488', 'backgroundColor' => '#0d9488'],
        ],
    ];
    $dataStatuts = ['labels' => $statutLabels, 'values' => $statutValues, 'colors' => $statutColors];
    $dataSecteurs = ['labels' => $sectLabels, 'values' => $sectNb, 'label' => 'Projets'];
    $dataMotifs = [
        'labels' => $motifsLabels,
        'values' => $motifsValues,
        'colors' => ['#ef4444', '#f97316', '#eab308', '#6366f1', '#9ca3af', '#0d9488'],
    ];
    $dataEquipes = ['labels' => $equipeLabels, 'values' => $equipeNb, 'label' => 'Dossiers traités'];
?>

<div class="dash-stats-grid mb-3">
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Total projets','valeur' => $kpis['total'],'icon' => 'fa-folder']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Total projets','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpis['total']),'icon' => 'fa-folder']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Soumis','valeur' => $kpis['soumis'],'icon' => 'fa-paper-plane','couleur' => 'var(--status-soumis)']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Soumis','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpis['soumis']),'icon' => 'fa-paper-plane','couleur' => 'var(--status-soumis)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'En examen','valeur' => $kpis['en_examen'],'icon' => 'fa-magnifying-glass','couleur' => 'var(--status-en-examen)']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'En examen','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpis['en_examen']),'icon' => 'fa-magnifying-glass','couleur' => 'var(--status-en-examen)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Approuvés','valeur' => $kpis['approuve'],'icon' => 'fa-check','couleur' => 'var(--status-approuve)']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Approuvés','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpis['approuve']),'icon' => 'fa-check','couleur' => 'var(--status-approuve)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Validés','valeur' => $kpis['valide'],'icon' => 'fa-check-double','couleur' => 'var(--status-valide)']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Validés','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpis['valide']),'icon' => 'fa-check-double','couleur' => 'var(--status-valide)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Rejetés','valeur' => $kpis['rejete'],'icon' => 'fa-xmark','couleur' => 'var(--status-rejete)']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Rejetés','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kpis['rejete']),'icon' => 'fa-xmark','couleur' => 'var(--status-rejete)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
</div>

<div class="an-grid">
    <div class="an-card an-full">
        <h6><i class="fas fa-filter me-1"></i>Entonnoir du circuit</h6>
        <canvas id="anAdminEntonnoir" data-chart="<?php echo e(json_encode($dataEntonnoir)); ?>"></canvas>
    </div>

    <div class="an-card an-full">
        <h6><i class="fas fa-chart-line me-1"></i>Évolution sur 12 mois (soumis vs validés)</h6>
        <canvas id="anAdminEvolution" data-chart="<?php echo e(json_encode($dataEvolution)); ?>"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-chart-pie me-1"></i>Répartition par statut</h6>
        <canvas id="anAdminStatuts" data-chart="<?php echo e(json_encode($dataStatuts)); ?>"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-building me-1"></i>Top secteurs (par nombre de projets)</h6>
        <canvas id="anAdminSecteurs" data-chart="<?php echo e(json_encode($dataSecteurs)); ?>"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-comment-slash me-1"></i>Analyse des motifs de rejet</h6>
        <canvas id="anAdminMotifs" data-chart="<?php echo e(json_encode($dataMotifs)); ?>"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-users-gear me-1"></i>Charge de travail des équipes</h6>
        <canvas id="anAdminEquipes" data-chart="<?php echo e(json_encode($dataEquipes)); ?>"></canvas>
    </div>
</div>

<div class="an-grid">
    <div class="an-card">
        <h6><i class="fas fa-stopwatch me-1"></i>Délais moyens de traitement (jours)</h6>
        <div class="d-flex justify-content-between py-1 small"><span class="text-muted">Soumission → Approbation</span><strong><?php echo e($delaiAppro); ?> j</strong></div>
        <div class="d-flex justify-content-between py-1 small"><span class="text-muted">Approbation → Validation</span><strong><?php echo e($delaiValid); ?> j</strong></div>
        <div class="d-flex justify-content-between py-1 small"><span class="text-muted">Total du processus</span><strong><?php echo e($delaiTotal); ?> j</strong></div>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-triangle-exclamation me-1"></i>Projets bloqués (&gt; 10 jours)</h6>
        <?php $__empty_1 = true; $__currentLoopData = $projetsBloque; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="d-flex justify-content-between align-items-center py-2 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?> small">
                <div>
                    <div class="fw-semibold"><?php echo e($p['titre']); ?></div>
                    <div class="text-muted" style="font-size:.72rem;"><?php echo e($p['porteur']); ?> · <?php echo e($p['secteur']); ?></div>
                </div>
                <span class="badge bg-warning-subtle text-warning"><?php echo e($p['jours']); ?> j</span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-muted small mb-0 py-2 text-center">Aucun projet bloqué actuellement.</p>
        <?php endif; ?>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-ranking-star me-1"></i>Performance des porteurs</h6>
        <?php $__empty_1 = true; $__currentLoopData = $porteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="d-flex justify-content-between align-items-center py-2 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?> small">
                <span><?php echo e($p['nom']); ?></span>
                <span class="text-muted"><?php echo e($p['total']); ?> projet(s) · <strong><?php echo e($p['taux']); ?>%</strong> réussite</span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-muted small mb-0 py-2 text-center">Pas encore de données.</p>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/charts-utils.js')); ?>"></script>
    <script src="<?php echo e(asset('js/analytique-admin.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/analytique/partials/_admin.blade.php ENDPATH**/ ?>