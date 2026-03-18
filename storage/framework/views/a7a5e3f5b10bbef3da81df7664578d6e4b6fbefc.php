<?php $__env->startSection('title', 'Projets à approuver'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/projet.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="projets-page">

    
    <div class="projets-header">
        <div>
            <h1 class="projets-title">Projets à approuver</h1>
            <p class="projets-subtitle">
                <?php echo e($projets->total()); ?> projet<?php echo e($projets->total() > 1 ? 's' : ''); ?> au total
            </p>
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
                    'soumis'    => 'Soumis',
                    'en_examen' => 'En examen',
                    'approuve'  => 'Approuvé',
                    'rejete'    => 'Rejeté',
                ];
            ?>

            <?php $__currentLoopData = $statuts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('approbateur.projets.index',
                    array_merge(request()->query(),
                    ['statut' => $val, 'search' => request('search')]))); ?>"
                   class="status-filter <?php echo e(request('statut','') === $val ? 'active' : ''); ?>">
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
                    <th>Date soumission</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <?php
                        $statusClass = [
                            'soumis'=>'status-blue',
                            'en_examen'=>'status-yellow',
                            'approuve'=>'status-green',
                            'rejete'=>'status-red'
                        ][$projet->statutProjet] ?? 'status-gray';

                        $statusLabel = [
                            'soumis'=>'Soumis',
                            'en_examen'=>'En examen',
                            'approuve'=>'Approuvé',
                            'rejete'=>'Rejeté'
                        ][$projet->statutProjet] ?? $projet->statutProjet;
                    ?>

                    <tr>

                        <td>
                            <a href="<?php echo e(route('approbateur.projets.show',$projet)); ?>"
                               class="projet-code">
                                <?php echo e($projet->codeProjet); ?>

                            </a>
                        </td>

                        <td>
                            <a href="<?php echo e(route('approbateur.projets.show',$projet)); ?>"
                               class="projet-titre">
                                <?php echo e($projet->titre); ?>

                            </a>
                        </td>

                        <td class="td-muted">
                            <?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?>

                        </td>

                        <td class="td-muted">
                            <?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?>

                        </td>

                        <td class="td-budget">
                            <?php echo e($projet->montantDemande
                                ? number_format($projet->montantDemande,0,',',' ')
                                .' F CFA'
                                : '—'); ?>

                        </td>

                        <td>
                            <span class="status-badge <?php echo e($statusClass); ?>">
                                <?php echo e($statusLabel); ?>

                            </span>
                        </td>

                        <td class="td-muted">
                            <?php echo e(optional($projet->dateSoumission)->format('d/m/Y') ?? '—'); ?>

                        </td>

                        <td>

                            <div class="td-actions">

                                
                                <a href="<?php echo e(route('approbateur.projets.show',$projet)); ?>"
                                   class="btn-icon"
                                   title="Examiner">
                                    <i class="fas fa-eye"></i>
                                </a>

                                
                                <?php if($projet->statutProjet === 'soumis'): ?>

                                    <form method="POST"
                                          action="<?php echo e(route('approbateur.projets.examiner',$projet)); ?>"
                                          onsubmit="return confirm('Mettre ce projet en examen ?')">

                                        <?php echo csrf_field(); ?>

                                        <button type="submit"
                                                class="btn-icon btn-icon-warning"
                                                title="Mettre en examen">
                                            <i class="fas fa-search"></i>
                                        </button>

                                    </form>

                                <?php endif; ?>


                                
                                <?php if($projet->statutProjet === 'en_examen'): ?>

                                    <button type="button"
                                            class="btn-icon btn-icon-success"
                                            title="Approuver"
                                            onclick="openApprouver(<?php echo e($projet->id); ?>)">

                                        <i class="fas fa-check"></i>

                                    </button>

                                    <button type="button"
                                            class="btn-icon btn-icon-danger"
                                            title="Rejeter"
                                            onclick="openRejeter(<?php echo e($projet->id); ?>)">

                                        <i class="fas fa-times"></i>

                                    </button>

                                <?php endif; ?>

                            </div>

                        </td>

                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>
                        <td colspan="8" class="td-empty">
                            <i class="fas fa-folder-open"></i>
                            <p>Aucun projet trouvé.</p>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/approbateur/projets/index.blade.php ENDPATH**/ ?>