@extends('layouts.app')

@section('title', 'Modifier un utilisateur')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endpush

@section('content')

<div class="page-header">
    <a href="{{ route('admin.users.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="page-title">Modifier l'utilisateur</h1>
        <p class="page-subtitle">{{ $user->nomComplet }}</p>
    </div>
</div>

<form action="{{ route('admin.users.update', $user) }}" method="POST" class="user-form">
    @csrf
    @method('PUT')

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
                            id="nomComplet"
                            name="nomComplet"
                            value="{{ old('nomComplet', $user->nomComplet) }}"
                            class="field-input @error('nomComplet') is-invalid @enderror"
                            required>
                    @error('nomComplet')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col">
                    <label for="email" class="field-label">Adresse e-mail <span class="required">*</span></label>
                    <input type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            class="field-input @error('email') is-invalid @enderror"
                            required>
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col">
                    <label for="matricule" class="field-label">Matricule</label>
                    <input type="text"
                            id="matricule"
                            name="matricule"
                            value="{{ old('matricule', $user->matricule) }}"
                            class="field-input @error('matricule') is-invalid @enderror">
                    @error('matricule')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col">
                    <label for="fonction" class="field-label">Fonction</label>
                    <input type="text"
                            id="fonction" 
                            name="fonction"
                            value="{{ old('fonction', $user->fonction) }}"
                            class="field-input @error('fonction') is-invalid @enderror">
                    @error('fonction')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col">
                    <label for="contact" class="field-label">Contact</label>
                    <input type="text"
                            id="contact" 
                            name="contact"
                            value="{{ old('contact', $user->contact) }}"
                            class="field-input @error('contact') is-invalid @enderror">
                    @error('contact')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col">
                    <label class="field-label">Rôle</label>
                    <input type="text"
                            class="field-input"
                            value="{{ ucfirst($user->role) }}"
                            readonly
                            style="background:#f9fafb; color:#6b7280; cursor:not-allowed;">
                    <input type="hidden" name="role" value="{{ $user->role }}">
                </div>

            </div>

            <div class="form-check-row">
                <input class="field-checkbox" type="checkbox"
                        id="actif" name="actif" value="1"
                        {{ old('actif', $user->actif) ? 'checked' : '' }}>
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
            <div class="field-info">
                <i class="fas fa-info-circle"></i>
                Laissez vide si vous ne souhaitez pas modifier le mot de passe.
            </div>
            <div class="form-row" style="margin-top: 1rem;">

                <div class="form-col">
                    <label for="password" class="field-label">Nouveau mot de passe</label>
                    <input type="password"
                            id="password" 
                            name="password"
                            class="field-input @error('password') is-invalid @enderror"
                            placeholder="••••••••">
                    @error('password')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col">
                    <label for="password_confirmation" class="field-label">Confirmer le mot de passe</label>
                    <input type="password"
                            id="password_confirmation" 
                            name="password_confirmation"
                            class="field-input"
                            placeholder="••••••••">
                </div>

            </div>
        </div>
    </div>

    {{-- ── Section Administrateur ── --}}
    @if($user->role == 'admin')
    <div class="form-card">

        <div class="form-card-header header-admin">
            <i class="fas fa-user-shield"></i>
            <span>Informations Administrateur</span>
        </div>

        <div class="form-card-body">
            <div class="form-row">

                <div class="form-col">
                    <label for="datePriseFonction" class="field-label">Date de prise de fonction</label>
                    <input type="date"
                            id="datePriseFonction" 
                            name="datePriseFonction"
                            value="{{ old('datePriseFonction', optional($user->admin)->datePriseFonction ?? '') }}"
                            class="field-input @error('datePriseFonction') is-invalid @enderror">
                    @error('datePriseFonction')<span class="field-error">{{ $message }}</span>@enderror
                </div>

            </div>
        </div>
    </div>
    @endif

    {{-- ── Section Approbateur ── --}}
    @if($user->role == 'approbateur')
    <div class="form-card">
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
                            value="{{ old('service', optional($user->approbateur)->service ?? '') }}"
                            class="field-input @error('service') is-invalid @enderror">
                    @error('service')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-col">
                    <label for="poste" class="field-label">Poste</label>
                    <input type="text"
                            id="poste" name="poste"
                            value="{{ old('poste', optional($user->approbateur)->poste ?? '') }}"
                            class="field-input @error('poste') is-invalid @enderror">
                    @error('poste')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ── Section Validateur ── --}}
    @if($user->role == 'validateur')
    <div class="form-card">
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
                            value="{{ old('dateDebutMandat', optional($user->validateur)->dateDebutMandat ?? '') }}"
                            class="field-input @error('dateDebutMandat') is-invalid @enderror">
                    @error('dateDebutMandat')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-col">
                    <label for="dateFinMandat" class="field-label">Date de fin de mandat</label>
                    <input type="date"
                            id="dateFinMandat" name="dateFinMandat"
                            value="{{ old('dateFinMandat', optional($user->validateur)->dateFinMandat ?? '') }}"
                            class="field-input @error('dateFinMandat') is-invalid @enderror">
                    @error('dateFinMandat')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ── Section Porteur ── --}}
    @if($user->role == 'porteur')
    <div class="form-card">
        <div class="form-card-header header-porteur">
            <i class="fas fa-user-tie"></i>
            <span>Informations Porteur de projet</span>
        </div>
        <div class="form-card-body">
            <div class="form-row">

                <div class="form-col">
                    <label for="structure" class="field-label">Structure</label>
                    <input type="text"
                            id="structure" 
                            name="structure"
                            value="{{ old('structure', optional($user->porteur)->structure ?? '') }}"
                            class="field-input @error('structure') is-invalid @enderror">
                    @error('structure')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col">
                    <label for="specialite" class="field-label">Spécialité</label>
                    <input type="text"
                            id="specialite" 
                            name="specialite"
                            value="{{ old('specialite', optional($user->porteur)->specialite ?? '') }}"
                            class="field-input @error('specialite') is-invalid @enderror">
                    @error('specialite')<span class="field-error">{{ $message }}</span>@enderror
                </div>

            </div>
        </div>
    </div>
    @endif

    {{-- ── Actions ── --}}
    <div class="form-actions">
        <a href="{{ route('admin.users.index') }}" class="btn-cancel">Annuler</a>
        <button type="submit" class="btn-save">
            <i class="fas fa-save"></i>
            Mettre à jour
        </button>
    </div>

</form>

@endsection
