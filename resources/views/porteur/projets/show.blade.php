@extends('layouts.app')

@section('title', $projet->titre)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="projets-page">

    {{-- Header --}}
    <div class="page-header">
        <a href="{{ route('porteur.projets.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-header-info">
            <div>
                <h1 class="projets-title">{{ $projet->titre }}</h1>
                <p class="projets-subtitle">{{ $projet->codeProjet }}</p>
            </div>
            @php
                $statusClass = [
                    'brouillon' => 'status-gray',
                    'soumis'    => 'status-blue',
                    'en_examen' => 'status-yellow',
                    'approuve'  => 'status-green',
                    'valide'    => 'status-teal',
                    'rejete'    => 'status-red',
                ][$projet->statutProjet] ?? 'status-gray';
                $statusLabel = [
                    'brouillon' => 'Brouillon',
                    'soumis'    => 'Soumis',
                    'en_examen' => 'En examen',
                    'approuve'  => 'Approuvé',
                    'valide'    => 'Validé',
                    'rejete'    => 'Rejeté',
                ][$projet->statutProjet] ?? $projet->statutProjet;
            @endphp
            <span class="status-badge {{ $statusClass }} status-lg">{{ $statusLabel }}</span>
        </div>
        <div class="page-header-actions">
            @if($projet->isEditable())
            <a href="{{ route('porteur.projets.edit', $projet) }}" class="btn-edit-main">
                <i class="fas fa-pencil-alt"></i> Modifier
            </a>
            @endif
            @if($projet->isDeletable())
            <form method="POST" action="{{ route('porteur.projets.destroy', $projet) }}"
                    onsubmit="return confirm('Supprimer définitivement ce projet ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-delete-main" title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
            @endif
        </div>
    </div>

    {{-- BANNIÈRE REJET --}}
    @php
        $dernierRejet  = $projet->commentaires->where('typeCommentaire', 'rejet')->sortByDesc('dateEnvoi')->first();
        $derniereModif = $projet->commentaires->where('typeCommentaire', 'demande')->sortByDesc('dateEnvoi')->first();
    @endphp

    @if($projet->statutProjet === 'brouillon' && $dernierRejet)
    <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:16px;">
        <div style="display:flex;align-items:flex-start;gap:12px;padding:12px 16px;
                    background:#fef2f2;border:1px solid #fecaca;border-radius:10px;">
            <i class="fas fa-times-circle" style="color:#dc2626;font-size:1rem;margin-top:2px;flex-shrink:0;"></i>
            <div>
                <p style="font-size:.73rem;font-weight:800;text-transform:uppercase;letter-spacing:.04em;color:#b91c1c;margin:0 0 4px;">
                    Projet rejeté — Motif
                </p>
                <p  style="font-size:.82rem;
                    color:#374151;
                    margin:0 0 3px;
                    line-height:1.5;">
                    {{ $dernierRejet->message }}
                </p>
                <p style="font-size:.7rem;color:#9ca3af;margin:0;">
                    Par {{ optional($dernierRejet->utilisateur)->nomComplet ?? 'Approbateur' }}
                    le {{ optional($dernierRejet->dateEnvoi)->format('d/m/Y à H:i') }}
                </p>
            </div>
        </div>

        @if($derniereModif)
        <div style="display:flex;align-items:flex-start;gap:12px;padding:12px 16px;
                    background:#fff7ed;border:1px solid #fed7aa;border-radius:10px;">
            <i class="fas fa-exclamation-triangle" style="color:#ea580c;font-size:1rem;margin-top:2px;flex-shrink:0;"></i>
            <div>
                <p style="font-size:.73rem;font-weight:800;text-transform:uppercase;letter-spacing:.04em;color:#c2410c;margin:0 0 4px;">
                    Modifications demandées
                </p>
                <p style="font-size:.82rem;color:#374151;margin:0;line-height:1.5;">{{ $derniereModif->message }}</p>
            </div>
        </div>
        @endif

        <div style="display:flex;align-items:flex-start;gap:12px;padding:12px 16px;
                    background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;">
            <i class="fas fa-info-circle" style="color:#2563eb;font-size:1rem;margin-top:2px;flex-shrink:0;"></i>
            <div style="flex:1;">
                <p style="font-size:.73rem;font-weight:800;text-transform:uppercase;letter-spacing:.04em;color:#1d4ed8;margin:0 0 4px;">
                    Comment procéder ?
                </p>
                <p style="font-size:.82rem;color:#374151;margin:0 0 10px;line-height:1.5;">
                    Corrigez votre projet puis resoumettez-le pour une nouvelle approbation.
                </p>
                <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                    <a href="{{ route('porteur.projets.edit', $projet) }}"
                        style="display:inline-flex;align-items:center;gap:6px;background:#fff;
                                border:1.5px solid #1d4ed8;color:#1d4ed8;border-radius:8px;
                                padding:7px 14px;font-size:.78rem;font-weight:700;text-decoration:none;">
                        <i class="fas fa-pencil-alt"></i> Corriger le projet
                    </a>
                    <form method="POST" action="{{ route('porteur.projets.soumettre', $projet) }}"
                            onsubmit="return confirm('Resoumettre pour une nouvelle approbation ?')">
                        @csrf
                        <button type="submit"
                                style="display:inline-flex;align-items:center;gap:6px;background:#1d4ed8;
                                        color:#fff;border:none;border-radius:8px;padding:7px 14px;
                                        font-size:.78rem;font-weight:700;cursor:pointer;">
                            <i class="fas fa-paper-plane"></i> Resoumettre le projet
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- BARRE D'ACTIONS --}}
    <div class="projet-actions-bar">
        {{-- Soumettre (seulement si brouillon sans rejet en attente) --}}
        @if($projet->isSubmittable())

            {{-- Message d'information pour les projets rejetés --}}
            @if($projet->statutProjet === 'rejete')
                <div class="alert alert-warning mb-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Projet rejeté</strong><br>
                    Ce projet a été rejeté. Après avoir effectué les modifications nécessaires,
                    vous pouvez le soumettre à nouveau pour évaluation.
                </div>
            @endif

            <form method="POST" action="{{ route('porteur.projets.soumettre', $projet) }}">
                @csrf
                <button type="submit" class="action-btn action-btn-indigo"
                        onclick="return confirm('{{ $projet->statutProjet === 'rejete' ? 'Soumettre à nouveau ce projet pour évaluation ?' : 'Soumettre ce projet pour approbation ?' }}')">
                    <i class="fas {{ $projet->statutProjet === 'rejete' ? 'fa-redo-alt' : 'fa-paper-plane' }}"></i>
                    {{ $projet->statutProjet === 'rejete' ? 'Soumettre à nouveau' : 'Soumettre le projet' }}
                </button>
            </form>
        @else
            {{-- Messages d'information selon le statut --}}
            @if($projet->statutProjet === 'soumis')
                <div class="alert alert-info">
                    <i class="fas fa-clock"></i>
                    Ce projet est déjà en attente d'approbation.
                </div>
            @elseif(in_array($projet->statutProjet, ['approuve', 'valide', 'finance']))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Ce projet a déjà été approuvé et ne peut plus être modifié.
                </div>
            @endif
        @endif
        @if (!$projet->isApprouveAndValide() && !$projet->planification_demandee)
            <form action="{{ route('porteur.demande.planification', $projet->id) }}" method="POST">
            @csrf
            <button class="btn btn-primary">
                <i class="fas fa-calendar"></i>
                Demander une planification
            </button>
        </form>
        @endif
    </div>

    {{-- CONTENU PRINCIPAL --}}
    <div class="show-grid">

        {{-- Colonne gauche --}}
        <div class="show-col-main">

            {{-- Infos générales --}}
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-info-circle"></i>
                    <span>Informations générales</span>
                </div>
                <div class="form-card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Secteur</span>
                            <span class="info-value">
                                {{ optional($projet->secteur)->nomSecteur ?? '—' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Durée</span>
                            <span class="info-value">
                                {{ $projet->duree ? $projet->duree . ' mois' : '—' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de création</span>
                            <span class="info-value">
                                {{ optional($projet->dateCreation)->format('d/m/Y') ?? '—' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de soumission</span>
                            <span class="info-value">
                                {{ optional($projet->dateSoumission)->format('d/m/Y') ?? '—' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de début probable</span>
                            <span class="info-value">
                                {{ optional($projet->dateDebut)->format('d/m/Y') ?? '—' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de fin probable</span>
                            <span class="info-value">
                                {{ optional($projet->dateFin)->format('d/m/Y') ?? '—' }}
                            </span>
                        </div>
                        @if($projet->dateApprobation)
                        <div class="info-item">
                            <span class="info-label">Date d'approbation</span>
                            <span class="info-value">
                                {{ optional($projet->dateApprobation)->format('d/m/Y') }}
                            </span>
                        </div>
                        @endif
                    </div>
                    @if($projet->description)
                    <div class="info-block">
                        <span class="info-label">Description</span>
                        <p class="info-text">{{ $projet->description }}</p>
                    </div>
                    @endif
                    @if($projet->objectif)
                    <div class="info-block">
                        <span class="info-label">Objectif</span>
                        <p class="info-text">{{ $projet->objectif }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Planifications (lecture seule pour le porteur) --}}
            @if($projet->planifications->count())
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-calendar-check"></i>
                    <span>
                        Planification du projet ({{ $projet->planifications->count() }} activité(s))
                    </span>
                </div>
                <div class="form-card-body">

                    <div class="plan-cards-grid">

                        @foreach($projet->planifications as $plan)
                        <div class="plan-act-card">
                            <div class="plan-act-top">
                                <div class="plan-act-num">{{ $loop->iteration }}</div>
                            </div>
                            <h4 class="plan-act-titre">
                                {{ $plan->activitePlanification }}
                            </h4>
                            <div class="plan-act-footer">
                                @if($plan->periode)
                                <span class="plan-act-info">
                                    <i class="fas fa-clock"></i> {{ $plan->periode }}
                                </span>
                                @endif
                                @if($plan->coutEstimatif)
                                <span class="plan-act-budget">
                                    <i class="fas fa-coins"></i>
                                    {{ number_format($plan->coutEstimatif, 0, ',', ' ') }} F CFA
                                </span>
                                @endif
                            </div>
                            @if($plan->indicateur)
                            <p class="plan-act-desc">
                                Indicateur : {{ $plan->indicateur }}
                                @if($plan->uniteIndicateur) ({{ $plan->uniteIndicateur }}) @endif
                            </p>
                            @endif
                            @if($plan->resultatsAttendues)
                            <p class="plan-act-desc">Résultats : {{ $plan->resultatsAttendues }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </div>

        {{-- Colonne droite --}}
        <div class="show-col-side">

            {{-- Budget --}}
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-coins"></i>
                    <span>Budget</span>
                </div>
                <div class="form-card-body">
                    <div class="budget-display">
                        <span class="budget-label-sm">Budget total</span>
                        <span class="budget-value">
                            {{ $projet->budgetTotal ? number_format($projet->budgetTotal, 0, ',', ' ') . ' F CFA' : '—' }}
                        </span>
                    </div>
                    @if($projet->montantDemande)
                    <div class="budget-display">
                        <span class="budget-label-sm">Montant demandé</span>
                        <span class="budget-value-sm">{{ number_format($projet->montantDemande, 0, ',', ' ') }} F CFA</span>
                    </div>
                    @endif
                    @if($projet->planifications->count())
                    <div class="budget-display">
                        <span class="budget-label-sm">Coût planifié total</span>
                        <span class="budget-value-sm">
                            {{ number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ') }} F CFA
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Documents --}}
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-paperclip"></i>
                    <span>Documents ({{ $projet->documents->count() }})</span>
                </div>
                <div class="form-card-body">
                    @forelse($projet->documents as $doc)
                    <div class="doc-existing-item">
                        @php
                            $ext  = pathinfo($doc->nomFichier, PATHINFO_EXTENSION);
                            $icon = in_array($ext, ['pdf']) ? 'fa-file-pdf'
                                    : (in_array($ext, ['doc','docx']) ? 'fa-file-word'
                                    : (in_array($ext, ['xls','xlsx']) ? 'fa-file-excel'
                                    : (in_array($ext, ['jpg','jpeg','png']) ? 'fa-file-image'
                                    : 'fa-file-alt')));
                        @endphp
                        <i class="fas {{ $icon }}"></i>
                        <span class="doc-file-name">{{ $doc->nomFichier }}</span>
                        <span class="doc-badge">{{ $doc->typeDocument }}</span>
                        <a href="{{ route('porteur.projets.documents.download', [$projet, $doc]) }}"
                            class="doc-action-link" title="Télécharger">
                            <i class="fas fa-download"></i>
                        </a>
                        <form method="POST"
                                action="{{ route('porteur.projets.documents.destroy', [$projet, $doc]) }}"
                                onsubmit="return confirm('Supprimer ce document ?')"
                                style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="doc-action-del" title="Supprimer">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                    @empty
                    <p class="info-empty">Aucun document joint.</p>
                    @endforelse

                    <form method="POST"
                            action="{{ route('porteur.projets.documents.store', $projet) }}"
                            enctype="multipart/form-data" class="mt-3" id="formAddDoc">
                        @csrf
                        <input type="file" id="newDocuments" name="documents[]" multiple
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" style="display:none">
                        <div class="doc-toolbar">
                            <button type="button" class="btn-attach"
                                    onclick="document.getElementById('newDocuments').click()">
                                <i class="fas fa-plus"></i> Ajouter des fichiers
                            </button>
                        </div>
                        <p class="doc-hint">PDF, Word, Excel, images — Max 10 Mo par fichier</p>
                        <div id="newFileList" class="doc-file-list" style="display:none"></div>
                        <div id="submitDocBtn" style="display:none; margin-top:10px;">
                            <button type="submit" class="btn-save btn-sm">
                                <i class="fas fa-upload"></i> Enregistrer
                            </button>
                            <button type="button" class="btn-cancel btn-sm ms-2"
                                    onclick="resetDocForm()">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- Timeline commentaires --}}
    @if($projet->commentaires->count() > 0)
    <div class="form-card" style="margin-top:16px;">
        <div class="form-card-header">
            <i class="fas fa-comments"></i>
            <span>Historique des commentaires du projet ({{ $projet->commentaires->count() }})</span>
        </div>
        <div class="form-card-body">
            <div class="timeline">
                @foreach($projet->commentaires->sortByDesc('dateEnvoi') as $commentaire)
                @php
                    $icons  = ['approbation'=>'fa-check-circle','rejet'=>'fa-times-circle','demande'=>'fa-exclamation-circle','info'=>'fa-info-circle'];
                    $colors = ['approbation'=>'#16a34a','rejet'=>'#dc2626','demande'=>'#d97706','info'=>'#2563eb'];
                    $icon   = $icons[$commentaire->typeCommentaire]  ?? 'fa-comment';
                    $color  = $colors[$commentaire->typeCommentaire] ?? '#6b7280';
                @endphp
                <div class="timeline-item">
                    <div class="timeline-icon" style="background:{{ $color }}15;color:{{ $color }};">
                        <i class="fas {{ $icon }}"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <span class="timeline-author">{{ optional($commentaire->utilisateur)->role ?? '—' }}</span>
                            <span class="timeline-date">{{ optional($commentaire->dateEnvoi)->format('d/m/Y à H:i') }}</span>
                        </div>
                        <p class="timeline-message">{{ $commentaire->message }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

</div>

@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('active'); document.body.style.overflow='hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('active'); document.body.style.overflow=''; }
const newDocInput  = document.getElementById('newDocuments');
const newFileList  = document.getElementById('newFileList');
const submitDocBtn = document.getElementById('submitDocBtn');
if (newDocInput) {
    newDocInput.addEventListener('change', function() {
        const files = Array.from(this.files);
        if (!files.length) return;
        newFileList.style.display = 'block';
        submitDocBtn.style.display = 'block';
        newFileList.innerHTML = files.map(f => `
            <div class="doc-file-item">
                <i class="${getDocIcon(f.name)} doc-file-icon"></i>
                <div class="doc-file-info">
                    <span class="doc-file-name">${f.name}</span>
                    <span class="doc-file-size">${formatDocSize(f.size)}</span>
                </div>
                <span class="doc-file-ok"><i class="fas fa-check-circle"></i> Accepté</span>
            </div>`).join('');
    });
}
function resetDocForm() {
    if (newDocInput) newDocInput.value = '';
    if (newFileList) { newFileList.innerHTML=''; newFileList.style.display='none'; }
    if (submitDocBtn) submitDocBtn.style.display='none';
}
function getDocIcon(name) {
    const ext = name.split('.').pop().toLowerCase();
    if (['pdf'].includes(ext)) return 'fas fa-file-pdf';
    if (['doc','docx'].includes(ext)) return 'fas fa-file-word';
    if (['xls','xlsx'].includes(ext)) return 'fas fa-file-excel';
    if (['jpg','jpeg','png'].includes(ext)) return 'fas fa-file-image';
    return 'fas fa-file-alt';
}
function formatDocSize(b) {
    if (b < 1024) return b+' o';
    if (b < 1048576) return (b/1024).toFixed(1)+' Ko';
    return (b/1048576).toFixed(1)+' Mo';
}
</script>
@endpush
@endsection
