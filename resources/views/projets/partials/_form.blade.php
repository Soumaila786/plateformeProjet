@php
    $p = $projet ?? null;
    // Repli défensif : si le controller oublie de passer $secteurs, on affiche
    // un menu vide plutôt qu'une ErrorException qui casse toute la page.
    // Le vrai correctif reste côté controller (voir message) : il faut
    // passer $secteurs à chaque vue qui inclut cette modale.
    $secteurs = $secteurs ?? collect();
    $typesProjets = $typesProjets ?? \App\Models\TypeProjet::where('actif', true)->orderBy('nom')->get();
    $sousDomaines = $sousDomaines ?? \App\Models\SousDomaine::where('actif', true)->orderBy('nom')->get();
@endphp

<div class="mb-3">
    <label class="form-label">Titre du projet</label>
    <input type="text" name="titre" value="{{ old('titre', $p->titre ?? '') }}"
        class="form-control @error('titre') is-invalid @enderror" required maxlength="255">
    @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $p->description ?? '') }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Objectif</label>
    <textarea name="objectif" rows="2" class="form-control @error('objectif') is-invalid @enderror">{{ old('objectif', $p->objectif ?? '') }}</textarea>
    @error('objectif')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <label class="form-label">Type de projet</label>
        <select name="type_projet_id" class="form-select @error('type_projet_id') is-invalid @enderror" required>
            <option value="">Sélectionner...</option>
            @foreach ($typesProjets as $type)
                <option value="{{ $type->id }}" {{ (string) old('type_projet_id', $p->type_projet_id ?? '') === (string) $type->id ? 'selected' : '' }}>{{ $type->nom }}</option>
            @endforeach
        </select>
        @error('type_projet_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Secteur d'activité</label>
        <select name="secteur_id" class="form-select @error('secteur_id') is-invalid @enderror" required>
            <option value="">Sélectionner...</option>
            @forelse ($secteurs as $secteur)
                <option value="{{ $secteur->id }}" {{ (string) old('secteur_id', $p->secteur_id ?? '') === (string) $secteur->id ? 'selected' : '' }}>
                    {{ $secteur->nomSecteur }}
                </option>
            @empty
                <option value="" disabled>Aucun secteur disponible — vérifie que $secteurs est bien transmis à la vue</option>
            @endforelse
        </select>
        @error('secteur_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Sous-domaine</label>
        <select name="sous_domaine_id" class="form-select @error('sous_domaine_id') is-invalid @enderror">
            <option value="">Aucun sous-domaine</option>
            @foreach ($sousDomaines as $sousDomaine)
                <option value="{{ $sousDomaine->id }}" data-secteur="{{ $sousDomaine->secteur_id }}" {{ (string) old('sous_domaine_id', $p->sous_domaine_id ?? '') === (string) $sousDomaine->id ? 'selected' : '' }}>{{ $sousDomaine->nom }}</option>
            @endforeach
        </select>
        @error('sous_domaine_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Durée (mois)</label>
        <input type="number" name="duree" min="1" value="{{ old('duree', $p->duree ?? '') }}" class="form-control @error('duree') is-invalid @enderror">
        @error('duree')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label">Date de début</label>
        <input type="date" name="dateDebut" value="{{ old('dateDebut', optional($p->dateDebut ?? null)->format('Y-m-d')) }}" class="form-control @error('dateDebut') is-invalid @enderror">
        @error('dateDebut')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Date de fin</label>
        <input type="date" name="dateFin" value="{{ old('dateFin', optional($p->dateFin ?? null)->format('Y-m-d')) }}" class="form-control @error('dateFin') is-invalid @enderror">
        @error('dateFin')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label">Budget total (FCFA)</label>
        <input type="number" name="budgetTotal" min="0" step="1" value="{{ old('budgetTotal', $p->budgetTotal ?? '') }}" class="form-control @error('budgetTotal') is-invalid @enderror">
        @error('budgetTotal')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Montant demandé (FCFA)</label>
        <input type="number" name="montantDemande" min="0" step="1" value="{{ old('montantDemande', $p->montantDemande ?? '') }}" class="form-control @error('montantDemande') is-invalid @enderror">
        @error('montantDemande')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

{{-- Masqué automatiquement en édition (JS, id="lpDocumentsUpload") : update() ne
    traite pas les fichiers — l'ajout de documents après création se fait depuis
    la page détail (section Documents) --}}
<div class="mb-3" id="lpDocumentsUpload">
    <label class="form-label">Document (optionnel — pdf, doc, xls, image, 10 Mo max)</label>
    <input type="file" name="documents[]" class="form-control @error('documents') is-invalid @enderror">
    @error('documents')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <div class="mt-2">
        <label class="form-label small">Nom personnalisé</label>
        <input type="text" name="document_names[]" class="form-control form-control-sm" maxlength="255" placeholder="Ex. Budget prévisionnel">
        <div class="form-text">Laissez vide pour conserver le nom original du fichier.</div>
    </div>
</div>
