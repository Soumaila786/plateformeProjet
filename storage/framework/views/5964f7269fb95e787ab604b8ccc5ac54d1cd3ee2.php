<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.info','data' => ['titre' => 'Informations du projet','icon' => 'fa-circle-info','class' => 'mb-3']]); ?>
<?php $component->withName('cards.info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
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
            <div class="fw-semibold font-monospace"><?php echo e(number_format($projet->budgetTotal ?? 0, 0, ',', ' ')); ?> FCFA</div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="text-muted small">Montant demandé</div>
            <div class="fw-semibold font-monospace"><?php echo e(number_format($projet->montantDemande ?? 0, 0, ',', ' ')); ?> FCFA</div>
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
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/projets/partials/_main_info.blade.php ENDPATH**/ ?>