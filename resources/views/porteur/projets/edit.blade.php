@extends('layouts.app')

@section('title', 'Modifier le projet')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/projet.css') }}">
@endpush

@section('content')

<div class="projets-page">

    <div class="page-header">
        <a href="{{ route('porteur.projets.show', $projet) }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="projets-title">Modifier le projet</h1>
            <p class="projets-subtitle">{{ $projet->codeProjet }} — {{ $projet->titre }}</p>
        </div>
    </div>

    {{-- ── Message de modification demandée ── --}}
    @if($projet->messageModification)
    <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Modification demandée par l'approbateur :</strong>
        <p class="mb-0 mt-1" style="font-size:.88rem;">{{ $projet->messageModification }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form action="{{ route('porteur.projets.update', $projet) }}" method="POST" class="projet-form">
        @csrf
        @method('PUT')

        {{-- ── Informations générales ── --}}
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-project-diagram"></i>
                <span>Informations générales</span>
            </div>
            <div class="form-card-body">
                <div class="form-row">

                    <div class="form-col form-col-full">
                        <label class="field-label">Titre <span class="required">*</span></label>
                        <input type="text" name="titre"
                                value="{{ old('titre', $projet->titre) }}"
                                class="field-input @error('titre') is-invalid @enderror" required>
                        @error('titre')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col form-col-full">
                        <label class="field-label">Description <span class="required">*</span></label>
                        <textarea name="description" rows="3"
                                    class="field-input field-textarea @error('description') is-invalid @enderror"
                                    required>{{ old('description', $projet->description) }}</textarea>
                        @error('description')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col form-col-full">
                        <label class="field-label">Objectif</label>
                        <textarea name="objectif" rows="2"
                                    class="field-input field-textarea @error('objectif') is-invalid @enderror">{{ old('objectif', $projet->objectif) }}</textarea>
                        @error('objectif')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Secteur <span class="required">*</span></label>
                        <select name="secteur_id" class="field-input @error('secteur_id') is-invalid @enderror" required>
                            <option value="">— Sélectionner —</option>
                            @foreach($secteurs as $secteur)
                            <option value="{{ $secteur->id }}" {{ old('secteur_id', $projet->secteur_id) == $secteur->id ? 'selected' : '' }}>
                                {{ $secteur->nomSecteur }}
                            </option>
                            @endforeach
                        </select>
                        @error('secteur_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Durée (mois)</label>
                        <input type="number" name="duree"
                                value="{{ old('duree', $projet->duree) }}"
                                class="field-input @error('duree') is-invalid @enderror"
                                min="1">
                        @error('duree')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ── Budget & Planification ── --}}
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-coins"></i>
                <span>Budget & Planification</span>
            </div>
            <div class="form-card-body">
                <div class="form-row">

                    <div class="form-col">
                        <label class="field-label">Budget total (F CFA)</label>
                        <input type="number" name="budgetTotal"
                                value="{{ old('budgetTotal', $projet->budgetTotal) }}"
                                class="field-input @error('budgetTotal') is-invalid @enderror"
                                min="0" step="1">
                        @error('budgetTotal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Montant demandé (F CFA) <span class="required">*</span></label>
                        <input type="number" name="montantDemande"
                                value="{{ old('montantDemande', $projet->montantDemande) }}"
                                class="field-input @error('montantDemande') is-invalid @enderror"
                                min="0" step="1" required>
                        @error('montantDemande')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Date de début probable</label>
                        <input type="date" name="dateDebut"
                                value="{{ old('dateDebut', optional($projet->dateDebut)->format('Y-m-d')) }}"
                                class="field-input @error('dateDebut') is-invalid @enderror">
                        @error('dateDebut')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Date de fin probable</label>
                        <input type="date" name="dateFin"
                                value="{{ old('dateFin', optional($projet->dateFin)->format('Y-m-d')) }}"
                                class="field-input @error('dateFin') is-invalid @enderror">
                        @error('dateFin')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('porteur.projets.show', $projet) }}" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Mettre à jour
            </button>
        </div>

    </form>

    {{-- ── Documents (formulaire séparé) ── --}}
    <div class="form-card mt-3">
        <div class="form-card-header">
            <i class="fas fa-paperclip"></i>
            <span>Documents joints ({{ $projet->documents->count() }})</span>
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

            {{-- Ajout de nouveaux documents --}}
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

@push('scripts')
<script>
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
    if (newDocInput)  newDocInput.value = '';
    if (newFileList)  { newFileList.innerHTML = ''; newFileList.style.display = 'none'; }
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
