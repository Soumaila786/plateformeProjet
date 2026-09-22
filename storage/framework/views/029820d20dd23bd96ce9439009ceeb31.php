<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
<?php $__env->stopPush(); ?>

<?php if($projetsBloquesCount > 0): ?>
    <div class="dash-alert-bloque">
        <i class="fas fa-triangle-exclamation"></i>
        <strong><?php echo e($projetsBloquesCount); ?></strong> projet<?php echo e($projetsBloquesCount > 1 ? 's' : ''); ?>

        bloqué<?php echo e($projetsBloquesCount > 1 ? 's' : ''); ?> depuis plus de 10 jours sans traitement.
    </div>
<?php endif; ?>

<div class="dash-stats-grid">
    <?php if (isset($component)) { $__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'Projets au total','valeur' => $totalProjets,'icon' => 'fa-folder','href' => ''.e(route('admin.projets.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Projets au total','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalProjets),'icon' => 'fa-folder','href' => ''.e(route('admin.projets.index')).'']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'Soumis','valeur' => $projetsSoumis,'icon' => 'fa-paper-plane','couleur' => 'var(--status-soumis)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Soumis','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($projetsSoumis),'icon' => 'fa-paper-plane','couleur' => 'var(--status-soumis)']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'En examen','valeur' => $projetsEnExamen,'icon' => 'fa-magnifying-glass','couleur' => 'var(--status-en-examen)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'En examen','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($projetsEnExamen),'icon' => 'fa-magnifying-glass','couleur' => 'var(--status-en-examen)']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'Approuvés','valeur' => $projetsApprouves,'icon' => 'fa-check','couleur' => 'var(--status-approuve)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Approuvés','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($projetsApprouves),'icon' => 'fa-check','couleur' => 'var(--status-approuve)']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'Validés','valeur' => $projetsValides,'icon' => 'fa-check-double','couleur' => 'var(--status-valide)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Validés','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($projetsValides),'icon' => 'fa-check-double','couleur' => 'var(--status-valide)']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'Rejetés','valeur' => $projetsRejetes,'icon' => 'fa-xmark','couleur' => 'var(--status-rejete)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Rejetés','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($projetsRejetes),'icon' => 'fa-xmark','couleur' => 'var(--status-rejete)']); ?>
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

<div class="dash-stats-grid">
    <?php if (isset($component)) { $__componentOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a8c6e5f79632e252d9172cb00eaaab5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'Utilisateurs actifs','valeur' => $usersActifs,'icon' => 'fa-users','href' => ''.e(route('admin.users.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Utilisateurs actifs','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($usersActifs),'icon' => 'fa-users','href' => ''.e(route('admin.users.index')).'']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'Utilisateurs inactifs','valeur' => $usersInactifs,'icon' => 'fa-user-slash','couleur' => 'var(--color-text-muted)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Utilisateurs inactifs','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($usersInactifs),'icon' => 'fa-user-slash','couleur' => 'var(--color-text-muted)']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'Secteurs actifs','valeur' => $secteursActifs,'icon' => 'fa-building','couleur' => 'var(--color-info)','href' => ''.e(route('admin.secteurs.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Secteurs actifs','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($secteursActifs),'icon' => 'fa-building','couleur' => 'var(--color-info)','href' => ''.e(route('admin.secteurs.index')).'']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.stat','data' => ['label' => 'Total secteurs','valeur' => $totalSecteurs,'icon' => 'fa-building-columns','couleur' => 'var(--color-text-muted)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total secteurs','valeur' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalSecteurs),'icon' => 'fa-building-columns','couleur' => 'var(--color-text-muted)']); ?>
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

<div class="row g-3">
    <div class="col-lg-7">
        <div class="dash-card">
            <h6 class="fw-bold mb-3">Projets récents</h6>
            <?php echo $__env->make('dashboard.partials._projets_recents', ['projetsRecents' => $projetsRecents, 'routeShow' => 'admin.projets.show'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="dash-card">
            <h6 class="fw-bold mb-3">Nouveaux utilisateurs</h6>
            <?php $__empty_1 = true; $__currentLoopData = $usersRecents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="d-flex align-items-center gap-2 py-2 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?>">
                    <?php if (isset($component)) { $__componentOriginal509c53a7568e07868cb1e8962f0ef801 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal509c53a7568e07868cb1e8962f0ef801 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.avatars.avatar','data' => ['user' => $u,'size' => 32]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('avatars.avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($u),'size' => 32]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal509c53a7568e07868cb1e8962f0ef801)): ?>
<?php $attributes = $__attributesOriginal509c53a7568e07868cb1e8962f0ef801; ?>
<?php unset($__attributesOriginal509c53a7568e07868cb1e8962f0ef801); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal509c53a7568e07868cb1e8962f0ef801)): ?>
<?php $component = $__componentOriginal509c53a7568e07868cb1e8962f0ef801; ?>
<?php unset($__componentOriginal509c53a7568e07868cb1e8962f0ef801); ?>
<?php endif; ?>
                    <div class="min-w-0">
                        <div class="small fw-semibold text-truncate"><?php echo e($u->nomComplet); ?></div>
                        <div class="text-muted text-truncate" style="font-size:.72rem;"><?php echo e(ucfirst($u->role)); ?></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-muted small mb-0 py-3 text-center">Aucun utilisateur récent.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\dashboard\partials\_admin.blade.php ENDPATH**/ ?>