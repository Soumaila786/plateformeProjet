@extends('layouts.app')

@section('title', $projet->titre)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

<div class="projets-page">

    {{-- ── Header ── --}}
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

    {{-- ── Alerte motif rejet + modification ── --}}
    @if($projet->motifRejet)
    <div class="rejet-banner">
        <div class="rejet-banner-block rejet-block-rouge">
            <i class="fas fa-times-circle"></i>
            <div>
                <p class="rejet-banner-label">Motif du rejet</p>
                <p class="rejet-banner-text">{{ $projet->motifRejet }}</p>
            </div>
        </div>
        @if($projet->messageModification)
        <div class="rejet-banner-block rejet-block-jaune">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <p class="rejet-banner-label">Modifications demandées par l'approbateur</p>
                <p class="rejet-banner-text">{{ $projet->messageModification }}</p>
            </div>
        </div>
        @endif
    </div>
    @endif

    {{-- ══ BARRE D'ACTIONS ══ --}}
    <div class="projet-actions-bar">

        {{-- Planifier --}}
        <button type="button" class="action-btn action-btn-blue"
                onclick="openModal('modalPlanifier')">
            <i class="fas fa-calendar-plus"></i>
            Planifier le projet
        </button>

        {{-- Brouillon → Soumettre --}}
        @if($projet->isSubmittable())
        <form method="POST" action="{{ route('porteur.projets.soumettre', $projet) }}">
            @csrf
            <button type="submit" class="action-btn action-btn-indigo"
                    onclick="return confirm('Soumettre ce projet pour approbation ? Vous ne pourrez plus le modifier.')">
                <i class="fas fa-paper-plane"></i>
                Soumettre le projet
            </button>
        </form>
        @endif

    </div>

    {{-- ══ CONTENU PRINCIPAL ══ --}}
    <div class="show-grid">

        {{-- ── Colonne gauche ── --}}
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
                            <span class="info-value">{{ $projet->dateApprobation->format('d/m/Y') }}</span>
                        </div>
                        @endif
                        @if($projet->dateValidation)
                        <div class="info-item">
                            <span class="info-label">Date de validation</span>
                            <span class="info-value">{{ $projet->dateValidation->format('d/m/Y') }}</span>
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

            {{-- Planifications --}}
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-tasks"></i>
                    <span>Planification ({{ $projet->planifications->count() }})</span>
                    <button type="button" class="card-header-btn"
                            onclick="openModal('modalPlanifier')">
                        <i class="fas fa-plus"></i> Ajouter
                    </button>
                </div>
                @if($projet->planifications->count())
                <div class="form-card-body">
                    <div class="plan-cards-grid">
                        @foreach($projet->planifications as $plan)
                        @php
                            $planStatutClass = ['en_attente'=>'status-gray',
                                                'financee'=>'status-green',
                                                'en_cours'=>'status-blue',
                                                'termine'=>'status-teal',
                                                'annule'=>'status-red'][$plan->statutActivite] ?? 'status-gray';
                            $planStatutLabel = ['en_attente'=>'En attente',
                                                'financee'=>'Financée',
                                                'en_cours'=>'En cours',
                                                'termine'=>'Terminée',
                                                'annule'=>'Annulée'][$plan->statutActivite] ?? $plan->statutActivite;
                            $planIcons = ['en_attente'=>'fa-clock',
                                        'financee'=>'fa-coins',
                                        'en_cours'=>'fa-spinner',
                                        'termine'=>'fa-check-circle',
                                        'annule'=>'fa-times-circle'];
                            $planIcon  = $planIcons[$plan->statutActivite] ?? 'fa-circle';
                        @endphp
                        <div class="plan-act-card">
                            <div class="plan-act-top">
                                <div class="plan-act-num">{{ $loop->iteration }}</div>
                                <span class="status-badge {{ $planStatutClass }}">
                                    <i class="fas {{ $planIcon }}"></i>
                                    {{ $planStatutLabel }}
                                </span>
                                @if($projet->isEditable())
                                <form method="POST"
                                        action="{{ route('porteur.projets.planifications.destroy', [$projet, $plan]) }}"
                                        onsubmit="return confirm('Supprimer cette activité ?')"
                                        style="margin-left:auto;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon btn-icon-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>

                            <h4 class="plan-act-titre">{{ $plan->activite }}</h4>

                            @if($plan->descriptionActivite)
                            <p class="plan-act-desc">{{ $plan->descriptionActivite }}</p>
                            @endif

                            <div class="plan-act-footer">
                                <span class="plan-act-info">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ optional($plan->dateDebut)->format('d/m/Y') ?? '—' }}
                                    →
                                    {{ optional($plan->dateFin)->format('d/m/Y') ?? '—' }}
                                </span>
                                @if($plan->montantDemande)
                                <span class="plan-act-budget">
                                    <i class="fas fa-coins"></i>
                                    {{ number_format($plan->montantDemande, 0, ',', ' ') }} F CFA
                                </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="form-card-body">
                    <div class="doc-empty-state">
                        <i class="fas fa-calendar"></i>
                        <span>Aucune activité planifiée.</span>
                    </div>
                </div>
                @endif
            </div>

        </div>

        {{-- ── Colonne droite ── --}}
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
                        <span class="budget-label-sm">Total planifié</span>
                        <span class="budget-value-sm">
                            {{ number_format($projet->planifications->sum('montantDemande'), 0, ',', ' ') }} F CFA
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

                    {{-- Documents existants --}}
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

                    {{-- Formulaire ajout document --}}
                    <form method="POST"
                            action="{{ route('porteur.projets.documents.store', $projet) }}"
                            enctype="multipart/form-data"
                            class="mt-3"
                            id="formAddDoc">
                        @csrf

                        <input type="file"
                                id="newDocuments"
                                name="documents[]"
                                multiple
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                                style="display:none">

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
                                <i class="fas fa-upload"></i> Enregistrer les fichiers
                            </button>
                            <button type="button" class="btn-cancel btn-sm ms-2"
                                    onclick="resetDocForm()">Annuler</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- ══ MODAL PLANIFICATION ══ --}}
<div id="modalPlanifier" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h2 class="modal-title">
                <i class="fas fa-calendar-plus"></i>
                Ajouter une activité
            </h2>
            <button type="button" class="modal-close" onclick="closeModal('modalPlanifier')">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('porteur.projets.planifications.store', $projet) }}">
            @csrf

            <div class="modal-body">

                <div class="form-col form-col-full">
                    <label class="field-label">Activité <span class="required">*</span></label>
                    <input type="text" name="activite"
                            value="{{ old('activite') }}"
                            class="field-input @error('activite') is-invalid @enderror"
                            placeholder="Ex : Analyse des besoins" required>
                    @error('activite')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col form-col-full">
                    <label class="field-label">Description</label>
                    <textarea name="descriptionActivite" rows="2"
                                class="field-input field-textarea"
                                placeholder="Détails de l'activité...">{{ old('descriptionActivite') }}</textarea>
                </div>

                <div class="modal-row">
                    <div class="form-col">
                        <label class="field-label">Date de début <span class="required">*</span></label>
                        <input type="date" name="dateDebut"
                                value="{{ old('dateDebut') }}"
                                class="field-input @error('dateDebut') is-invalid @enderror" required>
                        @error('dateDebut')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-col">
                        <label class="field-label">Date de fin <span class="required">*</span></label>
                        <input type="date" name="dateFin"
                                value="{{ old('dateFin') }}"
                                class="field-input @error('dateFin') is-invalid @enderror" required>
                        @error('dateFin')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="modal-row">
                    <div class="form-col">
                        <label class="field-label">Montant demandé (F CFA)</label>
                        <input type="number" name="montantDemande"
                                value="{{ old('montantDemande') }}"
                                class="field-input @error('montantDemande') is-invalid @enderror"
                                placeholder="0" min="0" step="1">
                        @error('montantDemande')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-col">
                        <label class="field-label">Statut</label>
                        <select name="statutActivite" class="field-input">
                            <option value="en_attente" {{ old('statutActivite','en_attente') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="en_cours"   {{ old('statutActivite') == 'en_cours'   ? 'selected' : '' }}>En cours</option>
                            <option value="termine"    {{ old('statutActivite') == 'termine'    ? 'selected' : '' }}>Terminé</option>
                            <option value="annule"     {{ old('statutActivite') == 'annule'     ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel"
                        onclick="closeModal('modalPlanifier')">Annuler</button>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ TIMELINE COMMENTAIRES ══ --}}
@if($projet->commentaires->count() > 0)
<div class="form-card" style="margin-top:16px;">
    <div class="form-card-header">
        <i class="fas fa-comments"></i>
        <span>Historique des actions ({{ $projet->commentaires->count() }})</span>
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
                        <span class="timeline-date">{{ $commentaire->dateEnvoi->format('d/m/Y à H:i') }}</span>
                    </div>
                    <p class="timeline-message">{{ $commentaire->message }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

</div>{{-- fin .projets-page --}}

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
    m.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});

@if($errors->any())
    openModal('modalPlanifier');
@endif

// ── Gestion ajout documents ──
const newDocInput  = document.getElementById('newDocuments');
const newFileList  = document.getElementById('newFileList');
const submitDocBtn = document.getElementById('submitDocBtn');

if (newDocInput) {
    newDocInput.addEventListener('change', function() {
        const files = Array.from(this.files);
        if (files.length === 0) return;

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
            </div>
        `).join('');
    });
}

function resetDocForm() {
    if (newDocInput) newDocInput.value = '';
    if (newFileList) { newFileList.innerHTML = ''; newFileList.style.display = 'none'; }
    if (submitDocBtn) submitDocBtn.style.display = 'none';
}

function getDocIcon(name) {
    const ext = name.split('.').pop().toLowerCase();
    if (['pdf'].includes(ext))              return 'fas fa-file-pdf';
    if (['doc','docx'].includes(ext))       return 'fas fa-file-word';
    if (['xls','xlsx'].includes(ext))       return 'fas fa-file-excel';
    if (['jpg','jpeg','png'].includes(ext)) return 'fas fa-file-image';
    return 'fas fa-file-alt';
}

function formatDocSize(b) {
    if (b < 1024)    return b + ' o';
    if (b < 1048576) return (b / 1024).toFixed(1) + ' Ko';
    return (b / 1048576).toFixed(1) + ' Mo';
}
</script>
@endpush

@endsection
