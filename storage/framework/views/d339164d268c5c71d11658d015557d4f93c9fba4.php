<?php $__env->startSection('title', 'Mes projets traités'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/validateur.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="valid-page">

    
    <div class="valid-header">
        <div>
            <h1 class="valid-header-title">Mes projets traités</h1>
            <p class="valid-header-sub"><?php echo e($projets->total()); ?> projet(s) traité(s)</p>
        </div>
        <a href="<?php echo e(route('validateur.projets.index')); ?>" class="valid-btn-back">
            <i class="fas fa-arrow-left"></i> À valider
        </a>
    </div>

    
    <form method="GET" action="<?php echo e(route('validateur.projets.mes_projets')); ?>" id="filterForm">
        <div class="valid-search-bar">
            <div class="valid-search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" name="search" id="searchInput"
                       value="<?php echo e(request('search')); ?>"
                       placeholder="Rechercher par titre ou code...">
            </div>

            <select name="secteur_id" class="valid-select"
                    onchange="document.getElementById('filterForm').submit()">
                <option value="">Tous les secteurs</option>
                <?php $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($secteur->id); ?>" <?php echo e(request('secteur_id') == $secteur->id ? 'selected' : ''); ?>>
                    <?php echo e($secteur->nomSecteur); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="statut" class="valid-select"
                    onchange="document.getElementById('filterForm').submit()">
                <option value="">Tous les statuts</option>
                <option value="valide" <?php echo e(request('statut') === 'valide' ? 'selected' : ''); ?>>Validés</option>
                <option value="rejete" <?php echo e(request('statut') === 'rejete' ? 'selected' : ''); ?>>Rejetés</option>
            </select>

            <button type="submit" class="valid-filter-btn">
                <i class="fas fa-filter"></i> Filtrer
            </button>

            <?php if(request('search') || request('secteur_id') || request('statut')): ?>
            <a href="<?php echo e(route('validateur.projets.mes_projets')); ?>" class="valid-reset-btn">
                <i class="fas fa-times"></i> Réinitialiser
            </a>
            <?php endif; ?>
        </div>
    </form>

    
    <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $stMap = [
            'valide' => ['lbl'=>'Validé', 'cls'=>'valid-badge-valide', 'dot'=>'#15803d'],
            'rejete' => ['lbl'=>'Rejeté', 'cls'=>'valid-badge-rejete', 'dot'=>'#ef4444'],
        ];
        $st = $stMap[$projet->statutProjet] ?? ['lbl'=>$projet->statutProjet,'cls'=>'','dot'=>'#9ca3af'];
        $dateTraitement = $projet->validated_at ?? $projet->updated_at;
    ?>

    <div class="valid-projet-row <?php echo e($projet->statutProjet); ?>">

        <div class="valid-projet-avatar"
             style="<?php echo e($projet->statutProjet === 'rejete' ? 'background:var(--valid-red-light);color:var(--valid-red);border-color:var(--valid-red-border);' : ''); ?>">
            <?php echo e(strtoupper(substr(optional($projet->secteur)->nomSecteur ?? $projet->titre, 0, 1))); ?>

        </div>

        <div class="valid-projet-info">
            <div class="valid-projet-top">
                <span class="valid-projet-code"><?php echo e($projet->codeProjet); ?></span>
                <span class="valid-projet-titre"><?php echo e($projet->titre); ?></span>
            </div>
            <p class="valid-projet-meta">
                <span><i class="fas fa-user"></i><?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?></span>
                <span><i class="fas fa-tag"></i><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></span>
                <?php if($projet->montantDemande): ?>
                <span><i class="fas fa-coins"></i><strong><?php echo e(number_format($projet->montantDemande, 0, ',', ' ')); ?> F CFA</strong></span>
                <?php endif; ?>
                <?php if($dateTraitement): ?>
                <span><i class="fas fa-calendar-check"></i>Traité le <?php echo e($dateTraitement->format('d/m/Y')); ?></span>
                <?php endif; ?>
            </p>
            
            <?php if($projet->statutProjet === 'rejete' && $projet->motifRejet): ?>
            <div style="margin-top:6px;padding:6px 10px;background:var(--valid-red-light);
                        border:1px solid var(--valid-red-border);border-radius:var(--valid-radius-md);
                        font-size:.74rem;color:var(--valid-red);">
                <i class="fas fa-comment-alt" style="margin-right:4px;"></i>
                <strong>Motif :</strong> <?php echo e($projet->motifRejet); ?>

            </div>
            <?php endif; ?>
        </div>

        <div class="valid-projet-badges">
            <span class="valid-badge <?php echo e($st['cls']); ?>">
                <span class="valid-dot" style="background:<?php echo e($st['dot']); ?>;"></span>
                <?php echo e($st['lbl']); ?>

            </span>
            <a href="<?php echo e(route('validateur.projets.show', $projet)); ?>"
               class="valid-btn valid-btn-outline valid-btn-icon" title="Voir">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="valid-empty">
        <i class="fas fa-folder-open"></i>
        <p>
            <?php if(request('statut') || request('search') || request('secteur_id')): ?>
                Aucun projet ne correspond à votre recherche.
            <?php else: ?>
                Vous n'avez traité aucun projet pour le moment.
            <?php endif; ?>
        </p>
    </div>
    <?php endif; ?>

    <div class="valid-pagination">
        <?php echo e($projets->withQueryString()->links()); ?>

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
    }, 450);
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/validateur/projets/mes_projets.blade.php ENDPATH**/ ?>