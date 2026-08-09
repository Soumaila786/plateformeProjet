@extends('layouts.app')

@section('title', 'Nouveau projet')

@section('breadcrumb')
    <a href="{{ route('porteur.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <a href="{{ route('porteur.projets.index') }}">Mes projets</a>
    <span>/</span>
    <span>Nouveau projet</span>
@endsection

@section('page-header')
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Nouveau projet</h1>
            <p class="page-header-sub">Renseignez les informations ci-dessous pour créer votre projet</p>
        </div>
        <x-buttons.link :href="route('porteur.projets.index')" variant="ghost" icon="fa-arrow-left">
            Retour à mes projets
        </x-buttons.link>
    </div>
@endsection

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/projet-form.css') }}">
    @endpush

    <form action="{{ route('porteur.projets.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="pf-form">
        @csrf

        <div class="pf-layout">
            <div class="pf-main">

                <div class="pf-section">
                    <div class="pf-section-head">
                        <div class="pf-section-icon">
                            <i class="fas fa-circle-info"></i>
                        </div>
                        <div>
                            <h2 class="pf-section-title">
                                Informations générales
                            </h2>
                            <p class="pf-section-sub">
                                Le titre et la description de votre projet
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Titre du projet</label>
                        <input type="text" name="titre" value="{{ old('titre') }}"
                            class="form-control @error('titre') is-invalid @enderror" required maxlength="255"
                            placeholder="Ex : Réhabilitation du laboratoire de chimie">
                        @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" required
                                placeholder="Décrivez le contexte et le contenu du projet...">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Objectif</label>
                        <textarea name="objectif" rows="3" class="form-control @error('objectif') is-invalid @enderror"
                                placeholder="Quel résultat ce projet doit-il atteindre ?">{{ old('objectif') }}</textarea>
                        @error('objectif')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="pf-section">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fas fa-calendar-days"></i></div>
                        <div>
                            <h2 class="pf-section-title">Planning</h2>
                            <p class="pf-section-sub">Secteur, durée et dates prévisionnelles</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Secteur d'activité</label>
                            <select name="secteur_id" class="form-select @error('secteur_id') is-invalid @enderror" required>
                                <option value="">Sélectionner...</option>
                                @foreach ($secteurs as $secteur)
                                    <option value="{{ $secteur->id }}" {{ (string) old('secteur_id') === (string) $secteur->id ? 'selected' : '' }}>
                                        {{ $secteur->nomSecteur }}
                                    </option>
                                @endforeach
                            </select>
                            @error('secteur_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Durée (mois)</label>
                            <input type="number" 
                                name="duree" min="1" 
                                value="{{ old('duree') }}" 
                                class="form-control @error('duree') is-invalid @enderror">
                            @error('duree')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date de début</label>
                            <input type="date" 
                                name="dateDebut" 
                                value="{{ old('dateDebut') }}" 
                                class="form-control @error('dateDebut') is-invalid @enderror">
                            @error('dateDebut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date de fin</label>
                            <input type="date"
                                name="dateFin"
                                value="{{ old('dateFin') }}"
                                class="form-control @error('dateFin') is-invalid @enderror">
                            @error('dateFin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="pf-section">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fas fa-coins"></i></div>
                        <div>
                            <h2 class="pf-section-title">Budget</h2>
                            <p class="pf-section-sub">Montants prévisionnels en FCFA</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Budget total</label>
                            <div class="input-group">
                                <input type="number"
                                    name="budgetTotal"
                                    min="0" step="1"
                                    value="{{ old('budgetTotal') }}"
                                    class="form-control @error('budgetTotal') is-invalid @enderror">
                                <span class="input-group-text">FCFA</span>
                            </div>
                            @error('budgetTotal')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Montant demandé</label>
                            <div class="input-group">
                                <input type="number"
                                    name="montantDemande"
                                    min="0"
                                    step="1"
                                    value="{{ old('montantDemande') }}"
                                    class="form-control @error('montantDemande') is-invalid @enderror">
                                <span class="input-group-text">FCFA</span>
                            </div>
                            @error('montantDemande')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="pf-section">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fas fa-paperclip"></i></div>
                        <div>
                            <h2 class="pf-section-title">Documents</h2>
                            <p class="pf-section-sub">Optionnel — pdf, doc, xls, images (10 Mo max chacun)</p>
                        </div>
                    </div>

                    <input type="file" name="documents[]" multiple class="form-control @error('documents') is-invalid @enderror">
                    @error('documents')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="pf-aside">
                <div class="pf-aside-card">
                    <h3 class="pf-aside-title"><i class="fas fa-lightbulb"></i> Avant de soumettre</h3>
                    <ul class="pf-checklist">
                        <li>Le projet est créé en <strong>brouillon</strong> — vous pourrez encore le modifier</li>
                        <li>Ajoutez vos documents justificatifs si vous les avez déjà</li>
                        <li>Vous soumettrez le projet pour examen depuis sa page de détail</li>
                    </ul>

                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check me-1"></i>Créer le projet</button>
                        <x-buttons.link :href="route('porteur.projets.index')" variant="ghost">Annuler</x-buttons.link>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
