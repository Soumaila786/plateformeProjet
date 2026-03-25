<?php $__env->startSection('title', 'Projets à valider'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/validDash.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="vpage">

    
    <div class="page-header">
        <div>
            <h1 class="page-title">Projets à valider</h1>
            <p class="page-sub"><?php echo e($projets->total()); ?> projet<?php echo e($projets->total() > 1 ? 's' : ''); ?> au total</p>
        </div>
    </div>

    
    <div class="filters">
        <div class="search-wrap">
            <i class="fas fa-search search-ico"></i>
            <input type="text" id="searchInput" class="search-input"
                    placeholder="Rechercher par titre ou code..."
                    value="<?php echo e(request('search')); ?>">
        </div>
        <select id="secteurFilter" class="filter-select">
            <option value="">Tous les secteurs</option>
            <?php $__currentLoopData = $secteurs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($secteur->id); ?>" <?php echo e(request('secteur') == $secteur->id ? 'selected' : ''); ?>>
                <?php echo e($secteur->nomSecteur); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <div class="status-pills">
            <?php $statuts = ['' => 'Tous', 'approuve' => 'Approuvés', 'valide' => 'Validés', 'rejete' => 'Rejetés']; ?>
            <?php $__currentLoopData = $statuts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('validateur.projets.index', array_merge(request()->query(), ['statut'=>$val]))); ?>"
                class="pill <?php echo e(request('statut','') === $val ? 'active' : ''); ?>"><?php echo e($lbl); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="proj-grid">
        <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $map = [
                'approuve' => ['lbl'=>'Approuvé','dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d'],
                'valide'   => ['lbl'=>'Validé',  'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e'],
                'rejete'   => ['lbl'=>'Rejeté',  'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c'],
            ];
            $s = $map[$projet->statutProjet] ?? $map['approuve'];
        ?>
        <div class="proj-card">
            <div class="proj-card-head">
                <span class="status-badge" style="background:<?php echo e($s['bg']); ?>;color:<?php echo e($s['color']); ?>;">
                    <span class="dot" style="background:<?php echo e($s['dot']); ?>;"></span><?php echo e($s['lbl']); ?>

                </span>
                <span class="proj-code"><?php echo e($projet->codeProjet); ?></span>
            </div>
            <h3 class="proj-titre"><?php echo e(Str::limit($projet->titre, 55)); ?></h3>
            <p class="proj-objectif"><?php echo e(Str::limit($projet->objectif ?? '—', 80)); ?></p>
            <div class="proj-details">
                <div class="proj-detail">
                    <i class="fas fa-wallet"></i>
                    <span>Budget : <strong><?php echo e(number_format($projet->budgetTotal ?? 0, 0, ',', ' ')); ?> F CFA</strong></span>
                </div>
                <div class="proj-detail">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>Demandé : <strong><?php echo e(number_format($projet->montantDemande ?? 0, 0, ',', ' ')); ?> F CFA</strong></span>
                </div>
                <div class="proj-detail">
                    <i class="fas fa-tag"></i>
                    <span><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></span>
                </div>
                <div class="proj-detail">
                    <i class="fas fa-user"></i>
                    <span><?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?></span>
                </div>
            </div>
            <a href="<?php echo e(route('validateur.projets.show', $projet)); ?>" class="btn-examiner">
                <i class="fas fa-shield-alt"></i> Examiner le projet
            </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state" style="grid-column:1/-1;">
            <i class="fas fa-check-double"></i>
            <p>Aucun projet en attente de validation.</p>
        </div>
        <?php endif; ?>
    </div>

    <?php if($projets->hasPages()): ?>
    <div style="margin-top:16px;"><?php echo e($projets->withQueryString()->links()); ?></div>
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
document.getElementById('secteurFilter').addEventListener('change', function () {
    const url = new URL(window.location.href);
    this.value ? url.searchParams.set('secteur', this.value) : url.searchParams.delete('secteur');
    url.searchParams.delete('page');
    window.location.href = url.toString();
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/validateur/projets/index.blade.php ENDPATH**/ ?>