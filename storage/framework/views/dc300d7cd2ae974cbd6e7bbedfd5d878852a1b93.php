<?php $__env->startSection('title', 'Tableau de bord'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/validDash.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="vdash">


<div class="vd-banner">
    <div>
        <p class="vd-banner-sub">Bienvenue,</p>
        <h2 class="vd-banner-name"><?php echo e(Auth::user()->nomComplet); ?></h2>
        <p class="vd-banner-role">Validateur &middot; <?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?></p>
    </div>
    <div class="vd-banner-icon"><i class="fas fa-medal"></i></div>
    <div class="vd-banner-circle c1"></div>
    <div class="vd-banner-circle c2"></div>
</div>


<div class="vd-stats">
    <div class="vd-stat">
        <div class="vd-stat-top"><span class="vd-stat-lbl">Total projets</span><div class="vd-stat-ic"><i class="fas fa-folder"></i></div></div>
        <p class="vd-stat-val"><?php echo e($totalProjets); ?></p>
        <p class="vd-stat-hint">Tous projets confondus</p>
    </div>
    <div class="vd-stat">
        <div class="vd-stat-top"><span class="vd-stat-lbl">Soumis</span><div class="vd-stat-ic"><i class="fas fa-paper-plane"></i></div></div>
        <p class="vd-stat-val"><?php echo e($soumis); ?></p>
        <p class="vd-stat-hint">En attente d'approbation</p>
    </div>
    <div class="vd-stat">
        <div class="vd-stat-top"><span class="vd-stat-lbl">Approuvés</span><div class="vd-stat-ic"><i class="fas fa-check-circle"></i></div></div>
        <p class="vd-stat-val"><?php echo e($enAttente); ?></p>
        <p class="vd-stat-hint">Prêts à être validés</p>
    </div>
    <div class="vd-stat">
        <div class="vd-stat-top"><span class="vd-stat-lbl">Validés</span><div class="vd-stat-ic"><i class="fas fa-medal"></i></div></div>
        <p class="vd-stat-val"><?php echo e($valides); ?></p>
        <p class="vd-stat-hint">Validés définitivement</p>
    </div>
    <div class="vd-stat">
        <div class="vd-stat-top"><span class="vd-stat-lbl">Rejetés</span><div class="vd-stat-ic"><i class="fas fa-times-circle"></i></div></div>
        <p class="vd-stat-val"><?php echo e($rejetes); ?></p>
        <p class="vd-stat-hint">Projets non retenus</p>
    </div>
</div>


<a href="<?php echo e(route('validateur.analytique')); ?>" class="analytique-banner">
    <div class="analytique-banner-left">
        <div class="analytique-icon"><i class="fas fa-chart-line"></i></div>
        <div>
            <p class="analytique-title">Tableau analytique</p>
            <p class="analytique-sub">Entonnoir, délais, répartition, évolution financière, heatmap secteurs…</p>
        </div>
    </div>
    <span class="analytique-cta">Accéder <i class="fas fa-arrow-right"></i></span>
</a>


<div class="vd-main-grid">

    
    <div class="card">
        <div class="card-head">
            <h3 class="card-title">Projets récents</h3>
            <a href="<?php echo e(route('validateur.projets.index')); ?>" class="link-more">Voir tous <i class="fas fa-arrow-right"></i></a>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $projetsRecents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $map = [
                'approuve' => ['lbl'=>'Approuvé','dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d'],
                'valide'   => ['lbl'=>'Validé',  'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e'],
                'rejete'   => ['lbl'=>'Rejeté',  'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c'],
            ];
            $s = $map[$projet->statutProjet] ?? $map['approuve'];
        ?>
        <a href="<?php echo e(route('validateur.projets.show', $projet)); ?>" class="projet-row">
            <div class="projet-avatar">
                <?php echo e(strtoupper(substr(optional($projet->secteur)->nomSecteur ?? $projet->titre, 0, 1))); ?>

            </div>
            <div class="projet-info">
                <p class="projet-name"><?php echo e($projet->titre); ?></p>
                <p class="projet-sub">
                    <?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?>

                    &middot; <?php echo e(optional($projet->updated_at)->translatedFormat('d F Y')); ?>

                </p>
            </div>
            <span class="status-badge" style="background:<?php echo e($s['bg']); ?>;color:<?php echo e($s['color']); ?>;">
                <span class="dot" style="background:<?php echo e($s['dot']); ?>;"></span><?php echo e($s['lbl']); ?>

            </span>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state">
            <i class="fas fa-folder-open"></i>
            <p>Aucun projet à traiter pour le moment</p>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="vd-aside">

        
        <?php if($projetsUrgents->count() > 0): ?>
        <div class="card action-card">
            <div class="card-head action-head">
                <i class="fas fa-exclamation-circle"></i>
                <h3 class="card-title">À valider (<?php echo e($projetsUrgents->count()); ?>)</h3>
            </div>
            <?php $__currentLoopData = $projetsUrgents->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('validateur.projets.show', $p)); ?>" class="action-row">
                <span class="dot" style="background:#0d419474;margin-top:4px;flex-shrink:0;"></span>
                <p class="action-title"><?php echo e(Str::limit($p->titre, 48)); ?></p>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($projetsUrgents->count() > 4): ?>
            <div style="padding:6px 14px 10px;">
                <a href="<?php echo e(route('validateur.projets.index', ['statut'=>'approuve'])); ?>" class="link-more">
                    +<?php echo e($projetsUrgents->count() - 4); ?> autres <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        
        <div class="card">
            <div class="card-head" style="border-bottom:none;">
                <h3 class="card-title">Suivi</h3>
                <a href="<?php echo e(route('validateur.projets.index')); ?>" class="link-more">Voir tout</a>
            </div>
            <?php $__currentLoopData = [
                ['statut'=>'approuve','lbl'=>'Approuvés','dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d','val'=>$enAttente],
                ['statut'=>'valide',  'lbl'=>'Validés',  'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e','val'=>$valides],
                ['statut'=>'rejete',  'lbl'=>'Rejetés',  'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c','val'=>$rejetes],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($item['val'] > 0): ?>
            <a href="<?php echo e(route('validateur.projets.index', ['statut'=>$item['statut']])); ?>" class="mp-row">
                <span class="status-badge" style="background:<?php echo e($item['bg']); ?>;color:<?php echo e($item['color']); ?>;">
                    <span class="dot" style="background:<?php echo e($item['dot']); ?>;"></span><?php echo e($item['lbl']); ?>

                </span>
                <span class="mp-count"><?php echo e($item['val']); ?></span>
            </a>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($enAttente === 0 && $valides === 0 && $rejetes === 0): ?>
            <p class="empty-text">Aucun projet</p>
            <?php endif; ?>
            <div style="padding:10px 16px 12px;">
                <a href="<?php echo e(route('validateur.projets.index', ['statut'=>'approuve'])); ?>" class="btn-primary">
                    <i class="fas fa-inbox"></i>&nbsp;Voir les projets à valider
                </a>
            </div>
        </div>

    </div>
</div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/validateur/dashboard.blade.php ENDPATH**/ ?>