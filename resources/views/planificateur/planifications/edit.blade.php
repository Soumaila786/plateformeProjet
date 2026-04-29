@extends('layouts.app')
@section('title', 'Modifier une activité')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/planifDash.css') }}">
@endpush

@section('content')
<div class="plan-page">

    {{-- Breadcrumb --}}
    <div class="plan-breadcrumb">
        <a href="{{ route('planificateur.dashboard') }}"><i class="fas fa-home"></i></a>
        <span>/</span>
        <a href="{{ route('planificateur.projets.index') }}">Projets</a>
        <span>/</span>
        <a href="{{ route('planificateur.projets.show', $projet) }}">{{ $projet->codeProjet }}</a>
        <span>/</span>
        <span>Modifier activité</span>
    </div>

    {{-- Header --}}
    <div class="plan-header">
        <div>
            <h1 class="plan-header-title">Modifier l'activité de planification</h1>
            <p class="plan-header-sub">
                Projet : <strong style="color:var(--plan-text-gray);">{{ $projet->titre }}</strong>
            </p>
        </div>
        <a href="{{ route('planificateur.projets.show', $projet) }}" class="plan-btn-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    {{-- Erreurs --}}
    @if($errors->any())
    <div class="plan-alert plan-alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <ul style="margin:0;padding-left:16px;">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    {{-- Formulaire --}}
    <form method="POST" action="{{ route('planificateur.planifications.update', [$projet, $planification]) }}">
        @csrf @method('PUT')
        <div class="plan-form-card">
            <div class="plan-form-card-head">
                <i class="fas fa-edit"></i> Modifier l'activité
            </div>
            <div class="plan-form-card-body">

                <div class="plan-form-grid-1">
                    <div class="plan-form-group">
                        <label class="plan-form-label">
                            Activité de planification <span class="req">*</span>
                        </label>
                        <input type="text" name="activitePlanification"
                               value="{{ old('activitePlanification', $planification->activitePlanification) }}"
                               class="plan-form-input" required>
                        @error('activitePlanification')
                        <p class="plan-form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="plan-form-grid-2">
                    <div class="plan-form-group">
                        <label class="plan-form-label">Indicateur</label>
                        <input type="text" name="indicateur"
                               value="{{ old('indicateur', $planification->indicateur) }}"
                               class="plan-form-input">
                    </div>
                    <div class="plan-form-group">
                        <label class="plan-form-label">Unité de l'indicateur</label>
                        <input type="text" name="uniteIndicateur"
                               value="{{ old('uniteIndicateur', $planification->uniteIndicateur) }}"
                               class="plan-form-input">
                    </div>
                </div>

                <div class="plan-form-grid-2">
                    <div class="plan-form-group">
                        <label class="plan-form-label">Période</label>
                        <input type="text" name="periode"
                               value="{{ old('periode', $planification->periode) }}"
                               class="plan-form-input">
                    </div>
                    <div class="plan-form-group">
                        <label class="plan-form-label">Coût estimatif (F CFA)</label>
                        <input type="number" name="coutEstimatif"
                               value="{{ old('coutEstimatif', $planification->coutEstimatif) }}"
                               class="plan-form-input" min="0" step="1">
                        @error('coutEstimatif')
                        <p class="plan-form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="plan-form-group">
                    <label class="plan-form-label">Résultats attendus</label>
                    <textarea name="resultatsAttendues" rows="3"
                              class="plan-form-textarea">{{ old('resultatsAttendues', $planification->resultatsAttendues) }}</textarea>
                </div>

                <div class="plan-form-actions">
                    <a href="{{ route('planificateur.projets.show', $projet) }}" class="plan-btn-cancel">
                        Annuler
                    </a>
                    <button type="submit" class="plan-btn-save">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
