<?php
    $role = auth()->user()->role;
    $labelsStatutActivite = [
        'en_attente' => ['label' => 'En attente', 'color' => 'secondary'],
        'financee'   => ['label' => 'Financée',   'color' => 'success'],
        'en_cours'   => ['label' => 'En cours',   'color' => 'primary'],
        'termine'    => ['label' => 'Terminée',   'color' => 'info'],
        'annule'     => ['label' => 'Annulée',    'color' => 'danger'],
    ];
    // Nom de route selon le rôle connecté (porteur ou planificateur peuvent
    // tous deux gérer des activités, chacun sous son propre préfixe de route).
    $routeStoreActivite = $role.'.planifications.store';
    $routeUpdateActivite = $role.'.planifications.update';
?>

<?php if($projet->activites->isNotEmpty() || in_array($role, ['porteur', 'planificateur'])): ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.info','data' => ['titre' => 'Planification','icon' => 'fa-list-check','class' => 'mb-3']]); ?>
<?php $component->withName('cards.info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['titre' => 'Planification','icon' => 'fa-list-check','class' => 'mb-3']); ?>

    <?php $__empty_1 = true; $__currentLoopData = $projet->activites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php $sa = $labelsStatutActivite[$activite->statutActivite] ?? ['label' => $activite->statutActivite, 'color' => 'secondary']; ?>
        <div class="d-flex justify-content-between align-items-start py-2 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?>">
            <div>
                <div class="fw-semibold"><?php echo e($activite->activite); ?></div>
                <div class="text-muted small">
                    <?php echo e($activite->indicateur); ?> <?php echo e($activite->uniteIndicateur); ?> · <?php echo e($activite->periode); ?>

                    · <span class="font-monospace"><?php echo e(number_format($activite->coutEstimatif, 0, ',', ' ')); ?> FCFA</span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <?php if($role === 'approbateur'): ?>
                    <form action="<?php echo e(route('approbateur.projets.activite.statut', [$projet, $activite])); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <select name="statutActivite" class="form-select form-select-sm" onchange="this.form.submit()">
                            <?php $__currentLoopData = $labelsStatutActivite; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $conf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php echo e($activite->statutActivite === $key ? 'selected' : ''); ?>><?php echo e($conf['label']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </form>
                <?php else: ?>
                    <span class="badge bg-<?php echo e($sa['color']); ?>-subtle text-<?php echo e($sa['color']); ?>"><?php echo e($sa['label']); ?></span>
                <?php endif; ?>

                <?php if(in_array($role, ['porteur', 'planificateur']) && Route::has($routeUpdateActivite)): ?>
                    <?php
                        $champsModifierActivite = [
                            'activitePlanification' => $activite->activite,
                            'indicateur' => $activite->indicateur,
                            'uniteIndicateur' => $activite->uniteIndicateur,
                            'resultatsAttendues' => $activite->resultatsAttendues,
                            'coutEstimatif' => $activite->coutEstimatif,
                            'periode' => $activite->periode,
                        ];
                    ?>
                    <button type="button" class="btn btn-sm btn-link text-decoration-none" title="Modifier l'activité"
                            data-modal-edit="modalActiviteForm"
                            data-modal-action="<?php echo e(route($routeUpdateActivite, [$projet, $activite])); ?>"
                            data-modal-titre-edition="Modifier l'activité"
                            data-modal-fields="<?php echo e(json_encode($champsModifierActivite)); ?>">
                        <i class="fas fa-pen"></i>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-muted small mb-0">Aucune activité de planification pour l'instant.</p>
    <?php endif; ?>

    <?php if(in_array($role, ['porteur', 'planificateur']) && Route::has($routeStoreActivite)): ?>
        <button type="button" class="btn btn-outline-secondary btn-sm mt-3"
                data-modal-new="modalActiviteForm"
                data-modal-action="<?php echo e(route($routeStoreActivite, $projet)); ?>"
                data-modal-titre-creation="Nouvelle activité">
            <i class="fas fa-plus"></i> Ajouter une activité
        </button>

        <?php echo $__env->make('modals.activite-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\projets\partials\_activities.blade.php ENDPATH**/ ?>