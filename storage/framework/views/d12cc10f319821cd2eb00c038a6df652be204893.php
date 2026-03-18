<?php $__env->startSection('title', $projet->titre); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="projets-page">

    
    <div class="page-header">
        <a href="<?php echo e(route('porteur.projets.index')); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-header-info">
            <div>
                <h1 class="projets-title"><?php echo e($projet->titre); ?></h1>
                <p class="projets-subtitle"><?php echo e($projet->codeProjet); ?></p>
            </div>
            <?php
                $statusClass = [
                    'brouillon' => 'status-gray',
                    'soumis'    => 'status-blue',
                    'en_examen' => 'status-yellow',
                    'approuve'  => 'status-green',
                    'valide'    => 'status-teal',
                    'rejete'    => 'status-red',
                ][$projet->statutProjet] ?? 'status-gray';
                $statusLabel = [
                    'brouillon' => 'Brouillon',
                    'soumis'    => 'Soumis',
                    'en_examen' => 'En examen',
                    'approuve'  => 'Approuvé',
                    'valide'    => 'Validé',
                    'rejete'    => 'Rejeté',
                ][$projet->statutProjet] ?? $projet->statutProjet;
            ?>
            <span class="status-badge <?php echo e($statusClass); ?> status-lg"><?php echo e($statusLabel); ?></span>
        </div>
        <div class="page-header-actions">
            <?php if($projet->isEditable()): ?>
            <a href="<?php echo e(route('porteur.projets.edit', $projet)); ?>" class="btn-edit-main">
                <i class="fas fa-pencil-alt"></i> Modifier
            </a>
            <?php endif; ?>

            <?php if($projet->isDeletable()): ?>
            <form method="POST" action="<?php echo e(route('porteur.projets.destroy', $projet)); ?>"
                    onsubmit="return confirm('Supprimer définitivement ce projet ?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn-delete-main" title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
            <?php endif; ?>
        </div>
    </div>

    
    <?php
        $dernierRejet = $projet->commentaires->where('typeCommentaire', 'rejet')->last();
        // Si vous utilisez un type différent pour les modifs, adaptez le nom ci-dessous
        $derniereModif = $projet->commentaires->where('typeCommentaire', 'demande')->last();
    ?>

    <?php if($dernierRejet): ?>
        <div class="rejet-banner">
            
            <div class="rejet-banner-block rejet-block-rouge">
                <i class="fas fa-times-circle"></i>
                <div>
                    <p class="rejet-banner-label">Motif du rejet</p>
                    <p class="rejet-banner-text"><?php echo e($dernierRejet->message); ?></p>
                </div>
            </div>

            
            <?php if($derniereModif): ?>
            <div class="rejet-banner-block rejet-block-jaune">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <p class="rejet-banner-label">Modifications demandées par l'approbateur</p>
                    <p class="rejet-banner-text"><?php echo e($derniereModif->message); ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    
    <div class="projet-actions-bar">

        
        <button type="button" class="action-btn action-btn-blue"
                onclick="openModal('modalPlanifier')">
            <i class="fas fa-plus"></i>
            Créer activité
        </button>

        <?php if(!$projet->planification_demandee && !in_array($projet->statutProjet, ['approuve', 'valide'])): ?>

            <form action="<?php echo e(route('porteur.demande.planification', $projet->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-calendar-plus"></i>
                    Demander planification
                </button>
            </form>
        <?php else: ?>
            
        <?php endif; ?>


        
        <?php if($projet->isSubmittable()): ?>
        <form method="POST" action="<?php echo e(route('porteur.projets.soumettre', $projet)); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="action-btn action-btn-indigo"
                    onclick="return confirm('Soumettre ce projet pour approbation ? Vous ne pourrez plus le modifier.')">
                <i class="fas fa-paper-plane"></i>
                Soumettre le projet
            </button>
        </form>
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
                            <span class="info-label">Date de début probable</span>
                            <span class="info-value"><?php echo e(optional($projet->dateDebut)->format('d/m/Y') ?? '—'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de fin probable</span>
                            <span class="info-value"><?php echo e(optional($projet->dateFin)->format('d/m/Y') ?? '—'); ?></span>
                        </div>
                        <?php if($projet->dateApprobation): ?>
                        <div class="info-item">
                            <span class="info-label">Date d'approbation</span>
                            <span class="info-value"><?php echo e($projet->dateApprobation->format('d/m/Y')); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if($projet->dateValidation): ?>
                        <div class="info-item">
                            <span class="info-label">Date de validation</span>
                            <span class="info-value"><?php echo e($projet->dateValidation->format('d/m/Y')); ?></span>
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
                </div>
            </div>

            
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-tasks"></i>
                    <span>Les activites du projet (<?php echo e($projet->activites->count()); ?>)</span>
                    <button type="button" class="card-header-btn"
                            onclick="openModal('modalPlanifier')">
                        <i class="fas fa-plus"></i> Ajouter
                    </button>
                </div>
                <?php if($projet->activites->count()): ?>
                <div class="form-card-body">
                    <div class="plan-cards-grid">
                        <?php $__currentLoopData = $projet->activites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $planStatutClass = ['en_attente'=>'status-gray',
                                                'financee'=>'status-green',
                                                'en_cours'=>'status-blue',
                                                'termine'=>'status-teal',
                                                'annule'=>'status-red'][$plan->statutActivite] ?? 'status-gray';
                            $planStatutLabel = ['en_attente'=>'En attente',
                                                'financee'=>'Financée',
                                                'en_cours'=>'En cours',
                                                'termine'=>'Terminée',
                                                'annule'=>'Annulée'][$plan->statutActivite] ?? $plan->statutActivite;
                            $planIcons = ['en_attente'=>'fa-clock',
                                        'financee'=>'fa-coins',
                                        'en_cours'=>'fa-spinner',
                                        'termine'=>'fa-check-circle',
                                        'annule'=>'fa-times-circle'];
                            $planIcon  = $planIcons[$plan->statutActivite] ?? 'fa-circle';
                        ?>
                        <div class="plan-act-card">
                            <div class="plan-act-top">
                                <div class="plan-act-num"><?php echo e($loop->iteration); ?></div>
                                <span class="status-badge <?php echo e($planStatutClass); ?>">
                                    <i class="fas <?php echo e($planIcon); ?>"></i>
                                    <?php echo e($planStatutLabel); ?>

                                </span>
                                <?php if($projet->isEditable()): ?>
                                <form method="POST"
                                        action="<?php echo e(route('porteur.projets.activites.destroy', [$projet, $plan])); ?>"
                                        onsubmit="return confirm('Supprimer cette activité ?')"
                                        style="margin-left:auto;">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn-icon btn-icon-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>

                            <h4 class="plan-act-titre"><?php echo e($plan->activite); ?></h4>

                            <?php if($plan->descriptionActivite): ?>
                            <p class="plan-act-desc"><?php echo e($plan->descriptionActivite); ?></p>
                            <?php endif; ?>

                            <div class="plan-act-footer">
                                <span class="plan-act-info">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?php echo e(optional($plan->dateDebut)->format('d/m/Y') ?? '—'); ?>

                                    →
                                    <?php echo e(optional($plan->dateFin)->format('d/m/Y') ?? '—'); ?>

                                </span>
                                <?php if($plan->montantDemande): ?>
                                <span class="plan-act-budget">
                                    <i class="fas fa-coins"></i>
                                    <?php echo e(number_format($plan->montantDemande, 0, ',', ' ')); ?> F CFA
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php else: ?>
                <div class="form-card-body">
                    <div class="doc-empty-state">
                        <i class="fas fa-calendar"></i>
                        <span>Aucune activité crée.</span>
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
                        <a href="<?php echo e(route('porteur.projets.documents.download', [$projet, $doc])); ?>"
                            class="doc-action-link" title="Télécharger">
                            <i class="fas fa-download"></i>
                        </a>
                        <form method="POST"
                                action="<?php echo e(route('porteur.projets.documents.destroy', [$projet, $doc])); ?>"
                                onsubmit="return confirm('Supprimer ce document ?')"
                                style="display:inline;">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="doc-action-del" title="Supprimer">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="info-empty">Aucun document joint.</p>
                    <?php endif; ?>

                    
                    <form method="POST"
                            action="<?php echo e(route('porteur.projets.documents.store', $projet)); ?>"
                            enctype="multipart/form-data"
                            class="mt-3"
                            id="formAddDoc">
                        <?php echo csrf_field(); ?>

                        <input type="file"
                                id="newDocuments"
                                name="documents[]"
                                multiple
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                                style="display:none">

                        <div class="doc-toolbar">
                            <button type="button" class="btn-attach"
                                    onclick="document.getElementById('newDocuments').click()">
                                <i class="fas fa-plus"></i> Ajouter des fichiers
                            </button>
                        </div>

                        <p class="doc-hint">PDF, Word, Excel, images — Max 10 Mo par fichier</p>

                        <div id="newFileList" class="doc-file-list" style="display:none"></div>

                        <div id="submitDocBtn" style="display:none; margin-top:10px;">
                            <button type="submit" class="btn-save btn-sm">
                                <i class="fas fa-upload"></i> Enregistrer les fichiers
                            </button>
                            <button type="button" class="btn-cancel btn-sm ms-2"
                                    onclick="resetDocForm()">Annuler</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>


    
    <?php if($projet->planification): ?>

        <div class="form-card" style="margin-top:16px;">
            <div class="form-card-header">
                <i class="fas fa-calendar-check"></i>
                <span>Planification du projet</span>
            </div>

            <div class="form-card-body">

                <div class="info-grid">

                    <div class="info-item">
                        <span class="info-label">Activité</span>
                        <span class="info-value"><?php echo e($projet->planification->activitePlanification); ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Référence</span>
                        <span class="info-value"><?php echo e($projet->planification->reference); ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Indicateur</span>
                        <span class="info-value"><?php echo e($projet->planification->indicateur); ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Unité</span>
                        <span class="info-value"><?php echo e($projet->planification->uniteIndicateur); ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Résultats attendus</span>
                        <span class="info-value"><?php echo e($projet->planification->resultatsAttendues); ?></span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Coût estimatif</span>
                        <span class="info-value">
                            <?php echo e(number_format($projet->planification->coutEstimatif, 0, ',', ' ')); ?> F CFA
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Période</span>
                        <span class="info-value"><?php echo e($projet->planification->periode); ?></span>
                    </div>

                </div>

            </div>
        </div>

        <?php endif; ?>
</div>


<div id="modalPlanifier" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h2 class="modal-title">
                <i class="fas fa-calendar-plus"></i>
                Ajouter une activité
            </h2>
            <button type="button" class="modal-close" onclick="closeModal('modalPlanifier')">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form method="POST" action="<?php echo e(route('porteur.projets.activites.store', $projet)); ?>">
            <?php echo csrf_field(); ?>

            <div class="modal-body">

                <div class="form-col form-col-full">
                    <label class="field-label">Activité <span class="required">*</span></label>
                    <input type="text" name="activite"
                            value="<?php echo e(old('activite')); ?>"
                            class="field-input <?php $__errorArgs = ['activite'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Ex : Analyse des besoins" required>
                    <?php $__errorArgs = ['activite'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-col form-col-full">
                    <label class="field-label">Description</label>
                    <textarea name="descriptionActivite" rows="2"
                                class="field-input field-textarea"
                                placeholder="Détails de l'activité..."><?php echo e(old('descriptionActivite')); ?></textarea>
                </div>

                <div class="modal-row">
                    <div class="form-col">
                        <label class="field-label">Date de début probale <span class="required">*</span></label>
                        <input type="date" name="dateDebut"
                                value="<?php echo e(old('dateDebut')); ?>"
                                class="field-input <?php $__errorArgs = ['dateDebut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <?php $__errorArgs = ['dateDebut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-col">
                        <label class="field-label">Date de fin probale <span class="required">*</span></label>
                        <input type="date" name="dateFin"
                                value="<?php echo e(old('dateFin')); ?>"
                                class="field-input <?php $__errorArgs = ['dateFin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <?php $__errorArgs = ['dateFin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="modal-row">
                    <div class="form-col">
                        <label class="field-label">Montant demandé (F CFA)</label>
                        <input type="number" name="montantDemande"
                                value="<?php echo e(old('montantDemande')); ?>"
                                class="field-input <?php $__errorArgs = ['montantDemande'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="0" min="0" step="1">
                        <?php $__errorArgs = ['montantDemande'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-col">
                        <label class="field-label">Statut</label>
                        <select name="statutActivite" class="field-input">
                            <option value="en_attente" <?php echo e(old('statutActivite','en_attente') == 'en_attente' ? 'selected' : ''); ?>>En attente</option>
                            <option value="annule"     <?php echo e(old('statutActivite') == 'annule'     ? 'selected' : ''); ?>>Annulé</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel"
                        onclick="closeModal('modalPlanifier')">Annuler</button>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>


<?php if($projet->commentaires->count() > 0): ?>
<div class="form-card" style="margin-top:16px;">
    <div class="form-card-header">
        <i class="fas fa-comments"></i>
        <span>Historique des commenataires (<?php echo e($projet->commentaires->count()); ?>)</span>
    </div>

    <div class="form-card-body">
        <div class="timeline">
            <?php $__currentLoopData = $projet->commentaires->sortByDesc('dateEnvoi'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commentaire): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $icons  = [
                    'approbation'=>'fa-check-circle',
                    'rejet'=>'fa-times-circle',
                    'demande'=>'fa-exclamation-circle',
                    'info'=>'fa-info-circle'
                ];

                $colors = [
                    'approbation'=>'#16a34a',
                    'rejet'=>'#dc2626',
                    'demande'=>'#d97706',
                    'info'=>'#2563eb'
                ];

                # En cas de type different on utilise par defaut
                $icon   = $icons[$commentaire->typeCommentaire]  ?? 'fa-comment';
                $color  = $colors[$commentaire->typeCommentaire] ?? '#6b7280';

            ?>
            <div class="timeline-item">
                <div class="timeline-icon" style="background:<?php echo e($color); ?>15;color:<?php echo e($color); ?>;">
                    <i class="fas <?php echo e($icon); ?>"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-header">
                        <span class="timeline-author"><?php echo e(optional($commentaire->utilisateur)->role ?? '—'); ?></span>
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
</div>

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

<?php if($errors->any()): ?>
    openModal('modalPlanifier');
<?php endif; ?>

// ── Gestion ajout documents ──
const newDocInput  = document.getElementById('newDocuments');
const newFileList  = document.getElementById('newFileList');
const submitDocBtn = document.getElementById('submitDocBtn');

if (newDocInput) {
    newDocInput.addEventListener('change', function() {
        const files = Array.from(this.files);
        if (files.length === 0) return;

        newFileList.style.display = 'block';
        submitDocBtn.style.display = 'block';

        newFileList.innerHTML = files.map(f => `
            <div class="doc-file-item">
                <i class="${getDocIcon(f.name)} doc-file-icon"></i>
                <div class="doc-file-info">
                    <span class="doc-file-name">${f.name}</span>
                    <span class="doc-file-size">${formatDocSize(f.size)}</span>
                </div>
                <span class="doc-file-ok"><i class="fas fa-check-circle"></i> Accepté</span>
            </div>
        `).join('');
    });
}

function resetDocForm() {
    if (newDocInput) newDocInput.value = '';
    if (newFileList) { newFileList.innerHTML = ''; newFileList.style.display = 'none'; }
    if (submitDocBtn) submitDocBtn.style.display = 'none';
}

function getDocIcon(name) {
    const ext = name.split('.').pop().toLowerCase();
    if (['pdf'].includes(ext))              return 'fas fa-file-pdf';
    if (['doc','docx'].includes(ext))       return 'fas fa-file-word';
    if (['xls','xlsx'].includes(ext))       return 'fas fa-file-excel';
    if (['jpg','jpeg','png'].includes(ext)) return 'fas fa-file-image';
    return 'fas fa-file-alt';
}

function formatDocSize(b) {
    if (b < 1024)    return b + ' o';
    if (b < 1048576) return (b / 1024).toFixed(1) + ' Ko';
    return (b / 1048576).toFixed(1) + ' Mo';
}

</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/porteur/projets/show.blade.php ENDPATH**/ ?>