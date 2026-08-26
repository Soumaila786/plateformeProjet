<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
<?php $__env->stopPush(); ?>

<div class="dash-stats-grid">
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Demandes en attente','valeur' => $demandesEnAttente,'icon' => 'fa-inbox','couleur' => 'var(--color-warning)','href' => ''.e(route('planificateur.projets.index')).'']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Demandes en attente','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($demandesEnAttente),'icon' => 'fa-inbox','couleur' => 'var(--color-warning)','href' => ''.e(route('planificateur.projets.index')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Projets traités','valeur' => $projetsTraites,'icon' => 'fa-check','couleur' => 'var(--status-approuve)','href' => ''.e(route('planificateur.projets.traites')).'']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Projets traités','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($projetsTraites),'icon' => 'fa-check','couleur' => 'var(--status-approuve)','href' => ''.e(route('planificateur.projets.traites')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Activités ce mois','valeur' => $activitesCeMois,'icon' => 'fa-calendar-check']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Activités ce mois','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activitesCeMois),'icon' => 'fa-calendar-check']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Coût total planifié','valeur' => number_format($coutTotalPlanifie, 0, ',', ' ').' FCFA','icon' => 'fa-coins','couleur' => 'var(--color-info)']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Coût total planifié','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($coutTotalPlanifie, 0, ',', ' ').' FCFA'),'icon' => 'fa-coins','couleur' => 'var(--color-info)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="dash-card">
            <h6 class="fw-bold mb-3">Dernières demandes de planification</h6>
            <?php echo $__env->make('dashboard.partials._projets_recents', ['projetsRecents' => $dernieresDemandes, 'routeShow' => 'planificateur.projets.show'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="dash-card">
            <h6 class="fw-bold mb-3">Projets récemment planifiés</h6>
            <?php echo $__env->make('dashboard.partials._projets_recents', ['projetsRecents' => $projetsRecentsTraites, 'routeShow' => 'planificateur.projets.show'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/dashboard/partials/_planificateur.blade.php ENDPATH**/ ?>