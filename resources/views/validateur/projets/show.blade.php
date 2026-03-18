@extends('layouts.app')
@section('title', 'Examen — ' . $projet->titre)
@push('styles')
<link rel="stylesheet" href="{{ asset('css/validDash.css') }}">
@endpush

@section('content')
<div class="vpage">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('validateur.dashboard') }}"><i class="fas fa-home"></i></a>
        <span>/</span>
        <a href="{{ route('validateur.projets.index') }}">Projets</a>
        <span>/</span>
        <span>{{ $projet->codeProjet }}</span>
    </div>

    {{-- Header --}}
    @php
        $map = [
            'approuve' => ['lbl'=>'Approuvé','dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d'],
            'valide'   => ['lbl'=>'Validé',  'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e'],
            'rejete'   => ['lbl'=>'Rejeté',  'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c'],
        ];
        $s = $map[$projet->statutProjet] ?? $map['approuve'];
    @endphp
    <div class="show-header">
        <div>
            <span class="status-badge" style="background:{{ $s['bg'] }};color:{{ $s['color'] }};">
                <span class="dot" style="background:{{ $s['dot'] }};"></span>{{ $s['lbl'] }}
            </span>
            <h1 class="show-title">{{ $projet->titre }}</h1>
            <div class="show-meta">
                <span><i class="fas fa-hashtag"></i> {{ $projet->codeProjet }}</span>
                <span><i class="fas fa-user"></i> {{ optional($projet->porteur)->nomComplet ?? '—' }}</span>
                <span><i class="fas fa-tag"></i> {{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
                <span><i class="fas fa-calendar"></i>
                    {{ optional($projet->dateDebut)->format('d/m/Y') ?? '—' }} →
                    {{ optional($projet->dateFin)->format('d/m/Y') ?? '—' }}
                </span>
            </div>
        </div>
        <a href="{{ route('validateur.projets.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    {{-- Grid 2 colonnes --}}
    <div class="show-grid">

        {{-- Colonne principale --}}
        <div class="show-main">

            {{-- Objectif --}}
            <div class="info-card">
                <h4 class="info-title"><i class="fas fa-bullseye"></i> Objectif</h4>
                <p class="info-text">{{ $projet->objectif ?? 'Non renseigné.' }}</p>
            </div>

            {{-- Description --}}
            @if($projet->description)
            <div class="info-card">
                <h4 class="info-title"><i class="fas fa-align-left"></i> Description</h4>
                <p class="info-text" style="white-space:pre-line;">{{ $projet->description }}</p>
            </div>
            @endif

            {{-- activites --}}
            @if($projet->activites && $projet->activites->count())
            <div class="info-card">
                <h4 class="info-title"><i class="fas fa-tasks"></i> Planification</h4>
                <div class="planif-list">
                    @foreach($projet->activites as $pl)
                    <div class="planif-item">
                        <div class="planif-dot"></div>
                        <div>
                            <p class="planif-name">{{ $pl->activite ?? $pl->titre ?? '—' }}</p>
                            <p class="planif-date">
                                {{ optional($pl->dateDebut)->format('d/m/Y') ?? '—' }} →
                                {{ optional($pl->dateFin)->format('d/m/Y') ?? '—' }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Documents --}}
            @if($projet->documents && $projet->documents->count())
            <div class="info-card">
                <h4 class="info-title"><i class="fas fa-paperclip"></i> Documents joints</h4>
                <div class="docs-list">
                    @foreach($projet->documents as $doc)
                    <a href="{{ asset('storage/' . $doc->cheminFichier) }}" target="_blank" class="doc-item">
                        <i class="fas fa-file-alt"></i>
                        <span>{{ $doc->nomFichier ?? basename($doc->cheminFichier) }}</span>
                        <i class="fas fa-external-link-alt doc-ext"></i>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Commentaires --}}
            @if($projet->commentaires && $projet->commentaires->count())
            <div class="info-card">
                <h4 class="info-title"><i class="fas fa-comments"></i> Commentaires</h4>
                <div class="comments-list">
                    @foreach($projet->commentaires->sortByDesc('created_at') as $com)
                    <div class="comment-item">
                        <div class="comment-avatar">
                            {{ strtoupper(substr(optional($com->utilisateur)->nomComplet ?? 'U', 0, 1)) }}
                        </div>
                        <div class="comment-body">
                            <div class="comment-head">
                                <span class="comment-author">{{ optional($com->utilisateur)->nomComplet ?? '—' }}</span>
                                <span class="comment-date">{{ optional($com->created_at)->format('d/m/Y H:i') }}</span>
                            </div>
                            <p class="comment-text">{{ $com->contenu }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div class="show-aside">

            {{-- Finances --}}
            <div class="aside-card">
                <h4 class="info-title"><i class="fas fa-wallet"></i> Finances</h4>
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
                </div>
            </div>

            {{-- Zone action --}}
            @if($projet->statutProjet === 'approuve')
            <div class="action-zone">
                <h4 class="action-zone-title"><i class="fas fa-gavel"></i> Décision de validation</h4>
                <p class="action-zone-desc">Ce projet a été approuvé. Vous pouvez le valider définitivement ou le rejeter.</p>

                {{-- Valider --}}
                <form method="POST" action="{{ route('validateur.projets.valider', $projet) }}"
                        onsubmit="return confirm('Confirmer la validation ?')">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Commentaire (optionnel)</label>
                        <textarea name="commentaire" class="form-textarea" rows="3"
                                    placeholder="Remarques sur la validation…"></textarea>
                    </div>
                    <button type="submit" class="btn-valider">
                        <i class="fas fa-medal"></i> Valider le projet
                    </button>
                </form>

                <div class="or-sep"><span>ou</span></div>

                {{-- Rejeter (toggle) --}}
                <div id="rejectToggle">
                    <button type="button" class="btn-reject-toggle" onclick="toggleReject()">
                        <i class="fas fa-times-circle"></i> Rejeter le projet
                    </button>
                </div>
                <div id="rejectForm" style="display:none;">
                    <form method="POST" action="{{ route('validateur.projets.rejeter', $projet) }}"
                            onsubmit="return confirm('Confirmer le rejet ?')">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" style="color:#dc2626;">Motif du rejet <span>*</span></label>
                            <textarea name="motifRejet" class="form-textarea form-textarea-danger"
                                        rows="4" placeholder="Expliquez le motif…" required></textarea>
                            @error('motifRejet')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="btn-rejeter">
                            <i class="fas fa-times-circle"></i> Confirmer le rejet
                        </button>
                        <button type="button" class="btn-cancel" onclick="toggleReject()">Annuler</button>
                    </form>
                </div>
            </div>

            @else
            {{-- Déjà traité --}}
            <div class="aside-card">
                <h4 class="info-title"><i class="fas fa-info-circle"></i> Décision prise</h4>
                <div class="decision-badge {{ $projet->statutProjet === 'valide' ? 'decision-valide' : 'decision-rejete' }}">
                    <i class="fas {{ $projet->statutProjet === 'valide' ? 'fa-medal' : 'fa-times-circle' }}"></i>
                    Projet {{ $projet->statutProjet === 'valide' ? 'validé' : 'rejeté' }}
                </div>
                @if($projet->motifRejet)
                <p class="motif-text">{{ $projet->motifRejet }}</p>
                @endif
                @if($projet->validated_at)
                <p class="decision-date">
                    <i class="fas fa-calendar-check"></i>
                    {{ \Carbon\Carbon::parse($projet->validated_at)->format('d/m/Y à H:i') }}
                </p>
                @endif
            </div>
            @endif

            {{-- Porteur --}}
            <div class="aside-card">
                <h4 class="info-title"><i class="fas fa-user"></i> Porteur de projet</h4>
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

        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleReject() {
    const f = document.getElementById('rejectForm');
    const t = document.getElementById('rejectToggle');
    const v = f.style.display !== 'none';
    f.style.display = v ? 'none' : 'block';
    t.style.display = v ? 'block' : 'none';
}
</script>
@endpush
@endsection
