@extends('layouts.app')

@section('title', 'Modifier le profil')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('parametres.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="mb-0 ms-3">Modifier le profil</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('parametres.profil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="field-label">Nom complet</label>
                        <input type="text" name="nomComplet" class="field-input" value="{{ Auth::user()->nomComplet }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="field-label">Email</label>
                        <input type="email" name="email" class="field-input" value="{{ Auth::user()->email }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="field-label">Matricule</label>
                        <input type="text" name="matricule" class="field-input" value="{{ Auth::user()->matricule }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="field-label">Fonction</label>
                        <input type="text" name="fonction" class="field-input" value="{{ Auth::user()->fonction }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="field-label">Contact</label>
                        <input type="text" name="contact" class="field-input" value="{{ Auth::user()->contact }}">
                    </div>
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