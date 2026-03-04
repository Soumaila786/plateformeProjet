@extends('layouts.app')

@section('title', 'Modifier un secteur')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/secteurs.css') }}">
@endpush

@section('content')

<div class="secteurs-page">

    <div class="page-header">
        <a href="{{ route('admin.secteurs.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="secteurs-title">Modifier le secteur</h1>
            <p class="secteurs-subtitle">{{ $secteur->nomSecteur }}</p>
        </div>
    </div>

    <form action="{{ route('admin.secteurs.update', $secteur) }}" method="POST" class="secteur-form">
        @csrf
        @method('PUT')

        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-building"></i>
                <span>Informations du secteur</span>
            </div>
            <div class="form-card-body">

                <div class="form-col-full">
                    <label for="nomSecteur" class="field-label">
                        Nom du secteur <span class="required">*</span>
                    </label>
                    <input type="text"
                           id="nomSecteur" name="nomSecteur"
                           value="{{ old('nomSecteur', $secteur->nomSecteur) }}"
                           class="field-input @error('nomSecteur') is-invalid @enderror"
                           required>
                    @error('nomSecteur')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col-full">
                    <label for="description" class="field-label">Description</label>
                    <textarea id="description" name="description"
                              class="field-input field-textarea @error('description') is-invalid @enderror"
                              rows="3">{{ old('description', $secteur->description) }}</textarea>
                    @error('description')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-check-row">
                    <input class="field-checkbox" type="checkbox"
                           id="statutSecteur" name="statutSecteur"
                           {{ old('statutSecteur', $secteur->statutSecteur) ? 'checked' : '' }}>
                    <label for="statutSecteur" class="field-label" style="margin:0; cursor:pointer;">
                        Secteur actif
                    </label>
                </div>

            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.secteurs.index') }}" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i>
                Mettre à jour
            </button>
        </div>

    </form>

</div>

@endsection
