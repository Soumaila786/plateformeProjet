@extends('layouts.app')
@section('title', 'Modifier une activité')
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
                <h1 class="projets-title">Modifier l'activité de planification</h1>
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
    <form method="POST" action="{{ route('porteur.planifications.update', [$projet, $planification]) }}">
        @csrf @method('PUT')
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-edit"></i>
                <span>Modifier l'activité</span>
            </div>
            <div class="form-card-body">

                <div class="form-grid-1">
                    <div class="form-group">
                        <label class="form-label">
                            Activité de planification <span class="req">*</span>
                        </label>
                        <input type="text" name="activitePlanification"
                               value="{{ old('activitePlanification', $planification->activitePlanification) }}"
                               class="form-input" required>
                        @error('activitePlanification')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Indicateur</label>
                        <input type="text" name="indicateur"
                               value="{{ old('indicateur', $planification->indicateur) }}"
                               class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unité de l'indicateur</label>
                        <input type="text" name="uniteIndicateur"
                               value="{{ old('uniteIndicateur', $planification->uniteIndicateur) }}"
                               class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Période</label>
                        <input type="text" name="periode"
                               value="{{ old('periode', $planification->periode) }}"
                               class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Coût estimatif (F CFA)</label>
                        <input type="number" name="coutEstimatif"
                               value="{{ old('coutEstimatif', $planification->coutEstimatif) }}"
                               class="form-input" min="0" step="1">
                        @error('coutEstimatif')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group" style="margin-top:14px;">
                    <label class="form-label">Résultats attendus</label>
                    <textarea name="resultatsAttendues" rows="3"
                                class="form-textarea">{{ old('resultatsAttendues', $planification->resultatsAttendues) }}</textarea>
                </div>

                <div class="form-actions">
                    <a href="{{ route('porteur.projets.show', $projet) }}" class="btn-cancel">
                        Annuler
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
