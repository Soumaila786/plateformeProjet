<?php $__env->startSection('title', 'Tableau Analytique'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/adminAnalytique.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="an-wrap">


<div class="an-header">
    <div>
        <h1 class="an-title">Tableau analytique</h1>
        <p class="an-sub">Vue globale en temps réel · <?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?></p>
    </div>
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn-back">
        <i class="fas fa-arrow-left"></i> Tableau de bord
    </a>
</div>


<div class="kpi-grid">
    <?php
        $kpiItems = [
            ['lbl'=>'Total projets', 'val'=>$kpis['total'],     'icon'=>'fa-folder',       'cls'=>''],
            ['lbl'=>'Brouillons',    'val'=>$kpis['brouillon'], 'icon'=>'fa-edit',         'cls'=>''],
            ['lbl'=>'Soumis',        'val'=>$kpis['soumis'],    'icon'=>'fa-paper-plane',  'cls'=>'kpi-indigo'],
            ['lbl'=>'En examen',     'val'=>$kpis['en_examen'], 'icon'=>'fa-search',       'cls'=>'kpi-orange'],
            ['lbl'=>'Approuvés',     'val'=>$kpis['approuve'],  'icon'=>'fa-check-circle', 'cls'=>'kpi-green'],
            ['lbl'=>'Rejetés',       'val'=>$kpis['rejete'],    'icon'=>'fa-times-circle', 'cls'=>'kpi-red'],
            ['lbl'=>'Validés',       'val'=>$kpis['valide'],    'icon'=>'fa-medal',        'cls'=>'kpi-teal'],
        ];
    ?>
    <?php $__currentLoopData = $kpiItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="kpi-card <?php echo e($k['cls']); ?>">
        <div class="kpi-top">
            <span class="kpi-lbl"><?php echo e($k['lbl']); ?></span>
            <div class="kpi-icon"><i class="fas <?php echo e($k['icon']); ?>"></i></div>
        </div>
        <p class="kpi-val"><?php echo e($k['val']); ?></p>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="delai-grid">
    <div class="delai-card">
        <i class="fas fa-stopwatch delai-ic"></i>
        <div>
            <p class="delai-lbl">Délai moyen approbation</p>
            <p class="delai-val"><?php echo e($delaiAppro); ?><span> jours</span></p>
        </div>
    </div>
    <div class="delai-card">
        <i class="fas fa-hourglass-half delai-ic"></i>
        <div>
            <p class="delai-lbl">Délai moyen validation</p>
            <p class="delai-val"><?php echo e($delaiValid); ?><span> jours</span></p>
        </div>
    </div>
    <div class="delai-card delai-total">
        <i class="fas fa-flag-checkered delai-ic"></i>
        <div>
            <p class="delai-lbl">Délai total (soumission → validation)</p>
            <p class="delai-val"><?php echo e($delaiTotal); ?><span> jours</span></p>
        </div>
    </div>
</div>


<div class="an-row-2">

    
    <div class="an-card an-card-lg">
        <div class="an-card-head">
            <h3 class="an-card-title">Entonnoir complet du processus</h3>
            <p class="an-card-sub">De la création à la validation finale</p>
        </div>
        <div class="funnel-wrap">
            <?php $__currentLoopData = $entonnoir; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $stepVal  = (int)($step['val'] ?? 0);
                $maxRef   = (int)($maxEntonnoir ?? 1);
                $barPct   = $maxRef > 0 ? (int)round($stepVal / $maxRef * 100) : 0;
                $ref0     = (int)($entonnoir[0]['val'] ?? 1);
                $totalRef = $ref0 > 0 ? $ref0 : 1;
                $conv     = (int)round($stepVal / $totalRef * 100);
            ?>
            <div class="funnel-step">
                <span class="funnel-lbl-txt"><?php echo e($step['lbl']); ?></span>
                <div class="funnel-bar-wrap">
                    <div class="funnel-bar" style="background:<?php echo e($step['color']); ?>;opacity:.12;"></div>
                    <div class="funnel-bar funnel-bar-fill" style="width:<?php echo e($barPct); ?>%;background:<?php echo e($step['color']); ?>;"></div>
                </div>
                <div class="funnel-label">
                    <span class="funnel-lbl-val" style="color:<?php echo e($step['color']); ?>;"><?php echo e($stepVal); ?></span>
                    <span class="funnel-lbl-pct"><?php echo e($conv); ?>%</span>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="funnel-rejet">
                <i class="fas fa-times-circle" style="color:#ef4444;font-size:.75rem;"></i>
                <span>Rejetés : <strong style="color:#ef4444;"><?php echo e($kpis['rejete']); ?></strong> projet(s) sur l'ensemble du processus</span>
            </div>
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
            <h3 class="an-card-title">Évolution mensuelle</h3>
            <p class="an-card-sub">Soumissions vs validations — 12 derniers mois</p>
        </div>
        <div class="chart-box"><canvas id="evolutionChart"></canvas></div>
    </div>

    
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Motifs de rejet</h3>
            <p class="an-card-sub">Regroupement par mots-clés</p>
        </div>
        <div class="chart-box"><canvas id="rejetChart"></canvas></div>
    </div>

</div>


<div class="an-card">
    <div class="an-card-head">
        <h3 class="an-card-title">Top secteurs d'activité</h3>
        <p class="an-card-sub">Nombre de projets et montants demandés par secteur</p>
    </div>
    <div class="chart-box" style="height:260px;"><canvas id="secteurChart"></canvas></div>
</div>


<div class="an-row-2">

    
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Performance des porteurs</h3>
            <p class="an-card-sub">Top 10 par nombre de projets et taux de réussite</p>
        </div>
        <div class="porteurs-list">
            <?php $__currentLoopData = $porteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="porteur-row">
                <div class="porteur-rank <?php echo e($i < 3 ? 'top-'.($i+1) : ''); ?>"><?php echo e($i + 1); ?></div>
                <div class="porteur-info">
                    <div class="porteur-head">
                        <p class="porteur-nom"><?php echo e($p['nom']); ?></p>
                        <div class="porteur-badges">
                            <span class="porteur-badge"><?php echo e($p['total']); ?> proj.</span>
                            <?php if($p['rejete'] > 0): ?>
                            <span class="porteur-badge porteur-badge-red"><?php echo e($p['rejete']); ?> rej.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="porteur-bar-wrap">
                        <div class="porteur-bar" style="width:<?php echo e($p['taux']); ?>%;"></div>
                    </div>
                    <p class="porteur-taux-lbl"><?php echo e($p['taux']); ?>% de réussite</p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($porteurs->isEmpty()): ?>
            <p class="empty-text">Aucune donnée disponible.</p>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="an-card">
        <div class="an-card-head">
            <h3 class="an-card-title">Charge de travail des équipes</h3>
            <p class="an-card-sub">Projets traités par approbateur et validateur</p>
        </div>
        <div class="chart-box"><canvas id="equipeChart"></canvas></div>
    </div>

</div>


<div class="an-card" style="margin-bottom:0;">
    <div class="an-card-head">
        <h3 class="an-card-title">
            Projets en attente critique
            <?php if($projetsBloque->count() > 0): ?>
            <span class="bloque-badge"><?php echo e($projetsBloque->count()); ?></span>
            <?php endif; ?>
        </h3>
        <p class="an-card-sub">Bloqués depuis plus de 10 jours sans changement de statut</p>
    </div>

    <?php if($projetsBloque->isEmpty()): ?>
    <div class="empty-state" style="padding:24px;">
        <i class="fas fa-check-circle" style="color:#22c55e;font-size:1.8rem;"></i>
        <p>Aucun projet bloqué. Tout est traité dans les délais.</p>
    </div>
    <?php else: ?>
    <div class="bloque-table-wrap">
        <table class="bloque-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Titre</th>
                    <th>Statut</th>
                    <th>Porteur</th>
                    <th>Secteur</th>
                    <th>Bloqué depuis</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $projetsBloque; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $mapStatut = [
                        'soumis'    => ['lbl'=>'Soumis',   'bg'=>'#eef2ff','color'=>'#4338ca','dot'=>'#6366f1'],
                        'en_examen' => ['lbl'=>'En examen','bg'=>'#fff7ed','color'=>'#c2410c','dot'=>'#f97316'],
                        'approuve'  => ['lbl'=>'Approuvé', 'bg'=>'#f0fdf4','color'=>'#15803d','dot'=>'#22c55e'],
                    ];
                    $st = $mapStatut[$p['statut']] ?? $mapStatut['soumis'];
                    $urgence = $p['jours'] >= 30 ? 'row-danger' : ($p['jours'] >= 20 ? 'row-warn' : '');
                ?>
                <tr class="<?php echo e($urgence); ?>">
                    <td><span class="bloque-code"><?php echo e($p['code']); ?></span></td>
                    <td class="bloque-titre"><?php echo e(Str::limit($p['titre'], 40)); ?></td>
                    <td>
                        <span class="status-badge" style="background:<?php echo e($st['bg']); ?>;color:<?php echo e($st['color']); ?>;">
                            <span class="dot" style="background:<?php echo e($st['dot']); ?>;"></span><?php echo e($st['lbl']); ?>

                        </span>
                    </td>
                    <td class="td-muted"><?php echo e($p['porteur']); ?></td>
                    <td class="td-muted"><?php echo e($p['secteur']); ?></td>
                    <td>
                        <span class="jours-badge <?php echo e($p['jours'] >= 30 ? 'jours-danger' : ($p['jours'] >= 20 ? 'jours-warn' : 'jours-normal')); ?>">
                            <i class="fas fa-clock"></i> <?php echo e($p['jours']); ?> j
                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

</div>


<script>
    window.adminAnalytiqueData = {
        donut: {
            labels: <?php echo json_encode($statutLabels, 15, 512) ?>,
            values: <?php echo json_encode($statutValues, 15, 512) ?>,
            colors: <?php echo json_encode($statutColors, 15, 512) ?>
        },
        evolution: {
            labels: <?php echo json_encode($moisLabels, 15, 512) ?>,
            soumis: <?php echo json_encode($moisSoumis, 15, 512) ?>,
            valides: <?php echo json_encode($moisValides, 15, 512) ?>
        },
        rejets: {
            labels: <?php echo json_encode($motifsLabels, 15, 512) ?>,
            values: <?php echo json_encode($motifsValues, 15, 512) ?>
        },
        secteurs: {
            labels: <?php echo json_encode($sectLabels, 15, 512) ?>,
            nb: <?php echo json_encode($sectNb, 15, 512) ?>,
            valides: <?php echo json_encode($sectValide, 15, 512) ?>,
            demande: <?php echo json_encode($sectDemande, 15, 512) ?>
        },
        equipes: {
            labels: <?php echo json_encode($equipeLabels, 15, 512) ?>,
            nb: <?php echo json_encode($equipeNb, 15, 512) ?>,
            roles: <?php echo json_encode($equipeRoles, 15, 512) ?>
        }
    };
</script>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="<?php echo e(asset('js/adminAnalytique.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/admin/analytique.blade.php ENDPATH**/ ?>