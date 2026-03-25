<?php $__env->startSection('title', 'Examen — ' . $projet->titre); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/validDash.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="vpage">

    
    <div class="breadcrumb">
        <a href="<?php echo e(route('validateur.dashboard')); ?>"><i class="fas fa-home"></i></a>
        <span>/</span>
        <a href="<?php echo e(route('validateur.projets.index')); ?>">Projets</a>
        <span>/</span>
        <span><?php echo e($projet->codeProjet); ?></span>
    </div>

    
    <?php
        $map = [
            'approuve' => ['lbl'=>'Approuvé','dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d'],
            'valide'   => ['lbl'=>'Validé',  'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e'],
            'rejete'   => ['lbl'=>'Rejeté',  'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c'],
        ];
        $s = $map[$projet->statutProjet] ?? $map['approuve'];
    ?>
    <div class="show-header">
        <div>
            <span class="status-badge" style="background:<?php echo e($s['bg']); ?>;color:<?php echo e($s['color']); ?>;">
                <span class="dot" style="background:<?php echo e($s['dot']); ?>;"></span><?php echo e($s['lbl']); ?>

            </span>
            <h1 class="show-title"><?php echo e($projet->titre); ?></h1>
            <div class="show-meta">
                <span><i class="fas fa-hashtag"></i> <?php echo e($projet->codeProjet); ?></span>
                <span><i class="fas fa-user"></i> <?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?></span>
                <span><i class="fas fa-tag"></i> <?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></span>
                <span><i class="fas fa-calendar"></i>
                    <?php echo e(optional($projet->dateDebut)->format('d/m/Y') ?? '—'); ?> →
                    <?php echo e(optional($projet->dateFin)->format('d/m/Y') ?? '—'); ?>

                </span>
            </div>
        </div>
        <a href="<?php echo e(route('validateur.projets.index')); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    
    <div class="show-grid">

        
        <div class="show-main">

            
            <div class="info-card">
                <h4 class="info-title"><i class="fas fa-bullseye"></i> Objectif</h4>
                <p class="info-text"><?php echo e($projet->objectif ?? 'Non renseigné.'); ?></p>
            </div>

            
            <?php if($projet->description): ?>
            <div class="info-card">
                <h4 class="info-title"><i class="fas fa-align-left"></i> Description</h4>
                <p class="info-text" style="white-space:pre-line;"><?php echo e($projet->description); ?></p>
            </div>
            <?php endif; ?>

            
            <?php if($projet->activites && $projet->activites->count()): ?>
            <div class="info-card">
                <h4 class="info-title"><i class="fas fa-tasks"></i> Planification</h4>
                <div class="planif-list">
                    <?php $__currentLoopData = $projet->activites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="planif-item">
                        <div class="planif-dot"></div>
                        <div>
                            <p class="planif-name"><?php echo e($pl->activite ?? $pl->titre ?? '—'); ?></p>
                            <p class="planif-date">
                                <?php echo e(optional($pl->dateDebut)->format('d/m/Y') ?? '—'); ?> →
                                <?php echo e(optional($pl->dateFin)->format('d/m/Y') ?? '—'); ?>

                            </p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if($projet->documents && $projet->documents->count()): ?>
            <div class="info-card">
                <h4 class="info-title"><i class="fas fa-paperclip"></i> Documents joints</h4>
                <div class="docs-list">
                    <?php $__currentLoopData = $projet->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(asset('storage/' . $doc->cheminFichier)); ?>" target="_blank" class="doc-item">
                        <i class="fas fa-file-alt"></i>
                        <span><?php echo e($doc->nomFichier ?? basename($doc->cheminFichier)); ?></span>
                        <i class="fas fa-external-link-alt doc-ext"></i>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if($projet->commentaires && $projet->commentaires->count()): ?>
            <div class="info-card">
                <h4 class="info-title"><i class="fas fa-comments"></i> Commentaires</h4>
                <div class="comments-list">
                    <?php $__currentLoopData = $projet->commentaires->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $com): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="comment-item">
                        <div class="comment-avatar">
                            <?php echo e(strtoupper(substr(optional($com->utilisateur)->nomComplet ?? 'U', 0, 1))); ?>

                        </div>
                        <div class="comment-body">
                            <div class="comment-head">
                                <span class="comment-author"><?php echo e(optional($com->utilisateur)->nomComplet ?? '—'); ?></span>
                                <span class="comment-date"><?php echo e(optional($com->created_at)->format('d/m/Y H:i')); ?></span>
                            </div>
                            <p class="comment-text"><?php echo e($com->contenu); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

        </div>

        
        <div class="show-aside">

            
            <div class="aside-card">
                <h4 class="info-title"><i class="fas fa-wallet"></i> Finances</h4>
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
                </div>
            </div>

            
            <?php if($projet->statutProjet === 'approuve'): ?>
            <div class="action-zone">
                <h4 class="action-zone-title"><i class="fas fa-gavel"></i> Décision de validation</h4>
                <p class="action-zone-desc">Ce projet a été approuvé. Vous pouvez le valider définitivement ou le rejeter.</p>

                
                <form method="POST" action="<?php echo e(route('validateur.projets.valider', $projet)); ?>"
                        onsubmit="return confirm('Confirmer la validation ?')">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label class="form-label">Commentaire (optionnel)</label>
                        <textarea name="commentaire" class="form-textarea" rows="3"
                                    placeholder="Remarques sur la validation…"></textarea>
                    </div>
                    <button type="submit" class="btn-valider">
                        <i class="fas fa-medal"></i> Valider le projet
                    </button>
                </form>

                <div class="or-sep"><span>ou</span></div>

                
                <div id="rejectToggle">
                    <button type="button" class="btn-reject-toggle" onclick="toggleReject()">
                        <i class="fas fa-times-circle"></i> Rejeter le projet
                    </button>
                </div>
                <div id="rejectForm" style="display:none;">
                    <form method="POST" action="<?php echo e(route('validateur.projets.rejeter', $projet)); ?>"
                            onsubmit="return confirm('Confirmer le rejet ?')">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label class="form-label" style="color:#dc2626;">Motif du rejet <span>*</span></label>
                            <textarea name="motifRejet" class="form-textarea form-textarea-danger"
                                        rows="4" placeholder="Expliquez le motif…" required></textarea>
                            <?php $__errorArgs = ['motifRejet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <button type="submit" class="btn-rejeter">
                            <i class="fas fa-times-circle"></i> Confirmer le rejet
                        </button>
                        <button type="button" class="btn-cancel" onclick="toggleReject()">Annuler</button>
                    </form>
                </div>
            </div>

            <?php else: ?>
            
            <div class="aside-card">
                <h4 class="info-title"><i class="fas fa-info-circle"></i> Décision prise</h4>
                <div class="decision-badge <?php echo e($projet->statutProjet === 'valide' ? 'decision-valide' : 'decision-rejete'); ?>">
                    <i class="fas <?php echo e($projet->statutProjet === 'valide' ? 'fa-medal' : 'fa-times-circle'); ?>"></i>
                    Projet <?php echo e($projet->statutProjet === 'valide' ? 'validé' : 'rejeté'); ?>

                </div>
                <?php if($projet->motifRejet): ?>
                <p class="motif-text"><?php echo e($projet->motifRejet); ?></p>
                <?php endif; ?>
                <?php if($projet->validated_at): ?>
                <p class="decision-date">
                    <i class="fas fa-calendar-check"></i>
                    <?php echo e(\Carbon\Carbon::parse($projet->validated_at)->format('d/m/Y à H:i')); ?>

                </p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            
            <div class="aside-card">
                <h4 class="info-title"><i class="fas fa-user"></i> Porteur de projet</h4>
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

        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function toggleReject() {
    const f = document.getElementById('rejectForm');
    const t = document.getElementById('rejectToggle');
    const v = f.style.display !== 'none';
    f.style.display = v ? 'none' : 'block';
    t.style.display = v ? 'block' : 'none';
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/validateur/projets/show.blade.php ENDPATH**/ ?>