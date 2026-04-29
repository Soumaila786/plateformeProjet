<?php $__env->startSection('title', 'Examen — ' . $projet->titre); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/validateur.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="valid-page">

    
    <div class="valid-breadcrumb">
        <a href="<?php echo e(route('validateur.dashboard')); ?>"><i class="fas fa-home"></i></a>
        <span>/</span>
        <a href="<?php echo e(route('validateur.projets.index')); ?>">Projets</a>
        <span>/</span>
        <span><?php echo e($projet->codeProjet); ?></span>
    </div>

    
    <?php if(session('success')): ?>
    <div class="valid-alert valid-alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
    <div class="valid-alert valid-alert-error"><i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?></div>
    <?php endif; ?>

    
    <?php
        $stMap = [
            'approuve' => ['lbl'=>'Approuvé','cls'=>'valid-badge-approuve','dot'=>'#0d9488'],
            'valide'   => ['lbl'=>'Validé',  'cls'=>'valid-badge-valide',  'dot'=>'#15803d'],
            'rejete'   => ['lbl'=>'Rejeté',  'cls'=>'valid-badge-rejete',  'dot'=>'#ef4444'],
        ];
        $s = $stMap[$projet->statutProjet] ?? $stMap['approuve'];
    ?>

    <div class="valid-header">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;flex-wrap:wrap;">
                <span style="font-size:.7rem;font-weight:700;color:var(--valid-text-light);
                             text-transform:uppercase;letter-spacing:.05em;
                             background:var(--valid-bg-gray);padding:3px 10px;border-radius:20px;">
                    <?php echo e($projet->codeProjet); ?>

                </span>
                <span class="valid-badge <?php echo e($s['cls']); ?>">
                    <span class="valid-dot" style="background:<?php echo e($s['dot']); ?>;"></span>
                    <?php echo e($s['lbl']); ?>

                </span>
            </div>
            <h1 class="valid-header-title"><?php echo e($projet->titre); ?></h1>
            <p class="valid-header-sub" style="display:flex;gap:14px;flex-wrap:wrap;margin-top:4px;">
                <span><i class="fas fa-user" style="margin-right:4px;"></i><?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?></span>
                <span><i class="fas fa-tag" style="margin-right:4px;"></i><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></span>
                <?php if($projet->dateDebut && $projet->dateFin): ?>
                <span>
                    <i class="fas fa-calendar" style="margin-right:4px;"></i>
                    <?php echo e($projet->dateDebut->format('d/m/Y')); ?> → <?php echo e($projet->dateFin->format('d/m/Y')); ?>

                </span>
                <?php endif; ?>
            </p>
        </div>
        <a href="<?php echo e(route('validateur.projets.index')); ?>" class="valid-btn-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    
    <div class="valid-show-grid">

        
        <div class="valid-show-main">

            
            <div class="valid-info-card">
                <div class="valid-info-card-head">
                    <span class="valid-info-card-title">
                        <i class="fas fa-info-circle"></i> Informations générales
                    </span>
                </div>
                <div class="valid-info-grid">
                    <div>
                        <p class="valid-info-lbl">Secteur</p>
                        <p class="valid-info-val"><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="valid-info-lbl">Durée</p>
                        <p class="valid-info-val"><?php echo e($projet->duree ? $projet->duree.' mois' : '—'); ?></p>
                    </div>
                    <div>
                        <p class="valid-info-lbl">Date début</p>
                        <p class="valid-info-val"><?php echo e(optional($projet->dateDebut)->format('d/m/Y') ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="valid-info-lbl">Date fin</p>
                        <p class="valid-info-val"><?php echo e(optional($projet->dateFin)->format('d/m/Y') ?? '—'); ?></p>
                    </div>
                    <?php if($projet->objectif): ?>
                    <div class="valid-info-full">
                        <p class="valid-info-lbl">Objectif</p>
                        <p class="valid-info-val"><?php echo e($projet->objectif); ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if($projet->description): ?>
                    <div class="valid-info-full">
                        <p class="valid-info-lbl">Description</p>
                        <p class="valid-info-val" style="white-space:pre-line;"><?php echo e($projet->description); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <?php if($projet->planifications->count()): ?>
            <div class="valid-info-card">
                <div class="valid-info-card-head">
                    <span class="valid-info-card-title">
                        <i class="fas fa-tasks"></i> Planification
                        <span class="valid-info-count"><?php echo e($projet->planifications->count()); ?></span>
                    </span>
                </div>

                <?php $__currentLoopData = $projet->planifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="valid-activite-card">
                    <div class="valid-activite-head">
                        <div class="valid-activite-num"><?php echo e($loop->iteration); ?></div>
                        <p class="valid-activite-titre"><?php echo e($plan->activitePlanification); ?></p>
                        <?php if($plan->coutEstimatif): ?>
                        <span class="valid-activite-cout">
                            <i class="fas fa-coins" style="font-size:.6rem;"></i>
                            <?php echo e(number_format($plan->coutEstimatif, 0, ',', ' ')); ?> F CFA
                        </span>
                        <?php endif; ?>
                    </div>

                    <div class="valid-activite-details">
                        <?php if($plan->indicateur): ?>
                        <div>
                            <span class="valid-activite-detail-lbl">Indicateur : </span>
                            <span class="valid-activite-detail-val">
                                <?php echo e($plan->indicateur); ?>

                                <?php if($plan->uniteIndicateur): ?> (<?php echo e($plan->uniteIndicateur); ?>) <?php endif; ?>
                            </span>
                        </div>
                        <?php endif; ?>
                        <?php if($plan->periode): ?>
                        <div>
                            <span class="valid-activite-detail-lbl">Période : </span>
                            <span class="valid-activite-detail-val"><?php echo e($plan->periode); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if($plan->resultatsAttendues): ?>
                        <div class="valid-activite-detail-full">
                            <span class="valid-activite-detail-lbl">Résultats attendus : </span>
                            <span class="valid-activite-detail-val"><?php echo e($plan->resultatsAttendues); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="valid-total-bar">
                    <span class="valid-total-label">Total estimé :</span>
                    <span class="valid-total-val">
                        <?php echo e(number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ')); ?> F CFA
                    </span>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if($projet->documents && $projet->documents->count()): ?>
            <div class="valid-info-card">
                <div class="valid-info-card-head">
                    <span class="valid-info-card-title">
                        <i class="fas fa-paperclip"></i> Documents joints
                        <span class="valid-info-count"><?php echo e($projet->documents->count()); ?></span>
                    </span>
                </div>
                <div class="valid-docs-list">
                    <?php $__currentLoopData = $projet->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(asset('storage/'.$doc->cheminFichier)); ?>" target="_blank" class="valid-doc-item">
                        <i class="fas fa-file-alt"></i>
                        <span><?php echo e($doc->nomFichier ?? basename($doc->cheminFichier)); ?></span>
                        <i class="fas fa-external-link-alt" style="font-size:.65rem;color:var(--valid-text-light);"></i>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if($projet->commentaires && $projet->commentaires->count()): ?>
            <div class="valid-info-card">
                <div class="valid-info-card-head">
                    <span class="valid-info-card-title">
                        <i class="fas fa-comments"></i> Commentaires
                        <span class="valid-info-count"><?php echo e($projet->commentaires->count()); ?></span>
                    </span>
                </div>
                <div class="valid-comments-list">
                    <?php $__currentLoopData = $projet->commentaires->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $com): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="valid-comment-item">
                        <div class="valid-comment-avatar">
                            <?php echo e(strtoupper(substr(optional($com->utilisateur)->nomComplet ?? 'U', 0, 1))); ?>

                        </div>
                        <div class="valid-comment-body">
                            <div class="valid-comment-head">
                                <span class="valid-comment-author"><?php echo e(optional($com->utilisateur)->nomComplet ?? '—'); ?></span>
                                <span class="valid-comment-date"><?php echo e(optional($com->created_at)->format('d/m/Y H:i')); ?></span>
                            </div>
                            <p class="valid-comment-text"><?php echo e($com->contenu ?? $com->message ?? ''); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

        </div>

        
        <div class="valid-show-aside">

            
            <div class="valid-aside-card">
                <p class="valid-aside-title"><i class="fas fa-wallet"></i> Finances</p>
                <div class="valid-fin-rows">
                    <div class="valid-fin-row">
                        <span>Budget total</span>
                        <strong><?php echo e(number_format($projet->budgetTotal ?? 0, 0, ',', ' ')); ?> F CFA</strong>
                    </div>
                    <div class="valid-fin-row">
                        <span>Montant demandé</span>
                        <strong><?php echo e(number_format($projet->montantDemande ?? 0, 0, ',', ' ')); ?> F CFA</strong>
                    </div>
                    <div class="valid-fin-row">
                        <span>Durée</span>
                        <strong><?php echo e($projet->duree ?? '—'); ?> mois</strong>
                    </div>
                    <?php if($projet->planifications->count()): ?>
                    <div class="valid-fin-row">
                        <span>Coût planifié</span>
                        <strong style="color:var(--valid-primary);">
                            <?php echo e(number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ')); ?> F CFA
                        </strong>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <?php if($projet->statutProjet === 'approuve'): ?>
            <div class="valid-decision-zone">
                <p class="valid-decision-zone-title">
                    <i class="fas fa-gavel"></i> Décision de validation
                </p>
                <p class="valid-decision-zone-desc">
                    Ce projet a été approuvé. Vous pouvez le valider définitivement ou le rejeter.
                </p>

                
                <form method="POST" action="<?php echo e(route('validateur.projets.valider', $projet)); ?>"
                      onsubmit="return confirm('Confirmer la validation définitive ?')">
                    <?php echo csrf_field(); ?>
                    <div class="valid-form-group">
                        <label class="valid-form-label">Commentaire (optionnel)</label>
                        <textarea name="commentaire" class="valid-form-textarea" rows="3"
                                  placeholder="Remarques sur la validation…"></textarea>
                    </div>
                    <button type="submit" class="valid-btn valid-btn-primary valid-btn-large">
                        <i class="fas fa-medal"></i> Valider le projet
                    </button>
                </form>

                <div class="valid-or-sep"><span>ou</span></div>

                
                <div class="valid-reject-zone">
                    <div id="rejectToggle">
                        <button type="button" class="valid-btn-reject-toggle" onclick="toggleReject()">
                            <i class="fas fa-times-circle"></i> Rejeter le projet
                        </button>
                    </div>
                    <div id="rejectForm" style="display:none;margin-top:10px;">
                        <form method="POST" action="<?php echo e(route('validateur.projets.rejeter', $projet)); ?>"
                              onsubmit="return confirm('Confirmer le rejet ?')">
                            <?php echo csrf_field(); ?>
                            <div class="valid-form-group">
                                <label class="valid-form-label" style="color:var(--valid-red);">
                                    Motif du rejet <span>*</span>
                                </label>
                                <textarea name="motifRejet" class="valid-form-textarea danger" rows="4"
                                          placeholder="Expliquez le motif…" required></textarea>
                                <?php $__errorArgs = ['motifRejet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="valid-form-error"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div style="display:flex;gap:8px;">
                                <button type="submit" class="valid-btn valid-btn-red" style="flex:1;justify-content:center;">
                                    <i class="fas fa-times-circle"></i> Confirmer
                                </button>
                                <button type="button" class="valid-btn valid-btn-gray" onclick="toggleReject()">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php else: ?>
            
            <div class="valid-aside-card">
                <p class="valid-aside-title"><i class="fas fa-flag-checkered"></i> Décision finale</p>
                <div class="valid-decision-badge <?php echo e($projet->statutProjet === 'valide' ? 'valid-decision-valide' : 'valid-decision-rejete'); ?>">
                    <i class="fas <?php echo e($projet->statutProjet === 'valide' ? 'fa-medal' : 'fa-times-circle'); ?>"></i>
                    Projet <?php echo e($projet->statutProjet === 'valide' ? 'validé' : 'rejeté'); ?>

                </div>
                <?php if($projet->motifRejet): ?>
                <p class="valid-motif-text"><?php echo e($projet->motifRejet); ?></p>
                <?php endif; ?>
                <?php if($projet->validated_at): ?>
                <p class="valid-decision-date">
                    <i class="fas fa-calendar-check"></i>
                    <?php echo e(\Carbon\Carbon::parse($projet->validated_at)->format('d/m/Y à H:i')); ?>

                </p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            
            <div class="valid-aside-card">
                <p class="valid-aside-title"><i class="fas fa-user"></i> Porteur de projet</p>
                <div class="valid-porteur-block">
                    <div class="valid-porteur-avatar">
                        <?php echo e(strtoupper(substr(optional($projet->porteur)->nomComplet ?? 'P', 0, 1))); ?>

                    </div>
                    <div>
                        <p class="valid-porteur-name"><?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?></p>
                        <p class="valid-porteur-email"><?php echo e(optional($projet->porteur)->email ?? '—'); ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
function toggleReject() {
    const f = document.getElementById('rejectForm');
    const t = document.getElementById('rejectToggle');
    const hidden = f.style.display === 'none' || f.style.display === '';
    f.style.display = hidden ? 'block' : 'none';
    t.style.display = hidden ? 'none' : 'block';
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/validateur/projets/show.blade.php ENDPATH**/ ?>