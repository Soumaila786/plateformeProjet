@extends('layouts.app')

@section('title', 'Préférences de notifications')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('parametres.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="mb-0 ms-3">Préférences de notifications</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('parametres.notifications.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" checked>
                        <label class="form-check-label" for="email_notifications">
                            Recevoir les notifications par email
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="projet_notifications" name="projet_notifications" checked>
                        <label class="form-check-label" for="projet_notifications">
                            Notifications pour les projets
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="commentaire_notifications" name="commentaire_notifications" checked>
                        <label class="form-check-label" for="commentaire_notifications">
                            Notifications pour les commentaires
                        </label>
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