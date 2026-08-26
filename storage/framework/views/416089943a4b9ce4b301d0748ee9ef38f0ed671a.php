<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/listes-projets.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/modals-crud.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php
    $u = auth()->user();
    $estOperateur = !$u->hasRole('admin');
    $porteurProjet = $projet->porteur ?? $projet->user ?? null;
    $estProprietaire = $porteurProjet && $porteurProjet->id === $u->id;
    $champsModifierProjet = [
        'titre' => $projet->titre, 'description' => $projet->description,
        'objectif' => $projet->objectif, 'secteur_id' => $projet->secteur_id,
        'duree' => $projet->duree,
        'dateDebut' => optional($projet->dateDebut)->format('Y-m-d'),
        'dateFin' => optional($projet->dateFin)->format('Y-m-d'),
        'budgetTotal' => $projet->budgetTotal, 'montantDemande' => $projet->montantDemande,
    ];
?>

<div class="d-flex flex-wrap gap-2">

    <?php if($estOperateur && $u->can('projets.examiner') && $projet->statutProjet === 'soumis'): ?>
        <form action="<?php echo e(route('approbateur.projets.examiner', $projet)); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.button','data' => ['variant' => 'outline','icon' => 'fa-magnifying-glass','type' => 'submit']]); ?>
<?php $component->withName('buttons.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['variant' => 'outline','icon' => 'fa-magnifying-glass','type' => 'submit']); ?>
                Mettre en examen
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </form>
    <?php endif; ?>

    <?php if($estOperateur && $u->can('projets.approuver') && $projet->statutProjet === 'en_examen'): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.button','data' => ['variant' => 'success','icon' => 'fa-check','dataBsToggle' => 'modal','dataBsTarget' => '#modalApprouver']]); ?>
<?php $component->withName('buttons.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['variant' => 'success','icon' => 'fa-check','data-bs-toggle' => 'modal','data-bs-target' => '#modalApprouver']); ?>
            Approuver
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if($estOperateur && $u->can('projets.valider') && $projet->statutProjet === 'approuve'): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.button','data' => ['variant' => 'success','icon' => 'fa-check-double','dataBsToggle' => 'modal','dataBsTarget' => '#modalValider']]); ?>
<?php $component->withName('buttons.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['variant' => 'success','icon' => 'fa-check-double','data-bs-toggle' => 'modal','data-bs-target' => '#modalValider']); ?>
            Valider
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if($estOperateur && $u->can('projets.demander_modification') && in_array($projet->statutProjet, ['en_examen', 'approuve'])): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.button','data' => ['variant' => 'outline','icon' => 'fa-pen','dataBsToggle' => 'modal','dataBsTarget' => '#modalDemandeModif']]); ?>
<?php $component->withName('buttons.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['variant' => 'outline','icon' => 'fa-pen','data-bs-toggle' => 'modal','data-bs-target' => '#modalDemandeModif']); ?>
            Demander modification
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if($estOperateur && $u->can('projets.rejeter') && in_array($projet->statutProjet, ['en_examen', 'approuve'])): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.button','data' => ['variant' => 'danger','icon' => 'fa-xmark','dataBsToggle' => 'modal','dataBsTarget' => '#modalRejeter']]); ?>
<?php $component->withName('buttons.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['variant' => 'danger','icon' => 'fa-xmark','data-bs-toggle' => 'modal','data-bs-target' => '#modalRejeter']); ?>
            Rejeter
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if($estProprietaire && $u->can('projets.modifier') && $projet->isEditable()): ?>
        <button type="button" class="btn btn-outline-secondary btn-sm"
                data-modal-edit="modalProjetForm"
                data-modal-action="<?php echo e(route('porteur.projets.update', $projet)); ?>"
                data-modal-titre-edition="Modifier le projet"
                data-modal-fields="<?php echo e(json_encode($champsModifierProjet)); ?>">
            <i class="fas fa-pen"></i> Modifier
        </button>
    <?php endif; ?>

    <?php if($estProprietaire && $u->can('projets.soumettre') && $projet->isSubmittable()): ?>
        <form action="<?php echo e(route('porteur.projets.soumettre', $projet)); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.button','data' => ['variant' => 'primary','icon' => 'fa-paper-plane','type' => 'submit']]); ?>
<?php $component->withName('buttons.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['variant' => 'primary','icon' => 'fa-paper-plane','type' => 'submit']); ?>
                <?php echo e($projet->isRejected() ? 'Soumettre à nouveau' : 'Soumettre'); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </form>
    <?php endif; ?>

    
    <?php if($estProprietaire && $u->can('projets.gerer_planification') && $projet->statutProjet === 'brouillon' && !$projet->planification_demandee): ?>
        <form action="<?php echo e(route('porteur.demande.planification', $projet)); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.button','data' => ['variant' => 'outline','icon' => 'fa-calendar-check','type' => 'submit']]); ?>
<?php $component->withName('buttons.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['variant' => 'outline','icon' => 'fa-calendar-check','type' => 'submit']); ?>
                Demander une planification
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </form>
    <?php endif; ?>

    <?php if($estProprietaire && $u->can('projets.supprimer') && $projet->isDeletable()): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.buttons.button','data' => ['variant' => 'danger','icon' => 'fa-trash','dataBsToggle' => 'modal','dataBsTarget' => '#modalSupprimer']]); ?>
<?php $component->withName('buttons.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['variant' => 'danger','icon' => 'fa-trash','data-bs-toggle' => 'modal','data-bs-target' => '#modalSupprimer']); ?>
            Supprimer
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php endif; ?>
</div>

<?php if($estOperateur && ($u->can('projets.approuver') || $u->can('projets.valider'))): ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modals.confirm','data' => ['id' => 'modalApprouver','titre' => 'Approuver le projet','action' => route('approbateur.projets.approuver', $projet),'boutonLabel' => 'Approuver','boutonVariant' => 'success']]); ?>
<?php $component->withName('modals.confirm'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'modalApprouver','titre' => 'Approuver le projet','action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('approbateur.projets.approuver', $projet)),'boutonLabel' => 'Approuver','boutonVariant' => 'success']); ?>
        <p class="text-muted small">Le projet passera à l'étape suivante du circuit.</p>
        <label class="form-label small">Commentaire (optionnel)</label>
        <textarea name="commentaire" class="form-control" rows="3" maxlength="1000"></textarea>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modals.confirm','data' => ['id' => 'modalValider','titre' => 'Valider le projet','action' => route('validateur.projets.valider', $projet),'boutonLabel' => 'Valider','boutonVariant' => 'success']]); ?>
<?php $component->withName('modals.confirm'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'modalValider','titre' => 'Valider le projet','action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('validateur.projets.valider', $projet)),'boutonLabel' => 'Valider','boutonVariant' => 'success']); ?>
        <p class="text-muted small">Le projet sera marqué comme validé.</p>
        <label class="form-label small">Commentaire (optionnel)</label>
        <textarea name="commentaire" class="form-control" rows="3" maxlength="1000"></textarea>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php endif; ?>

<?php if($estOperateur && $u->can('projets.rejeter')): ?>
    <?php $routeRejeter = $u->hasRole('approbateur') ? 'approbateur.projets.rejeter' : 'validateur.projets.rejeter'; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modals.confirm','data' => ['id' => 'modalRejeter','titre' => 'Rejeter le projet','action' => route($routeRejeter, $projet),'boutonLabel' => 'Rejeter','boutonVariant' => 'danger']]); ?>
<?php $component->withName('modals.confirm'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'modalRejeter','titre' => 'Rejeter le projet','action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route($routeRejeter, $projet)),'boutonLabel' => 'Rejeter','boutonVariant' => 'danger']); ?>
        <p class="text-muted small">Sélectionnez au moins un motif de rejet.</p>
        <?php $__currentLoopData = $motifsDisponibles ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="motifs[]" value="<?php echo e($motif->id); ?>" id="rejet-motif-<?php echo e($motif->id); ?>">
                <label class="form-check-label small" for="rejet-motif-<?php echo e($motif->id); ?>"><?php echo e($motif->libelle); ?></label>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <label class="form-label small mt-2">Commentaire libre (optionnel)</label>
        <textarea name="commentaire_libre" class="form-control" rows="3" maxlength="1000"></textarea>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php endif; ?>

<?php if($u->can('projets.demander_modification')): ?>
    <?php $routeDemande = $u->hasRole('approbateur') ? 'approbateur.projets.demande-modification' : 'validateur.projets.demande-modification'; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modals.confirm','data' => ['id' => 'modalDemandeModif','titre' => 'Demander une modification','action' => route($routeDemande, $projet),'boutonLabel' => 'Envoyer la demande','boutonVariant' => 'primary']]); ?>
<?php $component->withName('modals.confirm'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'modalDemandeModif','titre' => 'Demander une modification','action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route($routeDemande, $projet)),'boutonLabel' => 'Envoyer la demande','boutonVariant' => 'primary']); ?>
        <p class="text-muted small">Le projet repassera en brouillon pour que le porteur corrige.</p>
        <?php $__currentLoopData = $motifsDisponibles ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="motifs[]" value="<?php echo e($motif->id); ?>" id="modif-motif-<?php echo e($motif->id); ?>">
                <label class="form-check-label small" for="modif-motif-<?php echo e($motif->id); ?>"><?php echo e($motif->libelle); ?></label>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <label class="form-label small mt-2">Commentaire libre (optionnel)</label>
        <textarea name="commentaire_libre" class="form-control" rows="3" maxlength="1000"></textarea>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php endif; ?>

<?php if($u->can('projets.supprimer') && ($estProprietaire || $u->hasRole('admin'))): ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.modals.confirm','data' => ['id' => 'modalSupprimer','titre' => 'Supprimer ce projet ?','action' => route(($u->hasRole('admin') ? 'admin' : 'porteur').'.projets.destroy', $projet),'method' => 'DELETE','boutonLabel' => 'Supprimer','boutonVariant' => 'danger']]); ?>
<?php $component->withName('modals.confirm'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['id' => 'modalSupprimer','titre' => 'Supprimer ce projet ?','action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route(($u->hasRole('admin') ? 'admin' : 'porteur').'.projets.destroy', $projet)),'method' => 'DELETE','boutonLabel' => 'Supprimer','boutonVariant' => 'danger']); ?>
        <p class="text-muted small mb-0">Cette action est irréversible et supprimera également les documents associés.</p>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php endif; ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('projets.creer')): ?>
    <?php echo $__env->make('modals.projet-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\projets\partials\_actions_bar.blade.php ENDPATH**/ ?>