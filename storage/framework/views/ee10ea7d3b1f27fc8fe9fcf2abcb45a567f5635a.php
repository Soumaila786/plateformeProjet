<?php $__env->startSection('title', $projet->titre); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="projets-page">

    
    <div class="page-header">
        <a href="<?php echo e(route('admin.projets.index')); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-header-info">
            <div>
                <h1 class="projets-title"><?php echo e($projet->titre); ?></h1>
                <p class="projets-subtitle"><?php echo e($projet->codeProjet); ?></p>
            </div>
            <div class="page-header-actions">
                <?php
                    $sc = [
                        'brouillon'=>'status-gray',
                        'soumis'=>'status-blue',
                        'en_examen'=>'status-yellow',
                        'approuve'=>'status-green',
                        'valide'=>'status-teal',
                        'rejete'=>'status-red'
                    ];
                    $sl = [
                        'brouillon'=>'Brouillon',
                        'soumis'=>'Soumis',
                        'en_examen'=>'En examen',
                        'approuve'=>'Approuvé',
                        'valide'=>'Validé',
                        'rejete'=>'Rejeté'
                    ];
                ?>
                <span class="status-badge <?php echo e($sc[$projet->statutProjet] ?? 'status-gray'); ?> status-lg">
                    <?php echo e($sl[$projet->statutProjet] ?? $projet->statutProjet); ?>

                </span>
                
                <form method="POST" action="<?php echo e(route('admin.projets.destroy', $projet)); ?>"
                        onsubmit="return confirm('Supprimer définitivement ce projet ?')" style="display:inline;">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn-danger btn-sm">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
    <div class="alert alert-error">
        <i class="fas fa-times-circle"></i> <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    
    <div class="form-card">
        <div class="form-card-header">
            <i class="fas fa-project-diagram"></i>
            <span>Informations générales</span>
        </div>
        <div class="form-card-body">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Porteur</span>
                    <span class="info-value">
                        <a href="<?php echo e(route('admin.users.show', $projet->porteur)); ?>">
                            <?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?>

                        </a>
                    </span>
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
                    <span class="info-label">Date création</span>
                    <span class="info-value"><?php echo e(optional($projet->dateCreation)->format('d/m/Y') ?? '—'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date soumission</span>
                    <span class="info-value"><?php echo e(optional($projet->dateSoumission)->format('d/m/Y') ?? '—'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date approbation</span>
                    <span class="info-value"><?php echo e(optional($projet->dateApprobation)->format('d/m/Y') ?? '—'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date validation</span>
                    <span class="info-value"><?php echo e(optional($projet->dateValidation)->format('d/m/Y') ?? '—'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Budget total</span>
                    <span class="info-value"><?php echo e($projet->budgetTotal ? number_format($projet->budgetTotal, 0, ',', ' ') . ' F CFA' : '—'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Montant demandé</span>
                    <span class="info-value"><?php echo e($projet->montantDemande ? number_format($projet->montantDemande, 0, ',', ' ') . ' F CFA' : '—'); ?></span>
                </div>
            </div>

            <?php if($projet->description): ?>
            <div class="info-block mt-3">
                <span class="info-label">Description</span>
                <p class="info-text"><?php echo e($projet->description); ?></p>
            </div>
            <?php endif; ?>

            <?php if($projet->objectif): ?>
            <div class="info-block mt-2">
                <span class="info-label">Objectif</span>
                <p class="info-text"><?php echo e($projet->objectif); ?></p>
            </div>
            <?php endif; ?>

            <?php if($projet->motifRejet): ?>
            <div class="info-block mt-2 alert-rejet">
                <span class="info-label"><i class="fas fa-times-circle"></i> Motif de rejet</span>
                <p class="info-text"><?php echo e($projet->motifRejet); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="form-card">
        <div class="form-card-header">
            <i class="fas fa-tasks"></i>
            <span>Planification (<?php echo e($projet->activites->count()); ?>)</span>
        </div>
        <div class="form-card-body">
            <?php $__empty_1 = true; $__currentLoopData = $projet->activites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="plan-item">
                <div class="plan-info">
                    <span class="plan-titre"><?php echo e($plan->activite); ?></span>
                    <span class="plan-dates">
                        <?php echo e(optional($plan->dateDebut)->format('d/m/Y')); ?> →
                        <?php echo e(optional($plan->dateFin)->format('d/m/Y')); ?>

                    </span>
                </div>
                <span class="plan-budget"><?php echo e($plan->budget ? number_format($plan->budget, 0, ',', ' ') . ' F' : ''); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="info-empty">Aucune étape de planification.</p>
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
                            : (in_array($ext, ['jpg','jpeg','png']) ? 'fa-file-image' : 'fa-file-alt')));
                ?>
                <i class="fas <?php echo e($icon); ?>"></i>
                <span class="doc-file-name"><?php echo e($doc->nomFichier); ?></span>
                <span class="doc-badge"><?php echo e($doc->typeDocument); ?></span>
                <span class="doc-uploader"><?php echo e(optional($doc->uploader)->nomComplet ?? '—'); ?></span>
                <a href="<?php echo e(route('admin.projets.documents.download', [$projet, $doc])); ?>"
                    class="doc-action-link" title="Télécharger">
                    <i class="fas fa-download"></i>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="info-empty">Aucun document joint.</p>
            <?php endif; ?>
        </div>
    </div>

    
    <?php if($projet->commentaires->count() > 0): ?>
    <div class="form-card mt-3">
        <div class="form-card-header">
            <i class="fas fa-comments"></i>
            <span>Historique des commentaires du projet (<?php echo e($projet->commentaires->count()); ?>)</span>
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


<div class="modal-overlay" id="modalStatut">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Changer le statut</h3>
            <button type="button" class="modal-close" onclick="closeModal('modalStatut')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="<?php echo e(route('admin.projets.statut', $projet)); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-body">
                <label class="field-label">Nouveau statut</label>
                <select name="statut" class="field-input" required>
                    <?php $__currentLoopData = ['brouillon'=>'Brouillon','soumis'=>'Soumis','en_examen'=>'En examen','approuve'=>'Approuvé','valide'=>'Validé','rejete'=>'Rejeté']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val); ?>" <?php echo e($projet->statutProjet === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalStatut')">Annuler</button>
                <button type="submit" class="btn-save">
                    <i class="fas fa-exchange-alt"></i> Appliquer
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
        m.addEventListener('click', function(e) { if (e.target === this) closeModal(this.id); });
    });

    const newDocInput  = document.getElementById('newDocuments');
    const newFileList  = document.getElementById('newFileList');
    const submitDocBtn = document.getElementById('submitDocBtn');

    newDocInput.addEventListener('change', function() {
        const files = Array.from(this.files);
        if (!files.length) return;
        newFileList.style.display = 'block';
        submitDocBtn.style.display = 'block';
        newFileList.innerHTML = files.map(f => `
            <div class="doc-file-item">
                <i class="${getIcon(f.name)} doc-file-icon"></i>
                <div class="doc-file-info">
                    <span class="doc-file-name">${f.name}</span>
                    <span class="doc-file-size">${formatSize(f.size)}</span>
                </div>
                <span class="doc-file-ok"><i class="fas fa-check-circle"></i> Accepté</span>
            </div>`).join('');
    });

    function resetDocForm() {
        newDocInput.value = '';
        newFileList.innerHTML = ''; newFileList.style.display = 'none';
        submitDocBtn.style.display = 'none';
    }

    function getIcon(name) {
        const ext = name.split('.').pop().toLowerCase();
        if (['pdf'].includes(ext))              return 'fas fa-file-pdf';
        if (['doc','docx'].includes(ext))       return 'fas fa-file-word';
        if (['xls','xlsx'].includes(ext))       return 'fas fa-file-excel';
        if (['jpg','jpeg','png'].includes(ext)) return 'fas fa-file-image';
        return 'fas fa-file-alt';
    }

    function formatSize(b) {
        if (b < 1024) return b + ' o';
        if (b < 1048576) return (b/1024).toFixed(1) + ' Ko';
        return (b/1048576).toFixed(1) + ' Mo';
    }
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/admin/projets/show.blade.php ENDPATH**/ ?>