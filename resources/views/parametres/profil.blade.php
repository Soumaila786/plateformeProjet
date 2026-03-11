@extends('layouts.app')
@section('title', 'Modifier le profil')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/parametre.css') }}">
@endpush
@section('content')
<div class="param-subpage">

    <div class="param-subpage-header">
        <a href="{{ route('parametres.index') }}" class="param-back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="param-subpage-title">Modifier le profil</h1>
            <p class="param-subpage-sub">Informations personnelles de votre compte</p>
        </div>
    </div>

    @if(session('success'))
    <div class="param-alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="param-alert-error"><i class="fas fa-exclamation-circle"></i> Veuillez corriger les erreurs.</div>
    @endif

    <div class="param-section-card">
        <div class="param-section-header">
            <i class="fas fa-user-circle"></i><span>Identité</span>
        </div>
        <div class="param-section-body">
            <div class="param-avatar-row">
                <div class="param-avatar">{{ strtoupper(substr(Auth::user()->nomComplet, 0, 2)) }}</div>
                <div>
                    <p class="param-avatar-name">{{ Auth::user()->nomComplet }}</p>
                    <p class="param-avatar-role">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="param-section-card">
        <div class="param-section-header">
            <i class="fas fa-edit"></i><span>Informations</span>
        </div>
        <div class="param-section-body">
            <form action="{{ route('parametres.profil.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="param-form-grid">
                    <div class="param-field">
                        <label class="param-field-label">Nom complet <span class="required">*</span></label>
                        <input type="text" name="nomComplet"
                               class="param-field-input @error('nomComplet') is-invalid @enderror"
                               value="{{ old('nomComplet', Auth::user()->nomComplet) }}" required>
                        @error('nomComplet')<span class="param-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="param-field">
                        <label class="param-field-label">Email <span class="required">*</span></label>
                        <input type="email" name="email"
                               class="param-field-input @error('email') is-invalid @enderror"
                               value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email')<span class="param-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="param-field">
                        <label class="param-field-label">Matricule</label>
                        <input type="text" name="matricule"
                               class="param-field-input @error('matricule') is-invalid @enderror"
                               value="{{ old('matricule', Auth::user()->matricule) }}">
                        @error('matricule')<span class="param-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="param-field">
                        <label class="param-field-label">Fonction</label>
                        <input type="text" name="fonction"
                               class="param-field-input @error('fonction') is-invalid @enderror"
                               value="{{ old('fonction', Auth::user()->fonction) }}">
                        @error('fonction')<span class="param-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="param-field">
                        <label class="param-field-label">Contact</label>
                        <input type="text" name="contact"
                               class="param-field-input @error('contact') is-invalid @enderror"
                               value="{{ old('contact', Auth::user()->contact) }}"
                               placeholder="+226 XX XX XX XX">
                        @error('contact')<span class="param-field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="param-form-actions">
                    <button type="submit" class="param-btn-save">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <a href="{{ route('parametres.index') }}" class="param-btn-cancel">Annuler</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
