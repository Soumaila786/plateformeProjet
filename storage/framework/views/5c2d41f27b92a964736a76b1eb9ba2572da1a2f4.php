<?php $__env->startSection('title', 'Mes projets traités'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/projet.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="projets-page">

    
    <div class="projets-header">
        <div>
            <h1 class="projets-title">Mes projets traités</h1>
            <p class="projets-subtitle"><?php echo e($projets->total()); ?> projet<?php echo e($projets->total() > 1 ? 's' : ''); ?> traité<?php echo e($projets->total() > 1 ? 's' : ''); ?></p>
        </div>
    </div>

    
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
                    'en_examen' => 'En examen',
                    'approuve'  => 'Approuvé',
                    'rejete'    => 'Rejeté',
                ];
            ?>
            <?php $__currentLoopData = $statuts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('approbateur.projets.mes_projets', array_merge(request()->query(), ['statut' => $val, 'search' => request('search')]))); ?>"
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
                        <th>Porteur</th>
                        <th>Secteur</th>
                        <th>Montant demandé</th>
                        <th>Statut</th>
                        <th>Date traitement</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $statusClass = [
                            'en_examen' => 'status-yellow',
                            'approuve'  => 'status-green',
                            'rejete'    => 'status-red',
                        ][$projet->statutProjet] ?? 'status-gray';
                        $statusLabel = [
                            'en_examen' => 'En examen',
                            'approuve'  => 'Approuvé',
                            'rejete'    => 'Rejeté',
                        ][$projet->statutProjet] ?? $projet->statutProjet;
                    ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('approbateur.projets.show', $projet)); ?>" class="projet-code">
                                <?php echo e($projet->codeProjet); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo e(route('approbateur.projets.show', $projet)); ?>" class="projet-titre">
                                <?php echo e($projet->titre); ?>

                            </a>
                        </td>
                        <td class="td-muted"><?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?></td>
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
                            
                            <?php if($projet->dateApprobation): ?>
                                <?php echo e($projet->dateApprobation->format('d/m/Y')); ?>

                            <?php else: ?>
                                <?php echo e($projet->updated_at->format('d/m/Y')); ?>

                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="td-actions">
                                <a href="<?php echo e(route('approbateur.projets.show', $projet)); ?>"
                                    class="btn-icon" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="td-empty">
                            <i class="fas fa-folder-open"></i>
                            <p>
                                <?php if(request('statut') || request('search')): ?>
                                    Aucun projet ne correspond à votre recherche.
                                <?php else: ?>
                                    Aucun projet traité pour l'instant.
                                <?php endif; ?>
                            </p>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/approbateur/projets/mes_projets.blade.php ENDPATH**/ ?>