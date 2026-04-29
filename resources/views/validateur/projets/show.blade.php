@extends('layouts.app')
@section('title', 'Examen — ' . $projet->titre)
@push('styles')
<link rel="stylesheet" href="{{ asset('css/validateur.css') }}">
@endpush

@section('content')
<div class="valid-page">

    {{-- Breadcrumb --}}
    <div class="valid-breadcrumb">
        <a href="{{ route('validateur.dashboard') }}"><i class="fas fa-home"></i></a>
        <span>/</span>
        <a href="{{ route('validateur.projets.index') }}">Projets</a>
        <span>/</span>
        <span>{{ $projet->codeProjet }}</span>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="valid-alert valid-alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="valid-alert valid-alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    {{-- Header --}}
    @php
        $stMap = [
            'approuve' => ['lbl'=>'Approuvé','cls'=>'valid-badge-approuve','dot'=>'#0d9488'],
            'valide'   => ['lbl'=>'Validé',  'cls'=>'valid-badge-valide',  'dot'=>'#15803d'],
            'rejete'   => ['lbl'=>'Rejeté',  'cls'=>'valid-badge-rejete',  'dot'=>'#ef4444'],
        ];
        $s = $stMap[$projet->statutProjet] ?? $stMap['approuve'];
    @endphp

    <div class="valid-header">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;flex-wrap:wrap;">
                <span style="font-size:.7rem;font-weight:700;color:var(--valid-text-light);
                             text-transform:uppercase;letter-spacing:.05em;
                             background:var(--valid-bg-gray);padding:3px 10px;border-radius:20px;">
                    {{ $projet->codeProjet }}
                </span>
                <span class="valid-badge {{ $s['cls'] }}">
                    <span class="valid-dot" style="background:{{ $s['dot'] }};"></span>
                    {{ $s['lbl'] }}
                </span>
            </div>
            <h1 class="valid-header-title">{{ $projet->titre }}</h1>
            <p class="valid-header-sub" style="display:flex;gap:14px;flex-wrap:wrap;margin-top:4px;">
                <span><i class="fas fa-user" style="margin-right:4px;"></i>{{ optional($projet->porteur)->nomComplet ?? '—' }}</span>
                <span><i class="fas fa-tag" style="margin-right:4px;"></i>{{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
                @if($projet->dateDebut && $projet->dateFin)
                <span>
                    <i class="fas fa-calendar" style="margin-right:4px;"></i>
                    {{ $projet->dateDebut->format('d/m/Y') }} → {{ $projet->dateFin->format('d/m/Y') }}
                </span>
                @endif
            </p>
        </div>
        <a href="{{ route('validateur.projets.index') }}" class="valid-btn-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    {{-- Grille principale --}}
    <div class="valid-show-grid">

        {{-- Colonne principale --}}
        <div class="valid-show-main">

            {{-- Infos générales --}}
            <div class="valid-info-card">
                <div class="valid-info-card-head">
                    <span class="valid-info-card-title">
                        <i class="fas fa-info-circle"></i> Informations générales
                    </span>
                </div>
                <div class="valid-info-grid">
                    <div>
                        <p class="valid-info-lbl">Secteur</p>
                        <p class="valid-info-val">{{ optional($projet->secteur)->nomSecteur ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="valid-info-lbl">Durée</p>
                        <p class="valid-info-val">{{ $projet->duree ? $projet->duree.' mois' : '—' }}</p>
                    </div>
                    <div>
                        <p class="valid-info-lbl">Date début</p>
                        <p class="valid-info-val">{{ optional($projet->dateDebut)->format('d/m/Y') ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="valid-info-lbl">Date fin</p>
                        <p class="valid-info-val">{{ optional($projet->dateFin)->format('d/m/Y') ?? '—' }}</p>
                    </div>
                    @if($projet->objectif)
                    <div class="valid-info-full">
                        <p class="valid-info-lbl">Objectif</p>
                        <p class="valid-info-val">{{ $projet->objectif }}</p>
                    </div>
                    @endif
                    @if($projet->description)
                    <div class="valid-info-full">
                        <p class="valid-info-lbl">Description</p>
                        <p class="valid-info-val" style="white-space:pre-line;">{{ $projet->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Planification — activités en CARDS border-left --}}
            @if($projet->planifications->count())
            <div class="valid-info-card">
                <div class="valid-info-card-head">
                    <span class="valid-info-card-title">
                        <i class="fas fa-tasks"></i> Planification
                        <span class="valid-info-count">{{ $projet->planifications->count() }}</span>
                    </span>
                </div>

                @foreach($projet->planifications as $plan)
                <div class="valid-activite-card">
                    <div class="valid-activite-head">
                        <div class="valid-activite-num">{{ $loop->iteration }}</div>
                        <p class="valid-activite-titre">{{ $plan->activitePlanification }}</p>
                        @if($plan->coutEstimatif)
                        <span class="valid-activite-cout">
                            <i class="fas fa-coins" style="font-size:.6rem;"></i>
                            {{ number_format($plan->coutEstimatif, 0, ',', ' ') }} F CFA
                        </span>
                        @endif
                    </div>

                    <div class="valid-activite-details">
                        @if($plan->indicateur)
                        <div>
                            <span class="valid-activite-detail-lbl">Indicateur : </span>
                            <span class="valid-activite-detail-val">
                                {{ $plan->indicateur }}
                                @if($plan->uniteIndicateur) ({{ $plan->uniteIndicateur }}) @endif
                            </span>
                        </div>
                        @endif
                        @if($plan->periode)
                        <div>
                            <span class="valid-activite-detail-lbl">Période : </span>
                            <span class="valid-activite-detail-val">{{ $plan->periode }}</span>
                        </div>
                        @endif
                        @if($plan->resultatsAttendues)
                        <div class="valid-activite-detail-full">
                            <span class="valid-activite-detail-lbl">Résultats attendus : </span>
                            <span class="valid-activite-detail-val">{{ $plan->resultatsAttendues }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach

                <div class="valid-total-bar">
                    <span class="valid-total-label">Total estimé :</span>
                    <span class="valid-total-val">
                        {{ number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ') }} F CFA
                    </span>
                </div>
            </div>
            @endif

            {{-- Documents --}}
            @if($projet->documents && $projet->documents->count())
            <div class="valid-info-card">
                <div class="valid-info-card-head">
                    <span class="valid-info-card-title">
                        <i class="fas fa-paperclip"></i> Documents joints
                        <span class="valid-info-count">{{ $projet->documents->count() }}</span>
                    </span>
                </div>
                <div class="valid-docs-list">
                    @foreach($projet->documents as $doc)
                    <a href="{{ asset('storage/'.$doc->cheminFichier) }}" target="_blank" class="valid-doc-item">
                        <i class="fas fa-file-alt"></i>
                        <span>{{ $doc->nomFichier ?? basename($doc->cheminFichier) }}</span>
                        <i class="fas fa-external-link-alt" style="font-size:.65rem;color:var(--valid-text-light);"></i>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Commentaires --}}
            @if($projet->commentaires && $projet->commentaires->count())
            <div class="valid-info-card">
                <div class="valid-info-card-head">
                    <span class="valid-info-card-title">
                        <i class="fas fa-comments"></i> Commentaires
                        <span class="valid-info-count">{{ $projet->commentaires->count() }}</span>
                    </span>
                </div>
                <div class="valid-comments-list">
                    @foreach($projet->commentaires->sortByDesc('created_at') as $com)
                    <div class="valid-comment-item">
                        <div class="valid-comment-avatar">
                            {{ strtoupper(substr(optional($com->utilisateur)->nomComplet ?? 'U', 0, 1)) }}
                        </div>
                        <div class="valid-comment-body">
                            <div class="valid-comment-head">
                                <span class="valid-comment-author">{{ optional($com->utilisateur)->nomComplet ?? '—' }}</span>
                                <span class="valid-comment-date">{{ optional($com->created_at)->format('d/m/Y H:i') }}</span>
                            </div>
                            <p class="valid-comment-text">{{ $com->contenu ?? $com->message ?? '' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- Aside --}}
        <div class="valid-show-aside">

            {{-- Budget --}}
            <div class="valid-aside-card">
                <p class="valid-aside-title"><i class="fas fa-wallet"></i> Finances</p>
                <div class="valid-fin-rows">
                    <div class="valid-fin-row">
                        <span>Budget total</span>
                        <strong>{{ number_format($projet->budgetTotal ?? 0, 0, ',', ' ') }} F CFA</strong>
                    </div>
                    <div class="valid-fin-row">
                        <span>Montant demandé</span>
                        <strong>{{ number_format($projet->montantDemande ?? 0, 0, ',', ' ') }} F CFA</strong>
                    </div>
                    <div class="valid-fin-row">
                        <span>Durée</span>
                        <strong>{{ $projet->duree ?? '—' }} mois</strong>
                    </div>
                    @if($projet->planifications->count())
                    <div class="valid-fin-row">
                        <span>Coût planifié</span>
                        <strong style="color:var(--valid-primary);">
                            {{ number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ') }} F CFA
                        </strong>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Zone décision --}}
            @if($projet->statutProjet === 'approuve')
            <div class="valid-decision-zone">
                <p class="valid-decision-zone-title">
                    <i class="fas fa-gavel"></i> Décision de validation
                </p>
                <p class="valid-decision-zone-desc">
                    Ce projet a été approuvé. Vous pouvez le valider définitivement ou le rejeter.
                </p>

                {{-- Valider --}}
                <form method="POST" action="{{ route('validateur.projets.valider', $projet) }}"
                      onsubmit="return confirm('Confirmer la validation définitive ?')">
                    @csrf
                    <div class="valid-form-group">
                        <label class="valid-form-label">Commentaire (optionnel)</label>
                        <textarea name="commentaire" class="valid-form-textarea" rows="3"
                                  placeholder="Remarques sur la validation…"></textarea>
                    </div>
                    <button type="submit" class="valid-btn valid-btn-primary valid-btn-large">
                        <i class="fas fa-medal"></i> Valider le projet
                    </button>
                </form>

                <div class="valid-or-sep"><span>ou</span></div>

                {{-- Rejeter (toggle) --}}
                <div class="valid-reject-zone">
                    <div id="rejectToggle">
                        <button type="button" class="valid-btn-reject-toggle" onclick="toggleReject()">
                            <i class="fas fa-times-circle"></i> Rejeter le projet
                        </button>
                    </div>
                    <div id="rejectForm" style="display:none;margin-top:10px;">
                        <form method="POST" action="{{ route('validateur.projets.rejeter', $projet) }}"
                              onsubmit="return confirm('Confirmer le rejet ?')">
                            @csrf
                            <div class="valid-form-group">
                                <label class="valid-form-label" style="color:var(--valid-red);">
                                    Motif du rejet <span>*</span>
                                </label>
                                <textarea name="motifRejet" class="valid-form-textarea danger" rows="4"
                                          placeholder="Expliquez le motif…" required></textarea>
                                @error('motifRejet')
                                <p class="valid-form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div style="display:flex;gap:8px;">
                                <button type="submit" class="valid-btn valid-btn-red" style="flex:1;justify-content:center;">
                                    <i class="fas fa-times-circle"></i> Confirmer
                                </button>
                                <button type="button" class="valid-btn valid-btn-gray" onclick="toggleReject()">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @else
            {{-- Décision déjà prise --}}
            <div class="valid-aside-card">
                <p class="valid-aside-title"><i class="fas fa-flag-checkered"></i> Décision finale</p>
                <div class="valid-decision-badge {{ $projet->statutProjet === 'valide' ? 'valid-decision-valide' : 'valid-decision-rejete' }}">
                    <i class="fas {{ $projet->statutProjet === 'valide' ? 'fa-medal' : 'fa-times-circle' }}"></i>
                    Projet {{ $projet->statutProjet === 'valide' ? 'validé' : 'rejeté' }}
                </div>
                @if($projet->motifRejet)
                <p class="valid-motif-text">{{ $projet->motifRejet }}</p>
                @endif
                @if($projet->validated_at)
                <p class="valid-decision-date">
                    <i class="fas fa-calendar-check"></i>
                    {{ \Carbon\Carbon::parse($projet->validated_at)->format('d/m/Y à H:i') }}
                </p>
                @endif
            </div>
            @endif

            {{-- Porteur --}}
            <div class="valid-aside-card">
                <p class="valid-aside-title"><i class="fas fa-user"></i> Porteur de projet</p>
                <div class="valid-porteur-block">
                    <div class="valid-porteur-avatar">
                        {{ strtoupper(substr(optional($projet->porteur)->nomComplet ?? 'P', 0, 1)) }}
                    </div>
                    <div>
                        <p class="valid-porteur-name">{{ optional($projet->porteur)->nomComplet ?? '—' }}</p>
                        <p class="valid-porteur-email">{{ optional($projet->porteur)->email ?? '—' }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@push('scripts')
<script>
function toggleReject() {
    const f = document.getElementById('rejectForm');
    const t = document.getElementById('rejectToggle');
    const hidden = f.style.display === 'none' || f.style.display === '';
    f.style.display = hidden ? 'block' : 'none';
    t.style.display = hidden ? 'none' : 'block';
}
</script>
@endpush
@endsection
