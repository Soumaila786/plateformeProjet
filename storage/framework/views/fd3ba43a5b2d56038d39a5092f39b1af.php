<?php
    $stMap = [
        'brouillon' => ['lbl' => 'Brouillon',  'dot' => '#9ca3af'],
        'soumis'    => ['lbl' => 'Soumis',     'dot' => '#6366f1'],
        'en_examen' => ['lbl' => 'En examen',  'dot' => '#f97316'],
        'approuve'  => ['lbl' => 'Approuvé',   'dot' => '#22c55e'],
        'rejete'    => ['lbl' => 'Rejeté',     'dot' => '#ef4444'],
        'valide'    => ['lbl' => 'Validé',     'dot' => '#0d9488'],
    ];
?>

<?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $st = $stMap[$projet->statutProjet] ?? ['lbl' => $projet->statutProjet, 'dot' => '#9ca3af'];
        $porteurProjet = $projet->porteur ?? $projet->user ?? null;
        $estProprietaire = $porteurProjet && $porteurProjet->id === auth()->id();
        $champsModifierProjet = [
            'titre' => $projet->titre, 'description' => $projet->description,
            'objectif' => $projet->objectif, 'secteur_id' => $projet->secteur_id,
            'duree' => $projet->duree,
            'dateDebut' => optional($projet->dateDebut)->format('Y-m-d'),
            'dateFin' => optional($projet->dateFin)->format('Y-m-d'),
            'budgetTotal' => $projet->budgetTotal, 'montantDemande' => $projet->montantDemande,
        ];
    ?>

    <div class="lp-row">
        <div class="lp-avatar"><?php echo e(strtoupper(substr($projet->secteur->nomSecteur ?? $projet->titre, 0, 1))); ?></div>

        <div class="lp-info">
            <div class="lp-top">
                <span class="lp-code"><?php echo e($projet->codeProjet); ?></span>
                <span class="lp-titre"><?php echo e($projet->titre); ?></span>
            </div>
            <p class="lp-meta">
                <?php if($porteurProjet): ?>
                    <span><i class="fas fa-user"></i><?php echo e($porteurProjet->nomComplet); ?></span>
                <?php endif; ?>
                <span><i class="fas fa-tag"></i><?php echo e($projet->secteur->nomSecteur ?? '—'); ?></span>
                <?php if($projet->montantDemande): ?>
                    <span><i class="fas fa-coins"></i><strong><?php echo e(number_format($projet->montantDemande, 0, ',', ' ')); ?> FCFA</strong></span>
                <?php endif; ?>
                <?php if($projet->statutProjet === 'rejete' && !empty($projet->motifRejet)): ?>
                    <span class="text-truncate" style="max-width:260px;"><i class="fas fa-circle-info"></i><?php echo e($projet->motifRejet); ?></span>
                <?php endif; ?>
            </p>
        </div>

        <div class="lp-badges">
            <span class="lp-badge" style="background: color-mix(in srgb, <?php echo e($st['dot']); ?> 16%, white); color: <?php echo e($st['dot']); ?>;">
                <span class="lp-dot" style="background:<?php echo e($st['dot']); ?>;"></span><?php echo e($st['lbl']); ?>

            </span>

            <?php if(isset($routeShow)): ?>
                <a href="<?php echo e(route($routeShow, $projet)); ?>" class="lp-btn" title="Voir"><i class="fas fa-eye"></i></a>
            <?php endif; ?>

            <?php if(isset($routeExaminer) && !auth()->user()->hasRole('admin') && auth()->user()->can('projets.examiner') && $projet->statutProjet === 'soumis'): ?>
                <form method="POST" action="<?php echo e(route($routeExaminer, $projet)); ?>" onsubmit="return confirm('Mettre ce projet en examen ?')" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="lp-btn lp-btn-orange" title="Mettre en examen"><i class="fas fa-magnifying-glass"></i></button>
                </form>
            <?php endif; ?>

            <?php if(isset($routeApprouver) && !auth()->user()->hasRole('admin') && auth()->user()->can('projets.approuver') && $projet->statutProjet === 'en_examen'): ?>
                <button type="button" class="lp-btn lp-btn-green" title="Approuver" onclick="openModal('modalApprouver<?php echo e($projet->id); ?>')"><i class="fas fa-check"></i></button>
            <?php endif; ?>
            <?php if(isset($routeValider) && !auth()->user()->hasRole('admin') && auth()->user()->can('projets.valider') && $projet->statutProjet === 'approuve'): ?>
                <button type="button" class="lp-btn lp-btn-green" title="Valider" onclick="openModal('modalValider<?php echo e($projet->id); ?>')"><i class="fas fa-check-double"></i></button>
            <?php endif; ?>

            <?php if(isset($routeDemanderModif) && !auth()->user()->hasRole('admin') && auth()->user()->can('projets.demander_modification') && in_array($projet->statutProjet, ['en_examen', 'approuve'])): ?>
                <button type="button" class="lp-btn" title="Demander une modification" onclick="openModal('modalDemandeModif<?php echo e($projet->id); ?>')"><i class="fas fa-pen"></i></button>
            <?php endif; ?>

            <?php if(isset($routeRejeter) && !auth()->user()->hasRole('admin') && auth()->user()->can('projets.rejeter') && in_array($projet->statutProjet, ['en_examen', 'approuve'])): ?>
                <button type="button" class="lp-btn lp-btn-red" title="Rejeter" onclick="openModal('modalRejeter<?php echo e($projet->id); ?>')"><i class="fas fa-times"></i></button>
            <?php endif; ?>

            <?php if($estProprietaire && auth()->user()->can('projets.modifier') && $projet->isEditable()): ?>
                <button type="button" class="lp-btn" title="Modifier"
                        data-modal-edit="modalProjetForm"
                        data-modal-action="<?php echo e(route('porteur.projets.update', $projet)); ?>"
                        data-modal-titre-edition="Modifier le projet"
                        data-modal-fields="<?php echo e(json_encode($champsModifierProjet)); ?>">
                    <i class="fas fa-pen"></i>
                </button>
            <?php endif; ?>
            <?php if($estProprietaire && auth()->user()->can('projets.supprimer') && $projet->isDeletable()): ?>
                <form method="POST" action="<?php echo e(route('porteur.projets.destroy', $projet)); ?>" onsubmit="return confirm('Supprimer ce projet ?')" class="d-inline">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="lp-btn lp-btn-red" title="Supprimer"><i class="fas fa-trash"></i></button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <?php if(isset($routeApprouver) && !auth()->user()->hasRole('admin') && auth()->user()->can('projets.approuver') && $projet->statutProjet === 'en_examen'): ?>
        <div id="modalApprouver<?php echo e($projet->id); ?>" class="lp-modal-overlay">
            <div class="lp-modal-box">
                <div class="lp-modal-head">
                    <h3 class="lp-modal-title"><i class="fas fa-check-circle" style="color:#22c55e;"></i> Approuver le projet</h3>
                    <button onclick="closeModal('modalApprouver<?php echo e($projet->id); ?>')" class="lp-modal-close"><i class="fas fa-times"></i></button>
                </div>
                <form method="POST" action="<?php echo e(route($routeApprouver, $projet)); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="lp-modal-body">
                        <p class="text-muted small">Le projet <strong><?php echo e($projet->titre); ?></strong> passera à l'étape suivante.</p>
                        <label class="form-label small">Commentaire (optionnel)</label>
                        <textarea name="commentaire" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="lp-modal-foot">
                        <button type="button" onclick="closeModal('modalApprouver<?php echo e($projet->id); ?>')" class="btn btn-light btn-sm">Annuler</button>
                        <button type="submit" class="btn btn-success btn-sm">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if(isset($routeValider) && !auth()->user()->hasRole('admin') && auth()->user()->can('projets.valider') && $projet->statutProjet === 'approuve'): ?>
        <div id="modalValider<?php echo e($projet->id); ?>" class="lp-modal-overlay">
            <div class="lp-modal-box">
                <div class="lp-modal-head">
                    <h3 class="lp-modal-title"><i class="fas fa-check-double" style="color:#22c55e;"></i> Valider le projet</h3>
                    <button onclick="closeModal('modalValider<?php echo e($projet->id); ?>')" class="lp-modal-close"><i class="fas fa-times"></i></button>
                </div>
                <form method="POST" action="<?php echo e(route($routeValider, $projet)); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="lp-modal-body">
                        <p class="text-muted small">Le projet <strong><?php echo e($projet->titre); ?></strong> sera marqué comme validé.</p>
                        <label class="form-label small">Commentaire (optionnel)</label>
                        <textarea name="commentaire" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="lp-modal-foot">
                        <button type="button" onclick="closeModal('modalValider<?php echo e($projet->id); ?>')" class="btn btn-light btn-sm">Annuler</button>
                        <button type="submit" class="btn btn-success btn-sm">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if(isset($routeRejeter) && !auth()->user()->hasRole('admin') && auth()->user()->can('projets.rejeter') && in_array($projet->statutProjet, ['en_examen', 'approuve'])): ?>
        <div id="modalRejeter<?php echo e($projet->id); ?>" class="lp-modal-overlay">
            <div class="lp-modal-box">
                <div class="lp-modal-head">
                    <h3 class="lp-modal-title"><i class="fas fa-times-circle" style="color:#ef4444;"></i> Rejeter le projet</h3>
                    <button onclick="closeModal('modalRejeter<?php echo e($projet->id); ?>')" class="lp-modal-close"><i class="fas fa-times"></i></button>
                </div>
                <form method="POST" action="<?php echo e(route($routeRejeter, $projet)); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="lp-modal-body">
                        <label class="form-label small">Motif(s) de rejet <span class="text-danger">*</span></label>
                        <?php $__currentLoopData = $motifsDisponibles ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="motifs[]" value="<?php echo e($motif->id); ?>" id="rej-<?php echo e($projet->id); ?>-<?php echo e($motif->id); ?>">
                                <label class="form-check-label small" for="rej-<?php echo e($projet->id); ?>-<?php echo e($motif->id); ?>"><?php echo e($motif->libelle); ?></label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <label class="form-label small mt-2">Commentaire libre (optionnel)</label>
                        <textarea name="commentaire_libre" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="lp-modal-foot">
                        <button type="button" onclick="closeModal('modalRejeter<?php echo e($projet->id); ?>')" class="btn btn-light btn-sm">Annuler</button>
                        <button type="submit" class="btn btn-danger btn-sm">Confirmer le rejet</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if(isset($routeDemanderModif) && !auth()->user()->hasRole('admin') && auth()->user()->can('projets.demander_modification') && in_array($projet->statutProjet, ['en_examen', 'approuve'])): ?>
        <div id="modalDemandeModif<?php echo e($projet->id); ?>" class="lp-modal-overlay">
            <div class="lp-modal-box">
                <div class="lp-modal-head">
                    <h3 class="lp-modal-title"><i class="fas fa-pen" style="color:#f97316;"></i> Demander une modification</h3>
                    <button onclick="closeModal('modalDemandeModif<?php echo e($projet->id); ?>')" class="lp-modal-close"><i class="fas fa-times"></i></button>
                </div>
                <form method="POST" action="<?php echo e(route($routeDemanderModif, $projet)); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="lp-modal-body">
                        <p class="text-muted small">Le projet repassera en brouillon pour que le porteur corrige.</p>
                        <label class="form-label small">Motif(s) <span class="text-danger">*</span></label>
                        <?php $__currentLoopData = $motifsDisponibles ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="motifs[]" value="<?php echo e($motif->id); ?>" id="mod-<?php echo e($projet->id); ?>-<?php echo e($motif->id); ?>">
                                <label class="form-check-label small" for="mod-<?php echo e($projet->id); ?>-<?php echo e($motif->id); ?>"><?php echo e($motif->libelle); ?></label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <label class="form-label small mt-2">Commentaire libre (optionnel)</label>
                        <textarea name="commentaire_libre" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="lp-modal-foot">
                        <button type="button" onclick="closeModal('modalDemandeModif<?php echo e($projet->id); ?>')" class="btn btn-light btn-sm">Annuler</button>
                        <button type="submit" class="btn btn-warning btn-sm">Envoyer la demande</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="lp-empty">
        <i class="fas fa-folder-open"></i>
        <p class="mb-0">Aucun projet trouvé.</p>
    </div>
<?php endif; ?>

<div class="mt-3"><?php echo e($projets->withQueryString()->links()); ?></div>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/listes-projets.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\projets\partials\_liste_lignes.blade.php ENDPATH**/ ?>