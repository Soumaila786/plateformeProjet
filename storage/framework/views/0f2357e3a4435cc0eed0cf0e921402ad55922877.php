<?php $__env->startSection('title', 'Examen — ' . $projet->titre); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/approbateur.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="aprob-page">

    
    <div class="aprob-breadcrumb">
        <a href="<?php echo e(route('approbateur.dashboard')); ?>"><i class="fas fa-home"></i></a>
        <span>/</span>
        <a href="<?php echo e(route('approbateur.projets.index')); ?>">Projets</a>
        <span>/</span>
        <span><?php echo e($projet->codeProjet); ?></span>
    </div>

    
    <?php if(session('success')): ?>
    <div class="aprob-alert aprob-alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <?php
        $stMap = [
            'soumis'    => ['lbl'=>'Soumis',    'cls'=>'aprob-badge-soumis',    'dot'=>'#6366f1'],
            'en_examen' => ['lbl'=>'En examen', 'cls'=>'aprob-badge-en_examen', 'dot'=>'#f97316'],
            'approuve'  => ['lbl'=>'Approuvé',  'cls'=>'aprob-badge-approuve',  'dot'=>'#22c55e'],
            'rejete'    => ['lbl'=>'Rejeté',    'cls'=>'aprob-badge-rejete',    'dot'=>'#ef4444'],
            'valide'    => ['lbl'=>'Validé',    'cls'=>'aprob-badge-valide',    'dot'=>'#0d9488'],
            'brouillon' => ['lbl'=>'Brouillon', 'cls'=>'aprob-badge-brouillon', 'dot'=>'#9ca3af'],
        ];
        $s = $stMap[$projet->statutProjet] ?? $stMap['soumis'];
    ?>

    <div class="aprob-header">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;flex-wrap:wrap;">
                <span style="font-size:.7rem;font-weight:700;color:var(--aprob-text-light);
                             text-transform:uppercase;letter-spacing:.05em;
                             background:var(--aprob-bg-gray);padding:3px 10px;border-radius:20px;">
                    <?php echo e($projet->codeProjet); ?>

                </span>
                <span class="aprob-badge <?php echo e($s['cls']); ?>">
                    <span class="aprob-dot" style="background:<?php echo e($s['dot']); ?>;"></span>
                    <?php echo e($s['lbl']); ?>

                </span>
            </div>
            <h1 class="aprob-header-title"><?php echo e($projet->titre); ?></h1>
            <p class="aprob-header-sub" style="display:flex;gap:14px;flex-wrap:wrap;margin-top:4px;">
                <span><i class="fas fa-user" style="margin-right:4px;"></i><?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?></span>
                <span><i class="fas fa-tag" style="margin-right:4px;"></i><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></span>
                <?php if($projet->dateSoumission): ?>
                <span><i class="fas fa-calendar" style="margin-right:4px;"></i>Soumis le <?php echo e($projet->dateSoumission->format('d/m/Y')); ?></span>
                <?php endif; ?>
            </p>
        </div>
        <a href="<?php echo e(route('approbateur.projets.index')); ?>" class="aprob-btn-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    
    <div class="aprob-actions-bar">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('examiner', $projet)): ?>
        <form method="POST" action="<?php echo e(route('approbateur.projets.examiner', $projet)); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="aprob-btn aprob-btn-orange">
                <i class="fas fa-search"></i> Mettre en examen
            </button>
        </form>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approuver', $projet)): ?>
        <button type="button" class="aprob-btn aprob-btn-green"
                onclick="openModal('modalApprouver')">
            <i class="fas fa-check-circle"></i> Approuver
        </button>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rejeter', $projet)): ?>
        <button type="button" class="aprob-btn aprob-btn-red"
                onclick="openModal('modalRejeter')">
            <i class="fas fa-times-circle"></i> Rejeter
        </button>
        <?php endif; ?>

        <a href="<?php echo e(route('approbateur.projets.export.pdf', $projet)); ?>"
           class="aprob-btn aprob-btn-gray" target="_blank">
            <i class="fas fa-file-pdf"></i> Exporter PDF
        </a>
    </div>

    
    <div class="aprob-show-grid">

        
        <div class="aprob-show-main">

            
            <div class="aprob-info-card">
                <div class="aprob-info-card-head">
                    <span class="aprob-info-card-title">
                        <i class="fas fa-info-circle"></i> Informations générales
                    </span>
                </div>
                <div class="aprob-info-grid">
                    <div>
                        <p class="aprob-info-lbl">Secteur</p>
                        <p class="aprob-info-val"><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="aprob-info-lbl">Durée</p>
                        <p class="aprob-info-val"><?php echo e($projet->duree ? $projet->duree.' mois' : '—'); ?></p>
                    </div>
                    <div>
                        <p class="aprob-info-lbl">Date début</p>
                        <p class="aprob-info-val"><?php echo e(optional($projet->dateDebut)->format('d/m/Y') ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="aprob-info-lbl">Date fin</p>
                        <p class="aprob-info-val"><?php echo e(optional($projet->dateFin)->format('d/m/Y') ?? '—'); ?></p>
                    </div>
                    <?php if($projet->objectif): ?>
                    <div class="aprob-info-full">
                        <p class="aprob-info-lbl">Objectif</p>
                        <p class="aprob-info-val"><?php echo e($projet->objectif); ?></p>
                    </div>
                    <?php endif; ?>
                    <div class="aprob-info-full">
                        <p class="aprob-info-lbl">Description</p>
                        <p class="aprob-info-val" style="white-space:pre-line;"><?php echo e($projet->description ?? '—'); ?></p>
                    </div>
                </div>
            </div>

            
            <div class="aprob-info-card">
                <div class="aprob-info-card-head">
                    <span class="aprob-info-card-title">
                        <i class="fas fa-tasks"></i> Planification
                        <span class="aprob-info-count"><?php echo e($projet->planifications->count()); ?></span>
                    </span>
                </div>

                <?php $__empty_1 = true; $__currentLoopData = $projet->planifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="aprob-activite-card">
                    <div class="aprob-activite-head">
                        <div class="aprob-activite-num"><?php echo e($loop->iteration); ?></div>
                        <p class="aprob-activite-titre"><?php echo e($plan->activitePlanification); ?></p>
                        <?php if($plan->coutEstimatif): ?>
                        <span class="aprob-activite-cout">
                            <i class="fas fa-coins" style="font-size:.6rem;"></i>
                            <?php echo e(number_format($plan->coutEstimatif, 0, ',', ' ')); ?> F CFA
                        </span>
                        <?php endif; ?>
                    </div>

                    <div class="aprob-activite-details">
                        <?php if($plan->indicateur): ?>
                        <div>
                            <span class="aprob-activite-detail-lbl">Indicateur : </span>
                            <span class="aprob-activite-detail-val">
                                <?php echo e($plan->indicateur); ?>

                                <?php if($plan->uniteIndicateur): ?> (<?php echo e($plan->uniteIndicateur); ?>) <?php endif; ?>
                            </span>
                        </div>
                        <?php endif; ?>
                        <?php if($plan->periode): ?>
                        <div>
                            <span class="aprob-activite-detail-lbl">Période : </span>
                            <span class="aprob-activite-detail-val"><?php echo e($plan->periode); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if($plan->resultatsAttendues): ?>
                        <div class="aprob-activite-detail-full">
                            <span class="aprob-activite-detail-lbl">Résultats attendus : </span>
                            <span class="aprob-activite-detail-val"><?php echo e($plan->resultatsAttendues); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="aprob-empty" style="padding:24px;">
                    <i class="fas fa-calendar-plus"></i>
                    <p>Aucune activité planifiée pour ce projet.</p>
                </div>
                <?php endif; ?>

                <?php if($projet->planifications->count() > 0): ?>
                <div class="aprob-total-bar">
                    <span class="aprob-total-label">Total estimé :</span>
                    <span class="aprob-total-val">
                        <?php echo e(number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ')); ?> F CFA
                    </span>
                </div>
                <?php endif; ?>
            </div>

            
            <?php if($projet->documents->count()): ?>
            <div class="aprob-info-card">
                <div class="aprob-info-card-head">
                    <span class="aprob-info-card-title">
                        <i class="fas fa-paperclip"></i> Documents
                        <span class="aprob-info-count"><?php echo e($projet->documents->count()); ?></span>
                    </span>
                </div>
                <div class="aprob-docs-list">
                    <?php $__currentLoopData = $projet->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(asset('storage/'.$doc->cheminFichier)); ?>" target="_blank" class="aprob-doc-item">
                        <i class="fas fa-file-alt"></i>
                        <span><?php echo e($doc->nomFichier ?? basename($doc->cheminFichier)); ?></span>
                        <i class="fas fa-external-link-alt" style="font-size:.65rem;color:var(--aprob-text-light);"></i>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if($projet->commentaires->count()): ?>
            <div class="aprob-info-card">
                <div class="aprob-info-card-head">
                    <span class="aprob-info-card-title">
                        <i class="fas fa-comments"></i> Historique
                        <span class="aprob-info-count"><?php echo e($projet->commentaires->count()); ?></span>
                    </span>
                </div>
                <div class="aprob-comments-list">
                    <?php $__currentLoopData = $projet->commentaires->sortByDesc('dateEnvoi'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $com): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $comMap = [
                            'approbation' => ['icon'=>'fa-check-circle',       'color'=>'#16a34a'],
                            'rejet'       => ['icon'=>'fa-times-circle',       'color'=>'#dc2626'],
                            'demande'     => ['icon'=>'fa-exclamation-circle', 'color'=>'#d97706'],
                            'info'        => ['icon'=>'fa-info-circle',        'color'=>'#2563eb'],
                        ];
                        $cm = $comMap[$com->typeCommentaire] ?? ['icon'=>'fa-comment','color'=>'#6b7280'];
                    ?>
                    <div class="aprob-comment-item">
                        <div class="aprob-comment-avatar" style="background:<?php echo e($cm['color']); ?>18;color:<?php echo e($cm['color']); ?>;">
                            <i class="fas <?php echo e($cm['icon']); ?>"></i>
                        </div>
                        <div class="aprob-comment-body">
                            <div class="aprob-comment-head">
                                <span class="aprob-comment-role"><?php echo e(optional($com->utilisateur)->role ?? '—'); ?></span>
                                <span class="aprob-comment-date"><?php echo e(optional($com->dateEnvoi)->format('d/m/Y H:i')); ?></span>
                            </div>
                            <p class="aprob-comment-text"><?php echo e($com->message); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

        </div>

        
        <div class="aprob-show-aside">

            
            <div class="aprob-aside-card">
                <p class="aprob-aside-title"><i class="fas fa-wallet"></i> Budget</p>
                <div class="aprob-fin-rows">
                    <div class="aprob-fin-row">
                        <span>Budget total</span>
                        <strong><?php echo e(number_format($projet->budgetTotal ?? 0, 0, ',', ' ')); ?> F CFA</strong>
                    </div>
                    <div class="aprob-fin-row">
                        <span>Montant demandé</span>
                        <strong><?php echo e(number_format($projet->montantDemande ?? 0, 0, ',', ' ')); ?> F CFA</strong>
                    </div>
                    <div class="aprob-fin-row">
                        <span>Durée</span>
                        <strong><?php echo e($projet->duree ?? '—'); ?> mois</strong>
                    </div>
                    <?php if($projet->planifications->count()): ?>
                    <div class="aprob-fin-row">
                        <span>Coût planifié</span>
                        <strong style="color:var(--aprob-primary);">
                            <?php echo e(number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ')); ?> F CFA
                        </strong>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="aprob-aside-card">
                <p class="aprob-aside-title"><i class="fas fa-user"></i> Porteur</p>
                <div class="aprob-porteur-block">
                    <div class="aprob-porteur-avatar">
                        <?php echo e(strtoupper(substr(optional($projet->porteur)->nomComplet ?? 'P', 0, 1))); ?>

                    </div>
                    <div>
                        <p class="aprob-porteur-name"><?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?></p>
                        <p class="aprob-porteur-email"><?php echo e(optional($projet->porteur)->email ?? '—'); ?></p>
                    </div>
                </div>
            </div>

            
            <?php if(in_array($projet->statutProjet, ['soumis','en_examen'])): ?>
            <div class="aprob-aside-card aprob-decision-card">
                <p class="aprob-aside-title" style="color:var(--aprob-primary-hover);">
                    <i class="fas fa-gavel"></i> Décision
                </p>
                <p style="font-size:.73rem;color:var(--aprob-text-muted);margin:0 0 10px;">
                    Approuvez ou rejetez après examen complet.
                </p>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approuver', $projet)): ?>
                <button onclick="openModal('modalApprouver')"
                        class="aprob-btn aprob-btn-green"
                        style="width:100%;justify-content:center;margin-bottom:8px;">
                    <i class="fas fa-check-circle"></i> Approuver
                </button>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rejeter', $projet)): ?>
                <button onclick="openModal('modalRejeter')"
                        class="aprob-btn aprob-btn-red"
                        style="width:100%;justify-content:center;">
                    <i class="fas fa-times-circle"></i> Rejeter
                </button>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            
            <?php if(in_array($projet->statutProjet, ['approuve','rejete','valide'])): ?>
            <div class="aprob-aside-card">
                <p class="aprob-aside-title"><i class="fas fa-flag-checkered"></i> Décision finale</p>
                <div class="aprob-decision-badge <?php echo e(in_array($projet->statutProjet, ['approuve','valide']) ? 'aprob-decision-valide' : 'aprob-decision-rejete'); ?>">
                    <i class="fas <?php echo e($projet->statutProjet === 'rejete' ? 'fa-times-circle' : 'fa-check-circle'); ?>"></i>
                    Projet <?php echo e($s['lbl']); ?>

                </div>
                <?php if($projet->dateApprobation): ?>
                <p class="aprob-decision-date">
                    <i class="fas fa-calendar-check"></i>
                    <?php echo e(optional($projet->dateApprobation)->format('d/m/Y')); ?>

                </p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </div>
    </div>

</div>


<div id="modalApprouver" class="aprob-modal-overlay">
    <div class="aprob-modal-box">
        <div class="aprob-modal-head">
            <h3 class="aprob-modal-title">
                <i class="fas fa-check-circle" style="color:#22c55e;"></i> Approuver le projet
            </h3>
            <button onclick="closeModal('modalApprouver')" class="aprob-modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="<?php echo e(route('approbateur.projets.approuver', $projet)); ?>">
            <?php echo csrf_field(); ?>
            <div class="aprob-modal-body">
                <p style="font-size:.82rem;color:#6b7280;margin:0;">
                    Le projet sera transmis au validateur.
                </p>
                <div class="aprob-form-group">
                    <label class="aprob-form-label">Commentaire (optionnel)</label>
                    <textarea name="commentaire" class="aprob-form-textarea" rows="3"
                              placeholder="Observations..."></textarea>
                </div>
            </div>
            <div class="aprob-modal-foot">
                <button type="button" onclick="closeModal('modalApprouver')"
                        class="aprob-btn aprob-btn-gray">Annuler</button>
                <button type="submit" class="aprob-btn aprob-btn-green">
                    <i class="fas fa-check-circle"></i> Confirmer
                </button>
            </div>
        </form>
    </div>
</div>


<div id="modalRejeter" class="aprob-modal-overlay">
    <div class="aprob-modal-box">
        <div class="aprob-modal-head">
            <h3 class="aprob-modal-title">
                <i class="fas fa-times-circle" style="color:#ef4444;"></i> Rejeter le projet
            </h3>
            <button onclick="closeModal('modalRejeter')" class="aprob-modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="<?php echo e(route('approbateur.projets.rejeter', $projet)); ?>">
            <?php echo csrf_field(); ?>
            <div class="aprob-modal-body">
                <div class="aprob-form-group">
                    <label class="aprob-form-label">Motif du rejet <span style="color:#ef4444;">*</span></label>
                    <textarea name="motifRejet" class="aprob-form-textarea danger" rows="3"
                              placeholder="Expliquez le motif..." required></textarea>
                    <?php $__errorArgs = ['motifRejet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="aprob-form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="aprob-modal-foot">
                <button type="button" onclick="closeModal('modalRejeter')"
                        class="aprob-btn aprob-btn-gray">Annuler</button>
                <button type="submit" class="aprob-btn aprob-btn-red">
                    <i class="fas fa-times-circle"></i> Confirmer le rejet
                </button>
            </div>
        </form>
    </div>
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
document.querySelectorAll('.aprob-modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/approbateur/projets/show.blade.php ENDPATH**/ ?>