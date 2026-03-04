@extends('layouts.app')

@section('title', 'Paramètres généraux')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('parametres.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="mb-0 ms-3">Paramètres généraux</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('parametres.general.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="field-label">Langue</label>
                    <select name="langue" class="field-input">
                        <option value="fr">Français</option>
                        <option value="en">Anglais</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="field-label">Fuseau horaire</label>
                    <select name="timezone" class="field-input">
                        <option value="Africa/Dakar">Afrique/Dakar (GMT+0)</option>
                        <option value="Europe/Paris">Europe/Paris (GMT+1)</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection