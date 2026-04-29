<?php $__env->startSection('title', 'Mes projets'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/porteur.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="projets-page">

    
    <div class="projets-header">
        <div>
            <h1 class="projets-title">Mes projets</h1>
            <p class="projets-subtitle"><?php echo e($projets->total()); ?> projet<?php echo e($projets->total() > 1 ? 's' : ''); ?> au total</p>
        </div>
        <a href="<?php echo e(route('porteur.projets.create')); ?>" class="btn-add">
            <i class="fas fa-plus"></i> Nouveau projet
        </a>
    </div>

    
    <?php
        $nbModif = $projets->getCollection()->filter(function($p) {
            return $p->statutProjet === 'brouillon' &&
                   $p->commentaires->where('typeCommentaire', 'rejet')->isNotEmpty();
        })->count();
    ?>
    <?php if($nbModif > 0): ?>
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        <strong><?php echo e($nbModif); ?> projet(s)</strong> nécessite(nt) des modifications demandées par l'approbateur.
    </div>
    <?php endif; ?>

    
    <?php if(session('success')): ?>
    <div class="port-alert port-alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
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
            <a href="<?php echo e(route('porteur.projets.index', array_merge(request()->query(), ['statut'=>$val,'search'=>request('search')]))); ?>"
               class="status-filter <?php echo e(request('statut','') === $val ? 'active' : ''); ?>">
                <?php echo e($label); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="projets-list">
        <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
            $hasModification = $projet->statutProjet === 'brouillon' &&
                               $projet->commentaires->where('typeCommentaire','rejet')->isNotEmpty();
        ?>

        <div class="projet-card">
            
            <div class="projet-avatar">
                <?php echo e(strtoupper(substr(optional($projet->secteur)->nomSecteur ?? $projet->titre, 0, 1))); ?>

            </div>

            
            <div class="projet-info">
                <div class="projet-header-line">
                    <a href="<?php echo e(route('porteur.projets.show', $projet)); ?>" class="projet-code">
                        <?php echo e($projet->codeProjet); ?>

                    </a>
                    <a href="<?php echo e(route('porteur.projets.show', $projet)); ?>" class="projet-titre">
                        <?php echo e($projet->titre); ?>

                    </a>
                    <?php if($hasModification): ?>
                    <span class="modif-badge">
                        <i class="fas fa-exclamation-triangle"></i> Modification demandée
                    </span>
                    <?php endif; ?>
                </div>
                <div class="projet-meta">
                    <span><i class="fas fa-tag"></i><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></span>
                    <span><i class="far fa-calendar-alt"></i>Créé le <?php echo e(optional($projet->dateCreation)->format('d/m/Y') ?? '—'); ?></span>
                    <span>
                        <i class="fas fa-coins"></i>
                        <span class="projet-budget">
                            <?php echo e($projet->montantDemande ? number_format($projet->montantDemande, 0, ',', ' ') . ' F CFA' : '—'); ?>

                        </span>
                    </span>
                </div>
            </div>

            
            <div class="projet-right">
                <div class="projet-badges">
                    <span class="status-badge <?php echo e($statusClass); ?>"><?php echo e($statusLabel); ?></span>
                </div>
                <div class="projet-actions">
                    <a href="<?php echo e(route('porteur.projets.show', $projet)); ?>" class="action-icon" title="Voir">
                        <i class="fas fa-eye"></i>
                    </a>
                    <?php if($projet->isEditable()): ?>
                    <a href="<?php echo e(route('porteur.projets.edit', $projet)); ?>" class="action-icon" title="Modifier">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($projet->isSubmittable()): ?>
                    <form method="POST" action="<?php echo e(route('porteur.projets.soumettre', $projet)); ?>"
                          onsubmit="return confirm('Soumettre ce projet pour approbation ?')" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="action-icon action-icon-success" title="Soumettre">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                    <?php endif; ?>
                    <?php if($projet->isDeletable()): ?>
                    <form method="POST" action="<?php echo e(route('porteur.projets.destroy', $projet)); ?>"
                          onsubmit="return confirm('Supprimer définitivement ce projet ?')" style="display:inline;">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="action-icon action-icon-danger" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="td-empty" style="background:var(--port-bg-white);border-radius:var(--port-radius-xl);
                                     border:1px solid var(--port-border);padding:48px 20px;text-align:center;
                                     color:var(--port-text-light);">
            <i class="fas fa-folder-open" style="font-size:2rem;display:block;margin-bottom:10px;color:var(--port-border);"></i>
            <p style="font-size:.82rem;margin:0 0 12px;">
                <?php if(request('statut') || request('search')): ?>
                    Aucun projet ne correspond à votre recherche.
                <?php else: ?>
                    Vous n'avez pas encore de projet.
                <?php endif; ?>
            </p>
            <?php if(!request('statut') && !request('search')): ?>
            <a href="<?php echo e(route('porteur.projets.create')); ?>" class="btn-add">
                <i class="fas fa-plus"></i> Créer mon premier projet
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    
    <?php if($projets->hasPages()): ?>
    <div class="projets-pagination"><?php echo e($projets->withQueryString()->links()); ?></div>
    <?php endif; ?>

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
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/porteur/projets/index.blade.php ENDPATH**/ ?>