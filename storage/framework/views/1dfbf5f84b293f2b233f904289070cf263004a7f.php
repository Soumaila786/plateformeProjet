<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
<?php $__env->stopPush(); ?>

<div class="dash-stats-grid">
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'En attente de décision','valeur' => $enAttente,'icon' => 'fa-hourglass-half','couleur' => 'var(--color-warning)','href' => ''.e(route('approbateur.projets.index')).'']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'En attente de décision','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($enAttente),'icon' => 'fa-hourglass-half','couleur' => 'var(--color-warning)','href' => ''.e(route('approbateur.projets.index')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Soumis','valeur' => $soumis,'icon' => 'fa-paper-plane','couleur' => 'var(--status-soumis)']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Soumis','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($soumis),'icon' => 'fa-paper-plane','couleur' => 'var(--status-soumis)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'En examen','valeur' => $enExamen,'icon' => 'fa-magnifying-glass','couleur' => 'var(--status-en-examen)']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'En examen','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($enExamen),'icon' => 'fa-magnifying-glass','couleur' => 'var(--status-en-examen)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Approuvés','valeur' => $approuve,'icon' => 'fa-check','couleur' => 'var(--status-approuve)']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Approuvés','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($approuve),'icon' => 'fa-check','couleur' => 'var(--status-approuve)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Validés','valeur' => $valide,'icon' => 'fa-check-double','couleur' => 'var(--status-valide)']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Validés','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($valide),'icon' => 'fa-check-double','couleur' => 'var(--status-valide)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Rejetés','valeur' => $rejete,'icon' => 'fa-xmark','couleur' => 'var(--status-rejete)']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Rejetés','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rejete),'icon' => 'fa-xmark','couleur' => 'var(--status-rejete)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
</div>

<div class="dash-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Projets à traiter en priorité</h6>
        <a href="<?php echo e(route('approbateur.projets.index')); ?>" class="small">Voir tout</a>
    </div>
    <?php echo $__env->make('dashboard.partials._projets_recents', ['projetsRecents' => $projetsUrgents, 'routeShow' => 'approbateur.projets.show'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\dashboard\partials\_approbateur.blade.php ENDPATH**/ ?>