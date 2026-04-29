<?php $__env->startSection('title', 'Projets traités'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/planifDash.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="plan-page">

    
    <div class="plan-header">
        <div>
            <h1 class="plan-header-title">
                <i class="fas fa-folder-open" style="color:var(--plan-primary);font-size:1rem;"></i>
                Projets traités
            </h1>
            <p class="plan-header-sub">Projets ayant déjà des activités de planification</p>
        </div>
        <?php if($projets->total() > 0): ?>
        <span class="plan-badge plan-badge-green" style="font-size:.78rem;padding:5px 12px;">
            <?php echo e($projets->total()); ?> projet(s)
        </span>
        <?php endif; ?>
    </div>

    
    <?php if(session('success')): ?>
    <div class="plan-alert plan-alert-success">
        <i class="fas fa-check-circle"></i>
        <span><?php echo e(session('success')); ?></span>
    </div>
    <?php endif; ?>

    
    <form method="GET" class="plan-search-bar">
        <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                placeholder="Rechercher par titre ou code..."
                class="plan-search-input">
        <button type="submit" class="plan-search-btn">
            <i class="fas fa-search"></i> Rechercher
        </button>
        <?php if(request('search')): ?>
        <a href="<?php echo e(route('planificateur.projets.traites')); ?>" class="plan-reset-btn">
            <i class="fas fa-times"></i> Réinitialiser
        </a>
        <?php endif; ?>
    </form>

    
    <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $nbAct  = $projet->planifications->count();
        $cout   = $projet->planifications->sum('coutEstimatif');
        $budget = $projet->budgetTotal ?? 0;
        $pct    = $budget > 0 ? min(100, round($cout / $budget * 100)) : 0;
    ?>
    <div class="plan-projet-row">

        
        <div class="plan-projet-avatar">
            <?php echo e(strtoupper(substr(optional($projet->secteur)->nomSecteur ?? $projet->titre, 0, 1))); ?>

        </div>

        
        <div class="plan-projet-info">
            <div class="plan-projet-top">
                <span class="plan-projet-code"><?php echo e($projet->codeProjet); ?></span>
                <span class="plan-projet-titre"><?php echo e($projet->titre); ?></span>
            </div>
            <p class="plan-projet-meta">
                <span><i class="fas fa-user"></i><?php echo e(optional($projet->user)->nomComplet ?? '—'); ?></span>
                <span><i class="fas fa-tag"></i><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></span>
            </p>
            
            <?php if($budget > 0): ?>
            <div class="plan-progress-wrap">
                <div class="plan-progress-bar">
                    <div class="plan-progress-fill" style="width:<?php echo e($pct); ?>%;"></div>
                </div>
                <div class="plan-progress-label">
                    <span>Coût planifié</span>
                    <span>
                        <?php echo e(number_format($cout, 0, ',', ' ')); ?> F / <?php echo e(number_format($budget, 0, ',', ' ')); ?> F (<?php echo e($pct); ?>%)
                    </span>
                </div>
            </div>
            <?php endif; ?>
        </div>

        
        <div class="plan-projet-badges">
            <span class="plan-badge plan-badge-green">
                <i class="fas fa-check" style="font-size:.6rem;"></i>
                <?php echo e($nbAct); ?> activité(s)
            </span>
            <a href="<?php echo e(route('planificateur.projets.show', $projet)); ?>" class="plan-btn plan-btn-outline">
                <i class="fas fa-eye"></i> Voir
            </a>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="plan-empty">
        <i class="fas fa-folder-open"></i>
        <p>Aucun projet traité pour l'instant.</p>
        <a href="<?php echo e(route('planificateur.projets.index')); ?>" class="plan-btn plan-btn-primary" style="margin-top:8px;">
            <i class="fas fa-inbox"></i> Voir les demandes
        </a>
    </div>
    <?php endif; ?>

    <div class="plan-pagination">
        <?php echo e($projets->appends(request()->query())->links()); ?>

    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/planificateur/projets/traites.blade.php ENDPATH**/ ?>