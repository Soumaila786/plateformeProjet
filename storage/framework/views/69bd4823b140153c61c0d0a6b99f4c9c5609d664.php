<?php
    $porteurProjet = $projet->porteur ?? $projet->user ?? null;
?>

<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.info','data' => ['class' => 'mb-4']]); ?>
<?php $component->withName('cards.info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'mb-4']); ?>
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="text-muted small font-monospace"><?php echo e($projet->codeProjet); ?></span>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.badges.statut-projet','data' => ['statut' => $projet->statutProjet]]); ?>
<?php $component->withName('badges.statut-projet'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['statut' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($projet->statutProjet)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
            <h4 class="fw-bold mb-0" style="color: var(--color-text);"><?php echo e($projet->titre); ?></h4>
            <div class="ps-header-meta">
                <span><i class="fas fa-user"></i><?php echo e($porteurProjet->nomComplet ?? '—'); ?></span>
                <span><i class="fas fa-building"></i><?php echo e($projet->secteur->nomSecteur ?? '—'); ?></span>
            </div>
        </div>

        <?php echo $__env->make('projets.partials._actions_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <hr class="my-4" style="border-color: var(--color-border-light);">

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.circuit.stepper','data' => ['statut' => $projet->statutProjet]]); ?>
<?php $component->withName('circuit.stepper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['statut' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($projet->statutProjet)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\projets\partials\_header.blade.php ENDPATH**/ ?>