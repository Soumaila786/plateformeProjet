@extends('layouts.app')
@section('title', 'Modifier le secteur')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush
@section('content')
<div class="projets-page">
    <div class="page-header">
        <a href="{{ route('admin.secteurs.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i></a>
        <div>
            <h1 class="projets-title">Modifier le secteur</h1>
            <p class="projets-subtitle">{{ $secteur->nomSecteur }}</p>
        </div>
    </div>
    <form action="{{ route('admin.secteurs.update', $secteur) }}" method="POST" class="projet-form">
        @csrf
        @method('PUT')
        <div class="form-card">
            <div class="form-card-header"><i class="fas fa-tags"></i><span>Informations</span></div>
            <div class="form-card-body">
                <div class="form-row">
                    <div class="form-col form-col-full">
                        <label class="field-label">Nom du secteur <span class="required">*</span></label>
                        <input type="text" name="nomSecteur"
                                value="{{ old('nomSecteur', $secteur->nomSecteur) }}"
                                class="field-input @error('nomSecteur') is-invalid @enderror" required>
                        @error('nomSecteur')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-col form-col-full">
                        <label class="field-label">Description</label>
                        <textarea name="description" rows="3"
                                    class="field-input field-textarea @error('description') is-invalid @enderror">{{ old('description', $secteur->description) }}</textarea>
                        @error('description')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-col">
                        <label class="field-label">Statut</label>
                        <label class="toggle-switch">
                            <input type="checkbox" name="statutSecteur"
                                    {{ old('statut', $secteur->statutSecteur) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                            <span class="toggle-label">Actif</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('admin.secteurs.index') }}" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-save"><i class="fas fa-save"></i> Mettre à jour</button>
        </div>
    </form>
</div>
@endsection
