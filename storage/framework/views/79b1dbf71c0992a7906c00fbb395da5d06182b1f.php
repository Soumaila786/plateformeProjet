<?php $__env->startSection('title', 'Analytique — Validateur'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/validDash.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/analytique.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="an-wrap">


<div class="an-header">
    <div>
        <h1 class="an-title">Tableau analytique</h1>
        <p class="an-sub">Données en temps réel · <?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?></p>
    </div>
    <a href="<?php echo e(route('validateur.dashboard')); ?>" class="btn-back">
        <i class="fas fa-arrow-left"></i> Tableau de bord
    </a>
</div>


<div class="an-perf-grid">
    <div class="perf-card perf-main">
        <div class="perf-icon"><i class="fas fa-tachometer-alt"></i></div>
        <div>
            <p class="perf-label">Projets traités aujourd'hui</p>
            <p class="perf-val"><?php echo e($perf['aujourd_hui']); ?></p>
        </div>
    </div>
    <div class="perf-card">
        <div class="perf-icon"><i class="fas fa-calendar-week"></i></div>
        <div>
            <p class="perf-label">Cette semaine</p>
            <p class="perf-val"><?php echo e($perf['semaine']); ?></p>
        </div>
    </div>
    <div class="perf-card">
        <div class="perf-icon"><i class="fas fa-check-double"></i></div>
        <div>
            <p class="perf-label">Total traités</p>
            <p class="perf-val"><?php echo e($perf['total_traites']); ?></p>
        </div>
    </div>
    <div class="perf-card">
        <div class="perf-icon"><i class="fas fa-percentage"></i></div>
        <div>
            <p class="perf-label">Taux de validation</p>
            <p class="perf-val"><?php echo e($perf['taux_validation']); ?><span class="perf-unit">%</span></p>
        </div>
    </div>
    <div class="perf-card perf-warn">
        <div class="perf-icon"><i class="fas fa-clock"></i></div>
        <div>
            <p class="perf-label">En attente d'action</p>
            <p class="perf-val"><?php echo e($perf['en_attente']); ?></p>
        </div>
    </div>
</div>


<div class="an-row-2">

    
    <div class="an-card an-card-lg">
        <div class="an-card-head">
            <h3 class="an-card-title">Vue d'ensemble — Entonnoir des financements</h3>
            <p class="an-card-sub">Progression des projets de la soumission au financement</p>
        </div>
        <div class="funnel-wrap">
            <?php
                $total = max(1, $entonnoir['soumis'] + $entonnoir['approuve'] + $entonnoir['valide'] + $entonnoir['rejete']);
                $maxVal = max(1, $entonnoir['soumis'], $entonnoir['approuve'], $entonnoir['valide'], $entonnoir['rejete']);
                $steps = [
                    ['lbl'=>'Soumis',   'val'=>$entonnoir['soumis'],   'color'=>'#6366f1'],
                    ['lbl'=>'Approuvés','val'=>$entonnoir['approuve'], 'color'=>'#22c55e'],
                    ['lbl'=>'Validés',  'val'=>$entonnoir['valide'],   'color'=>'#0d9488'],
                    ['lbl'=>'Rejetés',  'val'=>$entonnoir['rejete'],   'color'=>'#ef4444'],
                ];
            ?>
            <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $val    = (int)($step['val'] ?? 0);
                $barPct = (int)round($val / $maxVal * 100);
                $pct    = (int)round($val / $total * 100);
            ?>
            <div class="funnel-step">
                <span class="funnel-lbl-txt"><?php echo e($step['lbl']); ?></span>
                <div class="funnel-bar-wrap">
                    <div class="funnel-bar" style="background:<?php echo e($step['color']); ?>;opacity:.15;"></div>
                    <div class="funnel-bar funnel-bar-fill"
                            style="width:<?php echo e($barPct); ?>%;background:<?php echo e($step['color']); ?>;"></div>
                </div>
                <div class="funnel-label">
                    <span class="funnel-lbl-val" style="color:<?php echo e($step['color']); ?>;"><?php echo e($val); ?></span>
                    <span class="funnel-lbl-pct"><?php echo e($pct); ?>%</span>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Couverture financière</h3>
            <p class="an-card-sub">Montant demandé vs budget total déclaré</p>
        </div>
        <div class="gauge-wrap">
            <div class="gauge-circle">
                <svg viewBox="0 0 120 120" class="gauge-svg">
                    <circle cx="60" cy="60" r="50" fill="none" stroke="#f3f4f6" stroke-width="10"/>
                    <circle cx="60" cy="60" r="50" fill="none" stroke="#0d9488" stroke-width="10"
                            stroke-dasharray="<?php echo e(round($pctJauge * 3.14159)); ?> 314"
                            stroke-dashoffset="78.5"
                            stroke-linecap="round"
                            transform="rotate(-90 60 60)"/>
                </svg>
                <div class="gauge-inner">
                    <p class="gauge-pct"><?php echo e($pctJauge); ?><span>%</span></p>
                    <p class="gauge-sub-lbl">couvert</p>
                </div>
            </div>
            <div class="gauge-legend">
                <div class="gauge-leg-item">
                    <span class="gauge-dot" style="background:#0d9488;"></span>
                    <div>
                        <p class="gauge-leg-lbl">Montant demandé</p>
                        <p class="gauge-leg-val"><?php echo e(number_format($totalDemande, 0, ',', ' ')); ?> F CFA</p>
                    </div>
                </div>
                <div class="gauge-leg-item">
                    <span class="gauge-dot" style="background:#e5e7eb;"></span>
                    <div>
                        <p class="gauge-leg-lbl">Budget total déclaré</p>
                        <p class="gauge-leg-val"><?php echo e(number_format($totalBudget, 0, ',', ' ')); ?> F CFA</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="an-row-2">

    
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Répartition par statut</h3>
            <p class="an-card-sub">Distribution actuelle de tous les projets</p>
        </div>
        <div class="chart-box"><canvas id="donutChart"></canvas></div>
    </div>

    
    <div class="an-card an-card-lg">
        <div class="an-card-head">
            <h3 class="an-card-title">Délais de traitement</h3>
            <p class="an-card-sub">Temps moyen en jours à chaque étape · <?php echo e($retard); ?> projet(s) en retard (+30j)</p>
        </div>
        <div class="chart-box"><canvas id="delaiChart"></canvas></div>
        <?php if($retard > 0): ?>
        <div class="retard-alert">
            <i class="fas fa-exclamation-triangle"></i>
            <span><?php echo e($retard); ?> projet(s) sans décision depuis plus de 30 jours</span>
            <a href="<?php echo e(route('validateur.projets.index')); ?>">Voir</a>
        </div>
        <?php endif; ?>
    </div>

</div>


<div class="an-row-2">

    
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Analyse financière par secteur</h3>
            <p class="an-card-sub">Budget déclaré vs montant demandé</p>
        </div>
        <div class="chart-box"><canvas id="secteurChart"></canvas></div>
    </div>

    
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Évolution cumulative des demandes</h3>
            <p class="an-card-sub">Cumul des montants demandés — 12 derniers mois</p>
        </div>
        <div class="chart-box"><canvas id="evolutionChart"></canvas></div>
    </div>

</div>


<div class="an-card" style="margin-bottom:0;">
    <div class="an-card-head">
        <h3 class="an-card-title">Concentration des projets par secteur</h3>
        <p class="an-card-sub">Nombre de projets par secteur d'activité</p>
    </div>
    <div class="heatmap-wrap">
        <?php $maxHeat = max(1, max($heatData ?: [1])); ?>
        <?php $__currentLoopData = $heatSecteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sect): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $val    = $heatData[$i] ?? 0;
            $pct    = round($val / $maxHeat * 100);
            $alpha  = 0.1 + ($pct / 100 * 0.85);
        ?>
        <div class="heat-cell" style="background:rgba(13,148,136,<?php echo e(number_format($alpha, 2)); ?>);">
            <p class="heat-sect"><?php echo e($sect); ?></p>
            <p class="heat-val" style="color:<?php echo e($pct > 50 ? '#fff' : '#0d9488'); ?>;"><?php echo e($val); ?></p>
            <p class="heat-lbl" style="color:<?php echo e($pct > 50 ? 'rgba(255,255,255,.7)' : '#9ca3af'); ?>;">projet(s)</p>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if(empty($heatSecteurs)): ?>
        <p style="color:#9ca3af;font-size:.8rem;padding:20px;">Aucune donnée disponible.</p>
        <?php endif; ?>
    </div>
</div>

</div>


<script>
    window.chartData = {
        donut: {
            labels: <?php echo json_encode($donutLabels, 15, 512) ?>,
            values: <?php echo json_encode($donutValues, 15, 512) ?>
        },
        delais: {
            labels: <?php echo json_encode($delais['labels'], 15, 512) ?>,
            values: <?php echo json_encode($delais['values'], 15, 512) ?>
        },
        secteurs: {
            labels: <?php echo json_encode($secteurLabels, 15, 512) ?>,
            budget: <?php echo json_encode($secteurBudget, 15, 512) ?>,
            demande: <?php echo json_encode($secteurDemande, 15, 512) ?>
        },
        evolution: {
            labels: <?php echo json_encode($evolution['labels'], 15, 512) ?>,
            values: <?php echo json_encode($evolution['values'], 15, 512) ?>
        }
    };
</script>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="<?php echo e(asset('js/validateurAnalytique.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/validateur/analytique.blade.php ENDPATH**/ ?>