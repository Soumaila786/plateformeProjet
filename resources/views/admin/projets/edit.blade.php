@extends('layouts.app')

@section('title', 'Modifier le projet')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/projets.css') }}">
@endpush

@section('content')

<div class="projets-page">

    <div class="page-header">
        <a href="{{ route('projets.show', $projet) }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="projets-title">Modifier le projet</h1>
            <p class="projets-subtitle">{{ $projet->codeProjet }} — {{ $projet->titre }}</p>
        </div>
    </div>

    <form action="{{ route('projets.update', $projet) }}" method="POST" class="projet-form">
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
                        <label class="field-label">Description</label>
                        <textarea name="description" rows="3"
                                  class="field-input field-textarea @error('description') is-invalid @enderror">{{ old('description', $projet->description) }}</textarea>
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
                        <label class="field-label">Porteur de projet <span class="required">*</span></label>
                        <select name="user_id" class="field-input @error('user_id') is-invalid @enderror" required>
                            <option value="">— Sélectionner —</option>
                            @foreach($porteurs as $porteur)
                            <option value="{{ $porteur->id }}" {{ old('user_id', $projet->user_id) == $porteur->id ? 'selected' : '' }}>
                                {{ $porteur->nomComplet }}
                            </option>
                            @endforeach
                        </select>
                        @error('user_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Statut <span class="required">*</span></label>
                        <select name="statutProjet" class="field-input @error('statutProjet') is-invalid @enderror" required>
                            @foreach(['brouillon' => 'Brouillon', 'soumis' => 'Soumis', 'en_examen' => 'En examen', 'approuve' => 'Approuvé', 'valide' => 'Validé', 'rejete' => 'Rejeté'] as $val => $label)
                            <option value="{{ $val }}" {{ old('statutProjet', $projet->statutProjet) == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                        @error('statutProjet')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ── Budget & Durée ── --}}
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-coins"></i>
                <span>Budget & Planification</span>
            </div>
            <div class="form-card-body">
                <div class="form-row">

                    <div class="form-col">
                        <label class="field-label">Budget total (F CFA) <span class="required">*</span></label>
                        <input type="number" name="budgetTotal"
                               value="{{ old('budgetTotal', $projet->budgetTotal) }}"
                               class="field-input @error('budgetTotal') is-invalid @enderror"
                               min="0" step="1" required>
                        @error('budgetTotal')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Montant demandé (F CFA)</label>
                        <input type="number" name="montantDemande"
                               value="{{ old('montantDemande', $projet->montantDemande) }}"
                               class="field-input @error('montantDemande') is-invalid @enderror"
                               min="0" step="1">
                        @error('montantDemande')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Durée (mois)</label>
                        <input type="number" name="duree"
                               value="{{ old('duree', $projet->duree) }}"
                               class="field-input @error('duree') is-invalid @enderror"
                               min="1">
                        @error('duree')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Date de début</label>
                        <input type="date" name="dateDebut"
                               value="{{ old('dateDebut', optional($projet->dateDebut)->format('Y-m-d')) }}"
                               class="field-input @error('dateDebut') is-invalid @enderror">
                        @error('dateDebut')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Date de fin</label>
                        <input type="date" name="dateFin"
                               value="{{ old('dateFin', optional($projet->dateFin)->format('Y-m-d')) }}"
                               class="field-input @error('dateFin') is-invalid @enderror">
                        @error('dateFin')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('projets.show', $projet) }}" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Mettre à jour
            </button>
        </div>

    </form>

</div>
@endsection
