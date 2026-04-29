@extends('layouts.app')
@section('title', 'Ajouter une activité')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/porteur.css') }}">
@endpush

@section('content')
<div class="projets-page">

    {{-- Header --}}
    <div class="page-header">
        <a href="{{ route('porteur.projets.show', $projet) }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-header-info">
            <div>
                <h1 class="projets-title">Ajouter une activité de planification</h1>
                <p class="projets-subtitle">{{ $projet->codeProjet }} — {{ $projet->titre }}</p>
            </div>
        </div>
    </div>

    {{-- Erreurs --}}
    @if($errors->any())
    <div class="port-alert port-alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <ul style="margin:0;padding-left:16px;">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    {{-- Formulaire --}}
    <form method="POST" action="{{ route('porteur.planifications.store', $projet) }}">
        @csrf
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-tasks"></i>
                <span>Détails de l'activité</span>
            </div>
            <div class="form-card-body">

                {{-- Activité --}}
                <div class="form-grid-1">
                    <div class="form-group">
                        <label class="form-label">
                            Activité de planification <span class="req">*</span>
                        </label>
                        <input type="text" name="activitePlanification"
                                value="{{ old('activitePlanification') }}"
                                class="form-input"
                                placeholder="Ex : Mise en œuvre du projet" required>
                        @error('activitePlanification')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Indicateur + Unité + Période + Coût --}}
                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Indicateur</label>
                        <input type="text" name="indicateur"
                                value="{{ old('indicateur') }}"
                                class="form-input"
                                placeholder="Ex : Nombre de bénéficiaires">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unité de l'indicateur</label>
                        <input type="text" name="uniteIndicateur"
                                value="{{ old('uniteIndicateur') }}"
                                class="form-input"
                                placeholder="Ex : Personnes, %, Km">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Période</label>
                        <input type="text" name="periode"
                                value="{{ old('periode') }}"
                                class="form-input"
                                placeholder="Ex : T1 2026, Annuel">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Coût estimatif (F CFA)</label>
                        <input type="number" name="coutEstimatif"
                                value="{{ old('coutEstimatif') }}"
                                class="form-input"
                                placeholder="0" min="0" step="1">
                        @error('coutEstimatif')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Résultats --}}
                <div class="form-group" style="margin-top:14px;">
                    <label class="form-label">Résultats attendus</label>
                    <textarea name="resultatsAttendues" rows="3"
                                class="form-textarea"
                                placeholder="Décrire les résultats attendus...">{{ old('resultatsAttendues') }}</textarea>
                </div>

                {{-- Actions --}}
                <div class="form-actions">
                    <a href="{{ route('porteur.projets.show', $projet) }}" class="btn-cancel">
                        Annuler
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
