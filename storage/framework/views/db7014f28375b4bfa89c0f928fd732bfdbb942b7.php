<?php $__env->startSection('title', 'Projets'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="projets-page">

    
    <div class="projets-header">
        <div>
            <h1 class="projets-title">Projets</h1>
            <p class="projets-subtitle"><?php echo e($projets->total()); ?> projet<?php echo e($projets->total() > 1 ? 's' : ''); ?> au total</p>
        </div>
    </div>

    
    <div class="projets-filters">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="search-input"
                    placeholder="Rechercher par titre ou code..."
                    value="<?php echo e(request('search')); ?>">
        </div>
        <div class="status-filters">
            <?php
                $statuts = [
                    ''          => 'Tous',
                    'brouillon' => 'Brouillon',
                    'soumis'    => 'Soumis',
                    'en_examen' => 'En examen',
                    'approuve'  => 'Approuvé',
                    'valide'    => 'Validé',
                    'rejete'    => 'Rejeté',
                ];
            ?>
            <?php $__currentLoopData = $statuts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('admin.projets.index', array_merge(request()->query(), ['statut' => $val]))); ?>"
                class="status-filter <?php echo e(request('statut', '') === $val ? 'active' : ''); ?>">
                <?php echo e($label); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
    <div class="projet-card">
        <div class="projet-card-top">
            <div class="projet-card-meta">
                <span class="projet-card-code"><?php echo e($projet->codeProjet); ?></span>
                <span class="status-badge <?php echo e($sc[$projet->statutProjet] ?? 'status-gray'); ?>">
                    <?php echo e($sl[$projet->statutProjet] ?? $projet->statutProjet); ?>

                </span>
            </div>
            <div class="projet-card-actions">
                <a href="<?php echo e(route('admin.projets.show', $projet)); ?>"
                    class="btn-icon" title="Voir le détail">
                    <i class="fas fa-eye"></i>
                </a>
                
                <form method="POST" action="<?php echo e(route('admin.projets.destroy', $projet)); ?>"
                        onsubmit="return confirm('Supprimer ce projet définitivement ?')"
                        style="display:inline;">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn-icon btn-icon-danger" title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        <h3 class="projet-card-titre"><?php echo e($projet->titre); ?></h3>

        <?php if($projet->description): ?>
        <p class="projet-card-desc"><?php echo e(Str::limit($projet->description, 100)); ?></p>
        <?php endif; ?>

        <div class="projet-card-footer">
            <div class="projet-card-info-row">
                <span class="projet-card-info">
                    <i class="fas fa-user"></i>
                    <?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?>

                </span>
                <span class="projet-card-info">
                    <i class="fas fa-tag"></i>
                    <?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?>

                </span>
                <?php if($projet->budgetTotal): ?>
                <span class="projet-card-info">
                    <i class="fas fa-coins"></i>
                    <?php echo e(number_format($projet->budgetTotal, 0, ',', ' ')); ?> F CFA
                </span>
                <?php endif; ?>
                <span class="projet-card-info">
                    <i class="fas fa-calendar"></i>
                    <?php echo e(optional($projet->dateCreation)->format('d/m/Y') ?? '—'); ?>

                </span>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="cards-empty">
        <i class="fas fa-folder-open"></i>
        <p>Aucun projet trouvé.</p>
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
        <form method="POST" id="formStatut" action="">
            <?php echo csrf_field(); ?>
            <div class="modal-body">
                <label class="field-label">Nouveau statut</label>
                <select name="statut" id="selectStatut" class="field-input" required>
                    <option value="brouillon">Brouillon</option>
                    <option value="soumis">Soumis</option>
                    <option value="en_examen">En examen</option>
                    <option value="approuve">Approuvé</option>
                    <option value="valide">Validé</option>
                    <option value="rejete">Rejeté</option>
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
    let timer;
    document.getElementById('searchInput').addEventListener('input', function () {
        clearTimeout(timer);
        const val = this.value;
        timer = setTimeout(() => {
            const url = new URL(window.location.href);
            url.searchParams.set('search', val);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }, 400);
    });

    function openStatutModal(projetId, currentStatut) {
        document.getElementById('formStatut').action = '/admin/projets/' + projetId + '/statut';
        document.getElementById('selectStatut').value = currentStatut;
        openModal('modalStatut');
    }

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
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/admin/projets/index.blade.php ENDPATH**/ ?>