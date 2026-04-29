@extends('layouts.app')
@section('title', 'Nouveau projet')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/porteur.css') }}">
@endpush

@section('content')
<div class="projets-page">

    <div class="page-header">
        <a href="{{ route('porteur.projets.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="projets-title">Nouveau projet</h1>
            <p class="projets-subtitle">Remplissez les informations de votre projet</p>
        </div>
    </div>

    @if($errors->any())
    <div class="port-alert port-alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <ul style="margin:0;padding-left:16px;">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('porteur.projets.store') }}" method="POST" class="projet-form" enctype="multipart/form-data">
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
                        <input type="text" name="titre" value="{{ old('titre') }}"
                                class="field-input @error('titre') is-invalid @enderror"
                                placeholder="Titre du projet" required>
                        @error('titre')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-col form-col-full">
                        <label class="field-label">Description <span class="required">*</span></label>
                        <textarea name="description" rows="3"
                                    class="field-input field-textarea @error('description') is-invalid @enderror"
                                    placeholder="Description du projet..." required>{{ old('description') }}</textarea>
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
                        <label class="field-label">Durée (mois)</label>
                        <input type="number" name="duree" value="{{ old('duree') }}"
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
                <span>Budget</span>
            </div>
            <div class="form-card-body">
                <div class="form-row">
                    <div class="form-col">
                        <label class="field-label">Budget total (F CFA)</label>
                        <input type="number" name="budgetTotal" value="{{ old('budgetTotal') }}"
                                class="field-input @error('budgetTotal') is-invalid @enderror"
                                placeholder="0" min="0" step="1">
                        @error('budgetTotal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-col">
                        <label class="field-label">Montant demandé (F CFA) <span class="required">*</span></label>
                        <input type="number" name="montantDemande" value="{{ old('montantDemande') }}"
                                class="field-input @error('montantDemande') is-invalid @enderror"
                                placeholder="0" min="0" step="1" required>
                        @error('montantDemande')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-col">
                        <label class="field-label">Date de début probable</label>
                        <input type="date" name="dateDebut" value="{{ old('dateDebut') }}"
                                class="field-input @error('dateDebut') is-invalid @enderror">
                        @error('dateDebut')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-col">
                        <label class="field-label">Date de fin probable</label>
                        <input type="date" name="dateFin" value="{{ old('dateFin') }}"
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
                <input type="file" id="documents" name="documents[]" multiple
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" style="display:none">
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
                @error('documents.*')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- Les actions --}}
        <div class="form-actions">
            <a href="{{ route('porteur.projets.index') }}" class="btn-cancel">Annuler</a>
            <button type="submit" name="action" value="brouillon" class="btn-cancel">
                <i class="fas fa-save"></i> Enregistrer en brouillon
            </button>
            <button type="submit" name="action" value="soumettre" class="btn-save"
                    onclick="return confirm('Soumettre ce projet ? Vous ne pourrez plus le modifier.')">
                <i class="fas fa-paper-plane"></i> Enregistrer et soumettre
            </button>
        </div>

    </form>

</div>

@push('scripts')
<script>
    const fileInput  = document.getElementById('documents');
    const fileListEl = document.getElementById('fileList');
    fileInput.addEventListener('change', function() {
        const files = Array.from(this.files);
        if (!files.length) {
            fileListEl.innerHTML = `<div class="doc-empty-state">
                                        <i class="fas fa-folder-open"></i>
                                        <span>Aucun fichier sélectionné</span>
                                    </div>`;
            return;
        }
        fileListEl.innerHTML = files.map(f => `
            <div class="doc-file-item">
                <i class="${getIcon(f.name)} doc-file-icon"></i>
                <div class="doc-file-info">
                    <span class="doc-file-name">${f.name}</span>
                    <span class="doc-file-size">${formatSize(f.size)}</span>
                </div>
                <span class="doc-file-ok">
                    <i class="fas fa-check-circle"></i>
                    Accepté
                </span>
            </div>`).join('');
    });
    function getIcon(name) {
        const ext = name.split('.').pop().toLowerCase();
        if (['pdf'].includes(ext)) return 'fas fa-file-pdf';
        if (['doc','docx'].includes(ext)) return 'fas fa-file-word';
        if (['xls','xlsx'].includes(ext)) return 'fas fa-file-excel';
        if (['jpg','jpeg','png'].includes(ext)) return 'fas fa-file-image';
        return 'fas fa-file-alt';
    }
    function formatSize(b) {
        if (b < 1024) return b+' o';
        if (b < 1048576) return (b/1024).toFixed(1)+' Ko';
        return (b/1048576).toFixed(1)+' Mo';
    }
</script>
@endpush
@endsection
