<?php $__env->startSection('title', 'Tableau de bord'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/adminDash.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="adm-wrap">


<div class="adm-banner">
    <div>
        <p class="adm-banner-sub">Bienvenue,</p>
        <h2 class="adm-banner-name"><?php echo e(Auth::user()->nomComplet); ?></h2>
        <p class="adm-banner-role"><?php echo e(Auth::user()->email); ?> &middot; <?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?></p>
    </div>
    <div class="adm-banner-icon"><i class="fas fa-shield-alt"></i></div>
    <div class="adm-banner-circle c1"></div>
    <div class="adm-banner-circle c2"></div>
</div>


<div class="adm-stats">
    <?php
        $statItems = [
            ['lbl'=>'Total projets', 'val'=>$totalProjets,     'icon'=>'fa-folder',       'hint'=>'Tous confondus'],
            ['lbl'=>'Soumis',        'val'=>$projetsSoumis,    'icon'=>'fa-paper-plane',  'hint'=>'En attente'],
            ['lbl'=>'En examen',     'val'=>$projetsEnExamen,  'icon'=>'fa-search',       'hint'=>'En cours'],
            ['lbl'=>'Approuvés',     'val'=>$projetsApprouves, 'icon'=>'fa-check-circle', 'hint'=>'À valider'],
            ['lbl'=>'Validés',       'val'=>$projetsValides,   'icon'=>'fa-medal',        'hint'=>'Finalisés'],
            ['lbl'=>'Rejetés',       'val'=>$projetsRejetes,   'icon'=>'fa-times-circle', 'hint'=>'Non retenus'],
        ];
    ?>
    <?php $__currentLoopData = $statItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="adm-stat">
        <div class="adm-stat-top">
            <span class="adm-stat-lbl"><?php echo e($s['lbl']); ?></span>
            <div class="adm-stat-ic"><i class="fas <?php echo e($s['icon']); ?>"></i></div>
        </div>
        <p class="adm-stat-val"><?php echo e($s['val']); ?></p>
        <p class="adm-stat-hint"><?php echo e($s['hint']); ?></p>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="adm-meta-grid">
    <div class="adm-meta-card">
        <div class="adm-meta-ic"><i class="fas fa-users"></i></div>
        <div>
            <p class="adm-meta-lbl">Utilisateurs</p>
            <p class="adm-meta-val"><?php echo e($totalUsers); ?></p>
            <p class="adm-meta-hint"><?php echo e($usersActifs); ?> actifs · <?php echo e($usersInactifs); ?> inactifs</p>
        </div>
    </div>
    <div class="adm-meta-card">
        <div class="adm-meta-ic"><i class="fas fa-tags"></i></div>
        <div>
            <p class="adm-meta-lbl">Secteurs</p>
            <p class="adm-meta-val"><?php echo e($totalSecteurs); ?></p>
            <p class="adm-meta-hint"><?php echo e($secteursActifs); ?> actifs</p>
        </div>
    </div>
    <div class="adm-meta-card">
        <div class="adm-meta-ic"><i class="fas fa-user-tie"></i></div>
        <div>
            <p class="adm-meta-lbl">Porteurs</p>
            <p class="adm-meta-val"><?php echo e($usersByRole->get('porteur', 0)); ?></p>
            <p class="adm-meta-hint">Porteurs de projet</p>
        </div>
    </div>
    <div class="adm-meta-card <?php echo e($projetsBloquesCount > 0 ? 'adm-meta-warn' : ''); ?>">
        <div class="adm-meta-ic"><i class="fas fa-exclamation-triangle"></i></div>
        <div>
            <p class="adm-meta-lbl">Bloqués</p>
            <p class="adm-meta-val"><?php echo e($projetsBloquesCount); ?></p>
            <p class="adm-meta-hint">Sans action depuis +10j</p>
        </div>
    </div>
</div>


<a href="<?php echo e(route('admin.analytique')); ?>" class="analytique-link">
    <div class="analytique-link-left">
        <div class="analytique-link-ic"><i class="fas fa-chart-bar"></i></div>
        <div>
            <p class="analytique-link-title">Tableau analytique</p>
            <p class="analytique-link-sub">Entonnoir · Délais · Secteurs · Porteurs · Rejets · Projets bloqués · Charge équipes</p>
        </div>
    </div>
    <span class="analytique-link-cta">Accéder <i class="fas fa-arrow-right"></i></span>
</a>


<div class="adm-main-grid">

    
    <div class="card">
        <div class="card-head">
            <h3 class="card-title">Projets récents</h3>
            <a href="<?php echo e(route('admin.projets.index')); ?>" class="link-more">Voir tous <i class="fas fa-arrow-right"></i></a>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $projetsRecents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $map = [
                'brouillon' => ['lbl'=>'Brouillon', 'dot'=>'#9ca3af','bg'=>'#f3f4f6','color'=>'#6b7280'],
                'soumis'    => ['lbl'=>'Soumis',    'dot'=>'#6366f1','bg'=>'#eef2ff','color'=>'#4338ca'],
                'en_examen' => ['lbl'=>'En examen', 'dot'=>'#f97316','bg'=>'#fff7ed','color'=>'#c2410c'],
                'approuve'  => ['lbl'=>'Approuvé',  'dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d'],
                'valide'    => ['lbl'=>'Validé',    'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e'],
                'rejete'    => ['lbl'=>'Rejeté',    'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c'],
            ];
            $s = $map[$projet->statutProjet] ?? $map['brouillon'];
        ?>
        <a href="<?php echo e(route('admin.projets.show', $projet)); ?>" class="projet-row">
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
            <p>Aucun projet pour le moment</p>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="adm-aside">

        
        <div class="card">
            <div class="card-head">
                <h3 class="card-title">Utilisateurs récents</h3>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="link-more">Voir tous <i class="fas fa-arrow-right"></i></a>
            </div>
            <?php $__empty_1 = true; $__currentLoopData = $usersRecents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $roleMap = [
                    'admin'       => ['lbl'=>'Admin',      'bg'=>'#faf5ff','color'=>'#7e22ce'],
                    'approbateur' => ['lbl'=>'Approbateur','bg'=>'#eef2ff','color'=>'#4338ca'],
                    'validateur'  => ['lbl'=>'Validateur', 'bg'=>'#f0fdfa','color'=>'#0f766e'],
                    'porteur'     => ['lbl'=>'Porteur',    'bg'=>'#f0fdf4','color'=>'#15803d'],
                ];
                $r = $roleMap[$user->role] ?? ['lbl'=>ucfirst($user->role),'bg'=>'#f3f4f6','color'=>'#6b7280'];
            ?>
            <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="user-row">
                <div class="user-avatar">
                    <?php echo e(strtoupper(substr($user->nomComplet ?? 'U', 0, 1))); ?>

                </div>
                <div class="projet-info">
                    <p class="projet-name"><?php echo e($user->nomComplet); ?></p>
                    <p class="projet-sub"><?php echo e($user->email); ?></p>
                </div>
                <span class="status-badge" style="background:<?php echo e($r['bg']); ?>;color:<?php echo e($r['color']); ?>;">
                    <?php echo e($r['lbl']); ?>

                </span>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state"><i class="fas fa-users"></i><p>Aucun utilisateur</p></div>
            <?php endif; ?>
        </div>

        
        <div class="card">
            <div class="card-head" style="border-bottom:none;">
                <h3 class="card-title">Raccourcis</h3>
            </div>
            <div class="adm-shortcuts">
                <a href="<?php echo e(route('admin.users.create')); ?>" class="shortcut-item">
                    <div class="shortcut-ic"><i class="fas fa-user-plus"></i></div>
                    <span>Nouvel utilisateur</span>
                </a>
                <a href="<?php echo e(route('admin.secteurs.create')); ?>" class="shortcut-item">
                    <div class="shortcut-ic"><i class="fas fa-plus-circle"></i></div>
                    <span>Nouveau secteur</span>
                </a>
                <a href="<?php echo e(route('admin.projets.index')); ?>" class="shortcut-item">
                    <div class="shortcut-ic"><i class="fas fa-folder-open"></i></div>
                    <span>Tous les projets</span>
                </a>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="shortcut-item">
                    <div class="shortcut-ic"><i class="fas fa-users-cog"></i></div>
                    <span>Gérer les users</span>
                </a>
            </div>
        </div>

    </div>
</div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>