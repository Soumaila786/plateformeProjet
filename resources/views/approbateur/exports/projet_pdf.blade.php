<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    @font-face {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: normal;
        src: url("{{ storage_path('fonts/Poppins-Regular.ttf') }}") format('truetype');
    }
    @font-face {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: bold;
        src: url("{{ storage_path('fonts/Poppins-Bold.ttf') }}") format('truetype');
    }

    * {
        margin:0;
        padding:0;
        box-sizing:border-box;
    }
    body {
        font-family: 'Poppins', DejaVu Sans, sans-serif;
        font-size: 10px;
        color: #000;
        background: #fff;
        line-height: 1.5;
        padding: 70px;
    }

    /* ── ZONE 1 : Header ── */
    .zone-header {
        border: 1.5px solid #969595;
        padding: 12px 16px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .logo-block { display: flex; align-items: center; gap: 10px; }
    .logo-icon {
        width: 42px; height: 42px;
        background: linear-gradient(135deg, #1e1b4b, #6366f1);
        border-radius: 8px;
        color: #fff;
        font-size: 14px; font-weight: 900;
        text-align: center; line-height: 42px;
    }
    .app-name { font-size: 13px; font-weight: 700; }
    .app-sub  { font-size: 7.5px; color: #555; margin-top: 1px; }
    .header-center { text-align: center; flex: 1; }
    .header-doc-title {
        font-size: 13px; font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border-bottom: 1px solid #969595;
        padding-bottom: 4px; margin-bottom: 4px;
    }
    .header-subtitle { font-size: 8px; color: #555; }
    .header-right { text-align: right; font-size: 7.5px; color: #555; line-height: 1.7; }

    /* ── ZONE 2 : Infos (2 colonnes) ── */
    .zone-info { display: flex; gap: 10px; margin-bottom: 10px; }
    .info-left, .info-right {
        border: 1.5px solid #969595; flex: 1; padding: 0;
    }
    .info-box-title {
        background: #000; color: #fff;
        font-size: 8px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.06em;
        padding: 3px 8px;
    }
    .info-row {
        border-bottom: 1px solid #ddd;
        padding: 4px 8px;
        font-size: 8.5px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row strong { font-weight: 700; }

    /* ── ZONE 3 : Planification ── */
    .zone-planif {
        border: 1.5px solid #969595;
        margin-bottom: 10px; margin-top: 10px;
    }
    .zone-title {
        background: #000; color: #fff;
        font-size: 9px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.07em;
        padding: 4px 10px;
    }
    .planif-grid { display: flex; flex-wrap: wrap; }
    .planif-cell {
        width: 50%; display: flex;
        border-bottom: 1px solid #ddd;
        padding: 4px 8px;
        font-size: 8.5px;
    }
    .planif-cell.full { width: 100%; }
    .planif-cell:nth-child(odd) { border-right: 1px solid #ddd; }
    .planif-cell strong { font-weight: 700; margin-right: 4px; }
    .planif-empty {
        font-size: 8.5px; color: #999; font-style: italic;
        padding: 12px 10px; text-align: center; width: 100%;
    }

    /* ── ZONE 4 : Tableau activités ── */
    .zone-activites { border: 1.5px solid #969595; margin-bottom: 14px; }
    .act-table { width: 100%; border-collapse: collapse; }
    .act-table th {
        background: #f0f0f0;
        font-size: 7.5px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.03em;
        padding: 5px 6px; border: 1px solid #ccc; text-align: left;
    }
    .act-table td {
        font-size: 8.5px; padding: 5px 6px;
        border: 1px solid #ccc; vertical-align: middle;
    }
    .act-table tr:nth-child(even) td { background: #fafafa; }
    .col-num     { width: 4%;  text-align: center; font-weight: 700; }
    .col-act     { width: 24%; }
    .col-date    { width: 11%; text-align: center; }
    .col-montant { width: 13%; text-align: right; font-weight: 600; }
    .col-sign    { width: 20%; text-align: center; }
    .act-total {
        text-align: right; font-size: 9px; font-weight: 700;
        padding: 5px 10px; border-top: 1.5px solid #969595; background: #f5f5f5;
    }
    .act-empty {
        text-align: center; font-style: italic;
        color: #999; padding: 14px; font-size: 8.5px;
    }
    .sign-placeholder {
        height: 22px; border-bottom: 1px dotted #999; display: block;
    }

    /* ── FOOTER ── */
    .footer { border-top: 1.5px solid #969595; padding-top: 7px; text-align: center; }
    .footer-note { font-size: 7px; color: #555; line-height: 1.7; }
    .footer-copy { font-size: 8px; font-weight: 700; color: #000; margin-top: 2px; }
</style>
</head>
<body>

{{-- ═══ ZONE 1 : HEADER ═══ --}}
<div class="zone-header">
    <div class="header-center">
        <div class="header-doc-title">Fiche de projet</div>
        <div class="header-subtitle">Document officiel &mdash; Confidentiel</div>
    </div>
    <div class="header-right">
        Exporté par : {{ optional($exportedBy)->nomComplet ?? '—' }}<br>
        Le {{ $exportedAt }}
    </div>
</div>

{{-- ═══ ZONE 2 : INFOS PROJET (2 colonnes) ═══ --}}
<div class="zone-info">

    <div class="info-left">
        <div class="info-box-title">Informations du projet</div>
        <div class="info-row"><strong>Code projet :</strong> {{ $projet->codeProjet }}</div>
        <div class="info-row"><strong>Titre :</strong> {{ $projet->titre }}</div>
        <div class="info-row"><strong>Date début :</strong> {{ optional($projet->dateDebut)->format('d/m/Y') ?? '—' }}</div>
        <div class="info-row"><strong>Date fin :</strong> {{ optional($projet->dateFin)->format('d/m/Y') ?? '—' }}</div>
        <div class="info-row"><strong>Budget total :</strong> {{ $projet->budgetTotal ? number_format($projet->budgetTotal, 0, ',', ' ').' F CFA' : '—' }}</div>
        <div class="info-row"><strong>Montant demandé :</strong> {{ $projet->montantDemande ? number_format($projet->montantDemande, 0, ',', ' ').' F CFA' : '—' }}</div>
        <div class="info-row"><strong>Secteur :</strong> {{ optional($projet->secteur)->nomSecteur ?? '—' }}</div>

    </div>

    <div class="info-right">
        <div class="info-box-title">Porteur &amp; Suivi</div>
        <div class="info-row"><strong>Nom du porteur :</strong> {{ optional($projet->porteur)->nomComplet ?? '—' }}</div>
        <div class="info-row"><strong>Email :</strong> {{ optional($projet->porteur)->email ?? '—' }}</div>
        <div class="info-row"><strong>Date soumission :</strong> {{ optional($projet->dateSoumission)->format('d/m/Y') ?? '—' }}</div>
        <div class="info-row"><strong>Date approbation :</strong> {{ optional($projet->dateApprobation)->format('d/m/Y') ?? '—' }}</div>
        <div class="info-row"><strong>Durée :</strong> {{ $projet->duree ? $projet->duree.' mois' : '—' }}</div>
        <div class="info-row"><strong>Objectif :</strong> {{ $projet->objectif ?? '—' }}</div>

    </div>

</div>

{{-- ═══ ZONE 3 : PLANIFICATION ═══ --}}
<div class="zone-planif">
    <div class="zone-title">Planification du projet</div>
    @if($projet->planification)
    <div class="planif-grid">
        <div class="planif-cell">
            <strong>Activité planifiée :</strong>&nbsp;{{ $projet->planification->activitePlanification ?? '—' }}
        </div>
        <div class="planif-cell">
            <strong>Indicateur :</strong>&nbsp;{{ $projet->planification->indicateur ?? '—' }}
        </div>
        <div class="planif-cell">
            <strong>Unité de mesure :</strong>&nbsp;{{ $projet->planification->uniteIndicateur ?? '—' }}
        </div>
        <div class="planif-cell">
            <strong>Période :</strong>&nbsp;{{ $projet->planification->periode ?? '—' }}
        </div>
        <div class="planif-cell">
            <strong>Coût estimatif :</strong>&nbsp;{{ $projet->planification->coutEstimatif ? number_format($projet->planification->coutEstimatif, 0, ',', ' ').' F CFA' : '—' }}
        </div>
        @if($projet->planification->resultatsAttendues)
        <div class="planif-cell full">
            <strong>Résultats attendus :</strong>&nbsp;{{ $projet->planification->resultatsAttendues }}
        </div>
        @endif
    </div>
    @else
    <div style="display:flex;">
        <div class="planif-empty">Aucune planification définie pour ce projet.</div>
    </div>
    @endif
</div>

{{-- ═══ ZONE 4 : TABLEAU ACTIVITÉS ═══ --}}
<div class="zone-activites">
    <div class="zone-title">Tableau des activités ({{ $projet->activites->count() }})</div>
    @if($projet->activites->count())
    <table class="act-table">
        <thead>
            <tr>
                <th class="col-num">N°</th>
                <th class="col-act">Activité</th>
                <th class="col-date">Date début</th>
                <th class="col-date">Date fin</th>
                <th class="col-montant">Montant demandé</th>
                <th class="col-sign">Nom du bailleur de fonds</th>
                <th class="col-sign">Signature bailleur</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projet->activites as $act)
            <tr>
                <td class="col-num">{{ $loop->iteration }}</td>
                <td class="col-act" style="font-weight:600;">{{ $act->activite }}</td>
                <td class="col-date">{{ optional($act->dateDebut)->format('d/m/Y') ?? '—' }}</td>
                <td class="col-date">{{ optional($act->dateFin)->format('d/m/Y') ?? '—' }}</td>
                <td class="col-montant">{{ $act->montantDemande ? number_format($act->montantDemande, 0, ',', ' ').' F CFA' : '—' }}</td>
                <td class="col-sign"><span class="sign-placeholder"></span></td>
                <td class="col-sign"><span class="sign-placeholder"></span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="act-total">
        Total : {{ number_format($projet->activites->sum('montantDemande'), 0, ',', ' ') }} F CFA
    </div>
    @else
    <div class="act-empty">Aucune activité définie pour ce projet.</div>
    @endif
</div>

{{-- ═══ FOOTER ═══ --}}
<div class="footer">
    <div class="footer-note">
        Toute reproduction ou diffusion non autorisée est strictement interdite.
    </div>
    <div class="footer-copy">&copy; {{ date('Y') }} GesProjet &mdash; Tous droits réservés</div>
</div>

</body>
</html>
