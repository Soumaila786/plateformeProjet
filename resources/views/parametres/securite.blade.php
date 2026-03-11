@extends('layouts.app')
@section('title', 'Sécurité')
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
            <h1 class="param-subpage-title">Sécurité</h1>
            <p class="param-subpage-sub">Gérez votre mot de passe</p>
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
            <i class="fas fa-lock"></i><span>Changer le mot de passe</span>
        </div>
        <div class="param-section-body">
            <div class="param-info-box">
                <i class="fas fa-info-circle"></i>
                Choisissez un mot de passe fort d'au moins 8 caractères.
            </div>
            <form action="{{ route('parametres.securite.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="param-form-grid-1">
                    <div class="param-field">
                        <label class="param-field-label">Mot de passe actuel <span class="required">*</span></label>
                        <input type="password" name="current_password"
                                class="param-field-input @error('current_password') is-invalid @enderror"
                                placeholder="••••••••" required>
                        @error('current_password')<span class="param-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="param-field">
                        <label class="param-field-label">Nouveau mot de passe <span class="required">*</span></label>
                        <input type="password" name="new_password"
                                class="param-field-input @error('new_password') is-invalid @enderror"
                                placeholder="••••••••" required>
                        @error('new_password')<span class="param-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="param-field">
                        <label class="param-field-label">Confirmer le nouveau mot de passe <span class="required">*</span></label>
                        <input type="password" name="new_password_confirmation"
                                class="param-field-input"
                                placeholder="••••••••" required>
                    </div>
                </div>
                <div class="param-form-actions">
                    <button type="submit" class="param-btn-save">
                        <i class="fas fa-key"></i> Mettre à jour
                    </button>
                    <a href="{{ route('parametres.index') }}" class="param-btn-cancel">Annuler</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
