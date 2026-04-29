<?php $__env->startSection('title', 'Tableau de bord — Planificateur'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/planifDash.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="dash">

    
    <div class="banner">
        <div>
            <p class="banner-sub">Bienvenue,</p>
            <h2 class="banner-name"><?php echo e(Auth::user()->nomComplet); ?></h2>
            <p class="banner-role"><?php echo e(Auth::user()->email); ?> &middot; <?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?></p>
        </div>
        <div class="banner-icon"><i class="fas fa-calendar-alt"></i></div>
        <div class="banner-circle c1"></div>
        <div class="banner-circle c2"></div>
    </div>

    
    <div class="stats-grid mt-3">
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Demandes en attente</span>
                <div class="stat-icon"><i class="fas fa-inbox"></i></div>
            </div>
            <p class="stat-val"><?php echo e($demandesEnAttente); ?></p>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Projets traités</span>
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            </div>
            <p class="stat-val"><?php echo e($projetsTraites); ?></p>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total activités créées</span>
                <div class="stat-icon"><i class="fas fa-tasks"></i></div>
            </div>
            <p class="stat-val"><?php echo e($totalActivites); ?></p>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total projets</span>
                <div class="stat-icon"><i class="fas fa-folder"></i></div>
            </div>
            <p class="stat-val"><?php echo e($totalProjets); ?></p>
        </div>
    </div>

    
    <div class="finance-grid mt-3">
        <div class="finance-card">
            <div class="finance-icon"><i class="fas fa-coins"></i></div>
            <div>
                <p class="finance-label">Coût total planifié</p>
                <p class="finance-amount"><?php echo e(number_format($coutTotalPlanifie, 0, ',', ' ')); ?> <span>F CFA</span></p>
                <p class="finance-sub">Toutes activités confondues</p>
                <div class="finance-bar"><div style="width:100%;"></div></div>
            </div>
        </div>
        <div class="finance-card">
            <div class="finance-icon"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <p class="finance-label">Activités ce mois</p>
                <p class="finance-amount"><?php echo e($activitesCeMois); ?> <span>activité(s)</span></p>
                <p class="finance-sub">Créées ce mois-ci</p>
                <div class="finance-bar">
                    <?php $pctMois = $totalActivites > 0 ? min(100, round($activitesCeMois / $totalActivites * 100)) : 0; ?>
                    <div style="width:<?php echo e($pctMois); ?>%;"></div>
                </div>
            </div>
        </div>
        <div class="finance-card">
            <div class="finance-icon"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <p class="finance-label">En attente de traitement</p>
                <p class="finance-amount"><?php echo e($demandesEnAttente); ?> <span>projet(s)</span></p>
                <p class="finance-sub">Porteurs en attente</p>
                <div class="finance-bar">
                    <?php $pctAtt = $totalProjets > 0 ? min(100, round($demandesEnAttente / $totalProjets * 100)) : 0; ?>
                    <div style="width:<?php echo e($pctAtt); ?>%;"></div>
                </div>
            </div>
        </div>
        <div class="finance-card">
            <div class="finance-icon"><i class="fas fa-percentage"></i></div>
            <div>
                <p class="finance-label">Taux de traitement</p>
                <?php $tauxTraitement = $totalProjets > 0 ? min(100, round($projetsTraites / $totalProjets * 100)) : 0; ?>
                <p class="finance-amount"><?php echo e($tauxTraitement); ?> <span>%</span></p>
                <p class="finance-sub">Projets planifiés / total</p>
                <div class="finance-bar"><div style="width:<?php echo e($tauxTraitement); ?>%;"></div></div>
            </div>
        </div>
    </div>

    
    <div class="main-grid mt-4">

        
        <div>

            
            <?php if($demandesEnAttente > 0): ?>
            <div class="card demande-card" style="margin-bottom:14px;">
                <div class="demande-head mb-3">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo e($demandesEnAttente); ?> demande(s) en attente de planification
                </div>
                <?php $__currentLoopData = $dernieresDemandes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('planificateur.projets.show', $projet)); ?>" class="demande-row">
                    <div class="demande-info mb-2">
                        <p class="demande-titre">
                            <span style="font-size:.68rem;background:#ede9fe;color:#6d28d9;
                                            padding:1px 7px;border-radius:20px;font-weight:700;margin-right:6px;">
                                <?php echo e($projet->codeProjet); ?>

                            </span>
                            <?php echo e($projet->titre); ?>

                        </p>
                        <p class="demande-sub">
                            <i class="fas fa-user" style="font-size:.6rem;"></i>
                            <?php echo e(optional($projet->user)->nomComplet ?? '—'); ?>

                            &middot;
                            <i class="fas fa-tag" style="font-size:.6rem;"></i>
                            <?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?>

                        </p>
                    </div>
                    <span class="btn-planifier">
                        <i class="fas fa-calendar-plus"></i> Planifier
                    </span>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($demandesEnAttente > 5): ?>
                <div style="padding:9px 16px;text-align:center;">
                    <a href="<?php echo e(route('planificateur.projets.index')); ?>"
                        style="font-size:.73rem;color:#6d28d9;font-weight:600;text-decoration:none;">
                        Voir <?php echo e($demandesEnAttente - 5); ?> autre(s) demande(s)
                        <i class="fas fa-arrow-right" style="font-size:.6rem;"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            
            <div class="card">
                <div class="card-head">
                    <h3 class="card-title">Projets récemment traités</h3>
                    <a href="<?php echo e(route('planificateur.projets.traites')); ?>" class="link-more">
                        Voir tous <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <?php $__empty_1 = true; $__currentLoopData = $projetsRecentsTraites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $nbAct   = $projet->planifications->count();
                    $coutP   = $projet->planifications->sum('coutEstimatif');
                    $pctCout = ($projet->budgetTotal ?? 0) > 0
                                ? min(100, round($coutP / $projet->budgetTotal * 100))
                                : 0;
                ?>
                <a href="<?php echo e(route('planificateur.projets.show', $projet)); ?>" class="projet-row">
                    <div class="projet-avatar">
                        <?php echo e(strtoupper(substr(optional($projet->secteur)->nomSecteur ?? $projet->titre, 0, 1))); ?>

                    </div>
                    <div class="projet-info">
                        <p class="projet-name"><?php echo e($projet->titre); ?></p>
                        <p class="projet-sub">
                            <?php echo e(optional($projet->user)->nomComplet ?? '—'); ?>

                            &middot; <?php echo e($nbAct); ?> activité(s)
                        </p>
                        <div class="plan-progress">
                            <div class="plan-bar">
                                <div class="plan-bar-fill" style="width:<?php echo e($pctCout); ?>%;"></div>
                            </div>
                            <span class="plan-pct"><?php echo e(number_format($coutP, 0, ',', ' ')); ?> F</span>
                        </div>
                    </div>
                    <span class="status-badge" style="background:#f5f3ff;color:#6d28d9;">
                        <span class="dot" style="background:#6d28d9;"></span>Planifié
                    </span>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-check"></i>
                    <p>Aucun projet traité pour l'instant.</p>
                    <?php if($demandesEnAttente > 0): ?>
                    <a href="<?php echo e(route('planificateur.projets.index')); ?>" class="btn-primary">
                        <i class="fas fa-calendar-plus"></i> Traiter une demande
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

        </div>

        
        <div class="aside">

            
            <div class="card">
                <div class="card-head" style="border-bottom:none;">
                    <h3 class="card-title">Résumé</h3>
                    <a href="<?php echo e(route('planificateur.projets.index')); ?>" class="link-more">Voir tout</a>
                </div>
                <a href="<?php echo e(route('planificateur.projets.index')); ?>" class="mp-row">
                    <span class="status-badge" style="background:#ede9fe;color:#6d28d9;">
                        <span class="dot" style="background:#6d28d9;"></span>En attente
                    </span>
                    <span class="mp-count"><?php echo e($demandesEnAttente); ?></span>
                </a>
                <a href="<?php echo e(route('planificateur.projets.traites')); ?>" class="mp-row">
                    <span class="status-badge" style="background:#f0fdf4;color:#15803d;">
                        <span class="dot" style="background:#22c55e;"></span>Traités
                    </span>
                    <span class="mp-count"><?php echo e($projetsTraites); ?></span>
                </a>
                <div class="mp-row" style="cursor:default;">
                    <span class="status-badge" style="background:#f3f4f6;color:#6b7280;">
                        <span class="dot" style="background:#9ca3af;"></span>Total activités
                    </span>
                    <span class="mp-count"><?php echo e($totalActivites); ?></span>
                </div>
            </div>

            
            <div class="card">
                <div class="card-head">
                    <h3 class="card-title">Notifications</h3>
                    <a href="<?php echo e(route('planificateur.notifications.index')); ?>" class="link-more">Voir tout</a>
                </div>
                <?php $__empty_1 = true; $__currentLoopData = ($notifications ?? collect())->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $ndot = ['success'=>'#22c55e','danger'=>'#ef4444','warning'=>'#f97316'][$notif->type ?? ''] ?? '#6d28d9';
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/planificateur/dashboard.blade.php ENDPATH**/ ?>