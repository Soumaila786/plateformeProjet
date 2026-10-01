<?php if (isset($component)) { $__componentOriginal10bc9ab4bc16e5be58d7bd824e42dc1a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal10bc9ab4bc16e5be58d7bd824e42dc1a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.info','data' => ['titre' => 'Informations du projet','icon' => 'fa-circle-info','class' => 'mb-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['titre' => 'Informations du projet','icon' => 'fa-circle-info','class' => 'mb-3']); ?>
    <p class="mb-3"><?php echo e($projet->description); ?></p>

    <?php if($projet->objectif): ?>
        <p class="text-muted small mb-3"><strong>Objectif :</strong> <?php echo e($projet->objectif); ?></p>
    <?php endif; ?>

    <div class="row g-3">
        <div class="col-sm-6 col-lg-3">
            <div class="text-muted small">Durée</div>
            <div class="fw-semibold"><?php echo e($projet->duree ? $projet->duree.' mois' : '—'); ?></div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="text-muted small">Période</div>
            <div class="fw-semibold">
                <?php echo e(optional($projet->dateDebut)->format('d/m/Y') ?? '—'); ?> → <?php echo e(optional($projet->dateFin)->format('d/m/Y') ?? '—'); ?>

            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="text-muted small">Budget total</div>
            <div class="fw-semibold font-monospace"><?php echo e(number_format($projet->budgetTotal ?? 0, 2, ',', ' ')); ?> <?php echo e($projet->budgetDevise ?? 'XOF'); ?></div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="text-muted small">Montant demandé</div>
            <div class="fw-semibold font-monospace"><?php echo e(number_format($projet->montantDemande ?? 0, 2, ',', ' ')); ?> <?php echo e($projet->montantDemandeDevise ?? 'XOF'); ?></div>
        </div>
    </div>

    <hr class="my-3">

    <div class="row g-3 text-muted small">
        <div class="col-sm-4">
            <i class="fas fa-paper-plane me-1"></i>Soumis le <?php echo e(optional($projet->dateSoumission)->format('d/m/Y') ?? '—'); ?>

        </div>
        <div class="col-sm-4">
            <i class="fas fa-check me-1"></i>Approuvé le <?php echo e(optional($projet->dateApprobation)->format('d/m/Y') ?? '—'); ?>

        </div>
        <div class="col-sm-4">
            <i class="fas fa-check-double me-1"></i>Validé le <?php echo e(optional($projet->dateValidation)->format('d/m/Y') ?? '—'); ?>

        </div>
    </div>
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
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/projets/partials/_main_info.blade.php ENDPATH**/ ?>