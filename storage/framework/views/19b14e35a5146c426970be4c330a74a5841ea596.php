<?php $__env->startSection('title', 'Projet — ' . $projet->titre); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/planifDash.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="plan-page">

    
    <div class="plan-breadcrumb">
        <a href="<?php echo e(route('planificateur.dashboard')); ?>"><i class="fas fa-home"></i></a>
        <span>/</span>
        <a href="<?php echo e(route('planificateur.projets.index')); ?>">Projets</a>
        <span>/</span>
        <span><?php echo e($projet->codeProjet); ?></span>
    </div>

    
    <?php if(session('success')): ?>
    <div class="plan-alert plan-alert-success">
        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
    <div class="plan-alert plan-alert-error">
        <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    
    <div class="plan-header">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                <span class="plan-projet-code"><?php echo e($projet->codeProjet); ?></span>
                <?php if($projet->planification_demandee): ?>
                <span class="plan-badge plan-badge-orange">
                    <i class="fas fa-hourglass-half" style="font-size:.6rem;"></i> Planification demandée
                </span>
                <?php else: ?>
                <span class="plan-badge plan-badge-green">
                    <i class="fas fa-check" style="font-size:.6rem;"></i> Planifié
                </span>
                <?php endif; ?>
            </div>
            <h1 class="plan-header-title"><?php echo e($projet->titre); ?></h1>
            <p class="plan-projet-meta" style="margin-top:4px;">
                <span><i class="fas fa-user"></i><?php echo e(optional($projet->user)->nomComplet ?? '—'); ?></span>
                <span><i class="fas fa-tag"></i><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></span>
                <?php if($projet->dateSoumission): ?>
                <span><i class="fas fa-calendar"></i>Soumis le <?php echo e($projet->dateSoumission->format('d/m/Y')); ?></span>
                <?php endif; ?>
            </p>
        </div>
        <a href="<?php echo e(route('planificateur.projets.index')); ?>" class="plan-btn-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    
    <div class="plan-actions-bar">
        <a href="<?php echo e(route('planificateur.planifications.create', $projet)); ?>"
            class="plan-action-btn plan-action-violet">
            <i class="fas fa-plus"></i> Ajouter une activité
        </a>
    </div>

    
    <div class="plan-show-grid">

        
        <div class="plan-show-main">

            
            <div class="plan-info-card">
                <div class="plan-info-card-head">
                    <span class="plan-info-card-title">
                        <i class="fas fa-info-circle"></i> Informations générales
                    </span>
                </div>
                <div class="plan-info-grid">
                    <div>
                        <p class="plan-info-lbl">Secteur</p>
                        <p class="plan-info-val"><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="plan-info-lbl">Durée</p>
                        <p class="plan-info-val"><?php echo e($projet->duree ? $projet->duree.' mois' : '—'); ?></p>
                    </div>
                    <div>
                        <p class="plan-info-lbl">Date début</p>
                        <p class="plan-info-val"><?php echo e(optional($projet->dateDebut)->format('d/m/Y') ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="plan-info-lbl">Date fin</p>
                        <p class="plan-info-val"><?php echo e(optional($projet->dateFin)->format('d/m/Y') ?? '—'); ?></p>
                    </div>
                    <?php if($projet->objectif): ?>
                    <div class="plan-info-full">
                        <p class="plan-info-lbl">Objectif</p>
                        <p class="plan-info-val"><?php echo e($projet->objectif); ?></p>
                    </div>
                    <?php endif; ?>
                    <div class="plan-info-full">
                        <p class="plan-info-lbl">Description</p>
                        <p class="plan-info-val" style="white-space:pre-line;"><?php echo e($projet->description ?? '—'); ?></p>
                    </div>
                </div>
            </div>

            
            <div class="plan-info-card">
                <div class="plan-info-card-head">
                    <span class="plan-info-card-title">
                        <i class="fas fa-tasks"></i>
                        Activités planifiées
                        <span class="plan-info-count"><?php echo e($projet->planifications->count()); ?></span>
                    </span>
                    <a href="<?php echo e(route('planificateur.planifications.create', $projet)); ?>"
                        class="plan-btn plan-btn-outline" style="font-size:.72rem;padding:5px 10px;">
                        <i class="fas fa-plus"></i> Ajouter
                    </a>
                </div>

                <div class="plan-activite-list">
                    <?php $__empty_1 = true; $__currentLoopData = $projet->planifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="plan-activite-item">
                        <div class="plan-activite-head">
                            <div class="plan-activite-left">
                                <div class="plan-activite-num"><?php echo e($loop->iteration); ?></div>
                                <p class="plan-activite-titre"><?php echo e($plan->activitePlanification); ?></p>
                            </div>
                            <div class="plan-activite-actions">
                                <a href="<?php echo e(route('planificateur.planifications.edit', [$projet, $plan])); ?>"
                                    class="plan-btn plan-btn-edit" title="Modifier">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form method="POST"
                                        action="<?php echo e(route('planificateur.planifications.destroy', [$projet, $plan])); ?>"
                                        onsubmit="return confirm('Supprimer cette activité ?')"
                                        style="display:inline;">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="plan-btn plan-btn-del" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="plan-activite-details">
                            <?php if($plan->indicateur): ?>
                            <div>
                                <span class="plan-activite-detail-lbl">Indicateur : </span>
                                <span class="plan-activite-detail-val">
                                    <?php echo e($plan->indicateur); ?>

                                    <?php if($plan->uniteIndicateur): ?> (<?php echo e($plan->uniteIndicateur); ?>) <?php endif; ?>
                                </span>
                            </div>
                            <?php endif; ?>
                            <?php if($plan->periode): ?>
                            <div>
                                <span class="plan-activite-detail-lbl">Période : </span>
                                <span class="plan-activite-detail-val"><?php echo e($plan->periode); ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if($plan->coutEstimatif): ?>
                            <div>
                                <span class="plan-activite-detail-lbl">Coût : </span>
                                <span class="plan-activite-cout">
                                    <?php echo e(number_format($plan->coutEstimatif, 0, ',', ' ')); ?> F CFA
                                </span>
                            </div>
                            <?php endif; ?>
                            <?php if($plan->resultatsAttendues): ?>
                            <div class="plan-activite-detail-full">
                                <span class="plan-activite-detail-lbl">Résultats attendus : </span>
                                <span class="plan-activite-detail-val"><?php echo e($plan->resultatsAttendues); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="plan-empty" style="padding:24px 16px;">
                        <i class="fas fa-calendar-plus"></i>
                        <p>Aucune activité planifiée.</p>
                        <a href="<?php echo e(route('planificateur.planifications.create', $projet)); ?>"
                            class="plan-btn plan-btn-primary" style="margin-top:8px;">
                            <i class="fas fa-plus"></i> Ajouter une activité
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if($projet->planifications->count() > 0): ?>
                <div class="plan-total-bar">
                    <span class="plan-total-label">Total estimé :</span>
                    <span class="plan-total-val">
                        <?php echo e(number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ')); ?> F CFA
                    </span>
                </div>
                <?php endif; ?>
            </div>

            
            <?php if($projet->documents->count()): ?>
            <div class="plan-info-card">
                <div class="plan-info-card-head">
                    <span class="plan-info-card-title">
                        <i class="fas fa-paperclip"></i> Documents
                        <span class="plan-info-count"><?php echo e($projet->documents->count()); ?></span>
                    </span>
                </div>
                <div style="display:flex;flex-direction:column;gap:6px;">
                    <?php $__currentLoopData = $projet->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(asset('storage/'.$doc->cheminFichier)); ?>" target="_blank"
                        style="display:flex;align-items:center;gap:8px;padding:8px 10px;
                                border-radius:var(--plan-radius-md);background:var(--plan-bg-light);
                                border:1px solid var(--plan-border);text-decoration:none;
                                color:var(--plan-text-gray);font-size:.8rem;
                                transition:background var(--plan-transition);"
                        onmouseover="this.style.background='var(--plan-primary-light)'"
                        onmouseout="this.style.background='var(--plan-bg-light)'">
                        <i class="fas fa-file-alt" style="color:var(--plan-primary);"></i>
                        <span style="flex:1;"><?php echo e($doc->nomFichier ?? basename($doc->cheminFichier)); ?></span>
                        <i class="fas fa-external-link-alt" style="font-size:.65rem;color:var(--plan-text-light);"></i>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

        </div>

        
        <div class="plan-show-aside">

            
            <div class="plan-aside-card">
                <p class="plan-aside-title"><i class="fas fa-wallet"></i> Budget</p>
                <div class="plan-fin-rows">
                    <div class="plan-fin-row">
                        <span>Budget total</span>
                        <strong><?php echo e(number_format($projet->budgetTotal ?? 0, 0, ',', ' ')); ?> F CFA</strong>
                    </div>
                    <div class="plan-fin-row">
                        <span>Montant demandé</span>
                        <strong><?php echo e(number_format($projet->montantDemande ?? 0, 0, ',', ' ')); ?> F CFA</strong>
                    </div>
                    <?php if($projet->planifications->count()): ?>
                    <div class="plan-fin-row">
                        <span>Coût planifié</span>
                        <strong style="color:var(--plan-primary);">
                            <?php echo e(number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ')); ?> F CFA
                        </strong>
                    </div>
                    <?php if(($projet->budgetTotal ?? 0) > 0): ?>
                    <?php $pct = min(100, round($projet->planifications->sum('coutEstimatif') / $projet->budgetTotal * 100)); ?>
                    <div class="plan-fin-row" style="border-bottom:none;">
                        <span>Couverture</span>
                        <strong><?php echo e($pct); ?>%</strong>
                    </div>
                    <div style="margin-top:6px;">
                        <div class="plan-progress-bar">
                            <div class="plan-progress-fill" style="width:<?php echo e($pct); ?>%;"></div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="plan-aside-card">
                <p class="plan-aside-title"><i class="fas fa-user"></i> Porteur</p>
                <div class="plan-porteur-block">
                    <div class="plan-porteur-avatar">
                        <?php echo e(strtoupper(substr(optional($projet->user)->nomComplet ?? 'P', 0, 1))); ?>

                    </div>
                    <div>
                        <p class="plan-porteur-name"><?php echo e(optional($projet->user)->nomComplet ?? '—'); ?></p>
                        <p class="plan-porteur-email"><?php echo e(optional($projet->user)->email ?? '—'); ?></p>
                    </div>
                </div>
            </div>

            
            <?php if($projet->dateDebut && $projet->dateFin): ?>
            <div class="plan-aside-card">
                <p class="plan-aside-title"><i class="fas fa-calendar-alt"></i> Calendrier</p>
                <div class="plan-fin-rows">
                    <div class="plan-fin-row">
                        <span>Début</span>
                        <strong><?php echo e($projet->dateDebut->format('d/m/Y')); ?></strong>
                    </div>
                    <div class="plan-fin-row">
                        <span>Fin</span>
                        <strong><?php echo e($projet->dateFin->format('d/m/Y')); ?></strong>
                    </div>
                    <?php if($projet->duree): ?>
                    <div class="plan-fin-row">
                        <span>Durée</span>
                        <strong><?php echo e($projet->duree); ?> mois</strong>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/planificateur/projets/show.blade.php ENDPATH**/ ?>