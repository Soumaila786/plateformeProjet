<?php $__env->startSection('title', 'Examen — ' . $projet->titre); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/approbDash.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="vpage">


<div class="breadcrumb mb-3">
    <a href="<?php echo e(route('approbateur.dashboard')); ?>"><i class="fas fa-home"></i></a>
    <span>/</span>
    <a href="<?php echo e(route('approbateur.projets.index')); ?>">Projets</a>
    <span>/</span>
    <span><?php echo e($projet->codeProjet); ?></span>
</div>


<?php
    $map = [
        'soumis'    => ['lbl'=>'Soumis',   'dot'=>'#6366f1','bg'=>'#eef2ff','color'=>'#4338ca'],
        'en_examen' => ['lbl'=>'En examen','dot'=>'#f97316','bg'=>'#fff7ed','color'=>'#c2410c'],
        'approuve'  => ['lbl'=>'Approuvé', 'dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d'],
        'rejete'    => ['lbl'=>'Rejeté',   'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c'],
        'valide'    => ['lbl'=>'Validé',   'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e'],
        'brouillon' => ['lbl'=>'Brouillon','dot'=>'#9ca3af','bg'=>'#f3f4f6','color'=>'#6b7280'],
    ];
    $s = $map[$projet->statutProjet] ?? $map['soumis'];
?>

<div class="show-header mb-4 mt-4">
    <div>
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
            <span class="proj-code"><?php echo e($projet->codeProjet); ?></span>
            <span class="status-badge" style="background:<?php echo e($s['bg']); ?>;color:<?php echo e($s['color']); ?>;">
                <span class="dot" style="background:<?php echo e($s['dot']); ?>;"></span><?php echo e($s['lbl']); ?>

            </span>
        </div>
        <h1 class="show-title"><?php echo e($projet->titre); ?></h1>
        <div class="show-meta">
            <span><i class="fas fa-user"></i> <?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?></span>
            <span><i class="fas fa-tag"></i> <?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></span>
            <span><i class="fas fa-calendar"></i> Soumis le <?php echo e(optional($projet->dateSoumission)->format('d/m/Y') ?? '—'); ?></span>
        </div>
    </div>
    <a href="<?php echo e(route('approbateur.projets.index')); ?>" class="btn-back">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>


<div class="actions-bar mb-4 mt-4">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('examiner', $projet)): ?>
    <form method="POST" action="<?php echo e(route('approbateur.projets.examiner', $projet)); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="action-btn action-orange">
            <i class="fas fa-search"></i> Mettre en examen
        </button>
    </form>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approuver', $projet)): ?>
    <button type="button" class="action-btn action-green" onclick="openModal('modalApprouver')">
        <i class="fas fa-check-circle"></i> Approuver
    </button>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rejeter', $projet)): ?>
    <button type="button" class="action-btn action-red" onclick="openModal('modalRejeter')">
        <i class="fas fa-times-circle"></i> Rejeter
    </button>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gererPlanification', $projet)): ?>
    <a href="<?php echo e(route('approbateur.planification.create', $projet)); ?>" class="action-btn action-indigo">
        <i class="fas fa-plus"></i> Ajouter une activité
    </a>
    <?php endif; ?>

    
    <a href="<?php echo e(route('approbateur.projets.export.pdf', $projet)); ?>"
        class="action-btn" style="background:#f3f4f6;color:#374151;border:1px solid #e5e7eb;"
        target="_blank">
        <i class="fas fa-file-pdf"></i> Exporter PDF
    </a>
</div>


<div class="show-grid">

    
    <div class="show-main">

        
        <div class="info-card">
            <h4 class="info-title"><i class="fas fa-info-circle"></i> Informations générales</h4>
            <div class="info-grid-2">
                <div class="info-item">
                    <p class="info-lbl">Secteur</p>
                    <p class="info-val"><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></p>
                </div>
                <div class="info-item">
                    <p class="info-lbl">Durée</p>
                    <p class="info-val"><?php echo e($projet->duree ? $projet->duree.' mois' : '—'); ?></p>
                </div>
                <div class="info-item">
                    <p class="info-lbl">Date début</p>
                    <p class="info-val"><?php echo e(optional($projet->dateDebut)->format('d/m/Y') ?? '—'); ?></p>
                </div>
                <div class="info-item">
                    <p class="info-lbl">Date fin</p>
                    <p class="info-val"><?php echo e(optional($projet->dateFin)->format('d/m/Y') ?? '—'); ?></p>
                </div>
                <div class="info-item info-full">
                    <p class="info-lbl">Objectif</p>
                    <p class="info-val"><?php echo e($projet->objectif ?? '—'); ?></p>
                </div>
                <div class="info-item info-full">
                    <p class="info-lbl">Description</p>
                    <p class="info-val" style="white-space:pre-line;"><?php echo e($projet->description ?? '—'); ?></p>
                </div>
            </div>
        </div>

        
        <div class="info-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                <h4 class="info-title" style="margin:0;">
                    <i class="fas fa-tasks"></i> Planification
                    <span class="info-count"><?php echo e($projet->planifications->count()); ?></span>
                </h4>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gererPlanification', $projet)): ?>
                <a href="<?php echo e(route('approbateur.planification.create', $projet)); ?>"
                    class="btn-voir" style="background:#eef2ff;color:#6366f1;width:auto;padding:5px 10px;border-radius:7px;font-size:.74rem;font-weight:700;text-decoration:none;">
                    <i class="fas fa-plus"></i> Ajouter
                </a>
                <?php endif; ?>
            </div>

            <?php $__empty_1 = true; $__currentLoopData = $projet->planifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="activite-item">
                <div class="activite-head">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div class="activite-num"><?php echo e($loop->iteration); ?></div>
                        <p class="activite-titre"><?php echo e($plan->activitePlanification); ?></p>
                    </div>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gererPlanification', $projet)): ?>
                    <div style="display:flex;gap:6px;">
                        <a href="<?php echo e(route('approbateur.planification.edit', [$projet, $plan])); ?>"
                            class="btn-voir" style="background:#eef2ff;color:#6366f1;">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form method="POST"
                                action="<?php echo e(route('approbateur.planification.destroy', [$projet, $plan])); ?>"
                                onsubmit="return confirm('Supprimer cette activité ?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-voir" style="background:#fef2f2;color:#dc2626;border:none;cursor:pointer;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="info-grid-2" style="margin-top:8px;">
                    <?php if($plan->indicateur): ?>
                    <div class="info-item">
                        <p class="info-lbl">Indicateur</p>
                        <p class="info-val"><?php echo e($plan->indicateur); ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if($plan->uniteIndicateur): ?>
                    <div class="info-item">
                        <p class="info-lbl">Unité</p>
                        <p class="info-val"><?php echo e($plan->uniteIndicateur); ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if($plan->periode): ?>
                    <div class="info-item">
                        <p class="info-lbl">Période</p>
                        <p class="info-val"><?php echo e($plan->periode); ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if($plan->coutEstimatif): ?>
                    <div class="info-item">
                        <p class="info-lbl">Coût estimatif</p>
                        <p class="info-val" style="font-weight:700;">
                            <?php echo e(number_format($plan->coutEstimatif, 0, ',', ' ')); ?> F CFA
                        </p>
                    </div>
                    <?php endif; ?>
                    <?php if($plan->resultatsAttendues): ?>
                    <div class="info-item info-full">
                        <p class="info-lbl">Résultats attendus</p>
                        <p class="info-val"><?php echo e($plan->resultatsAttendues); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state" style="padding:20px;">
                <i class="fas fa-calendar-plus"></i>
                <p>Aucune activité planifiée pour ce projet.</p>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gererPlanification', $projet)): ?>
                <a href="<?php echo e(route('approbateur.planification.create', $projet)); ?>"
                    class="btn-valider" style="width:auto;padding:8px 16px;margin-top:8px;">
                    <i class="fas fa-plus"></i> Ajouter une activité
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            
            <?php if($projet->planifications->count() > 0): ?>
            <div style="margin-top:10px;padding-top:10px;border-top:1px solid #f3f4f6;
                        display:flex;justify-content:flex-end;">
                <span style="font-size:.8rem;color:#6b7280;">Total estimé :&nbsp;</span>
                <span style="font-size:.85rem;font-weight:800;color:#111827;">
                    <?php echo e(number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ')); ?> F CFA
                </span>
            </div>
            <?php endif; ?>
        </div>

        
        <?php if($projet->documents->count()): ?>
        <div class="info-card">
            <h4 class="info-title">
                <i class="fas fa-paperclip"></i> Documents
                <span class="info-count"><?php echo e($projet->documents->count()); ?></span>
            </h4>
            <div class="docs-list">
                <?php $__currentLoopData = $projet->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(asset('storage/'.$doc->cheminFichier)); ?>" target="_blank" class="doc-item">
                    <i class="fas fa-file-alt"></i>
                    <span><?php echo e($doc->nomFichier ?? basename($doc->cheminFichier)); ?></span>
                    <i class="fas fa-external-link-alt doc-ext"></i>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        
        <?php if($projet->commentaires->count()): ?>
        <div class="info-card">
            <h4 class="info-title">
                <i class="fas fa-comments"></i> Historique
                <span class="info-count"><?php echo e($projet->commentaires->count()); ?></span>
            </h4>
            <div class="comments-list">
                <?php $__currentLoopData = $projet->commentaires->sortByDesc('dateEnvoi'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $com): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $comMap = [
                        'approbation' => ['icon'=>'fa-check-circle',      'color'=>'#16a34a'],
                        'rejet'       => ['icon'=>'fa-times-circle',      'color'=>'#dc2626'],
                        'demande'     => ['icon'=>'fa-exclamation-circle','color'=>'#d97706'],
                        'examen'      => ['icon'=>'fa-search',            'color'=>'#6366f1'],
                        'info'        => ['icon'=>'fa-info-circle',       'color'=>'#2563eb'],
                    ];
                    $cm = $comMap[$com->typeCommentaire] ?? ['icon'=>'fa-comment','color'=>'#6b7280'];
                ?>
                <div class="comment-item">
                    <div class="comment-avatar" style="background:<?php echo e($cm['color']); ?>18;color:<?php echo e($cm['color']); ?>;">
                        <i class="fas <?php echo e($cm['icon']); ?>"></i>
                    </div>
                    <div class="comment-body">
                        <div class="comment-head">
                            <span class="comment-author">
                                <?php echo e(optional($com->utilisateur)->nomComplet ?? '—'); ?>

                                <small style="color:#9ca3af;font-weight:400;">· <?php echo e(optional($com->utilisateur)->role ?? ''); ?></small>
                            </span>
                            <span class="comment-date"><?php echo e(optional($com->dateEnvoi)->format('d/m/Y H:i')); ?></span>
                        </div>
                        <p class="comment-text"><?php echo e($com->message); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

    </div>

    
    <div class="show-aside">

        
        <div class="aside-card">
            <h4 class="info-title"><i class="fas fa-wallet"></i> Budget</h4>
            <div class="fin-rows">
                <div class="fin-row">
                    <span>Budget total</span>
                    <strong><?php echo e(number_format($projet->budgetTotal ?? 0, 0, ',', ' ')); ?> F CFA</strong>
                </div>
                <div class="fin-row">
                    <span>Montant demandé</span>
                    <strong><?php echo e(number_format($projet->montantDemande ?? 0, 0, ',', ' ')); ?> F CFA</strong>
                </div>
                <div class="fin-row">
                    <span>Durée</span>
                    <strong><?php echo e($projet->duree ?? '—'); ?> mois</strong>
                </div>
                <?php if($projet->planifications->count()): ?>
                <div class="fin-row">
                    <span>Coût planifié</span>
                    <strong><?php echo e(number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ')); ?> F CFA</strong>
                </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="aside-card">
            <h4 class="info-title"><i class="fas fa-user"></i> Porteur</h4>
            <div class="porteur-block">
                <div class="porteur-avatar">
                    <?php echo e(strtoupper(substr(optional($projet->porteur)->nomComplet ?? 'P', 0, 1))); ?>

                </div>
                <div>
                    <p class="porteur-name"><?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?></p>
                    <p class="porteur-email"><?php echo e(optional($projet->porteur)->email ?? '—'); ?></p>
                </div>
            </div>
        </div>

        
        <?php if(in_array($projet->statutProjet, ['soumis','en_examen'])): ?>
        <div class="aside-card" style="border-color:#e0e7ff;">
            <h4 class="info-title" style="color:#4338ca;">
                <i class="fas fa-gavel" style="color:#6366f1;"></i> Décision
            </h4>
            <p style="font-size:.74rem;color:#9ca3af;margin:0 0 12px;">
                Approuvez ou rejetez après examen complet.
            </p>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approuver', $projet)): ?>
            <button onclick="openModal('modalApprouver')" class="btn-valider" style="margin-bottom:8px;">
                <i class="fas fa-check-circle"></i> Approuver
            </button>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('rejeter', $projet)): ?>
            <button onclick="openModal('modalRejeter')" class="btn-rejeter">
                <i class="fas fa-times-circle"></i> Rejeter
            </button>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        
        <?php if(in_array($projet->statutProjet, ['approuve','rejete','valide'])): ?>
        <div class="aside-card">
            <h4 class="info-title"><i class="fas fa-flag-checkered"></i> Décision</h4>
            <div class="decision-badge <?php echo e(in_array($projet->statutProjet, ['approuve','valide']) ? 'decision-valide' : 'decision-rejete'); ?>">
                <i class="fas <?php echo e($projet->statutProjet === 'rejete' ? 'fa-times-circle' : 'fa-check-circle'); ?>"></i>
                Projet <?php echo e($s['lbl']); ?>

            </div>
            <?php if($projet->dateApprobation): ?>
            <p class="decision-date">
                <i class="fas fa-calendar-check"></i>
                <?php echo e(optional($projet->dateApprobation)->format('d/m/Y')); ?>

            </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>
</div>

</div>


<div id="modalApprouver" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-head">
            <h3 class="modal-title"><i class="fas fa-check-circle" style="color:#22c55e;"></i> Approuver le projet</h3>
            <button onclick="closeModal('modalApprouver')" class="modal-close"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="<?php echo e(route('approbateur.projets.approuver', $projet)); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-body">
                <p style="font-size:.82rem;color:#6b7280;margin:0 0 12px;">
                    Le projet sera transmis au validateur.
                </p>
                <div class="form-group">
                    <label class="form-label">Commentaire (optionnel)</label>
                    <textarea name="commentaire" class="form-textarea" rows="3"
                              placeholder="Observations..."></textarea>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" onclick="closeModal('modalApprouver')" class="btn-cancel">Annuler</button>
                <button type="submit" class="btn-valider" style="width:auto;padding:9px 20px;">
                    <i class="fas fa-check-circle"></i> Confirmer
                </button>
            </div>
        </form>
    </div>
</div>


<div id="modalRejeter" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-head">
            <h3 class="modal-title"><i class="fas fa-times-circle" style="color:#ef4444;"></i> Rejeter le projet</h3>
            <button onclick="closeModal('modalRejeter')" class="modal-close"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="<?php echo e(route('approbateur.projets.rejeter', $projet)); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Motif du rejet <span style="color:#ef4444;">*</span></label>
                    <textarea name="motifRejet" class="form-textarea form-textarea-danger" rows="3"
                                placeholder="Expliquez le motif..." required></textarea>
                    <?php $__errorArgs = ['motifRejet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                    <label class="form-label">Modifications à apporter (optionnel)</label>
                    <textarea name="messageModification" class="form-textarea" rows="2"
                              placeholder="Indiquez ce qui doit être corrigé..."></textarea>
                    <p style="font-size:.7rem;color:#9ca3af;margin:4px 0 0;">
                        Si renseigné, le projet retourne en brouillon pour correction.
                    </p>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" onclick="closeModal('modalRejeter')" class="btn-cancel">Annuler</button>
                <button type="submit" class="btn-rejeter" style="width:auto;">
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
document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/approbateur/projets/show.blade.php ENDPATH**/ ?>