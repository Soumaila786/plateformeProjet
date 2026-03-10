@extends('layouts.app')

@section('title', 'Créer un projet')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

<div class="projets-page">

    <div class="page-header">
        <a href="{{ route('admin.projets.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="projets-title">Créer un projet</h1>
            <p class="projets-subtitle">Remplissez les informations du nouveau projet</p>
        </div>
    </div>

    <form action="{{ route('admin.projets.store') }}" method="POST"
          class="projet-form" enctype="multipart/form-data">
        @csrf

        {{-- Informations générales --}}
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
                               value="{{ old('titre') }}"
                               class="field-input @error('titre') is-invalid @enderror"
                               placeholder="Titre du projet" required>
                        @error('titre')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col form-col-full">
                        <label class="field-label">Description</label>
                        <textarea name="description" rows="3"
                                  class="field-input field-textarea @error('description') is-invalid @enderror"
                                  placeholder="Description du projet...">{{ old('description') }}</textarea>
                        @error('description')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col form-col-full">
                        <label class="field-label">Objectif</label>
                        <textarea name="objectif" rows="2"
                                  class="field-input field-textarea @error('objectif') is-invalid @enderror"
                                  placeholder="Objectif principal...">{{ old('objectif') }}</textarea>
                        @error('objectif')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Secteur <span class="required">*</span></label>
                        <select name="secteur_id" class="field-input @error('secteur_id') is-invalid @enderror" required>
                            <option value="">— Sélectionner —</option>
                            @foreach($secteurs as $secteur)
                            <option value="{{ $secteur->id }}" {{ old('secteur_id') == $secteur->id ? 'selected' : '' }}>
                                {{ $secteur->nomSecteur }}
                            </option>
                            @endforeach
                        </select>
                        @error('secteur_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Porteur de projet <span class="required">*</span></label>
                        <select name="user_id" class="field-input @error('user_id') is-invalid @enderror" required>
                            <option value="">— Sélectionner —</option>
                            @foreach($porteurs as $porteur)
                            <option value="{{ $porteur->id }}" {{ old('user_id') == $porteur->id ? 'selected' : '' }}>
                                {{ $porteur->nomComplet }}
                            </option>
                            @endforeach
                        </select>
                        @error('user_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Statut <span class="required">*</span></label>
                        <select name="statutProjet" class="field-input @error('statutProjet') is-invalid @enderror" required>
                            @foreach(['brouillon'=>'Brouillon','soumis'=>'Soumis','en_examen'=>'En examen','approuve'=>'Approuvé','valide'=>'Validé','rejete'=>'Rejeté'] as $val => $label)
                            <option value="{{ $val }}" {{ old('statutProjet', 'brouillon') == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                        @error('statutProjet')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Durée (mois)</label>
                        <input type="number" name="duree"
                               value="{{ old('duree') }}"
                               class="field-input @error('duree') is-invalid @enderror"
                               placeholder="Ex : 12" min="1">
                        @error('duree')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- Budget --}}
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
                               value="{{ old('budgetTotal') }}"
                               class="field-input @error('budgetTotal') is-invalid @enderror"
                               placeholder="0" min="0" step="1">
                        @error('budgetTotal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Montant demandé (F CFA)</label>
                        <input type="number" name="montantDemande"
                               value="{{ old('montantDemande') }}"
                               class="field-input @error('montantDemande') is-invalid @enderror"
                               placeholder="0" min="0" step="1">
                        @error('montantDemande')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Date de début</label>
                        <input type="date" name="dateDebut"
                               value="{{ old('dateDebut') }}"
                               class="field-input @error('dateDebut') is-invalid @enderror">
                        @error('dateDebut')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Date de fin</label>
                        <input type="date" name="dateFin"
                               value="{{ old('dateFin') }}"
                               class="field-input @error('dateFin') is-invalid @enderror">
                        @error('dateFin')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- Documents --}}
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-paperclip"></i>
                <span>Documents joints</span>
            </div>
            <div class="form-card-body">
                <input type="file" id="documents" name="documents[]"
                       multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                       style="display:none">
                <div class="doc-toolbar">
                    <button type="button" class="btn-attach"
                            onclick="document.getElementById('documents').click()">
                        <i class="fas fa-plus"></i> Joindre des fichiers
                    </button>
                    <select name="typeDocument" class="field-input doc-type-select">
                        <option value="rapport">Rapport</option>
                        <option value="budget">Budget</option>
                        <option value="contrat">Contrat</option>
                        <option value="etude">Étude de faisabilité</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                <p class="doc-hint">PDF, Word, Excel, images — Max 10 Mo par fichier</p>
                <div id="fileList" class="doc-file-list">
                    <div class="doc-empty-state">
                        <i class="fas fa-folder-open"></i>
                        <span>Aucun fichier sélectionné</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.projets.index') }}" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Créer le projet
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
const fileInput  = document.getElementById('documents');
const fileListEl = document.getElementById('fileList');

fileInput.addEventListener('change', function() {
    renderFiles(Array.from(this.files));
});

function getIcon(name) {
    const ext = name.split('.').pop().toLowerCase();
    if (['pdf'].includes(ext))              return 'fas fa-file-pdf';
    if (['doc','docx'].includes(ext))       return 'fas fa-file-word';
    if (['xls','xlsx'].includes(ext))       return 'fas fa-file-excel';
    if (['jpg','jpeg','png'].includes(ext)) return 'fas fa-file-image';
    return 'fas fa-file-alt';
}

function formatSize(b) {
    if (b < 1024)    return b + ' o';
    if (b < 1048576) return (b / 1024).toFixed(1) + ' Ko';
    return (b / 1048576).toFixed(1) + ' Mo';
}

function renderFiles(files) {
    if (!files || files.length === 0) {
        fileListEl.innerHTML = `<div class="doc-empty-state"><i class="fas fa-folder-open"></i><span>Aucun fichier sélectionné</span></div>`;
        return;
    }
    fileListEl.innerHTML = files.map(f => `
        <div class="doc-file-item">
            <i class="${getIcon(f.name)} doc-file-icon"></i>
            <div class="doc-file-info">
                <span class="doc-file-name">${f.name}</span>
                <span class="doc-file-size">${formatSize(f.size)}</span>
            </div>
            <span class="doc-file-ok"><i class="fas fa-check-circle"></i> Accepté</span>
        </div>
    `).join('');
}
</script>
@endpush

@endsection
