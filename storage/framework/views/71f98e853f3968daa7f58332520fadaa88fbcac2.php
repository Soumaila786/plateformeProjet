<?php $__env->startSection('title', 'Mes projets'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/projet.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="projets-page">

    
    <div class="projets-header">
        <div>
            <h1 class="projets-title">Mes projets</h1>
            <p class="projets-subtitle"><?php echo e($projets->total()); ?> projet<?php echo e($projets->total() > 1 ? 's' : ''); ?> au total</p>
        </div>
        <a href="<?php echo e(route('porteur.projets.create')); ?>" class="btn-add">
            <i class="fas fa-plus"></i>
            Nouveau projet
        </a>
    </div>

    
    <?php
        $nbModif = $projets->getCollection()->filter(function($p) {
                return $p->statutProjet === 'brouillon' &&
                    $p->commentaires->where('typeCommentaire', 'rejet')->isNotEmpty();
            })->count();
    ?>

    <?php if($nbModif > 0): ?>
    <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong><?php echo e($nbModif); ?> projet(s)</strong> nécessite(nt) des modifications demandées par l'approbateur.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    
    <div class="projets-filters">

        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text"
                    id="searchInput"
                    class="search-input"
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
            <a href="<?php echo e(route('porteur.projets.index', array_merge(request()->query(), ['statut' => $val, 'search' => request('search')]))); ?>"
                class="status-filter <?php echo e(request('statut', '') === $val ? 'active' : ''); ?>">
                <?php echo e($label); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </div>

    
    <div class="projets-table-wrap">
        <div class="table-scroll">
            <table class="projets-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Titre</th>
                        <th>Secteur</th>
                        <th>Montant demandé</th>
                        <th>Statut</th>
                        <th>Date création</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
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
                    ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('porteur.projets.show', $projet)); ?>" class="projet-code">
                                <?php echo e($projet->codeProjet); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo e(route('porteur.projets.show', $projet)); ?>" class="projet-titre">
                                <?php echo e($projet->titre); ?>

                            </a>
                            <?php if($projet->messageModification && $projet->statutProjet === 'brouillon'): ?>
                            <br><small style="color:#d97706;font-size:.72rem;">
                                <i class="fas fa-exclamation-triangle"></i> Modification demandée
                            </small>
                            <?php endif; ?>
                        </td>
                        <td class="td-muted"><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></td>
                        <td class="td-budget">
                            <?php echo e($projet->montantDemande ? number_format($projet->montantDemande, 0, ',', ' ') . ' F CFA' : '—'); ?>

                        </td>
                        <td>
                            <span class="status-badge <?php echo e($statusClass); ?>"><?php echo e($statusLabel); ?></span>
                            <?php if($projet->statutProjet === 'rejete' && $projet->motifRejet): ?>
                            <br>
                            <small data-bs-toggle="tooltip" title="<?php echo e($projet->motifRejet); ?>"
                                    style="color:#dc2626;cursor:pointer;font-size:.7rem;">
                                <i class="fas fa-info-circle"></i> Motif
                            </small>
                            <?php endif; ?>
                        </td>
                        <td class="td-muted">
                            <?php echo e(optional($projet->dateCreation)->format('d/m/Y') ?? '—'); ?>

                        </td>
                        <td>
                            <div class="td-actions">
                                <a href="<?php echo e(route('porteur.projets.show', $projet)); ?>"
                                    class="btn-icon" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <?php if($projet->isEditable()): ?>
                                <a href="<?php echo e(route('porteur.projets.edit', $projet)); ?>"
                                    class="btn-icon" title="Modifier">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <?php endif; ?>

                                <?php if($projet->isSubmittable()): ?>
                                <form method="POST" action="<?php echo e(route('porteur.projets.soumettre', $projet)); ?>"
                                        onsubmit="return confirm('Soumettre ce projet pour approbation ?')">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn-icon btn-icon-success" title="Soumettre">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                                <?php endif; ?>

                                <?php if($projet->isDeletable()): ?>
                                <form method="POST" action="<?php echo e(route('porteur.projets.destroy', $projet)); ?>"
                                        onsubmit="return confirm('Supprimer définitivement ce projet ?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn-icon btn-icon-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="td-empty">
                            <i class="fas fa-folder-open"></i>
                            <p>
                                <?php if(request('statut') || request('search')): ?>
                                    Aucun projet ne correspond à votre recherche.
                                <?php else: ?>
                                    Vous n'avez pas encore de projet.
                                <?php endif; ?>
                            </p>
                            <?php if(!request('statut') && !request('search')): ?>
                            <a href="<?php echo e(route('porteur.projets.create')); ?>" class="btn-add mt-2">
                                <i class="fas fa-plus"></i> Créer mon premier projet
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <?php if($projets->hasPages()): ?>
    <div class="projets-pagination">
        <?php echo e($projets->withQueryString()->links()); ?>

    </div>
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

document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
    new bootstrap.Tooltip(el);
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/porteur/projets/index.blade.php ENDPATH**/ ?>