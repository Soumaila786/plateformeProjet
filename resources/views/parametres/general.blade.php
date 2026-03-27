@extends('layouts.app')

@section('title', 'Paramètres généraux')

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
            <h1 class="param-subpage-title">Paramètres généraux</h1>
            <p class="param-subpage-sub">Langue, fuseau horaire et préférences</p>
        </div>
    </div>

    @if(session('success'))
    <div class="param-alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="param-section-card">
        <div class="param-section-header">
            <i class="fas fa-globe"></i><span>Localisation</span>
        </div>
        <div class="param-section-body">
            <form action="{{ route('parametres.general.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="param-form-grid">
                    <div class="param-field">
                        <label class="param-field-label">Langue</label>
                        <select name="langue" class="param-field-input">
                            <option value="fr">🇫🇷 Français</option>
                            <option value="en">🇬🇧 English</option>
                        </select>
                    </div>
                    <div class="param-field">
                        <label class="param-field-label">Fuseau horaire</label>
                        <select name="timezone" class="param-field-input">
                            <option value="Africa/Ouagadougou">Afrique/Ouagadougou (GMT+0)</option>
                            <option value="Africa/Dakar">Afrique/Dakar (GMT+0)</option>
                            <option value="Africa/Abidjan">Afrique/Abidjan (GMT+0)</option>
                            <option value="Africa/Lagos">Afrique/Lagos (GMT+1)</option>
                            <option value="Europe/Paris">Europe/Paris (GMT+1/+2)</option>
                        </select>
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
