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
            <h1 class="projets-title">Création d'un utilisateur</h1>
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
                        <input  type="text"
                                name="nomComplet"
                                value="{{ old('nomComplet') }}"
                                class="field-input @error('nomComplet') is-invalid @enderror"
                                placeholder="Prénom Nom"
                                required >
                        @error('nomComplet')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Email <span class="required">*</span></label>
                        <input  type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="field-input @error('email') is-invalid @enderror"
                                placeholder="email@exemple.com"
                                required >
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Rôle <span class="required">*</span></label>
                        <select name="role" class="field-input @error('role') is-invalid @enderror" required>
                            <option value="">— Sélectionner le rôle —</option>
                            {{-- <option value="admin"        {{ old('role') === 'admin'        ? 'selected' : '' }}>Administrateur</option> --}}
                            <option value="porteur"      {{ old('role') === 'porteur'      ? 'selected' : '' }}>Porteur de projet</option>
                            <option value="approbateur"  {{ old('role') === 'approbateur'  ? 'selected' : '' }}>Approbateur</option>
                            <option value="validateur"   {{ old('role') === 'validateur'   ? 'selected' : '' }}>Validateur</option>
                        </select>
                        @error('role')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Téléphone</label>
                        <input  type="text"
                                name="contact"
                                value="{{ old('contact') }}"
                                class="field-input @error('contact') is-invalid @enderror"
                                placeholder="+226 XX XX XX XX">
                        @error('contact')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-col">
                        <label class="field-label">Fonction</label>
                        <input  type="text"
                                name="fonction"
                                value="{{ old('fonction') }}"
                                class="field-input @error('fonction') is-invalid @enderror"
                                placeholder="Département---">
                        @error('fonction')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-col">
                        <label class="field-label">Matricule</label>
                        <input  type="text"
                                name="matricule"
                                value="{{ old('matricule') }}"
                                class="field-input @error('matricule') is-invalid @enderror"
                                placeholder="MAT-001UJKZ">
                        @error('matricule')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col form-col-full">
                        <label class="field-label">Organisation / Structure</label>
                        <input  type="text"
                                name="organisation"
                                value="{{ old('organisation') }}"
                                class="field-input @error('organisation') is-invalid @enderror"
                                placeholder="Nom de l'organisation">
                        @error('organisation')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div id="role-fields">

                        {{-- PORTEUR --}}
                        <div class="role-group d-none" id="porteur-fields">
                            <div class="form-col">
                                <label>Spécialité</label>
                                <input  type="text"
                                        name="specialite"
                                        class="field-input">
                            </div>
                        </div>

                        {{-- APPROBATEUR --}}
                        <div class="role-group d-none" id="approbateur-fields">
                            <div class="form-col">
                                <label>Service</label>
                                <input  type="text"
                                        name="service"
                                        class="field-input">
                            </div>
                            <div class="form-col">
                                <label>Poste</label>
                                <input  type="text"
                                        name="poste"
                                        class="field-input">
                            </div>
                        </div>

                        {{-- VALIDATEUR --}}
                        <div class="role-group d-none" id="validateur-fields">
                            <div class="form-col">
                                <label>Date début mandat</label>
                                <input  type="date"
                                        name="dateDebutMandat"
                                        class="field-input">
                            </div>
                            <div class="form-col">
                                <label>Date fin mandat</label>
                                <input  type="date"
                                        name="dateFinMandat"
                                        class="field-input">
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        {{-- Boutons d'actions --}}
        <div class="form-actions">
            <a href="{{ route('admin.users.index') }}" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i>
                Créer l'utilisateur
            </button>
        </div>

    </form>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const roleSelect = document.querySelector('select[name="role"]');

    const groups = {
        porteur: document.getElementById('porteur-fields'),
        approbateur: document.getElementById('approbateur-fields'),
        validateur: document.getElementById('validateur-fields')
    };

    function hideAll() {
        Object.values(groups).forEach(g => g.classList.add('d-none'));
    }

    function showFields(role) {
        hideAll();
        if (groups[role]) {
            groups[role].classList.remove('d-none');
        }
    }

    // changement du select
    roleSelect.addEventListener('change', function () {
        showFields(this.value);
    });

    // au chargement (important si old())
    showFields(roleSelect.value);
});
</script>
@endpush
@endsection
