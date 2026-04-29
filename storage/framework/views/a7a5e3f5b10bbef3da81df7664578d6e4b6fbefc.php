<?php $__env->startSection('title', 'Projets à approuver'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/approbateur.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="aprob-page">

    
    <div class="aprob-header">
        <div>
            <h1 class="aprob-header-title">Projets à approuver</h1>
            <p class="aprob-header-sub"><?php echo e($projets->total()); ?> projet<?php echo e($projets->total() > 1 ? 's' : ''); ?> au total</p>
        </div>
        <a href="<?php echo e(route('approbateur.projets.mes_projets')); ?>" class="aprob-btn aprob-btn-secondary">
            <i class="fas fa-history"></i> Mes projets traités
        </a>
    </div>

    
    <?php if(session('success')): ?>
    <div class="aprob-alert aprob-alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">

        <div class="aprob-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput"
                   placeholder="Rechercher par titre ou code..."
                   value="<?php echo e(request('search')); ?>">
        </div>

        <select id="secteurSelect" class="aprob-select">
            <option value="">Tous les secteurs</option>
            <?php $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($secteur->id); ?>" <?php echo e(request('secteur_id') == $secteur->id ? 'selected' : ''); ?>>
                <?php echo e($secteur->nomSecteur); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <div class="aprob-status-filters">
            <?php $statuts = ['' => 'Tous', 'soumis'=>'Soumis', 'en_examen'=>'En examen', 'approuve'=>'Approuvé', 'rejete'=>'Rejeté']; ?>
            <?php $__currentLoopData = $statuts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('approbateur.projets.index', array_merge(request()->query(), ['statut'=>$val]))); ?>"
               class="aprob-status-filter <?php echo e(request('statut','') === $val ? 'active' : ''); ?>">
                <?php echo e($label); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if(request('search') || request('secteur_id') || request('statut')): ?>
        <a href="<?php echo e(route('approbateur.projets.index')); ?>" class="aprob-reset-btn">
            <i class="fas fa-times"></i> Réinitialiser
        </a>
        <?php endif; ?>
    </div>

    
    <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $stMap = [
            'soumis'    => ['lbl'=>'Soumis',    'cls'=>'aprob-badge-soumis',    'dot'=>'#6366f1'],
            'en_examen' => ['lbl'=>'En examen', 'cls'=>'aprob-badge-en_examen', 'dot'=>'#f97316'],
            'approuve'  => ['lbl'=>'Approuvé',  'cls'=>'aprob-badge-approuve',  'dot'=>'#22c55e'],
            'rejete'    => ['lbl'=>'Rejeté',    'cls'=>'aprob-badge-rejete',    'dot'=>'#ef4444'],
        ];
        $st = $stMap[$projet->statutProjet] ?? ['lbl'=>$projet->statutProjet,'cls'=>'aprob-badge-brouillon','dot'=>'#9ca3af'];
    ?>

    <div class="aprob-projet-row <?php echo e($projet->statutProjet); ?>">

        
        <div class="aprob-projet-avatar">
            <?php echo e(strtoupper(substr(optional($projet->secteur)->nomSecteur ?? $projet->titre, 0, 1))); ?>

        </div>

        
        <div class="aprob-projet-info">
            <div class="aprob-projet-top">
                <span class="aprob-projet-code"><?php echo e($projet->codeProjet); ?></span>
                <span class="aprob-projet-titre"><?php echo e($projet->titre); ?></span>
            </div>
            <p class="aprob-projet-meta">
                <span><i class="fas fa-user"></i><?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?></span>
                <span><i class="fas fa-tag"></i><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></span>
                <?php if($projet->montantDemande): ?>
                <span><i class="fas fa-coins"></i><strong><?php echo e(number_format($projet->montantDemande, 0, ',', ' ')); ?> F CFA</strong></span>
                <?php endif; ?>
                <?php if($projet->dateSoumission): ?>
                <span><i class="fas fa-calendar"></i>Soumis le <?php echo e($projet->dateSoumission->format('d/m/Y')); ?></span>
                <?php endif; ?>
            </p>
        </div>

        
        <div class="aprob-projet-badges">
            <span class="aprob-badge <?php echo e($st['cls']); ?>">
                <span class="aprob-dot" style="background:<?php echo e($st['dot']); ?>;"></span>
                <?php echo e($st['lbl']); ?>

            </span>

            <a href="<?php echo e(route('approbateur.projets.show', $projet)); ?>"
               class="aprob-btn aprob-btn-outline aprob-btn-icon" title="Voir">
                <i class="fas fa-eye"></i>
            </a>

            <?php if($projet->statutProjet === 'soumis'): ?>
            <form method="POST" action="<?php echo e(route('approbateur.projets.examiner', $projet)); ?>"
                  onsubmit="return confirm('Mettre ce projet en examen ?')">
                <?php echo csrf_field(); ?>
                <button type="submit" class="aprob-btn aprob-btn-orange aprob-btn-icon" title="Mettre en examen">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <?php endif; ?>

            <?php if($projet->statutProjet === 'en_examen'): ?>
            <button type="button" class="aprob-btn aprob-btn-green aprob-btn-icon" title="Approuver"
                    onclick="openModal('modalApprouver<?php echo e($projet->id); ?>')">
                <i class="fas fa-check"></i>
            </button>
            <button type="button" class="aprob-btn aprob-btn-red aprob-btn-icon" title="Rejeter"
                    onclick="openModal('modalRejeter<?php echo e($projet->id); ?>')">
                <i class="fas fa-times"></i>
            </button>
            <?php endif; ?>
        </div>
    </div>

    
    <?php if($projet->statutProjet === 'en_examen'): ?>
    <div id="modalApprouver<?php echo e($projet->id); ?>" class="aprob-modal-overlay">
        <div class="aprob-modal-box">
            <div class="aprob-modal-head">
                <h3 class="aprob-modal-title">
                    <i class="fas fa-check-circle" style="color:#22c55e;"></i> Approuver le projet
                </h3>
                <button onclick="closeModal('modalApprouver<?php echo e($projet->id); ?>')" class="aprob-modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="<?php echo e(route('approbateur.projets.approuver', $projet)); ?>">
                <?php echo csrf_field(); ?>
                <div class="aprob-modal-body">
                    <p style="font-size:.82rem;color:#6b7280;margin:0;">
                        Le projet <strong><?php echo e($projet->titre); ?></strong> sera transmis au validateur.
                    </p>
                    <div class="aprob-form-group">
                        <label class="aprob-form-label">Commentaire (optionnel)</label>
                        <textarea name="commentaire" class="aprob-form-textarea" rows="3"
                                  placeholder="Observations..."></textarea>
                    </div>
                </div>
                <div class="aprob-modal-foot">
                    <button type="button" onclick="closeModal('modalApprouver<?php echo e($projet->id); ?>')"
                            class="aprob-btn aprob-btn-gray">Annuler</button>
                    <button type="submit" class="aprob-btn aprob-btn-green">
                        <i class="fas fa-check-circle"></i> Confirmer
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <div id="modalRejeter<?php echo e($projet->id); ?>" class="aprob-modal-overlay">
        <div class="aprob-modal-box">
            <div class="aprob-modal-head">
                <h3 class="aprob-modal-title">
                    <i class="fas fa-times-circle" style="color:#ef4444;"></i> Rejeter le projet
                </h3>
                <button onclick="closeModal('modalRejeter<?php echo e($projet->id); ?>')" class="aprob-modal-close">
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
                    </div>
                </div>
                <div class="aprob-modal-foot">
                    <button type="button" onclick="closeModal('modalRejeter<?php echo e($projet->id); ?>')"
                            class="aprob-btn aprob-btn-gray">Annuler</button>
                    <button type="submit" class="aprob-btn aprob-btn-red">
                        <i class="fas fa-times-circle"></i> Confirmer le rejet
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="aprob-empty">
        <i class="fas fa-folder-open"></i>
        <p>Aucun projet trouvé.</p>
    </div>
    <?php endif; ?>

    
    <div class="aprob-pagination">
        <?php echo e($projets->withQueryString()->links()); ?>

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

let timer;
document.getElementById('searchInput').addEventListener('input', function () {
    clearTimeout(timer);
    const val = this.value;
    timer = setTimeout(() => {
        const url = new URL(window.location.href);
        url.searchParams.set('search', val);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }, 450);
});

document.getElementById('secteurSelect').addEventListener('change', function () {
    const url = new URL(window.location.href);
    if (this.value) url.searchParams.set('secteur_id', this.value);
    else url.searchParams.delete('secteur_id');
    url.searchParams.delete('page');
    window.location.href = url.toString();
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/approbateur/projets/index.blade.php ENDPATH**/ ?>