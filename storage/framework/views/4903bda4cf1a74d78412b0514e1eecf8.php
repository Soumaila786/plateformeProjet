<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
<?php $__env->stopPush(); ?>

<div class="dash-stats-grid">
    <?php if (isset($component)) { $__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'En attente de validation','valeur' => $enAttente,'icon' => 'fa-hourglass-half','couleur' => 'var(--color-warning)','href' => ''.e(route('validateur.projets.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'En attente de validation','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($enAttente),'icon' => 'fa-hourglass-half','couleur' => 'var(--color-warning)','href' => ''.e(route('validateur.projets.index')).'']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'Soumis (global)','valeur' => $soumis,'icon' => 'fa-paper-plane','couleur' => 'var(--status-soumis)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Soumis (global)','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($soumis),'icon' => 'fa-paper-plane','couleur' => 'var(--status-soumis)']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'Rejetés','valeur' => $rejetes,'icon' => 'fa-xmark','couleur' => 'var(--status-rejete)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Rejetés','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rejetes),'icon' => 'fa-xmark','couleur' => 'var(--status-rejete)']); ?>
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

<div class="dash-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Projets à valider en priorité</h6>
        <a href="<?php echo e(route('validateur.projets.index')); ?>" class="small">Voir tout</a>
    </div>
    <?php echo $__env->make('dashboard.partials._projets_recents', ['projetsRecents' => $projetsUrgents, 'routeShow' => 'validateur.projets.show'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\dashboard\partials\_validateur.blade.php ENDPATH**/ ?>