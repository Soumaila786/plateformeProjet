@extends('layouts.app')
@section('title', $projet->titre)
@push('styles')
<link rel="stylesheet" href="{{ asset('css/porteur.css') }}">
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

    {{-- Flash --}}
    @if(session('success'))
    <div class="port-alert port-alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="port-alert port-alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    {{-- BANNIÈRE REJET --}}
    @php
        $dernierRejet  = $projet->commentaires->where('typeCommentaire', 'rejet')->sortByDesc('dateEnvoi')->first();
        $derniereModif = $projet->commentaires->where('typeCommentaire', 'demande')->sortByDesc('dateEnvoi')->first();
    @endphp

    @if($projet->statutProjet === 'brouillon' && $dernierRejet)
    <div class="rejet-container">
        <div class="alert-rejet">
            <i class="fas fa-times-circle"></i>
            <div>
                <p class="alert-rejet-title">Projet rejeté — Motif</p>
                <p class="alert-rejet-message">{{ $dernierRejet->message }}</p>
                <p class="alert-rejet-meta">
                    Par {{ optional($dernierRejet->utilisateur)->nomComplet ?? 'Approbateur' }}
                    le {{ optional($dernierRejet->dateEnvoi)->format('d/m/Y à H:i') }}
                </p>
            </div>
        </div>
        @if($derniereModif)
        <div class="alert-modification">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <p class="alert-modification-title">Modifications demandées</p>
                <p class="alert-modification-message">{{ $derniereModif->message }}</p>
            </div>
        </div>
        @endif
        <div class="alert-procedure">
            <i class="fas fa-info-circle"></i>
            <div>
                <p class="alert-procedure-title">Comment procéder ?</p>
                <p class="alert-procedure-message">
                    Corrigez votre projet puis resoumettez-le pour une nouvelle approbation.
                </p>
                <div class="alert-procedure-actions">
                    <a href="{{ route('porteur.projets.edit', $projet) }}" class="btn-corriger">
                        <i class="fas fa-pencil-alt"></i> Corriger le projet
                    </a>
                    <form method="POST" action="{{ route('porteur.projets.soumettre', $projet) }}"
                          onsubmit="return confirm('Resoumettre pour une nouvelle approbation ?')">
                        @csrf
                        <button type="submit" class="btn-resoumettre">
                            <i class="fas fa-paper-plane"></i> Resoumettre
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- BARRE D'ACTIONS --}}
    <div class="projet-actions-bar">

        {{-- Soumettre --}}
        @if($projet->isSubmittable())
        <form method="POST" action="{{ route('porteur.projets.soumettre', $projet) }}">
            @csrf
            <button type="submit" class="action-btn action-btn-indigo"
                    onclick="return confirm('{{ $projet->statutProjet === 'rejete' ? 'Soumettre à nouveau ?' : 'Soumettre pour approbation ?' }}')">
                <i class="fas {{ $projet->statutProjet === 'rejete' ? 'fa-redo-alt' : 'fa-paper-plane' }}"></i>
                {{ $projet->statutProjet === 'rejete' ? 'Soumettre à nouveau' : 'Soumettre le projet' }}
            </button>
        </form>
        @else
            @if($projet->statutProjet === 'soumis')
            <div class="port-alert port-alert-info" style="margin:0;">
                <i class="fas fa-clock"></i> Ce projet est en attente d'approbation.
            </div>
            @elseif(in_array($projet->statutProjet, ['approuve', 'valide']))
            <div class="port-alert port-alert-success" style="margin:0;">
                <i class="fas fa-check-circle"></i> Ce projet a été approuvé.
            </div>
            @endif
        @endif

        {{-- Options planification (seulement si projet pas encore soumis/approuvé/validé) --}}
        @if(!in_array($projet->statutProjet, ['approuve', 'valide', 'soumis', 'en_examen']))

            @if($projet->planifications->count() === 0 && !$projet->planification_demandee)
            {{-- Aucune planification encore : proposer les deux options --}}
            <a href="{{ route('porteur.planifications.create', $projet) }}"
                class="action-btn action-btn-green">
                <i class="fas fa-calendar-plus"></i> Planifier moi-même
            </a>
            <form action="{{ route('porteur.demande.planification', $projet->id) }}" method="POST">
                @csrf
                <button type="submit" class="action-btn"
                        style="background:#f5f3ff;color:#6d28d9;border:1px solid #ddd6fe;">
                    <i class="fas fa-paper-plane"></i> Demander une planification
                </button>
            </form>

            @elseif($projet->planifications->count() > 0 && !$projet->planification_demandee)
            {{-- Le porteur a déjà planifié lui-même --}}
            <a href="{{ route('porteur.planifications.create', $projet) }}"
                class="action-btn action-btn-green">
                <i class="fas fa-plus"></i> Ajouter une activité
            </a>

            @elseif($projet->planification_demandee)
            {{-- Demande envoyée au planificateur --}}
            <span class="port-alert port-alert-warning" style="margin:0;padding:8px 14px;font-size:.78rem;">
                <i class="fas fa-hourglass-half"></i> Planification demandée — en attente d'un planificateur
            </span>
            @endif

        @endif

    </div>

    {{-- CONTENU PRINCIPAL --}}
    <div class="show-grid">

        {{-- Colonne principale --}}
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
                            <span class="info-value">{{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Durée</span>
                            <span class="info-value">{{ $projet->duree ? $projet->duree . ' mois' : '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de création</span>
                            <span class="info-value">{{ optional($projet->dateCreation)->format('d/m/Y') ?? '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de soumission</span>
                            <span class="info-value">{{ optional($projet->dateSoumission)->format('d/m/Y') ?? '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de début probable</span>
                            <span class="info-value">{{ optional($projet->dateDebut)->format('d/m/Y') ?? '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de fin probable</span>
                            <span class="info-value">{{ optional($projet->dateFin)->format('d/m/Y') ?? '—' }}</span>
                        </div>
                        @if($projet->dateApprobation)
                        <div class="info-item">
                            <span class="info-label">Date d'approbation</span>
                            <span class="info-value">{{ optional($projet->dateApprobation)->format('d/m/Y') }}</span>
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

            {{-- Planification --}}
            <div class="form-card">

                <div class="form-card-header">
                    <i class="fas fa-calendar-check"></i>
                    <span>Planification ({{ $projet->planifications->count() }} activité(s))</span>

                    @if(!in_array($projet->statutProjet, ['approuve', 'valide', 'soumis', 'en_examen']))
                    <a href="{{ route('porteur.planifications.create', $projet) }}" class="btn-add-planification">
                        <i class="fas fa-plus"></i> Ajouter
                    </a>
                    @endif
                    
                </div>

                <div class="form-card-body">

                    @forelse($projet->planifications as $plan)
                    <div class="plan-act-card">
                        <div class="plan-act-header">
                            <div>
                                <div class="plan-act-num">{{ $loop->iteration }}</div>
                                <h4 class="plan-act-title">{{ $plan->activitePlanification }}</h4>
                            </div>
                            @if(!in_array($projet->statutProjet, ['approuve', 'valide', 'soumis', 'en_examen']))
                            <div class="plan-act-actions">
                                <a href="{{ route('porteur.planifications.edit', [$projet, $plan]) }}"
                                    class="plan-act-edit" title="Modifier">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form method="POST"
                                        action="{{ route('porteur.planifications.destroy', [$projet, $plan]) }}"
                                        onsubmit="return confirm('Supprimer cette activité ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="plan-act-delete" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>

                        <div class="plan-act-details">
                            @if($plan->indicateur)
                            <div>
                                <span class="plan-act-label">Indicateur : </span>
                                {{ $plan->indicateur }}
                                @if($plan->uniteIndicateur) ({{ $plan->uniteIndicateur }}) @endif
                            </div>
                            @endif
                            @if($plan->periode)
                            <div><span class="plan-act-label">Période : </span>{{ $plan->periode }}</div>
                            @endif
                            @if($plan->coutEstimatif)
                            <div>
                                <span class="plan-act-label">Coût : </span>
                                <span class="plan-act-cout">{{ number_format($plan->coutEstimatif, 0, ',', ' ') }} F CFA</span>
                            </div>
                            @endif
                            @if($plan->resultatsAttendues)
                            <div class="plan-act-full">
                                <span class="plan-act-label">Résultats attendus : </span>
                                {{ $plan->resultatsAttendues }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="plan-empty">
                        <i class="fas fa-calendar-plus"></i>
                        <p>Aucune activité planifiée.</p>
                        @if(!in_array($projet->statutProjet, ['approuve', 'valide', 'soumis', 'en_examen']))
                        <a href="{{ route('porteur.planifications.create', $projet) }}" class="btn-add-activity">
                            <i class="fas fa-plus"></i> Ajouter une activité
                        </a>
                        @endif
                    </div>
                    @endforelse

                    @if($projet->planifications->count() > 0)
                    <div class="plan-total">
                        <span>Total estimé :</span>
                        <span>{{ number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ') }} F CFA</span>
                    </div>
                    @endif
                </div>
            </div>

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
                        <span class="budget-value-sm" style="color:var(--port-primary);font-weight:800;">
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
                        <span class="doc-file-name" style="flex:1;">{{ $doc->nomFichier }}</span>
                        <span class="doc-badge">{{ $doc->typeDocument }}</span>
                        <a href="{{ route('porteur.projets.documents.download', [$projet, $doc]) }}"
                            class="doc-action-link" title="Télécharger">
                            <i class="fas fa-download"></i>
                        </a>
                        <form method="POST"
                                action="{{ route('porteur.projets.documents.destroy', [$projet, $doc]) }}"
                                onsubmit="return confirm('Supprimer ce document ?')" style="display:inline;">
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
                        <p class="doc-hint">PDF, Word, Excel, images — Max 10 Mo</p>
                        <div id="newFileList" class="doc-file-list" style="display:none"></div>
                        <div id="submitDocBtn" style="display:none;margin-top:10px;display:flex;gap:8px;">
                            <button type="submit" class="btn-save" style="font-size:.78rem;padding:7px 14px;">
                                <i class="fas fa-upload"></i> Enregistrer
                            </button>
                            <button type="button" class="btn-cancel" style="font-size:.78rem;padding:7px 14px;"
                                    onclick="resetDocForm()">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- Timeline commentaires --}}
    @if($projet->commentaires->count() > 0)
    <div class="form-card comment-timeline">
        <div class="form-card-header">
            <i class="fas fa-comments"></i>
            <span>Historique des commentaires ({{ $projet->commentaires->count() }})</span>
        </div>
        <div class="form-card-body">
            <div class="timeline">
                @foreach($projet->commentaires->sortByDesc('dateEnvoi') as $commentaire)
                @php
                    $icons  = ['approbation'=>'fa-check-circle','rejet'=>'fa-times-circle','demande'=>'fa-exclamation-circle','info'=>'fa-info-circle'];
                    $colors = ['approbation'=>'#16a34a','rejet'=>'#dc2626','demande'=>'#d97706','info'=>'#2563eb'];
                    $icon   = $icons[$commentaire->typeCommentaire] ?? 'fa-comment';
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
const newDocInput  = document.getElementById('newDocuments');
const newFileList  = document.getElementById('newFileList');
const submitDocBtn = document.getElementById('submitDocBtn');
if (newDocInput) {
    newDocInput.addEventListener('change', function() {
        const files = Array.from(this.files);
        if (!files.length) return;
        newFileList.style.display = 'flex';
        submitDocBtn.style.display = 'flex';
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
