@extends('layouts.app')
@section('title', 'Examen — ' . $projet->titre)
@push('styles')
<link rel="stylesheet" href="{{ asset('css/approbDash.css') }}">

@endpush

@section('content')
<div class="vpage">

{{-- Breadcrumb --}}
<div class="breadcrumb">
    <a href="{{ route('approbateur.dashboard') }}"><i class="fas fa-home"></i></a>
    <span>/</span>
    <a href="{{ route('approbateur.projets.index') }}">Projets</a>
    <span>/</span>
    <span>{{ $projet->codeProjet }}</span>
</div>

{{-- Header --}}
@php
    $map = [
        'soumis'    => ['lbl'=>'Soumis',   'dot'=>'#6366f1','bg'=>'#eef2ff','color'=>'#4338ca'],
        'en_examen' => ['lbl'=>'En examen','dot'=>'#f97316','bg'=>'#fff7ed','color'=>'#c2410c'],
        'approuve'  => ['lbl'=>'Approuvé', 'dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d'],
        'rejete'    => ['lbl'=>'Rejeté',   'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c'],
        'valide'    => ['lbl'=>'Validé',   'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e'],
        'brouillon' => ['lbl'=>'Brouillon','dot'=>'#9ca3af','bg'=>'#f3f4f6','color'=>'#6b7280'],
    ];
    $s = $map[$projet->statutProjet] ?? $map['soumis'];
@endphp

<div class="show-header mt-4">
    <div>
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
            <span class="proj-code">{{ $projet->codeProjet }}</span>
            <span class="status-badge" style="background:{{ $s['bg'] }};color:{{ $s['color'] }};">
                <span class="dot" style="background:{{ $s['dot'] }};"></span>{{ $s['lbl'] }}
            </span>
        </div>
        <h1 class="show-title">{{ $projet->titre }}</h1>
        <div class="show-meta">
            <span><i class="fas fa-user"></i> {{ optional($projet->porteur)->nomComplet ?? '—' }}</span>
            <span><i class="fas fa-tag"></i> {{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
            <span><i class="fas fa-calendar"></i> Soumis le {{ optional($projet->dateSoumission)->format('d/m/Y') ?? '—' }}</span>
            @if($projet->dateApprobation)
            <span><i class="fas fa-check"></i> Approuvé le {{ optional($projet->dateApprobation)->format('d/m/Y') }}</span>
            @endif
        </div>
    </div>
    <a href="{{ route('approbateur.projets.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

{{-- ── Barre d'actions ── --}}
<div class="actions-bar mt-4 mb-4">

    {{-- Passer en examen --}}
    @can('examiner', $projet)
    <form method="POST" action="{{ route('approbateur.projets.examiner', $projet) }}">
        @csrf
        <button type="submit" class="action-btn action-orange">
            <i class="fas fa-search"></i> Mettre en examen
        </button>
    </form>
    @endcan

    {{-- Approuver --}}
    @can('approuver', $projet)
    <button type="button" class="action-btn action-green" onclick="openModal('modalApprouver')">
        <i class="fas fa-check-circle"></i> Approuver
    </button>
    @endcan

    {{-- Rejeter --}}
    @can('rejeter', $projet)
    <button type="button" class="action-btn action-red" onclick="openModal('modalRejeter')">
        <i class="fas fa-times-circle"></i> Rejeter
    </button>
    @endcan


    {{-- Planification --}}
    @can('gererPlanification', $projet)
    @if($projet->planification)
    <a href="{{ route('approbateur.planification.edit', [$projet, $projet->planification]) }}"
        class="action-btn action-indigo">
        <i class="fas fa-calendar-check"></i> Modifier planification
    </a>
    @else
    <a href="{{ route('approbateur.planification.create', $projet) }}"
        class="action-btn action-indigo">
        <i class="fas fa-calendar-plus"></i> Planifier
    </a>
    @endif
    @endcan

    {{-- Exporter en pdf --}}
    <a href="{{ route('approbateur.projets.export.pdf', $projet) }}"
        class="action-btn action-indigo" target="_blank">
        <i class="fas fa-file-pdf"></i> Exporter PDF
    </a>

</div>

{{-- ── Grille principale ── --}}
<div class="show-grid">

    {{-- Colonne principale --}}
    <div class="show-main">

        {{-- Informations générales --}}
        <div class="info-card">
            <h4 class="info-title"><i class="fas fa-info-circle"></i> Informations générales</h4>
            <div class="info-grid-2">
                <div class="info-item">
                    <p class="info-lbl">Secteur</p>
                    <p class="info-val">{{ optional($projet->secteur)->nomSecteur ?? '—' }}</p>
                </div>
                <div class="info-item">
                    <p class="info-lbl">Durée</p>
                    <p class="info-val">{{ $projet->duree ? $projet->duree . ' mois' : '—' }}</p>
                </div>
                <div class="info-item">
                    <p class="info-lbl">Date début</p>
                    <p class="info-val">{{ optional($projet->dateDebut)->format('d/m/Y') ?? '—' }}</p>
                </div>
                <div class="info-item">
                    <p class="info-lbl">Date fin</p>
                    <p class="info-val">{{ optional($projet->dateFin)->format('d/m/Y') ?? '—' }}</p>
                </div>
                <div class="info-item info-full">
                    <p class="info-lbl">Objectif</p>
                    <p class="info-val">{{ $projet->objectif ?? '—' }}</p>
                </div>
                <div class="info-item info-full">
                    <p class="info-lbl">Description</p>
                    <p class="info-val" style="white-space:pre-line;">{{ $projet->description ?? '—' }}</p>
                </div>
            </div>
        </div>

        {{-- Activités du porteur --}}
        <div class="info-card">
            <h4 class="info-title">
                <i class="fas fa-tasks"></i> Activités du porteur
                <span class="info-count">{{ $projet->activites->count() }}</span>
            </h4>
            @forelse($projet->activites as $act)
            @php
                $actMap = [
                    'en_attente' => ['lbl'=>'En attente','bg'=>'#f3f4f6','color'=>'#6b7280'],
                    'en_cours'   => ['lbl'=>'En cours',  'bg'=>'#eff6ff','color'=>'#1d4ed8'],
                    'termine'    => ['lbl'=>'Terminée',  'bg'=>'#f0fdf4','color'=>'#15803d'],
                    'annule'     => ['lbl'=>'Annulée',   'bg'=>'#fef2f2','color'=>'#b91c1c'],
                    'financee'   => ['lbl'=>'Financée',  'bg'=>'#f0fdfa','color'=>'#0f766e'],
                ];
                $a = $actMap[$act->statutActivite] ?? $actMap['en_attente'];
            @endphp
            <div class="activite-item">
                <div class="activite-head">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div class="activite-num">{{ $loop->iteration }}</div>
                        <p class="activite-titre">{{ $act->activite }}</p>
                    </div>
                    <span class="status-badge" style="background:{{ $a['bg'] }};color:{{ $a['color'] }};">{{ $a['lbl'] }}</span>
                </div>
                @if($act->descriptionActivite)
                <p class="activite-desc">{{ $act->descriptionActivite }}</p>
                @endif
                <div class="activite-footer">
                    <span><i class="fas fa-calendar"></i> {{ optional($act->dateDebut)->format('d/m/Y') ?? '—' }} → {{ optional($act->dateFin)->format('d/m/Y') ?? '—' }}</span>
                    @if($act->montantDemande)
                    <span><i class="fas fa-coins"></i> {{ number_format($act->montantDemande, 0, ',', ' ') }} F CFA</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-state" style="padding:20px;">
                <i class="fas fa-tasks"></i>
                <p>Aucune activité définie par le porteur.</p>
            </div>
            @endforelse
        </div>

        {{-- Planification (si existe) --}}
        @can('voirPlanification', $projet)
        @if($projet->planification)
        <div class="info-card" style="border-left:3px solid #6366f1;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                <h4 class="info-title" style="margin:0;">
                    <i class="fas fa-calendar-check" style="color:#6366f1;"></i> Planification
                </h4>
                @can('gererPlanification', $projet)
                <div style="display:flex;gap:8px;">
                    <a href="{{ route('approbateur.planification.edit', [$projet, $projet->planification]) }}"
                       class="btn-voir" style="background:#eef2ff;color:#6366f1;">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <form method="POST" action="{{ route('approbateur.planification.destroy', [$projet, $projet->planification]) }}"
                          onsubmit="return confirm('Supprimer cette planification ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-voir" style="background:#fef2f2;color:#dc2626;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                @endcan
            </div>
            <div class="info-grid-2">
                <div class="info-item">
                    <p class="info-lbl">Activité planifiée</p>
                    <p class="info-val">{{ $projet->planification->activitePlanification ?? '—' }}</p>
                </div>
                <div class="info-item">
                    <p class="info-lbl">Indicateur</p>
                    <p class="info-val">{{ $projet->planification->indicateur ?? '—' }}</p>
                </div>
                <div class="info-item">
                    <p class="info-lbl">Unité</p>
                    <p class="info-val">{{ $projet->planification->uniteIndicateur ?? '—' }}</p>
                </div>
                <div class="info-item">
                    <p class="info-lbl">Période</p>
                    <p class="info-val">{{ $projet->planification->periode ?? '—' }}</p>
                </div>
                <div class="info-item">
                    <p class="info-lbl">Coût estimatif</p>
                    <p class="info-val">{{ $projet->planification->coutEstimatif ? number_format($projet->planification->coutEstimatif, 0, ',', ' ').' F CFA' : '—' }}</p>
                </div>
                @if($projet->planification->resultatsAttendues)
                <div class="info-item info-full">
                    <p class="info-lbl">Résultats attendus</p>
                    <p class="info-val">{{ $projet->planification->resultatsAttendues }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif
        @endcan

        {{-- Documents --}}
        @if($projet->documents->count())
        <div class="info-card">
            <h4 class="info-title">
                <i class="fas fa-paperclip"></i> Documents
                <span class="info-count">{{ $projet->documents->count() }}</span>
            </h4>
            <div class="docs-list">
                @foreach($projet->documents as $doc)
                <a href="{{ asset('storage/'.$doc->cheminFichier) }}" target="_blank" class="doc-item">
                    <i class="fas fa-file-alt"></i>
                    <span>{{ $doc->nomFichier ?? basename($doc->cheminFichier) }}</span>
                    <i class="fas fa-external-link-alt doc-ext"></i>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Historique commentaires --}}
        @if($projet->commentaires->count())
        <div class="info-card">
            <h4 class="info-title">
                <i class="fas fa-comments"></i> Historique
                <span class="info-count">{{ $projet->commentaires->count() }}</span>
            </h4>
            <div class="comments-list">
                @foreach($projet->commentaires->sortByDesc('dateEnvoi') as $com)
                @php
                    $comMap = [
                        'approbation' => ['icon'=>'fa-check-circle',      'color'=>'#16a34a'],
                        'rejet'       => ['icon'=>'fa-times-circle',      'color'=>'#dc2626'],
                        'demande'     => ['icon'=>'fa-exclamation-circle','color'=>'#d97706'],
                        'info'        => ['icon'=>'fa-info-circle',       'color'=>'#2563eb'],
                        'examen'      => ['icon'=>'fa-search',            'color'=>'#6366f1'],
                    ];
                    $cm = $comMap[$com->typeCommentaire] ?? ['icon'=>'fa-comment','color'=>'#6b7280'];
                @endphp
                <div class="comment-item">
                    <div class="comment-avatar" style="background:{{ $cm['color'] }}18;color:{{ $cm['color'] }};">
                        <i class="fas {{ $cm['icon'] }}"></i>
                    </div>
                    <div class="comment-body">
                        <div class="comment-head">
                            <span class="comment-author">
                                {{ optional($com->utilisateur)->nomComplet ?? '—' }}
                                <small style="color:#9ca3af;font-weight:400;">· {{ optional($com->utilisateur)->role ?? '' }}</small>
                            </span>
                            <span class="comment-date">{{ optional($com->dateEnvoi)->format('d/m/Y H:i') }}</span>
                        </div>
                        <p class="comment-text">{{ $com->message }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    {{-- Sidebar --}}
    <div class="show-aside">

        {{-- Budget --}}
        <div class="aside-card">
            <h4 class="info-title"><i class="fas fa-wallet"></i> Budget</h4>
            <div class="fin-rows">
                <div class="fin-row">
                    <span>Budget total</span>
                    <strong>{{ number_format($projet->budgetTotal ?? 0, 0, ',', ' ') }} F CFA</strong>
                </div>
                <div class="fin-row">
                    <span>Montant demandé</span>
                    <strong>{{ number_format($projet->montantDemande ?? 0, 0, ',', ' ') }} F CFA</strong>
                </div>
                <div class="fin-row">
                    <span>Durée</span>
                    <strong>{{ $projet->duree ?? '—' }} mois</strong>
                </div>
                @if($projet->activites->count())
                <div class="fin-row">
                    <span>Total activités</span>
                    <strong>{{ number_format($projet->activites->sum('montantDemande'), 0, ',', ' ') }} F CFA</strong>
                </div>
                @endif
            </div>
        </div>

        {{-- Porteur --}}
        <div class="aside-card">
            <h4 class="info-title"><i class="fas fa-user"></i> Porteur</h4>
            <div class="porteur-block">
                <div class="porteur-avatar">
                    {{ strtoupper(substr(optional($projet->porteur)->nomComplet ?? 'P', 0, 1)) }}
                </div>
                <div>
                    <p class="porteur-name">{{ optional($projet->porteur)->nomComplet ?? '—' }}</p>
                    <p class="porteur-email">{{ optional($projet->porteur)->email ?? '—' }}</p>
                </div>
            </div>
        </div>

        {{-- Zone décision approbateur --}}
        @if(in_array($projet->statutProjet, ['soumis','en_examen']))
        <div class="aside-card" style="border-color:#e0e7ff;">
            <h4 class="info-title" style="color:#4338ca;">
                <i class="fas fa-gavel" style="color:#6366f1;"></i> Décision
            </h4>
            <p style="font-size:.74rem;color:#9ca3af;margin:0 0 12px;">
                Approuvez ou rejetez ce projet après examen.
            </p>
            @can('approuver', $projet)
            <button onclick="openModal('modalApprouver')" class="btn-valider" style="margin-bottom:8px;">
                <i class="fas fa-check-circle"></i> Approuver
            </button>
            @endcan
            @can('rejeter', $projet)
            <button onclick="openModal('modalRejeter')" class="btn-rejeter">
                <i class="fas fa-times-circle"></i> Rejeter
            </button>
            @endcan
        </div>
        @endif

        {{-- Statut final --}}
        @if(in_array($projet->statutProjet, ['approuve','rejete','valide']))
        <div class="aside-card">
            <h4 class="info-title"><i class="fas fa-flag-checkered"></i> Décision finale</h4>
            <div class="decision-badge {{ $projet->statutProjet === 'approuve' || $projet->statutProjet === 'valide' ? 'decision-valide' : 'decision-rejete' }}">
                <i class="fas {{ $projet->statutProjet === 'rejete' ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                Projet {{ $s['lbl'] }}
            </div>
            @if($projet->dateApprobation)
            <p class="decision-date">
                <i class="fas fa-calendar-check"></i>
                {{ optional($projet->dateApprobation)->format('d/m/Y') }}
            </p>
            @endif
            {{-- Motif rejet depuis commentaires --}}
            @php
                $motif = $projet->commentaires->where('typeCommentaire','rejet')->last();
            @endphp
            @if($motif)
            <div class="vd-comment-box vd-comment-red" style="margin-top:10px;">
                {{ $motif->message }}
            </div>
            @endif
        </div>
        @endif

    </div>
</div>

</div>

{{-- ══ MODAL APPROUVER ══ --}}
<div id="modalApprouver" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-head">
            <h3 class="modal-title"><i class="fas fa-check-circle" style="color:#22c55e;"></i> Approuver le projet</h3>
            <button onclick="closeModal('modalApprouver')" class="modal-close"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="{{ route('approbateur.projets.approuver', $projet) }}">
            @csrf
            <div class="modal-body">
                <p style="font-size:.82rem;color:#6b7280;margin:0 0 12px;">
                    Le projet sera transmis au validateur pour validation finale.
                </p>
                <div class="form-group">
                    <label class="form-label">Commentaire (optionnel)</label>
                    <textarea name="commentaire" class="form-textarea" rows="3"
                              placeholder="Observations sur l'approbation..."></textarea>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" onclick="closeModal('modalApprouver')" class="btn-cancel">Annuler</button>
                <button type="submit" class="btn-valider" style="width:auto;padding:9px 20px;">
                    <i class="fas fa-check-circle"></i> Confirmer l'approbation
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ MODAL REJETER ══ --}}
<div id="modalRejeter" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-head">
            <h3 class="modal-title"><i class="fas fa-times-circle" style="color:#ef4444;"></i> Rejeter le projet</h3>
            <button onclick="closeModal('modalRejeter')" class="modal-close"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="{{ route('approbateur.projets.rejeter', $projet) }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Motif du rejet <span style="color:#ef4444;">*</span></label>
                    <textarea name="motifRejet" class="form-textarea form-textarea-danger" rows="3"
                              placeholder="Expliquez le motif du rejet..." required></textarea>
                    @error('motifRejet')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Demander des modifications (optionnel)</label>
                    <textarea name="messageModification" class="form-textarea" rows="2"
                              placeholder="Modifications à apporter avant resoumission..."></textarea>
                    <p style="font-size:.7rem;color:#9ca3af;margin:4px 0 0;">
                        Si renseigné, le projet retourne en brouillon pour modification.
                    </p>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" onclick="closeModal('modalRejeter')" class="btn-cancel">Annuler</button>
                <button type="submit" class="btn-rejeter" style="width:auto;">
                    <i class="fas fa-times-circle"></i> Confirmer le rejet
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openModal(id) {
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = '';
}
document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); });
});
</script>
@endpush

@endsection
