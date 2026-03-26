<?php $__env->startSection('title', 'Analytique — Approbateur'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/approbDash.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/analytique.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="an-wrap">

        
        <div class="an-header">
            <div>
                <h1 class="an-title">Tableau analytique</h1>
                <p class="an-sub">Données en temps réel · <?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?></p>
            </div>
            <a href="<?php echo e(route('approbateur.dashboard')); ?>" class="btn-back">
                <i class="fas fa-arrow-left"></i> Tableau de bord
            </a>
        </div>

        
        <div class="an-kpi-grid">
            <div class="kpi-card">
                <div class="kpi-icon"><i class="fas fa-stopwatch"></i></div>
                <div>
                    <p class="kpi-label">Délai moyen approbation</p>
                    <p class="kpi-val"><?php echo e($delaiAppro); ?><span class="kpi-unit"> j</span></p>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon"><i class="fas fa-hourglass-half"></i></div>
                <div>
                    <p class="kpi-label">Délai moyen validation</p>
                    <p class="kpi-val"><?php echo e($delaiValid); ?><span class="kpi-unit"> j</span></p>
                </div>
            </div>
            <div class="kpi-card <?php echo e($retard15 > 0 ? 'kpi-warn' : ''); ?>">
                <div class="kpi-icon"><i class="fas fa-clock"></i></div>
                <div>
                    <p class="kpi-label">En retard (+15 jours)</p>
                    <p class="kpi-val"><?php echo e($retard15); ?></p>
                </div>
            </div>
            <div class="kpi-card <?php echo e($retard30 > 0 ? 'kpi-danger' : ''); ?>">
                <div class="kpi-icon"><i class="fas fa-exclamation-triangle"></i></div>
                <div>
                    <p class="kpi-label">En retard (+30 jours)</p>
                    <p class="kpi-val"><?php echo e($retard30); ?></p>
                </div>
            </div>
            <div class="kpi-card kpi-budget">
                <div class="kpi-icon"><i class="fas fa-coins"></i></div>
                <div>
                    <p class="kpi-label">Demandes en attente</p>
                    <p class="kpi-val" style="font-size:1rem;"><?php echo e(number_format($cumulAttente, 0, ',', ' ')); ?><span class="kpi-unit"> F CFA</span></p>
                </div>
            </div>
        </div>

        
        <div class="an-row-2">

            
            <div class="an-card an-card-lg">
                <div class="an-card-head">
                    <h3 class="an-card-title">Entonnoir des statuts</h3>
                    <p class="an-card-sub">De la soumission à la validation — goulots d'étranglement</p>
                </div>
                <div class="funnel-wrap">
                    <?php $maxVal = max(1, collect($entonnoir)->max('val')); ?>
                    <?php $__currentLoopData = $entonnoir; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $barPct = $maxVal > 0 ? (int)round((int)($step['val'] ?? 0) / $maxVal * 100) : 0;
                    ?>
                    <div class="funnel-step">
                        <span class="funnel-lbl-txt"><?php echo e($step['lbl']); ?></span>
                        <div class="funnel-bar-wrap">
                            <div class="funnel-bar" style="background:<?php echo e($step['color']); ?>;opacity:.12;"></div>
                            <div class="funnel-bar funnel-bar-fill"
                                    style="width:<?php echo e($barPct); ?>%;background:<?php echo e($step['color']); ?>;"></div>
                        </div>
                        <div class="funnel-label">
                            <span class="funnel-lbl-val" style="color:<?php echo e($step['color']); ?>;"><?php echo e((int)($step['val'] ?? 0)); ?></span>
                            <span class="funnel-lbl-pct"><?php echo e((int)($step['pct'] ?? 0)); ?>%</span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="an-card">
                <div class="an-card-head">
                    <h3 class="an-card-title">Répartition par statut</h3>
                    <p class="an-card-sub">Distribution de tous les projets</p>
                </div>
                <div class="chart-box"><canvas id="donutChart"></canvas></div>
            </div>

        </div>

        
        <div class="an-row-2">

            
            <div class="an-card">
                <div class="an-card-head">
                    <h3 class="an-card-title">Activité — 12 derniers mois</h3>
                    <p class="an-card-sub">Créations vs soumissions · Délai moyen : <?php echo e(round($delaiMoyenAppro, 1)); ?> j</p>
                </div>
                <div class="chart-box"><canvas id="tempoChart"></canvas></div>
            </div>

            
            <div class="an-card">
                <div class="an-card-head">
                    <h3 class="an-card-title">Motifs de rejet</h3>
                    <p class="an-card-sub">Regroupement par mots-clés dans les motifs</p>
                </div>
                <div class="chart-box"><canvas id="rejetChart"></canvas></div>
            </div>

        </div>

        
        <div class="an-row-2">

            
            <div class="an-card">
                <div class="an-card-head">
                    <h3 class="an-card-title">Budget déclaré vs montant demandé</h3>
                    <p class="an-card-sub">Top 8 projets par montant demandé</p>
                </div>
                <div class="chart-box"><canvas id="budgetChart"></canvas></div>
            </div>

            
            <div class="an-card">
                <div class="an-card-head">
                    <h3 class="an-card-title">Distribution des montants demandés</h3>
                    <p class="an-card-sub">Répartition par tranche (F CFA)</p>
                </div>
                <div class="chart-box"><canvas id="trancheChart"></canvas></div>
            </div>

        </div>

        
        <div class="an-card">
            <div class="an-card-head">
                <h3 class="an-card-title">Analyse par secteur</h3>
                <p class="an-card-sub">Nombre de projets et montants demandés par secteur d'activité</p>
            </div>
            <div class="chart-box" style="height:260px;"><canvas id="secteurChart"></canvas></div>
        </div>

        
        <div class="an-row-2">

            
            <div class="an-card">
                <div class="an-card-head">
                    <h3 class="an-card-title">Timeline des projets approuvés</h3>
                    <p class="an-card-sub">Dates de début prévues</p>
                </div>
                <div style="padding:12px 16px;">
                    <?php $__empty_1 = true; $__currentLoopData = $timeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $pct = 0;
                        if ($p->dateDebut && $p->dateFin) {
                            $total = max(1, \Carbon\Carbon::parse($p->dateDebut)->diffInDays(\Carbon\Carbon::parse($p->dateFin)));
                            $done  = min($total, max(0, \Carbon\Carbon::parse($p->dateDebut)->diffInDays(now())));
                            $pct   = round($done / $total * 100);
                        }
                    ?>
                    <div class="timeline-item">
                        <div class="timeline-head">
                            <p class="timeline-name"><?php echo e(Str::limit($p->titre, 40)); ?></p>
                            <span class="timeline-dates">
                                <?php echo e(optional($p->dateDebut)->format('d/m/Y') ?? '—'); ?>

                                → <?php echo e(optional($p->dateFin)->format('d/m/Y') ?? '—'); ?>

                            </span>
                        </div>
                        <div class="timeline-bar">
                            <div class="timeline-fill" style="width:<?php echo e($pct); ?>%;"></div>
                        </div>
                        <p class="timeline-pct"><?php echo e($pct); ?>% écoulé</p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="empty-text">Aucun projet approuvé avec dates renseignées.</p>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="an-card">
                <div class="an-card-head">
                    <h3 class="an-card-title">Top porteurs de projets</h3>
                    <p class="an-card-sub">Activité et taux d'approbation</p>
                </div>
                <div style="padding:8px 0;">
                    <?php $__currentLoopData = $topPorteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="porteur-row">
                        <div class="porteur-rank"><?php echo e($i + 1); ?></div>
                        <div class="porteur-info">
                            <p class="porteur-nom"><?php echo e($p['nom']); ?></p>
                            <div class="porteur-bar-wrap">
                                <div class="porteur-bar" style="width:<?php echo e($p['taux']); ?>%;"></div>
                            </div>
                        </div>
                        <div class="porteur-stats">
                            <span class="porteur-total"><?php echo e($p['total']); ?> proj.</span>
                            <span class="porteur-taux"><?php echo e($p['taux']); ?>%</span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($topPorteurs->isEmpty()): ?>
                    <p class="empty-text">Aucune donnée disponible.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        
        <div class="an-card" style="margin-bottom:0;">
            <div class="an-card-head">
                <h3 class="an-card-title">Matrice de priorisation</h3>
                <p class="an-card-sub">Projets en attente · X = Montant demandé (M F CFA) · Y = Durée (mois) · Taille = Ancienneté</p>
            </div>
            <div class="chart-box" style="height:300px;"><canvas id="matriceChart"></canvas></div>
        </div>

    </div>

    
    <script>
        window.approbateurData = {
            donut: {
                labels: <?php echo json_encode($labels, 15, 512) ?>,
                values: <?php echo json_encode($donutValues, 15, 512) ?>,
                colors: <?php echo json_encode($colors, 15, 512) ?>
            },
            temporel: {
                labels: <?php echo json_encode($tempLabels, 15, 512) ?>,
                soumis: <?php echo json_encode($tempSoumis, 15, 512) ?>,
                creation: <?php echo json_encode($tempCreation, 15, 512) ?>
            },
            motifs: {
                labels: <?php echo json_encode($motifsLabels, 15, 512) ?>,
                values: <?php echo json_encode($motifsValues, 15, 512) ?>
            },
            budget: {
                labels: <?php echo json_encode($budgetLabels, 15, 512) ?>,
                totaux: <?php echo json_encode($budgetTotaux, 15, 512) ?>,
                demande: <?php echo json_encode($budgetDemande, 15, 512) ?>
            },
            tranches: {
                labels: <?php echo json_encode(array_keys($tranches), 15, 512) ?>,
                values: <?php echo json_encode(array_values($tranches), 15, 512) ?>
            },
            secteurs: {
                labels: <?php echo json_encode($sectLabels, 15, 512) ?>,
                nb: <?php echo json_encode($sectNb, 15, 512) ?>,
                demande: <?php echo json_encode($sectDemande, 15, 512) ?>
            },
            matrice: <?php echo json_encode($matrice, 15, 512) ?>
        };
    </script>

    <?php $__env->startPush('scripts'); ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
        <script src="<?php echo e(asset('js/approbateurAnalytique.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/approbateur/analytique.blade.php ENDPATH**/ ?>