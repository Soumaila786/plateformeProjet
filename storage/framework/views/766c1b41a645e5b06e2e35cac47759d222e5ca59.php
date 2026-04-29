<?php $__env->startSection('title', 'Projets à valider'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/validateur.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="valid-page">

    
    <div class="valid-header">
        <div>
            <h1 class="valid-header-title">Projets à valider</h1>
            <p class="valid-header-sub"><?php echo e($projets->total()); ?> projet(s) en attente de validation</p>
        </div>
        <a href="<?php echo e(route('validateur.projets.mes_projets')); ?>" class="valid-btn valid-btn-outline">
            <i class="fas fa-history"></i> Mes projets traités
        </a>
    </div>

    
    <?php if(session('success')): ?>
    <div class="valid-alert valid-alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <form method="GET" action="<?php echo e(route('validateur.projets.index')); ?>" id="filterForm">
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

            <button type="submit" class="valid-filter-btn">
                <i class="fas fa-filter"></i> Filtrer
            </button>

            <?php if(request('search') || request('secteur_id')): ?>
            <a href="<?php echo e(route('validateur.projets.index')); ?>" class="valid-reset-btn">
                <i class="fas fa-times"></i> Réinitialiser
            </a>
            <?php endif; ?>
        </div>
    </form>

    
    <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="valid-projet-row approuve">

        <div class="valid-projet-avatar">
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
                <?php if($projet->dateApprobation): ?>
                <span><i class="fas fa-calendar-check"></i>Approuvé le <?php echo e($projet->dateApprobation->format('d/m/Y')); ?></span>
                <?php endif; ?>
            </p>
        </div>

        <div class="valid-projet-badges">
            <span class="valid-badge valid-badge-approuve">
                <span class="valid-dot" style="background:#0d9488;"></span>
                Approuvé
            </span>
            <a href="<?php echo e(route('validateur.projets.show', $projet)); ?>"
                class="valid-btn valid-btn-primary" style="font-size:.75rem;padding:7px 13px;">
                <i class="fas fa-eye"></i> Examiner
            </a>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="valid-empty">
        <i class="fas fa-check-double" style="color:var(--valid-primary);"></i>
        <p>Aucun projet en attente de validation.</p>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/validateur/projets/index.blade.php ENDPATH**/ ?>