<?php $__env->startSection('title', 'Tableau de bord — Approbateur'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/approbDash.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="adash">


<div class="ad-banner">
    <div>
        <p class="ad-banner-sub">Bienvenue,</p>
        <h2 class="ad-banner-name"><?php echo e(Auth::user()->nomComplet); ?></h2>
        <p class="ad-banner-role">Approbateur &middot; <?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?></p>
    </div>
    <div class="ad-banner-icon"><i class="fas fa-check-double"></i></div>
    <div class="ad-banner-circle c1"></div>
    <div class="ad-banner-circle c2"></div>
</div>


<div class="ad-stats">
    <div class="ad-stat">
        <div class="ad-stat-top"><span class="ad-stat-lbl">Total</span><div class="ad-stat-ic"><i class="fas fa-folder"></i></div></div>
        <p class="ad-stat-val"><?php echo e($totalProjets); ?></p>
        <p class="ad-stat-hint">Tous projets</p>
    </div>
    <div class="ad-stat">
        <div class="ad-stat-top"><span class="ad-stat-lbl">Soumis</span><div class="ad-stat-ic"><i class="fas fa-paper-plane"></i></div></div>
        <p class="ad-stat-val"><?php echo e($soumis); ?></p>
        <p class="ad-stat-hint">En attente</p>
    </div>
    <div class="ad-stat">
        <div class="ad-stat-top"><span class="ad-stat-lbl">En examen</span><div class="ad-stat-ic"><i class="fas fa-search"></i></div></div>
        <p class="ad-stat-val"><?php echo e($enExamen); ?></p>
        <p class="ad-stat-hint">En cours</p>
    </div>
    <div class="ad-stat">
        <div class="ad-stat-top"><span class="ad-stat-lbl">Approuvés</span><div class="ad-stat-ic"><i class="fas fa-check-circle"></i></div></div>
        <p class="ad-stat-val"><?php echo e($approuve); ?></p>
        <p class="ad-stat-hint">Transmis au validateur</p>
    </div>
    <div class="ad-stat">
        <div class="ad-stat-top"><span class="ad-stat-lbl">Validés</span><div class="ad-stat-ic"><i class="fas fa-medal"></i></div></div>
        <p class="ad-stat-val"><?php echo e($valide); ?></p>
        <p class="ad-stat-hint">Finalisés</p>
    </div>
    <div class="ad-stat">
        <div class="ad-stat-top"><span class="ad-stat-lbl">Rejetés</span><div class="ad-stat-ic"><i class="fas fa-times-circle"></i></div></div>
        <p class="ad-stat-val"><?php echo e($rejete); ?></p>
        <p class="ad-stat-hint">Non retenus</p>
    </div>
</div>


<a href="<?php echo e(route('approbateur.analytique')); ?>" class="analytique-link">
    <div class="analytique-link-left">
        <div class="analytique-link-ic"><i class="fas fa-chart-bar"></i></div>
        <div>
            <p class="analytique-link-title">Tableau analytique</p>
            <p class="analytique-link-sub">Entonnoir, délais, budgets, motifs de rejet, secteurs, top porteurs…</p>
        </div>
    </div>
    <span class="analytique-link-cta">Accéder <i class="fas fa-arrow-right"></i></span>
</a>


<div class="ad-main-grid">

    
    <div class="card">
        <div class="card-head">
            <h3 class="card-title">Projets récents</h3>
            <a href="<?php echo e(route('approbateur.projets.index')); ?>" class="link-more">Voir tous <i class="fas fa-arrow-right"></i></a>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $projetsRecents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $map = [
                'soumis'    => ['lbl'=>'Soumis',   'dot'=>'#6366f1','bg'=>'#eef2ff','color'=>'#4338ca'],
                'en_examen' => ['lbl'=>'En examen','dot'=>'#f97316','bg'=>'#fff7ed','color'=>'#c2410c'],
                'approuve'  => ['lbl'=>'Approuvé', 'dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d'],
                'rejete'    => ['lbl'=>'Rejeté',   'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c'],
            ];
            $s = $map[$projet->statutProjet] ?? $map['soumis'];
        ?>
        <a href="<?php echo e(route('approbateur.projets.show', $projet)); ?>" class="projet-row">
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

    
    <div class="ad-aside">

        
        <?php if($projetsUrgents->count() > 0): ?>
        <div class="card action-card">
            <div class="card-head action-head">
                <i class="fas fa-exclamation-circle"></i>
                <h3 class="card-title">À traiter (<?php echo e($projetsUrgents->count()); ?>)</h3>
            </div>
            <?php $__currentLoopData = $projetsUrgents->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('approbateur.projets.show', $p)); ?>" class="action-row">
                <span class="dot" style="background:<?php echo e($p->statutProjet === 'en_examen' ? '#f97316' : '#6366f1'); ?>;margin-top:4px;flex-shrink:0;"></span>
                <p class="action-title"><?php echo e(Str::limit($p->titre, 46)); ?></p>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($projetsUrgents->count() > 4): ?>
            <div style="padding:6px 14px 10px;">
                <a href="<?php echo e(route('approbateur.projets.index')); ?>" class="link-more">
                    +<?php echo e($projetsUrgents->count() - 4); ?> autres <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        
        <div class="card">
            <div class="card-head" style="border-bottom:none;">
                <h3 class="card-title">Suivi</h3>
                <a href="<?php echo e(route('approbateur.projets.index')); ?>" class="link-more">Voir tout</a>
            </div>
            <?php $__currentLoopData = [
                ['statut'=>'soumis',   'lbl'=>'Soumis',   'dot'=>'#6366f1','bg'=>'#eef2ff','color'=>'#4338ca','val'=>$soumis],
                ['statut'=>'en_examen','lbl'=>'En examen','dot'=>'#f97316','bg'=>'#fff7ed','color'=>'#c2410c','val'=>$enExamen],
                ['statut'=>'approuve', 'lbl'=>'Approuvés','dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d','val'=>$approuve],
                ['statut'=>'rejete',   'lbl'=>'Rejetés',  'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c','val'=>$rejete],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($item['val'] > 0): ?>
            <a href="<?php echo e(route('approbateur.projets.index', ['statut'=>$item['statut']])); ?>" class="mp-row">
                <span class="status-badge" style="background:<?php echo e($item['bg']); ?>;color:<?php echo e($item['color']); ?>;">
                    <span class="dot" style="background:<?php echo e($item['dot']); ?>;"></span><?php echo e($item['lbl']); ?>

                </span>
                <span class="mp-count"><?php echo e($item['val']); ?></span>
            </a>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div style="padding:10px 16px 12px;">
                <a href="<?php echo e(route('approbateur.projets.index', ['statut'=>'soumis'])); ?>" class="btn-primary">
                    <i class="fas fa-inbox"></i>&nbsp;Voir les projets soumis
                </a>
            </div>
        </div>

    </div>
</div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/approbateur/dashboard.blade.php ENDPATH**/ ?>