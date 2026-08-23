<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
<?php $__env->stopPush(); ?>

<div class="dash-stats-grid">
    
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.stat','data' => ['label' => 'Brouillons','valeur' => $brouillon,'icon' => 'fa-pen','couleur' => 'var(--status-brouillon)']]); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Brouillons','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($brouillon),'icon' => 'fa-pen','couleur' => 'var(--status-brouillon)']); ?>
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

<div class="row g-3">
    <div class="col-lg-7">
        <div class="dash-card">
            <h6 class="fw-bold mb-3">Mes projets récents</h6>
            <?php echo $__env->make('dashboard.partials._projets_recents', ['projetsRecents' => $projetsRecents, 'routeShow' => 'porteur.projets.show'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="dash-card mb-3">
            <h6 class="fw-bold mb-3">Finances</h6>
            <div class="d-flex justify-content-between py-1 small">
                <span class="text-muted">Budget total demandé</span>
                <strong class="font-monospace"><?php echo e(number_format($budgetTotal, 0, ',', ' ')); ?> FCFA</strong>
            </div>
            <div class="d-flex justify-content-between py-1 small">
                <span class="text-muted">Montant demandé</span>
                <strong class="font-monospace"><?php echo e(number_format($montantDemande, 0, ',', ' ')); ?> FCFA</strong>
            </div>
        </div>
        <div class="dash-card">
            <h6 class="fw-bold mb-3">Notifications récentes</h6>
            <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="py-2 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?> small"><?php echo e($notif->message); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-muted small mb-0 py-3 text-center">Aucune notification.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\dashboard\partials\_porteur.blade.php ENDPATH**/ ?>