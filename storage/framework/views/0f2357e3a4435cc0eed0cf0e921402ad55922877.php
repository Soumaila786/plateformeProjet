<?php $__env->startSection('title', $projet->titre); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/projet.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="projets-page">

    
    <div class="page-header">
        <a href="<?php echo e(route('approbateur.projets.index')); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-header-info">
            <div>
                <h1 class="projets-title"><?php echo e($projet->titre); ?></h1>
                <p class="projets-subtitle"><?php echo e($projet->codeProjet); ?></p>
            </div>
            <?php
                $statusClass = [
                    'soumis'    => 'status-blue',
                    'en_examen' => 'status-yellow',
                    'approuve'  => 'status-green',
                    'rejete'    => 'status-red',
                ][$projet->statutProjet] ?? 'status-gray';
                $statusLabel = [
                    'soumis'    => 'Soumis',
                    'en_examen' => 'En examen',
                    'approuve'  => 'Approuvé',
                    'rejete'    => 'Rejeté',
                ][$projet->statutProjet] ?? $projet->statutProjet;
            ?>
            <span class="status-badge <?php echo e($statusClass); ?> status-lg"><?php echo e($statusLabel); ?></span>
        </div>
    </div>

    
    <div class="projet-actions-bar">

        
        <?php if($projet->statutProjet === 'soumis'): ?>
        <form method="POST" action="<?php echo e(route('approbateur.projets.examiner', $projet)); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="action-btn action-btn-yellow"
                    onclick="return confirm('Mettre ce projet en examen ?')">
                <i class="fas fa-search"></i>
                Mettre en examen
            </button>
        </form>
        <?php endif; ?>

        
        <?php if($projet->statutProjet === 'en_examen'): ?>
        <button type="button" class="action-btn action-btn-green"
                onclick="openModal('modalApprouver')">
            <i class="fas fa-check-circle"></i>
            Approuver
        </button>
        <button type="button" class="action-btn action-btn-red"
                onclick="openModal('modalRejeter')">
            <i class="fas fa-times-circle"></i>
            Rejeter
        </button>
        <?php endif; ?>

    </div>

    
    <div class="show-grid">

        
        <div class="show-col-main">

            
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-info-circle"></i>
                    <span>Informations générales</span>
                </div>
                <div class="form-card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Porteur</span>
                            <span class="info-value"><?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Secteur</span>
                            <span class="info-value"><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Durée</span>
                            <span class="info-value"><?php echo e($projet->duree ? $projet->duree . ' mois' : '—'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de création</span>
                            <span class="info-value"><?php echo e(optional($projet->dateCreation)->format('d/m/Y') ?? '—'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de soumission</span>
                            <span class="info-value"><?php echo e(optional($projet->dateSoumission)->format('d/m/Y') ?? '—'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de début</span>
                            <span class="info-value"><?php echo e(optional($projet->dateDebut)->format('d/m/Y') ?? '—'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de fin</span>
                            <span class="info-value"><?php echo e(optional($projet->dateFin)->format('d/m/Y') ?? '—'); ?></span>
                        </div>
                        <?php if($projet->dateApprobation): ?>
                        <div class="info-item">
                            <span class="info-label">Date d'approbation</span>
                            <span class="info-value"><?php echo e($projet->dateApprobation->format('d/m/Y')); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if($projet->description): ?>
                    <div class="info-block">
                        <span class="info-label">Description</span>
                        <p class="info-text"><?php echo e($projet->description); ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if($projet->objectif): ?>
                    <div class="info-block">
                        <span class="info-label">Objectif</span>
                        <p class="info-text"><?php echo e($projet->objectif); ?></p>
                    </div>
                    <?php endif; ?>

                    
                    <?php if($projet->motifRejet): ?>
                    <div class="info-block">
                        <span class="info-label" style="color:#dc2626;">Motif du rejet</span>
                        <p class="info-text" style="color:#dc2626;"><?php echo e($projet->motifRejet); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-tasks"></i>
                    <span>Planification (<?php echo e($projet->activites->count()); ?>)</span>
                </div>
                <?php if($projet->activites->count()): ?>
                <div class="form-card-body p-0">
                    <?php
                        $totalActivites  = $projet->activites->sum('montantDemande');
                        $totalFinancees  = $projet->activites->where('statutActivite','financee')->sum('montantDemande');
                        $nbFinancees     = $projet->activites->where('statutActivite','financee')->count();
                        $pctFinance      = $totalActivites > 0 ? round($totalFinancees / $totalActivites * 100) : 0;
                    ?>

                    
                    <div style="display:flex;gap:16px;padding:14px 20px;border-bottom:1.5px solid var(--gray-100);flex-wrap:wrap;background:var(--gray-50);">
                        <div style="flex:1;min-width:140px;">
                            <p style="font-size:.7rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Budget activités</p>
                            <p style="font-size:1rem;font-weight:800;color:var(--gray-900);"><?php echo e(number_format($totalActivites, 0, ',', ' ')); ?> <span style="font-size:.72rem;color:var(--gray-400);">F CFA</span></p>
                        </div>
                        <div style="flex:1;min-width:140px;">
                            <p style="font-size:.7rem;font-weight:700;color:#16a34a;text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Montant financé</p>
                            <p style="font-size:1rem;font-weight:800;color:#16a34a;"><?php echo e(number_format($totalFinancees, 0, ',', ' ')); ?> <span style="font-size:.72rem;">F CFA</span></p>
                        </div>
                        <div style="flex:1;min-width:140px;">
                            <p style="font-size:.7rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.04em;margin-bottom:3px;">Taux financement</p>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="flex:1;height:6px;background:var(--gray-200);border-radius:4px;overflow:hidden;">
                                    <div style="height:100%;width:<?php echo e($pctFinance); ?>%;background:#16a34a;border-radius:4px;transition:width .6s;"></div>
                                </div>
                                <span style="font-size:.82rem;font-weight:700;color:var(--gray-700);"><?php echo e($pctFinance); ?>%</span>
                            </div>
                        </div>
                    </div>

                    
                    <table class="projets-table">
                        <thead>
                            <tr>
                                <th>Activité</th>
                                <th>Début</th>
                                <th>Fin</th>
                                <th>Montant demandé</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $projet->activites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $planStatutClass = ['en_attente'=>'status-gray','financee'=>'status-green','en_cours'=>'status-blue','termine'=>'status-teal','annule'=>'status-red'][$plan->statutActivite] ?? 'status-gray';
                                $planStatutLabel = ['en_attente'=>'En attente','financee'=>'Financée','en_cours'=>'En cours','termine'=>'Terminée','annule'=>'Annulée'][$plan->statutActivite] ?? $plan->statutActivite;
                            ?>
                            <tr>
                                <td>
                                    <span style="font-weight:600;color:var(--gray-900);font-size:.84rem;"><?php echo e($plan->activite); ?></span>
                                    <?php if($plan->descriptionActivite): ?>
                                    <br><span style="font-size:.74rem;color:var(--gray-400);"><?php echo e(Str::limit($plan->descriptionActivite, 60)); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="td-muted"><?php echo e(optional($plan->dateDebut)->format('d/m/Y') ?? '—'); ?></td>
                                <td class="td-muted"><?php echo e(optional($plan->dateFin)->format('d/m/Y') ?? '—'); ?></td>
                                <td class="td-budget"><?php echo e($plan->montantDemande ? number_format($plan->montantDemande, 0, ',', ' ') . ' F' : '—'); ?></td>
                                <td><span class="status-badge <?php echo e($planStatutClass); ?>"><?php echo e($planStatutLabel); ?></span></td>
                                <td>
                                    <button type="button"
                                            class="btn-icon"
                                            title="Changer le statut"
                                            onclick="openActiviteModal(<?php echo e($plan->id); ?>, '<?php echo e($plan->statutActivite); ?>', '<?php echo e(addslashes($plan->activite)); ?>')">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="form-card-body">
                    <div class="doc-empty-state">
                        <i class="fas fa-calendar"></i>
                        <span>Aucune activité planifiée.</span>
                    </div>
                </div>
                <?php endif; ?>
            </div>

        </div>

        
        <div class="show-col-side">

            
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-coins"></i>
                    <span>Budget</span>
                </div>
                <div class="form-card-body">
                    <div class="budget-display">
                        <span class="budget-label-sm">Budget total</span>
                        <span class="budget-value">
                            <?php echo e($projet->budgetTotal ? number_format($projet->budgetTotal, 0, ',', ' ') . ' F CFA' : '—'); ?>

                        </span>
                    </div>
                    <?php if($projet->montantDemande): ?>
                    <div class="budget-display">
                        <span class="budget-label-sm">Montant demandé</span>
                        <span class="budget-value-sm"><?php echo e(number_format($projet->montantDemande, 0, ',', ' ')); ?> F CFA</span>
                    </div>
                    <?php endif; ?>
                    <?php if($projet->activites->count()): ?>
                    <div class="budget-display">
                        <span class="budget-label-sm">Total planifié</span>
                        <span class="budget-value-sm">
                            <?php echo e(number_format($projet->activites->sum('montantDemande'), 0, ',', ' ')); ?> F CFA
                        </span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-paperclip"></i>
                    <span>Documents (<?php echo e($projet->documents->count()); ?>)</span>
                </div>
                <div class="form-card-body">
                    <?php $__empty_1 = true; $__currentLoopData = $projet->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="doc-existing-item">
                        <?php
                            $ext  = pathinfo($doc->nomFichier, PATHINFO_EXTENSION);
                            $icon = in_array($ext, ['pdf']) ? 'fa-file-pdf'
                                    : (in_array($ext, ['doc','docx']) ? 'fa-file-word'
                                    : (in_array($ext, ['xls','xlsx']) ? 'fa-file-excel'
                                    : (in_array($ext, ['jpg','jpeg','png']) ? 'fa-file-image'
                                    : 'fa-file-alt')));
                        ?>
                        <i class="fas <?php echo e($icon); ?>"></i>
                        <span class="doc-file-name"><?php echo e($doc->nomFichier); ?></span>
                        <span class="doc-badge"><?php echo e($doc->typeDocument); ?></span>
                        <a href="<?php echo e(route('approbateur.projets.documents.download', [$projet, $doc])); ?>"
                            class="doc-action-link" title="Télécharger">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="info-empty">Aucun document joint.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>


<div id="modalApprouver" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h2 class="modal-title">
                <i class="fas fa-check-circle"></i> Approuver le projet
            </h2>
            <button type="button" class="modal-close" onclick="closeModal('modalApprouver')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="<?php echo e(route('approbateur.projets.approuver', $projet)); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-body">
                <p style="font-size:.88rem;color:#374151;">
                    Confirmez-vous l'approbation du projet <strong><?php echo e($projet->titre); ?></strong> ?
                    Il sera transmis au validateur.
                </p>
                <div class="form-col form-col-full mt-3">
                    <label class="field-label">Commentaire <small class="text-muted">(optionnel)</small></label>
                    <textarea name="commentaire" rows="2"
                                class="field-input field-textarea"
                                placeholder="Message pour le porteur..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalApprouver')">Annuler</button>
                <button type="submit" class="btn-save" style="background:#16a34a;border-color:#16a34a;">
                    <i class="fas fa-check-circle"></i> Confirmer l'approbation
                </button>
            </div>
        </form>
    </div>
</div>


<div id="modalRejeter" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h2 class="modal-title" style="color:#dc2626;">
                <i class="fas fa-times-circle"></i> Rejeter le projet
            </h2>
            <button type="button" class="modal-close" onclick="closeModal('modalRejeter')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="<?php echo e(route('approbateur.projets.rejeter', $projet)); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-body">

                <div class="form-col form-col-full">
                    <label class="field-label">Motif du rejet <span class="required">*</span></label>
                    <textarea name="motifRejet" rows="3"
                              class="field-input field-textarea <?php $__errorArgs = ['motifRejet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                              placeholder="Expliquez la raison du rejet..." required><?php echo e(old('motifRejet')); ?></textarea>
                    <?php $__errorArgs = ['motifRejet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-col form-col-full" style="margin-top:14px;">
                    <label class="field-label">Demander des modifications au porteur <small class="text-muted">(optionnel)</small></label>
                    <textarea name="messageModification" rows="2"
                              class="field-input field-textarea"
                              placeholder="Instructions pour la correction..."><?php echo e(old('messageModification')); ?></textarea>
                    <small style="color:#9ca3af;font-size:.72rem;">
                        Si renseigné, le projet reviendra en brouillon avec ce message visible par le porteur.
                    </small>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalRejeter')">Annuler</button>
                <button type="submit" class="btn-save" style="background:#dc2626;border-color:#dc2626;">
                    <i class="fas fa-times-circle"></i> Confirmer le rejet
                </button>
            </div>
        </form>
    </div>
</div>


<?php if($projet->commentaires->count() > 0): ?>
<div class="form-card mt-3">
    <div class="form-card-header">
        <i class="fas fa-comments"></i>
        <span>Historique des actions (<?php echo e($projet->commentaires->count()); ?>)</span>
    </div>
    <div class="form-card-body">
        <div class="timeline">
            <?php $__currentLoopData = $projet->commentaires->sortByDesc('dateEnvoi'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commentaire): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $icons  = ['approbation'=>'fa-check-circle','rejet'=>'fa-times-circle','demande'=>'fa-exclamation-circle','info'=>'fa-info-circle'];
                $colors = ['approbation'=>'#16a34a','rejet'=>'#dc2626','demande'=>'#d97706','info'=>'#2563eb'];
                $icon   = $icons[$commentaire->typeCommentaire]  ?? 'fa-comment';
                $color  = $colors[$commentaire->typeCommentaire] ?? '#6b7280';
            ?>
            <div class="timeline-item">
                <div class="timeline-icon" style="background:<?php echo e($color); ?>15;color:<?php echo e($color); ?>;">
                    <i class="fas <?php echo e($icon); ?>"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-header">
                        <span class="timeline-author"><?php echo e(optional($commentaire->utilisateur)->nomComplet ?? '—'); ?></span>
                        <span class="timeline-date"><?php echo e($commentaire->dateEnvoi->format('d/m/Y à H:i')); ?></span>
                    </div>
                    <p class="timeline-message"><?php echo e($commentaire->message); ?></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
function openModal(id) {
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = '';
}
document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});

<?php if($errors->has('motifRejet')): ?>
    openModal('modalRejeter');
<?php endif; ?>

function openActiviteModal(planId, currentStatut, activiteNom) {
    document.getElementById('activiteNomLabel').textContent = activiteNom;
    document.getElementById('selectStatutActivite').value = currentStatut;
    document.getElementById('formActiviteStatut').action =
        '<?php echo e(url("approbateur/projets/" . $projet->id . "/activites")); ?>/' + planId + '/statut';
    openModal('modalActivite');
}
</script>
<?php $__env->stopPush(); ?>


<div class="modal-overlay" id="modalActivite">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fas fa-exchange-alt" style="color:var(--primary);margin-right:6px;"></i> Statut de l'activité</h3>
            <button type="button" class="modal-close" onclick="closeModal('modalActivite')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" id="formActiviteStatut" action="">
            <?php echo csrf_field(); ?>
            <div class="modal-body">
                <p style="font-size:.82rem;color:var(--gray-500);margin-bottom:14px;">
                    Activité : <strong id="activiteNomLabel" style="color:var(--gray-900);"></strong>
                </p>
                <div class="form-col">
                    <label class="field-label">Nouveau statut <span class="required">*</span></label>
                    <select name="statutActivite" id="selectStatutActivite" class="field-input" required>
                        <option value="en_attente">En attente</option>
                        <option value="financee">Financée</option>
                        <option value="en_cours">En cours</option>
                        <option value="termine">Terminée</option>
                        <option value="annule">Annulée</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalActivite')">Annuler</button>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/approbateur/projets/show.blade.php ENDPATH**/ ?>