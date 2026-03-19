@extends('layouts.app')
@section('title', 'Modifier la planification')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/approbDash.css') }}">
@endpush

@section('content')
<div class="vpage">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('approbateur.dashboard') }}"><i class="fas fa-home"></i></a>
        <span>/</span>
        <a href="{{ route('approbateur.projets.index') }}">Projets</a>
        <span>/</span>
        <a href="{{ route('approbateur.projets.show', $projet) }}">{{ $projet->codeProjet }}</a>
        <span>/</span>
        <span>Modifier planification</span>
    </div>

    {{-- Header --}}
    <div class="show-header">
        <div>
            <h1 class="show-title">Modifier la planification</h1>
            <p style="font-size:.78rem;color:#9ca3af;margin:4px 0 0;">
                Projet : <strong style="color:#374151;">{{ $projet->titre }}</strong>
            </p>
        </div>
        <a href="{{ route('approbateur.projets.show', $projet) }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    {{-- Formulaire --}}
    <form method="POST" action="{{ route('approbateur.planification.update', [$projet, $planification]) }}">
        @csrf
        @method('PUT')
        <div class="info-card">

            <div style="display:flex;flex-direction:column;gap:16px;">

                <div class="form-group">
                    <label class="form-label">Activité de planification <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="activitePlanification"
                            value="{{ old('activitePlanification', $planification->activitePlanification) }}"
                            class="form-textarea" style="border-radius:8px;padding:9px 12px;"
                            placeholder="Ex : Mise en œuvre du projet" required>
                    @error('activitePlanification')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">

                    <div class="form-group">
                        <label class="form-label">Indicateur</label>
                        <input type="text" name="indicateur"
                                value="{{ old('indicateur', $planification->indicateur) }}"
                                class="form-textarea" style="border-radius:8px;padding:9px 12px;"
                                placeholder="Ex : Nombre de bénéficiaires">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                    <div class="form-group">
                        <label class="form-label">Unité de l'indicateur</label>
                        <input type="text" name="uniteIndicateur"
                                value="{{ old('uniteIndicateur', $planification->uniteIndicateur) }}"
                                class="form-textarea" style="border-radius:8px;padding:9px 12px;"
                                placeholder="Ex : Personnes, %, Km">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Période</label>
                        <input type="text" name="periode"
                                value="{{ old('periode', $planification->periode) }}"
                                class="form-textarea" style="border-radius:8px;padding:9px 12px;"
                                placeholder="Ex : T1 2026, Annuel">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Résultats attendus</label>
                    <textarea name="resultatsAttendues" rows="3" class="form-textarea"
                                placeholder="Décrire les résultats attendus...">{{ old('resultatsAttendues', $planification->resultatsAttendues) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Coût estimatif (F CFA)</label>
                    <input type="number" name="coutEstimatif"
                            value="{{ old('coutEstimatif', $planification->coutEstimatif) }}"
                            class="form-textarea" style="border-radius:8px;padding:9px 12px;"
                            placeholder="0" min="0" step="1">
                    @error('coutEstimatif')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;
                            padding-top:12px;border-top:1px solid #f3f4f6;">
                    <a href="{{ route('approbateur.projets.show', $projet) }}" class="btn-cancel">
                        Annuler
                    </a>
                    <button type="submit" class="btn-valider" style="width:auto;padding:9px 20px;">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>

            </div>
        </div>
    </form>

</div>
@endsection
