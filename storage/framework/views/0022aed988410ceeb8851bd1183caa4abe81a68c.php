<?php $__env->startSection('title', 'Tableau de bord'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/porteur.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="dash">

    
    <div class="banner">
        <div>
            <p class="banner-sub">Bienvenue,</p>
            <h2 class="banner-name"><?php echo e(Auth::user()->nomComplet); ?></h2>
            <p class="banner-role"><?php echo e(Auth::user()->email); ?> &middot; <?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?></p>
        </div>
        <div class="banner-icon"><i class="fas fa-folder-open"></i></div>
        <div class="banner-circle c1"></div>
        <div class="banner-circle c2"></div>
    </div>

    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total projets</span>
                <div class="stat-icon"><i class="fas fa-folder"></i></div>
            </div>
            <p class="stat-val"><?php echo e($total); ?></p>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Soumis</span>
                <div class="stat-icon"><i class="fas fa-paper-plane"></i></div>
            </div>
            <p class="stat-val"><?php echo e($soumis); ?></p>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Approuvés</span>
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            </div>
            <p class="stat-val"><?php echo e($approuve); ?></p>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Validés</span>
                <div class="stat-icon"><i class="fas fa-medal"></i></div>
            </div>
            <p class="stat-val"><?php echo e($valide); ?></p>
        </div>
    </div>

    
    <div class="finance-grid">
        <div class="finance-card">
            <div class="finance-icon"><i class="fas fa-wallet"></i></div>
            <div>
                <p class="finance-label">Budget total</p>
                <p class="finance-amount"><?php echo e(number_format($budgetTotal, 0, ',', ' ')); ?> <span>F CFA</span></p>
                <p class="finance-sub">Tous projets confondus</p>
                <div class="finance-bar"><div style="width:100%;"></div></div>
            </div>
        </div>
        <div class="finance-card">
            <div class="finance-icon"><i class="fas fa-hand-holding-usd"></i></div>
            <div>
                <?php $pctD = $budgetTotal > 0 ? min(100, round($montantDemande / $budgetTotal * 100)) : 0; ?>
                <p class="finance-label">Montant demandé</p>
                <p class="finance-amount"><?php echo e(number_format($montantDemande, 0, ',', ' ')); ?> <span>F CFA</span></p>
                <p class="finance-sub"><?php echo e($pctD); ?>% du budget total</p>
                <div class="finance-bar"><div style="width:<?php echo e($pctD); ?>%;"></div></div>
            </div>
        </div>
        <div class="finance-card">
            <div class="finance-icon"><i class="fas fa-coins"></i></div>
            <div>
                <p class="finance-label">Montant financé</p>
                <p class="finance-amount"> — <span>F CFA</span></p>
                <p class="finance-sub">Non disponible</p>
                <div class="finance-bar"><div style="width:0%;"></div></div>
            </div>
        </div>
        <div class="finance-card">
            <div class="finance-icon"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <?php $restant = max(0, $montantDemande - 0); $pctR = $montantDemande > 0 ? 100 : 0; ?>
                <p class="finance-label">Restant à financer</p>
                <p class="finance-amount"><?php echo e(number_format($restant, 0, ',', ' ')); ?> <span>F CFA</span></p>
                <p class="finance-sub">Montant non encore financé</p>
                <div class="finance-bar"><div style="width:<?php echo e($pctR); ?>%;"></div></div>
            </div>
        </div>
    </div>

    
    <div class="main-grid">

        
        <div class="card">
            <div class="card-head">
                <h3 class="card-title">Projets récents</h3>
                <a href="<?php echo e(route('porteur.projets.index')); ?>" class="link-more">
                    Voir tous <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <?php $__empty_1 = true; $__currentLoopData = $projetsRecents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $map = [
                    'brouillon' => ['lbl'=>'Brouillon','dot'=>'#9ca3af','bg'=>'#f3f4f6','color'=>'#6b7280'],
                    'soumis'    => ['lbl'=>'Soumis',   'dot'=>'#6366f1','bg'=>'#eef2ff','color'=>'#4338ca'],
                    'en_examen' => ['lbl'=>'En examen','dot'=>'#f97316','bg'=>'#fff7ed','color'=>'#c2410c'],
                    'approuve'  => ['lbl'=>'Approuvé', 'dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d'],
                    'valide'    => ['lbl'=>'Validé',   'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e'],
                    'rejete'    => ['lbl'=>'Rejeté',   'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c'],
                ];
                $s = $map[$projet->statutProjet] ?? $map['brouillon'];
            ?>
            <a href="<?php echo e(route('porteur.projets.show', $projet)); ?>" class="projet-row">
                <div class="projet-avatar">
                    <?php echo e(strtoupper(substr(optional($projet->secteur)->nomSecteur ?? $projet->titre, 0, 1))); ?>

                </div>
                <div class="projet-info">
                    <p class="projet-name"><?php echo e($projet->titre); ?></p>
                    <p class="projet-sub">
                        <?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?>

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
                <a href="<?php echo e(route('porteur.projets.create')); ?>" class="btn-primary">
                    <i class="fas fa-plus"></i> Créer un projet
                </a>
            </div>
            <?php endif; ?>
        </div>

        
        <div class="aside">

            
            <div class="card">
                <div class="card-head" style="border-bottom:none;">
                    <h3 class="card-title">Mes projets</h3>
                    <a href="<?php echo e(route('porteur.projets.index')); ?>" class="link-more">Voir tout</a>
                </div>
                <?php $__currentLoopData = [
                    ['statut'=>'brouillon','lbl'=>'Brouillon','dot'=>'#9ca3af','bg'=>'#f3f4f6','color'=>'#6b7280','val'=>$brouillon],
                    ['statut'=>'en_examen','lbl'=>'En examen','dot'=>'#f97316','bg'=>'#fff7ed','color'=>'#c2410c','val'=>$enExamen],
                    ['statut'=>'valide',   'lbl'=>'Validé',   'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e','val'=>$valide],
                    ['statut'=>'rejete',   'lbl'=>'Rejeté',   'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c','val'=>$rejete],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($item['val'] > 0): ?>
                <a href="<?php echo e(route('porteur.projets.index', ['statut'=>$item['statut']])); ?>" class="mp-row">
                    <span class="status-badge" style="background:<?php echo e($item['bg']); ?>;color:<?php echo e($item['color']); ?>;">
                        <span class="dot" style="background:<?php echo e($item['dot']); ?>;"></span><?php echo e($item['lbl']); ?>

                    </span>
                    <span class="mp-count"><?php echo e($item['val']); ?></span>
                </a>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($total === 0): ?><p class="empty-text">Aucun projet</p><?php endif; ?>
            </div>

            
            <div class="card">
                <div class="card-head">
                    <h3 class="card-title">Notifications</h3>
                    <a href="<?php echo e(route('porteur.notifications.index')); ?>" class="link-more">Voir tout</a>
                </div>
                <?php $__empty_1 = true; $__currentLoopData = ($notifications ?? collect())->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $ndot = ['success'=>'#22c55e','danger'=>'#ef4444','warning'=>'#f97316'][$notif->type ?? ''] ?? '#1d4ed8';
                ?>
                <div class="notif-row">
                    <span class="dot" style="background:<?php echo e($ndot); ?>;margin-top:5px;flex-shrink:0;"></span>
                    <div>
                        <p class="notif-title"><?php echo e($notif->titre ?? $notif->title ?? 'Notification'); ?></p>
                        <p class="notif-sub"><?php echo e(Str::limit($notif->message ?? '', 65)); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="empty-text">Aucune notification</p>
                <?php endif; ?>
            </div>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/porteur/dashboard.blade.php ENDPATH**/ ?>