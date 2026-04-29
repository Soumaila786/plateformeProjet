<?php $__env->startSection('title', 'Projets à traiter'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/planifDash.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="plan-page">

    
    <div class="plan-header">
        <div>
            <h1 class="plan-header-title">
                <i class="fas fa-inbox" style="color:var(--plan-primary);font-size:1rem;"></i>
                Projets à planifier
            </h1>
            <p class="plan-header-sub">Projets dont le porteur a demandé une planification</p>
        </div>
        <?php if($projets->total() > 0): ?>
        <span class="plan-badge plan-badge-violet" style="font-size:.78rem;padding:5px 12px;">
            <?php echo e($projets->total()); ?> demande(s)
        </span>
        <?php endif; ?>
    </div>

    
    <?php if(session('success')): ?>
    <div class="plan-alert plan-alert-success">
        <i class="fas fa-check-circle"></i>
        <span><?php echo e(session('success')); ?></span>
    </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
    <div class="plan-alert plan-alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <span><?php echo e(session('error')); ?></span>
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
        <a href="<?php echo e(route('planificateur.projets.index')); ?>" class="plan-reset-btn">
            <i class="fas fa-times"></i> Réinitialiser
        </a>
        <?php endif; ?>
    </form>

    
    <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="plan-projet-row urgent">

        
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
        </div>

        
        <div class="plan-projet-badges">
            <span class="plan-badge plan-badge-orange">
                <?php if($projet->updated_at): ?>
                <i class="fas fa-clock" style="font-size:.6rem;"></i>
                <?php echo e($projet->updated_at->diffForHumans()); ?>

                <?php endif; ?>
            </span>
            <a href="<?php echo e(route('planificateur.projets.show', $projet)); ?>" class="plan-btn-planifier">
                <i class="fas fa-calendar-plus"></i> Planifier
            </a>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="plan-empty">
        <i class="fas fa-inbox"></i>
        <p>Aucune demande de planification en attente.</p>
        <p style="font-size:.75rem;color:var(--plan-text-light);">
            Les demandes des porteurs apparaîtront ici.
        </p>
    </div>
    <?php endif; ?>

    
    <div class="plan-pagination mt-4">
        <?php echo e($projets->appends(request()->query())->links()); ?>

    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/planificateur/projets/index.blade.php ENDPATH**/ ?>