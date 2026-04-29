@extends('layouts.app')
@section('title', 'Examen — ' . $projet->titre)
@push('styles')
<link rel="stylesheet" href="{{ asset('css/approbateur.css') }}">
@endpush

@section('content')
<div class="aprob-page">

    {{-- Breadcrumb --}}
    <div class="aprob-breadcrumb">
        <a href="{{ route('approbateur.dashboard') }}"><i class="fas fa-home"></i></a>
        <span>/</span>
        <a href="{{ route('approbateur.projets.index') }}">Projets</a>
        <span>/</span>
        <span>{{ $projet->codeProjet }}</span>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="aprob-alert aprob-alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    {{-- Header --}}
    @php
        $stMap = [
            'soumis'    => ['lbl'=>'Soumis',    'cls'=>'aprob-badge-soumis',    'dot'=>'#6366f1'],
            'en_examen' => ['lbl'=>'En examen', 'cls'=>'aprob-badge-en_examen', 'dot'=>'#f97316'],
            'approuve'  => ['lbl'=>'Approuvé',  'cls'=>'aprob-badge-approuve',  'dot'=>'#22c55e'],
            'rejete'    => ['lbl'=>'Rejeté',    'cls'=>'aprob-badge-rejete',    'dot'=>'#ef4444'],
            'valide'    => ['lbl'=>'Validé',    'cls'=>'aprob-badge-valide',    'dot'=>'#0d9488'],
            'brouillon' => ['lbl'=>'Brouillon', 'cls'=>'aprob-badge-brouillon', 'dot'=>'#9ca3af'],
        ];
        $s = $stMap[$projet->statutProjet] ?? $stMap['soumis'];
    @endphp

    <div class="aprob-header">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;flex-wrap:wrap;">
                <span style="font-size:.7rem;font-weight:700;color:var(--aprob-text-light);
                             text-transform:uppercase;letter-spacing:.05em;
                             background:var(--aprob-bg-gray);padding:3px 10px;border-radius:20px;">
                    {{ $projet->codeProjet }}
                </span>
                <span class="aprob-badge {{ $s['cls'] }}">
                    <span class="aprob-dot" style="background:{{ $s['dot'] }};"></span>
                    {{ $s['lbl'] }}
                </span>
            </div>
            <h1 class="aprob-header-title">{{ $projet->titre }}</h1>
            <p class="aprob-header-sub" style="display:flex;gap:14px;flex-wrap:wrap;margin-top:4px;">
                <span><i class="fas fa-user" style="margin-right:4px;"></i>{{ optional($projet->porteur)->nomComplet ?? '—' }}</span>
                <span><i class="fas fa-tag" style="margin-right:4px;"></i>{{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
                @if($projet->dateSoumission)
                <span><i class="fas fa-calendar" style="margin-right:4px;"></i>Soumis le {{ $projet->dateSoumission->format('d/m/Y') }}</span>
                @endif
            </p>
        </div>
        <a href="{{ route('approbateur.projets.index') }}" class="aprob-btn-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    {{-- Barre d'actions --}}
    <div class="aprob-actions-bar">
        @can('examiner', $projet)
        <form method="POST" action="{{ route('approbateur.projets.examiner', $projet) }}">
            @csrf
            <button type="submit" class="aprob-btn aprob-btn-orange">
                <i class="fas fa-search"></i> Mettre en examen
            </button>
        </form>
        @endcan

        @can('approuver', $projet)
        <button type="button" class="aprob-btn aprob-btn-green"
                onclick="openModal('modalApprouver')">
            <i class="fas fa-check-circle"></i> Approuver
        </button>
        @endcan

        @can('rejeter', $projet)
        <button type="button" class="aprob-btn aprob-btn-red"
                onclick="openModal('modalRejeter')">
            <i class="fas fa-times-circle"></i> Rejeter
        </button>
        @endcan

        <a href="{{ route('approbateur.projets.export.pdf', $projet) }}"
           class="aprob-btn aprob-btn-gray" target="_blank">
            <i class="fas fa-file-pdf"></i> Exporter PDF
        </a>
    </div>

    {{-- Grille principale --}}
    <div class="aprob-show-grid">

        {{-- Colonne principale --}}
        <div class="aprob-show-main">

            {{-- Infos générales --}}
            <div class="aprob-info-card">
                <div class="aprob-info-card-head">
                    <span class="aprob-info-card-title">
                        <i class="fas fa-info-circle"></i> Informations générales
                    </span>
                </div>
                <div class="aprob-info-grid">
                    <div>
                        <p class="aprob-info-lbl">Secteur</p>
                        <p class="aprob-info-val">{{ optional($projet->secteur)->nomSecteur ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="aprob-info-lbl">Durée</p>
                        <p class="aprob-info-val">{{ $projet->duree ? $projet->duree.' mois' : '—' }}</p>
                    </div>
                    <div>
                        <p class="aprob-info-lbl">Date début</p>
                        <p class="aprob-info-val">{{ optional($projet->dateDebut)->format('d/m/Y') ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="aprob-info-lbl">Date fin</p>
                        <p class="aprob-info-val">{{ optional($projet->dateFin)->format('d/m/Y') ?? '—' }}</p>
                    </div>
                    @if($projet->objectif)
                    <div class="aprob-info-full">
                        <p class="aprob-info-lbl">Objectif</p>
                        <p class="aprob-info-val">{{ $projet->objectif }}</p>
                    </div>
                    @endif
                    <div class="aprob-info-full">
                        <p class="aprob-info-lbl">Description</p>
                        <p class="aprob-info-val" style="white-space:pre-line;">{{ $projet->description ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Planification — activités en CARDS avec border-left --}}
            <div class="aprob-info-card">
                <div class="aprob-info-card-head">
                    <span class="aprob-info-card-title">
                        <i class="fas fa-tasks"></i> Planification
                        <span class="aprob-info-count">{{ $projet->planifications->count() }}</span>
                    </span>
                </div>

                @forelse($projet->planifications as $plan)
                <div class="aprob-activite-card">
                    <div class="aprob-activite-head">
                        <div class="aprob-activite-num">{{ $loop->iteration }}</div>
                        <p class="aprob-activite-titre">{{ $plan->activitePlanification }}</p>
                        @if($plan->coutEstimatif)
                        <span class="aprob-activite-cout">
                            <i class="fas fa-coins" style="font-size:.6rem;"></i>
                            {{ number_format($plan->coutEstimatif, 0, ',', ' ') }} F CFA
                        </span>
                        @endif
                    </div>

                    <div class="aprob-activite-details">
                        @if($plan->indicateur)
                        <div>
                            <span class="aprob-activite-detail-lbl">Indicateur : </span>
                            <span class="aprob-activite-detail-val">
                                {{ $plan->indicateur }}
                                @if($plan->uniteIndicateur) ({{ $plan->uniteIndicateur }}) @endif
                            </span>
                        </div>
                        @endif
                        @if($plan->periode)
                        <div>
                            <span class="aprob-activite-detail-lbl">Période : </span>
                            <span class="aprob-activite-detail-val">{{ $plan->periode }}</span>
                        </div>
                        @endif
                        @if($plan->resultatsAttendues)
                        <div class="aprob-activite-detail-full">
                            <span class="aprob-activite-detail-lbl">Résultats attendus : </span>
                            <span class="aprob-activite-detail-val">{{ $plan->resultatsAttendues }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="aprob-empty" style="padding:24px;">
                    <i class="fas fa-calendar-plus"></i>
                    <p>Aucune activité planifiée pour ce projet.</p>
                </div>
                @endforelse

                @if($projet->planifications->count() > 0)
                <div class="aprob-total-bar">
                    <span class="aprob-total-label">Total estimé :</span>
                    <span class="aprob-total-val">
                        {{ number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ') }} F CFA
                    </span>
                </div>
                @endif
            </div>

            {{-- Documents --}}
            @if($projet->documents->count())
            <div class="aprob-info-card">
                <div class="aprob-info-card-head">
                    <span class="aprob-info-card-title">
                        <i class="fas fa-paperclip"></i> Documents
                        <span class="aprob-info-count">{{ $projet->documents->count() }}</span>
                    </span>
                </div>
                <div class="aprob-docs-list">
                    @foreach($projet->documents as $doc)
                    <a href="{{ asset('storage/'.$doc->cheminFichier) }}" target="_blank" class="aprob-doc-item">
                        <i class="fas fa-file-alt"></i>
                        <span>{{ $doc->nomFichier ?? basename($doc->cheminFichier) }}</span>
                        <i class="fas fa-external-link-alt" style="font-size:.65rem;color:var(--aprob-text-light);"></i>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Commentaires --}}
            @if($projet->commentaires->count())
            <div class="aprob-info-card">
                <div class="aprob-info-card-head">
                    <span class="aprob-info-card-title">
                        <i class="fas fa-comments"></i> Historique
                        <span class="aprob-info-count">{{ $projet->commentaires->count() }}</span>
                    </span>
                </div>
                <div class="aprob-comments-list">
                    @foreach($projet->commentaires->sortByDesc('dateEnvoi') as $com)
                    @php
                        $comMap = [
                            'approbation' => ['icon'=>'fa-check-circle',       'color'=>'#16a34a'],
                            'rejet'       => ['icon'=>'fa-times-circle',       'color'=>'#dc2626'],
                            'demande'     => ['icon'=>'fa-exclamation-circle', 'color'=>'#d97706'],
                            'info'        => ['icon'=>'fa-info-circle',        'color'=>'#2563eb'],
                        ];
                        $cm = $comMap[$com->typeCommentaire] ?? ['icon'=>'fa-comment','color'=>'#6b7280'];
                    @endphp
                    <div class="aprob-comment-item">
                        <div class="aprob-comment-avatar" style="background:{{ $cm['color'] }}18;color:{{ $cm['color'] }};">
                            <i class="fas {{ $cm['icon'] }}"></i>
                        </div>
                        <div class="aprob-comment-body">
                            <div class="aprob-comment-head">
                                <span class="aprob-comment-role">{{ optional($com->utilisateur)->role ?? '—' }}</span>
                                <span class="aprob-comment-date">{{ optional($com->dateEnvoi)->format('d/m/Y H:i') }}</span>
                            </div>
                            <p class="aprob-comment-text">{{ $com->message }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- Aside --}}
        <div class="aprob-show-aside">

            {{-- Budget --}}
            <div class="aprob-aside-card">
                <p class="aprob-aside-title"><i class="fas fa-wallet"></i> Budget</p>
                <div class="aprob-fin-rows">
                    <div class="aprob-fin-row">
                        <span>Budget total</span>
                        <strong>{{ number_format($projet->budgetTotal ?? 0, 0, ',', ' ') }} F CFA</strong>
                    </div>
                    <div class="aprob-fin-row">
                        <span>Montant demandé</span>
                        <strong>{{ number_format($projet->montantDemande ?? 0, 0, ',', ' ') }} F CFA</strong>
                    </div>
                    <div class="aprob-fin-row">
                        <span>Durée</span>
                        <strong>{{ $projet->duree ?? '—' }} mois</strong>
                    </div>
                    @if($projet->planifications->count())
                    <div class="aprob-fin-row">
                        <span>Coût planifié</span>
                        <strong style="color:var(--aprob-primary);">
                            {{ number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ') }} F CFA
                        </strong>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Porteur --}}
            <div class="aprob-aside-card">
                <p class="aprob-aside-title"><i class="fas fa-user"></i> Porteur</p>
                <div class="aprob-porteur-block">
                    <div class="aprob-porteur-avatar">
                        {{ strtoupper(substr(optional($projet->porteur)->nomComplet ?? 'P', 0, 1)) }}
                    </div>
                    <div>
                        <p class="aprob-porteur-name">{{ optional($projet->porteur)->nomComplet ?? '—' }}</p>
                        <p class="aprob-porteur-email">{{ optional($projet->porteur)->email ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Zone décision --}}
            @if(in_array($projet->statutProjet, ['soumis','en_examen']))
            <div class="aprob-aside-card aprob-decision-card">
                <p class="aprob-aside-title" style="color:var(--aprob-primary-hover);">
                    <i class="fas fa-gavel"></i> Décision
                </p>
                <p style="font-size:.73rem;color:var(--aprob-text-muted);margin:0 0 10px;">
                    Approuvez ou rejetez après examen complet.
                </p>
                @can('approuver', $projet)
                <button onclick="openModal('modalApprouver')"
                        class="aprob-btn aprob-btn-green"
                        style="width:100%;justify-content:center;margin-bottom:8px;">
                    <i class="fas fa-check-circle"></i> Approuver
                </button>
                @endcan
                @can('rejeter', $projet)
                <button onclick="openModal('modalRejeter')"
                        class="aprob-btn aprob-btn-red"
                        style="width:100%;justify-content:center;">
                    <i class="fas fa-times-circle"></i> Rejeter
                </button>
                @endcan
            </div>
            @endif

            {{-- Statut final --}}
            @if(in_array($projet->statutProjet, ['approuve','rejete','valide']))
            <div class="aprob-aside-card">
                <p class="aprob-aside-title"><i class="fas fa-flag-checkered"></i> Décision finale</p>
                <div class="aprob-decision-badge {{ in_array($projet->statutProjet, ['approuve','valide']) ? 'aprob-decision-valide' : 'aprob-decision-rejete' }}">
                    <i class="fas {{ $projet->statutProjet === 'rejete' ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                    Projet {{ $s['lbl'] }}
                </div>
                @if($projet->dateApprobation)
                <p class="aprob-decision-date">
                    <i class="fas fa-calendar-check"></i>
                    {{ optional($projet->dateApprobation)->format('d/m/Y') }}
                </p>
                @endif
            </div>
            @endif

        </div>
    </div>

</div>

{{-- Modal Approuver --}}
<div id="modalApprouver" class="aprob-modal-overlay">
    <div class="aprob-modal-box">
        <div class="aprob-modal-head">
            <h3 class="aprob-modal-title">
                <i class="fas fa-check-circle" style="color:#22c55e;"></i> Approuver le projet
            </h3>
            <button onclick="closeModal('modalApprouver')" class="aprob-modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('approbateur.projets.approuver', $projet) }}">
            @csrf
            <div class="aprob-modal-body">
                <p style="font-size:.82rem;color:#6b7280;margin:0;">
                    Le projet sera transmis au validateur.
                </p>
                <div class="aprob-form-group">
                    <label class="aprob-form-label">Commentaire (optionnel)</label>
                    <textarea name="commentaire" class="aprob-form-textarea" rows="3"
                              placeholder="Observations..."></textarea>
                </div>
            </div>
            <div class="aprob-modal-foot">
                <button type="button" onclick="closeModal('modalApprouver')"
                        class="aprob-btn aprob-btn-gray">Annuler</button>
                <button type="submit" class="aprob-btn aprob-btn-green">
                    <i class="fas fa-check-circle"></i> Confirmer
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Rejeter --}}
<div id="modalRejeter" class="aprob-modal-overlay">
    <div class="aprob-modal-box">
        <div class="aprob-modal-head">
            <h3 class="aprob-modal-title">
                <i class="fas fa-times-circle" style="color:#ef4444;"></i> Rejeter le projet
            </h3>
            <button onclick="closeModal('modalRejeter')" class="aprob-modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('approbateur.projets.rejeter', $projet) }}">
            @csrf
            <div class="aprob-modal-body">
                <div class="aprob-form-group">
                    <label class="aprob-form-label">Motif du rejet <span style="color:#ef4444;">*</span></label>
                    <textarea name="motifRejet" class="aprob-form-textarea danger" rows="3"
                              placeholder="Expliquez le motif..." required></textarea>
                    @error('motifRejet')<p class="aprob-form-error">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="aprob-modal-foot">
                <button type="button" onclick="closeModal('modalRejeter')"
                        class="aprob-btn aprob-btn-gray">Annuler</button>
                <button type="submit" class="aprob-btn aprob-btn-red">
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
document.querySelectorAll('.aprob-modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); });
});
</script>
@endpush
@endsection
