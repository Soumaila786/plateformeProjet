<?php if (isset($component)) { $__componentOriginal10bc9ab4bc16e5be58d7bd824e42dc1a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal10bc9ab4bc16e5be58d7bd824e42dc1a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.info','data' => ['titre' => 'Historique','icon' => 'fa-clock-rotate-left']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['titre' => 'Historique','icon' => 'fa-clock-rotate-left']); ?>

    <?php $__empty_1 = true; $__currentLoopData = $projet->commentaires->sortByDesc('dateEnvoi'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commentaire): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="d-flex gap-3 py-2 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?>">
            <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle"
                 style="width:32px; height:32px; background: color-mix(in srgb, <?php echo e($commentaire->couleur()); ?> 15%, white); color: <?php echo e($commentaire->couleur()); ?>;">
                <i class="fas <?php echo e($commentaire->icone()); ?>"></i>
            </div>
            <div>
                <div class="small fw-semibold">
                    <?php echo e($commentaire->utilisateur->nomComplet ?? '—'); ?>

                    <span class="text-muted fw-normal">· <?php echo e(optional($commentaire->dateEnvoi)->format('d/m/Y H:i')); ?></span>
                </div>

                <?php if($commentaire->relationLoaded('motifs') && $commentaire->motifs->isNotEmpty()): ?>
                    <div class="d-flex flex-wrap gap-1 my-1">
                        <?php $__currentLoopData = $commentaire->motifs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge bg-light text-dark border"><?php echo e($motif->libelle); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <?php if($commentaire->message): ?>
                    <p class="mb-0 small"><?php echo e($commentaire->message); ?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-muted small mb-0">Aucun échange pour l'instant.</p>
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
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/projets/partials/_history.blade.php ENDPATH**/ ?>