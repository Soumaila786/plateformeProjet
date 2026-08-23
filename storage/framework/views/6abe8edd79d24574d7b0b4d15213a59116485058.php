<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/analytique.css')); ?>">
<?php $__env->stopPush(); ?>

<?php
    $dataEntonnoir = [
        'labels' => ['Soumis', 'Approuvés', 'Validés', 'Rejetés'],
        'values' => [$entonnoir['soumis'], $entonnoir['approuve'], $entonnoir['valide'], $entonnoir['rejete']],
        'colors' => ['#6366f1', '#22c55e', '#0d9488', '#ef4444'],
        'label' => 'Projets',
    ];
    $dataStatuts = ['labels' => $donutLabels, 'values' => $donutValues];
    $dataEvolution = [
        'labels' => $evolution['labels'],
        'datasets' => [['label' => 'Cumul FCFA', 'data' => $evolution['values'], 'borderColor' => '#6366f1', 'backgroundColor' => '#6366f1']],
    ];
    $dataDelais = ['labels' => $delais['labels'], 'values' => $delais['values'], 'label' => 'Jours'];
    $dataSecteurs = ['labels' => $heatSecteurs, 'values' => $heatData, 'label' => 'Projets'];
?>

<div class="dash-stats-grid mb-3">
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Aujourd\'hui','valeur' => $perf['aujourd_hui'],'icon' => 'fa-calendar-day']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Aujourd\'hui','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perf['aujourd_hui']),'icon' => 'fa-calendar-day']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Cette semaine','valeur' => $perf['semaine'],'icon' => 'fa-calendar-week']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Cette semaine','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perf['semaine']),'icon' => 'fa-calendar-week']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Total traités','valeur' => $perf['total_traites'],'icon' => 'fa-check-double','couleur' => 'var(--status-valide)']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Total traités','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perf['total_traites']),'icon' => 'fa-check-double','couleur' => 'var(--status-valide)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Taux de validation','valeur' => $perf['taux_validation'].'%','icon' => 'fa-percent']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Taux de validation','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perf['taux_validation'].'%'),'icon' => 'fa-percent']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'En attente','valeur' => $perf['en_attente'],'icon' => 'fa-hourglass-half','couleur' => 'var(--color-warning)']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'En attente','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($perf['en_attente']),'icon' => 'fa-hourglass-half','couleur' => 'var(--color-warning)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
</div>

<div class="an-grid">
    <div class="an-card">
        <h6><i class="fas fa-filter me-1"></i>Entonnoir</h6>
        <canvas id="anValidEntonnoir" data-chart="<?php echo e(json_encode($dataEntonnoir)); ?>"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-chart-pie me-1"></i>Répartition par statut</h6>
        <canvas id="anValidStatuts" data-chart="<?php echo e(json_encode($dataStatuts)); ?>"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-gauge-high me-1"></i>Taux d'utilisation du budget</h6>
        <div class="progress mb-2" style="height:10px;">
            <div class="progress-bar" role="progressbar" style="width: <?php echo e($pctJauge); ?>%; background: var(--color-primary);"></div>
        </div>
        <div class="d-flex justify-content-between small text-muted">
            <span><?php echo e(number_format($totalDemande, 0, ',', ' ')); ?> FCFA demandés</span>
            <span><?php echo e(number_format($totalBudget, 0, ',', ' ')); ?> FCFA disponibles</span>
        </div>
        <?php if($retard > 0): ?>
            <div class="mt-2 small text-danger"><i class="fas fa-triangle-exclamation"></i> <?php echo e($retard); ?> projet(s) en attente depuis plus de 30 jours</div>
        <?php endif; ?>
    </div>

    <div class="an-card an-full">
        <h6><i class="fas fa-chart-line me-1"></i>Cumul des montants demandés (12 mois)</h6>
        <canvas id="anValidEvolution" data-chart="<?php echo e(json_encode($dataEvolution)); ?>"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-stopwatch me-1"></i>Délais de traitement (jours)</h6>
        <canvas id="anValidDelais" data-chart="<?php echo e(json_encode($dataDelais)); ?>"></canvas>
    </div>

    <div class="an-card">
        <h6><i class="fas fa-building me-1"></i>Volume de projets par secteur</h6>
        <canvas id="anValidSecteurs" data-chart="<?php echo e(json_encode($dataSecteurs)); ?>"></canvas>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/charts-utils.js')); ?>"></script>
    <script src="<?php echo e(asset('js/analytique-validateur.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\analytique\partials\_validateur.blade.php ENDPATH**/ ?>