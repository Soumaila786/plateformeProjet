<?php
    $porteurProjet = $projet->porteur ?? $projet->user ?? null;
?>

<?php if (isset($component)) { $__componentOriginal10bc9ab4bc16e5be58d7bd824e42dc1a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal10bc9ab4bc16e5be58d7bd824e42dc1a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.info','data' => ['class' => 'mb-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-4']); ?>
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="text-muted small font-monospace"><?php echo e($projet->codeProjet); ?></span>
                <?php if (isset($component)) { $__componentOriginal92e5bb4fc9387ee856165aa6c64590ff = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal92e5bb4fc9387ee856165aa6c64590ff = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badges.statut-projet','data' => ['statut' => $projet->statutProjet]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badges.statut-projet'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['statut' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($projet->statutProjet)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal92e5bb4fc9387ee856165aa6c64590ff)): ?>
<?php $attributes = $__attributesOriginal92e5bb4fc9387ee856165aa6c64590ff; ?>
<?php unset($__attributesOriginal92e5bb4fc9387ee856165aa6c64590ff); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal92e5bb4fc9387ee856165aa6c64590ff)): ?>
<?php $component = $__componentOriginal92e5bb4fc9387ee856165aa6c64590ff; ?>
<?php unset($__componentOriginal92e5bb4fc9387ee856165aa6c64590ff); ?>
<?php endif; ?>
            </div>
            <h4 class="fw-bold mb-0" style="color: var(--color-text);"><?php echo e($projet->titre); ?></h4>
            <div class="ps-header-meta">
                <span><i class="fas fa-user"></i><?php echo e($porteurProjet->nomComplet ?? '—'); ?></span>
                <span><i class="fas fa-building"></i><?php echo e($projet->secteur->nomSecteur ?? '—'); ?></span>
            </div>
        </div>

        <?php echo $__env->make('projets.partials._actions_bar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <hr class="my-4" style="border-color: var(--color-border-light);">

    <?php if (isset($component)) { $__componentOriginalca131747fe5833d9e6fd9ccba28013ae = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalca131747fe5833d9e6fd9ccba28013ae = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.circuit.stepper','data' => ['statut' => $projet->statutProjet]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('circuit.stepper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['statut' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($projet->statutProjet)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalca131747fe5833d9e6fd9ccba28013ae)): ?>
<?php $attributes = $__attributesOriginalca131747fe5833d9e6fd9ccba28013ae; ?>
<?php unset($__attributesOriginalca131747fe5833d9e6fd9ccba28013ae); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalca131747fe5833d9e6fd9ccba28013ae)): ?>
<?php $component = $__componentOriginalca131747fe5833d9e6fd9ccba28013ae; ?>
<?php unset($__componentOriginalca131747fe5833d9e6fd9ccba28013ae); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal10bc9ab4bc16e5be58d7bd824e42dc1a)): ?>
<?php $attributes = $__attributesOriginal10bc9ab4bc16e5be58d7bd824e42dc1a; ?>
<?php unset($__attributesOriginal10bc9ab4bc16e5be58d7bd824e42dc1a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal10bc9ab4bc16e5be58d7bd824e42dc1a)): ?>
<?php $component = $__componentOriginal10bc9ab4bc16e5be58d7bd824e42dc1a; ?>
<?php unset($__componentOriginal10bc9ab4bc16e5be58d7bd824e42dc1a); ?>
<?php endif; ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\projets\partials\_header.blade.php ENDPATH**/ ?>