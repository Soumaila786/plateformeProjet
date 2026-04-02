@extends('layouts.app')

@section('title', 'Modifier l\'utilisateur')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

<div class="projets-page">

    <div class="page-header">
        <a href="{{ route('admin.users.show', $user) }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="projets-title">Modification d'un utilisateur</h1>
            <p class="projets-subtitle">{{ $user->nomComplet }}</p>
        </div>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="projet-form">
        @csrf
        @method('PUT')

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
                                value="{{ old('nomComplet', $user->nomComplet) }}"
                                class="field-input @error('nomComplet') is-invalid @enderror" required>
                        @error('nomComplet')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Email <span class="required">*</span></label>
                        <input type="email" name="email"
                                value="{{ old('email', $user->email) }}"
                                class="field-input @error('email') is-invalid @enderror" required>
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Rôle <span class="required">*</span></label>
                        <select name="role" class="field-input @error('role') is-invalid @enderror" required>
                            <option value="admin"       {{ old('role', $user->role) === 'admin'       ? 'selected' : '' }}>Administrateur</option>
                            <option value="porteur"     {{ old('role', $user->role) === 'porteur'     ? 'selected' : '' }}>Porteur de projet</option>
                            <option value="approbateur" {{ old('role', $user->role) === 'approbateur' ? 'selected' : '' }}>Approbateur</option>
                            <option value="validateur"  {{ old('role', $user->role) === 'validateur'  ? 'selected' : '' }}>Validateur</option>
                        </select>
                        @error('role')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Téléphone</label>
                        <input type="text" name="contact"
                                value="{{ old('contact', $user->contact) }}"
                                class="field-input @error('contact') is-invalid @enderror">
                        @error('contact')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-col">
                        <label class="field-label">Fonction</label>
                        <input type="text" name="fonction"
                                value="{{ old('fonction', $user->fonction) }}"
                                class="field-input @error('fonction') is-invalid @enderror">
                        @error('fonction')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-col">
                        <label class="field-label">Matricule</label>
                        <input type="text" name="matricule"
                                value="{{ old('matricule', $user->matricule) }}"
                                class="field-input @error('matricule') is-invalid @enderror">
                        @error('matricule')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col form-col-full">
                        <label class="field-label">Organisation / Structure</label>
                        <input type="text" name="organisation"
                                value="{{ old('organisation', $user->organisation) }}"
                                class="field-input @error('organisation') is-invalid @enderror">
                        @error('organisation')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    {{-- Champs spécifiques selon le rôle --}}
                    @if ($user->role === 'porteur')
                        <div class="form-col ">
                            <label class="field-label">Spécialité</label>
                            <input type="text" name="specialite"
                                value="{{ old('specialite', optional($user->porteur)->specialite) }}"
                                class="field-input @error('specialite') is-invalid @enderror">
                            @error('specialite')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    @endif

                    @if ($user->role === 'approbateur')
                        <div class="form-col form-col-full">
                            <label class="field-label">Service</label>
                            <input type="text" name="service"
                                value="{{ old('service', optional($user->approbateur)->service) }}"
                                class="field-input @error('service') is-invalid @enderror">
                            @error('poste')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-col form-col-full">
                            <label class="field-label">Poste</label>
                            <input type="text" name="poste"
                                value="{{ old('poste', optional($user->approbateur)->poste) }}"
                                class="field-input @error('poste') is-invalid @enderror">
                            @error('poste')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    @endif

                    @php
                        $dateDebutMandat = old('dateDebutMandat');
                        if (!$dateDebutMandat && $user->role === 'validateur' && $user->validateur) {
                            $dateDebutMandat = $user->validateur->dateDebutMandat ? $user->validateur->dateDebutMandat->format('Y-m-d') : '';
                        }
                        $dateFinMandat = old('dateFinMandat');
                        if (!$dateFinMandat && $user->role === 'validateur' && $user->validateur) {
                            $dateFinMandat = $user->validateur->dateFinMandat ? $user->validateur->dateFinMandat->format('Y-m-d') : '';
                        }
                    @endphp

                    @if ($user->role === 'validateur')
                        <div class="form-col form-col-full">
                            <label class="field-label">Mandat début</label>
                            <input type="date" name="dateDebutMandat"
                                value="{{ $dateDebutMandat }}"
                                class="field-input @error('dateDebutMandat') is-invalid @enderror">
                            @error('dateDebutMandat')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-col form-col-full">
                            <label class="field-label">Mandat fin</label>
                            <input type="date" name="dateFinMandat"
                                value="{{ $dateFinMandat }}"
                                class="field-input @error('dateFinMandat') is-invalid @enderror">
                            @error('dateFinMandat')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-lock"></i>
                <span>Changer le mot de passe <small class="text-muted">(laisser vide pour ne pas modifier)</small></span>
            </div>
            <div class="form-card-body">
                <div class="form-row">

                    <div class="form-col">
                        <label class="field-label">Nouveau mot de passe</label>
                        <input type="password" name="motDePasse"
                                class="field-input @error('motDePasse') is-invalid @enderror"
                                value=""
                                placeholder="Min. 8 caractères">
                        @error('motDePasse')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-col">
                        <label class="field-label">Confirmer</label>
                        <input type="password" name="motDePasse_confirmation"
                                class="field-input"
                                placeholder="Répéter le mot de passe">
                    </div>

                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.users.show', $user) }}" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Mettre à jour
            </button>
        </div>

    </form>
</div>

@endsection
