<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    @font-face {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: normal;
        src: url("<?php echo e(storage_path('fonts/Poppins-Regular.ttf')); ?>") format('truetype');
    }
    @font-face {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: bold;
        src: url("<?php echo e(storage_path('fonts/Poppins-Bold.ttf')); ?>") format('truetype');
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
        font-family: 'Poppins',
        DejaVu Sans, sans-serif;
        font-size: 10px;
        color: #000;
        background: #fff;
        line-height: 1.5;
        padding: 70px;
    }

    /* ── HEADER ── */
    .header-table { width:100%; border:1.5px solid #000; margin-bottom:10px; border-collapse:collapse; }
    .header-table td { padding:10px 14px; vertical-align:middle; }
    .logo-icon {
        display:inline-block;
        width:38px; height:38px;
        background:#1c0fd3;
        border-radius:6px;
        color:#fff; font-size:13px; font-weight:700;
        text-align:center; line-height:38px;
        vertical-align:middle;
    }
    .app-name { font-size:12px; font-weight:700; display:inline-block; vertical-align:middle; margin-left:8px; }
    .app-sub  { font-size:7px; color:#555; display:block; margin-left:46px; }
    .doc-title { font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:.05em; text-align:center; }
    .doc-sub   { font-size:8px; color:#555; text-align:center; }
    .export-info { font-size:7.5px; color:#555; text-align:right; line-height:1.8; }

    /* ── INFO TABLES ── */
    .section-wrap { width:100%; border-collapse:collapse; margin-bottom:10px; }
    .section-wrap td { vertical-align:top; }
    .section-wrap td:first-child { padding-right:5px; }
    .section-wrap td:last-child  { padding-left:5px; }

    .info-table {
        width:100%;
        border-collapse:collapse;
        border:1.5px solid #000;
    }
    .info-head {
        background:#000; color:#fff;
        font-size:11px; font-weight:700;
        text-transform:uppercase; letter-spacing:.05em;
        padding:4px 8px;
    }
    .info-table tr { border-bottom:1px solid #ddd; }
    .info-table tr:last-child { border-bottom:none; }
    .info-table .lbl {
        width:20%; font-size:10px; font-weight:700;
        padding:4px 8px; background:#f7f7f7;
        border-right:1px solid #ddd;
    }
    .info-table .val {
        width:80%; font-size:9px;
        padding:4px 8px; color:#111;
    }

    /* ── PLANIFICATION TABLE ── */
    .plan-wrap { border:1.5px solid #000; margin-bottom:10px; }
    .plan-title {
        background:#000; color:#fff;
        font-size:9px; font-weight:700;
        text-transform:uppercase; letter-spacing:.05em;
        padding:4px 10px;
    }
    .plan-table { width:100%; border-collapse:collapse; }
    .plan-table th {
        background:#f0f0f0;
        font-size:7.5px; font-weight:700;
        text-transform:uppercase; letter-spacing:.03em;
        padding:5px 6px; border:1px solid #ccc;
        text-align:left;
    }
    .plan-table td {
        font-size:8.5px; padding:5px 6px;
        border:1px solid #ccc; vertical-align:middle;
    }
    .plan-table tr:nth-child(even) td { background:#fafafa; }
    .t-num  { width:4%;  text-align:center; font-weight:700; }
    .t-act  { width:26%; }
    .t-ind  { width:20%; }
    .t-prd  { width:12%; text-align:center; }
    .t-cout { width:15%; text-align:right; }
    .t-sign { width:11%; text-align:center; }
    .sign-line { display:block; border-bottom:1px dotted #999; height:20px; }
    .total-row {
        text-align:right; font-size:9px; font-weight:700;
        padding:5px 10px; border-top:1.5px solid #000;
        background:#f5f5f5;
    }
    .empty-row { text-align:center; font-style:italic; color:#999; padding:14px; }

    /* ── FOOTER ── */
    .footer-table {
        width:100%;
        border-collapse:collapse;
        border-top:1.5px solid #000;
        margin-top:50px;
    }
    .footer-table td { padding:6px 0; text-align:center; }
    .footer-note { font-size:7px; color:#555; line-height:1.7; }
    .footer-copy { font-size:8px; font-weight:700; color:#000; margin-top:3px; }
</style>
</head>
<body>


<table class="header-table">
    <tr>
        <td style="width:30%;">
            <span class="logo-icon">GP</span>
            <span class="app-name">GesProjet</span>
        </td>
        <td style="width:40%;">
            <div class="doc-title">Fiche de projet</div>
            <div class="doc-sub">Document officiel &mdash; Confidentiel</div>
        </td>
        <td style="width:30%;">
            <div class="export-info">
                Exporté le : <?php echo e($exportedAt); ?>

            </div>
        </td>
    </tr>
</table>


<table class="section-wrap">
    <tr>
        <td>
            <table class="info-table">
                <tr><td colspan="2" class="info-head">Informations du projet</td></tr>
                <tr><td class="lbl">Code projet</td><td class="val"><?php echo e($projet->codeProjet); ?></td></tr>
                <tr><td class="lbl">Titre</td><td class="val"><?php echo e($projet->titre); ?></td></tr>
                <tr><td class="lbl">Date début probable</td><td class="val"><?php echo e(optional($projet->dateDebut)->format('d/m/Y') ?? '—'); ?></td></tr>
                <tr><td class="lbl">Date fin probable</td><td class="val"><?php echo e(optional($projet->dateFin)->format('d/m/Y') ?? '—'); ?></td></tr>
                <tr><td class="lbl">Budget total</td><td class="val"><?php echo e($projet->budgetTotal ? number_format($projet->budgetTotal,0,',',' ').' F CFA' : '—'); ?></td></tr>
                <tr><td class="lbl">Montant demandé</td><td class="val"><?php echo e($projet->montantDemande ? number_format($projet->montantDemande,0,',',' ').' F CFA' : '—'); ?></td></tr>
                <tr><td class="lbl">Secteur</td><td class="val"><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></td></tr>
            </table>
        </td>
    </tr>

    <tr>
        <td style="padding-top:10px;">
            <table class="info-table">
                <tr><td colspan="2" class="info-head">Porteur &amp; Suivi</td></tr>
                <tr><td class="lbl">Nom du porteur</td><td class="val"><?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?></td></tr>
                <tr><td class="lbl">Email</td><td class="val"><?php echo e(optional($projet->porteur)->email ?? '—'); ?></td></tr>
                <tr><td class="lbl">Date soumission</td><td class="val"><?php echo e(optional($projet->dateSoumission)->format('d/m/Y') ?? '—'); ?></td></tr>
                <tr><td class="lbl">Date approbation</td><td class="val"><?php echo e(optional($projet->dateApprobation)->format('d/m/Y') ?? '—'); ?></td></tr>
                <tr><td class="lbl">Durée</td><td class="val"><?php echo e($projet->duree ? $projet->duree.' mois' : '—'); ?></td></tr>
                <tr><td class="lbl">Objectif</td><td class="val"><?php echo e($projet->objectif ?? '—'); ?></td></tr>
            </table>
        </td>
    </tr>
</table>


<div class="plan-wrap">
    <div class="plan-title">
        Planification du projet — Activités (<?php echo e($projet->planifications->count()); ?>)
    </div>
    <?php if($projet->planifications->count()): ?>
    <table class="plan-table">
        <thead>
            <tr>
                <th class="t-num">N°</th>
                <th class="t-act">Activité</th>
                <th class="t-ind">Indicateur / Unité</th>
                <th class="t-prd">Période</th>
                <th class="t-cout">Coût estimatif</th>
                <th class="t-sign">Nom bailleur</th>
                <th class="t-sign">Signature</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $projet->planifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="t-num"><?php echo e($loop->iteration); ?></td>
                <td class="t-act"><strong><?php echo e($plan->activitePlanification); ?></strong></td>
                <td class="t-ind">
                    <?php echo e($plan->indicateur ?? '—'); ?>

                    <?php if($plan->uniteIndicateur): ?> (<?php echo e($plan->uniteIndicateur); ?>) <?php endif; ?>
                </td>
                <td class="t-prd"><?php echo e($plan->periode ?? '—'); ?></td>
                <td class="t-cout"><?php echo e($plan->coutEstimatif ? number_format($plan->coutEstimatif,0,',',' ').' F CFA' : '—'); ?></td>
                <td class="t-sign"><span class="sign-line"></span></td>
                <td class="t-sign"><span class="sign-line"></span></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div class="total-row">
        Total estimé : <?php echo e(number_format($projet->planifications->sum('coutEstimatif'),0,',',' ')); ?> F CFA
    </div>
    <?php else: ?>
    <div class="empty-row">Aucune activité planifiée pour ce projet.</div>
    <?php endif; ?>
</div>


<table class="footer-table">
    <tr>
        <td>
            <div class="footer-note">
                Document généré automatiquement par GesProjet &mdash; Usage interne et confidentiel.<br>
                Toute reproduction non autorisée est strictement interdite.
            </div>
            <div class="footer-copy">&copy; <?php echo e(date('Y')); ?> GesProjet &mdash; Tous droits réservés</div>
        </td>
    </tr>
</table>

</body>
</html><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/approbateur/exports/projet_pdf.blade.php ENDPATH**/ ?>