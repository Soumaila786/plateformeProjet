@extends('layouts.app')

@section('title', 'Créer un utilisateur')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endpush

@section('content')

<div class="page-header">
    <a href="{{ route('admin.users.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="page-title">Créer un utilisateur</h1>
        <p class="page-subtitle">Remplissez les informations du nouvel utilisateur</p>
    </div>
</div>

{{-- CORRECTION ICI : route('admin.users.store') --}}
<form action="{{ route('admin.users.store') }}" method="POST" class="user-form">
    @csrf

    {{-- ── Informations générales ── --}}
    <div class="form-card">
        <div class="form-card-header">
            <i class="fas fa-user"></i>
            <span>Informations générales</span>
        </div>
        <div class="form-card-body">
            <div class="form-row">

                <div class="form-col">
                    <label for="nomComplet" class="field-label">Nom complet <span class="required">*</span></label>
                    <input type="text"
                           id="nomComplet" name="nomComplet"
                           value="{{ old('nomComplet') }}"
                           class="field-input @error('nomComplet') is-invalid @enderror"
                           placeholder="Ex : Issa kaboré"
                           required>
                    @error('nomComplet')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col">
                    <label for="email" class="field-label">Adresse e-mail <span class="required">*</span></label>
                    <input type="email"
                           id="email" name="email"
                           value="{{ old('email') }}"
                           class="field-input @error('email') is-invalid @enderror"
                           placeholder="Ex : exemple@domaine.com"
                           required>
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col">
                    <label for="matricule" class="field-label">Matricule</label>
                    <input type="text"
                           id="matricule" name="matricule"
                           value="{{ old('matricule') }}"
                           class="field-input @error('matricule') is-invalid @enderror"
                           placeholder="Ex : MAT-001">
                    @error('matricule')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col">
                    <label for="fonction" class="field-label">Fonction</label>
                    <input type="text"
                           id="fonction" name="fonction"
                           value="{{ old('fonction') }}"
                           class="field-input @error('fonction') is-invalid @enderror"
                           placeholder="Ex : Chef de projet">
                    @error('fonction')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col">
                    <label for="contact" class="field-label">Contact</label>
                    <input type="text"
                           id="contact" name="contact"
                           value="{{ old('contact') }}"
                           class="field-input @error('contact') is-invalid @enderror"
                           placeholder="Ex : +226 00 00 00 00">
                    @error('contact')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col">
                    <label for="role" class="field-label">Rôle <span class="required">*</span></label>
                    <select id="role" name="role"
                            class="field-input @error('role') is-invalid @enderror"
                            required>
                        <option value="">— Sélectionner un rôle —</option>
                        <option value="admin"        {{ old('role') == 'admin'        ? 'selected' : '' }}>Administrateur</option>
                        <option value="approbateur"  {{ old('role') == 'approbateur'  ? 'selected' : '' }}>Approbateur</option>
                        <option value="validateur"   {{ old('role') == 'validateur'   ? 'selected' : '' }}>Validateur</option>
                        <option value="porteur"      {{ old('role') == 'porteur'      ? 'selected' : '' }}>Porteur de projet</option>
                    </select>
                    @error('role')<span class="field-error">{{ $message }}</span>@enderror
                </div>

            </div>

            <div class="form-check-row">
                <input class="field-checkbox" type="checkbox"
                       id="actif" name="actif" value="1"
                       {{ old('actif', true) ? 'checked' : '' }}>
                <label for="actif" class="field-label" style="margin:0; cursor:pointer;">
                    Compte actif
                </label>
            </div>
        </div>
    </div>

    {{-- ── Sécurité ── --}}
    <div class="form-card">
        <div class="form-card-header">
            <i class="fas fa-lock"></i>
            <span>Sécurité</span>
        </div>
        <div class="form-card-body">
            <div class="form-row">

                <div class="form-col">
                    <label for="password" class="field-label">Mot de passe <span class="required">*</span></label>
                    <input type="password"
                           id="password" name="password"
                           class="field-input @error('password') is-invalid @enderror"
                           placeholder="••••••••"
                           required>
                    @error('password')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col">
                    <label for="password_confirmation" class="field-label">Confirmer le mot de passe <span class="required">*</span></label>
                    <input type="password"
                           id="password_confirmation" name="password_confirmation"
                           class="field-input @error('password_confirmation') is-invalid @enderror"
                           placeholder="••••••••"
                           required>
                    @error('password_confirmation')<span class="field-error">{{ $message }}</span>@enderror
                </div>

            </div>
        </div>
    </div>

    {{-- ── Section Administrateur ── --}}
    <div id="admin-fields" class="form-card role-section d-none">
        <div class="form-card-header header-admin">
            <i class="fas fa-user-shield"></i>
            <span>Informations Administrateur</span>
        </div>
        <div class="form-card-body">
            <div class="form-row">
                <div class="form-col">
                    <label for="datePriseFonction" class="field-label">Date de prise de fonction</label>
                    <input type="date"
                           id="datePriseFonction" name="datePriseFonction"
                           value="{{ old('datePriseFonction') }}"
                           class="field-input @error('datePriseFonction') is-invalid @enderror">
                    @error('datePriseFonction')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ── Section Approbateur ── --}}
    <div id="approbateur-fields" class="form-card role-section d-none">
        <div class="form-card-header header-approbateur">
            <i class="fas fa-user-check"></i>
            <span>Informations Approbateur</span>
        </div>
        <div class="form-card-body">
            <div class="form-row">
                <div class="form-col">
                    <label for="service" class="field-label">Service</label>
                    <input type="text"
                           id="service" name="service"
                           value="{{ old('service') }}"
                           class="field-input @error('service') is-invalid @enderror"
                           placeholder="Ex : Direction financière">
                    @error('service')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-col">
                    <label for="poste" class="field-label">Poste</label>
                    <input type="text"
                           id="poste" name="poste"
                           value="{{ old('poste') }}"
                           class="field-input @error('poste') is-invalid @enderror"
                           placeholder="Ex : Directeur adjoint">
                    @error('poste')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ── Section Validateur ── --}}
    <div id="validateur-fields" class="form-card role-section d-none">
        <div class="form-card-header header-validateur">
            <i class="fas fa-user-cog"></i>
            <span>Informations Validateur</span>
        </div>
        <div class="form-card-body">
            <div class="form-row">
                <div class="form-col">
                    <label for="dateDebutMandat" class="field-label">Date de début de mandat</label>
                    <input type="date"
                           id="dateDebutMandat" name="dateDebutMandat"
                           value="{{ old('dateDebutMandat') }}"
                           class="field-input @error('dateDebutMandat') is-invalid @enderror">
                    @error('dateDebutMandat')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-col">
                    <label for="dateFinMandat" class="field-label">Date de fin de mandat</label>
                    <input type="date"
                           id="dateFinMandat" name="dateFinMandat"
                           value="{{ old('dateFinMandat') }}"
                           class="field-input @error('dateFinMandat') is-invalid @enderror">
                    @error('dateFinMandat')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ── Section Porteur ── --}}
    <div id="porteur-fields" class="form-card role-section d-none">
        <div class="form-card-header header-porteur">
            <i class="fas fa-user-tie"></i>
            <span>Informations Porteur de projet</span>
        </div>
        <div class="form-card-body">
            <div class="form-row">
                <div class="form-col">
                    <label for="structure" class="field-label">Structure</label>
                    <input type="text"
                           id="structure" name="structure"
                           value="{{ old('structure') }}"
                           class="field-input @error('structure') is-invalid @enderror"
                           placeholder="Ex : ONG SantéBF">
                    @error('structure')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-col">
                    <label for="specialite" class="field-label">Spécialité</label>
                    <input type="text"
                           id="specialite" name="specialite"
                           value="{{ old('specialite') }}"
                           class="field-input @error('specialite') is-invalid @enderror"
                           placeholder="Ex : Santé communautaire">
                    @error('specialite')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ── Actions ── --}}
    <div class="form-actions">
        <a href="{{ route('admin.users.index') }}" class="btn-cancel">Annuler</a>
        <button type="submit" class="btn-save">
            <i class="fas fa-save"></i>
            Créer l'utilisateur
        </button>
    </div>

</form>

@push('scripts')
<script>
    const roleSelect = document.getElementById('role');
    const sections   = ['admin', 'approbateur', 'validateur', 'porteur'];

    roleSelect.addEventListener('change', function () {
        sections.forEach(r => {
            document.getElementById(r + '-fields').classList.add('d-none');
        });
        if (this.value) {
            document.getElementById(this.value + '-fields').classList.remove('d-none');
        }
    });

    // Restaurer la section si old('role') est présent
    if (roleSelect.value) roleSelect.dispatchEvent(new Event('change'));
</script>
@endpush

@endsection