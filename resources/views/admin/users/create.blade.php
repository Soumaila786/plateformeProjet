@extends('layouts.app')

@section('title', 'Créer un utilisateur')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

<div class="projets-page">

    <div class="page-header">
        <a href="{{ route('admin.users.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="projets-title">Créer un utilisateur</h1>
            <p class="projets-subtitle">Remplissez les informations du nouveau compte</p>
        </div>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="projet-form">
        @csrf

        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-user"></i>
                <span>Informations personnelles</span>
            </div>
            <div class="form-card-body">
                <div class="form-row">

                    <div class="form-col">
                        <label class="field-label">Nom complet <span class="required">*</span></label>
                        <input type="text" name="nomComplet"
                               value="{{ old('nomComplet') }}"
                               class="field-input @error('nomComplet') is-invalid @enderror"
                               placeholder="Prénom Nom" required>
                        @error('nomComplet')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Email <span class="required">*</span></label>
                        <input type="email" name="email"
                               value="{{ old('email') }}"
                               class="field-input @error('email') is-invalid @enderror"
                               placeholder="email@exemple.com" required>
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Rôle <span class="required">*</span></label>
                        <select name="role" class="field-input @error('role') is-invalid @enderror" required>
                            <option value="">— Sélectionner —</option>
                            <option value="admin"        {{ old('role') === 'admin'        ? 'selected' : '' }}>Administrateur</option>
                            <option value="porteur"      {{ old('role') === 'porteur'      ? 'selected' : '' }}>Porteur de projet</option>
                            <option value="approbateur"  {{ old('role') === 'approbateur'  ? 'selected' : '' }}>Approbateur</option>
                            <option value="validateur"   {{ old('role') === 'validateur'   ? 'selected' : '' }}>Validateur</option>
                        </select>
                        @error('role')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Téléphone</label>
                        <input type="text" name="telephone"
                               value="{{ old('telephone') }}"
                               class="field-input @error('telephone') is-invalid @enderror"
                               placeholder="+226 XX XX XX XX">
                        @error('telephone')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col form-col-full">
                        <label class="field-label">Organisation / Structure</label>
                        <input type="text" name="organisation"
                               value="{{ old('organisation') }}"
                               class="field-input @error('organisation') is-invalid @enderror"
                               placeholder="Nom de l'organisation">
                        @error('organisation')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-lock"></i>
                <span>Mot de passe</span>
            </div>
            <div class="form-card-body">
                <div class="form-row">

                    <div class="form-col">
                        <label class="field-label">Mot de passe <span class="required">*</span></label>
                        <input type="password" name="motDePasse"
                               class="field-input @error('motDePasse') is-invalid @enderror"
                               placeholder="Min. 8 caractères" required>
                        @error('motDePasse')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Confirmer <span class="required">*</span></label>
                        <input type="password" name="motDePasse_confirmation"
                               class="field-input"
                               placeholder="Répéter le mot de passe" required>
                    </div>

                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.users.index') }}" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Créer l'utilisateur
            </button>
        </div>

    </form>
</div>

@endsection
