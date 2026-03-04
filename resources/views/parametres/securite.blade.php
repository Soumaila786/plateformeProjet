@extends('layouts.app')

@section('title', 'Sécurité')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('parametres.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="mb-0 ms-3">Sécurité</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('parametres.securite.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="field-label">Mot de passe actuel</label>
                    <input type="password" name="current_password" class="field-input" required>
                </div>

                <div class="mb-3">
                    <label class="field-label">Nouveau mot de passe</label>
                    <input type="password" name="new_password" class="field-input" required>
                </div>

                <div class="mb-3">
                    <label class="field-label">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="new_password_confirmation" class="field-input" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection