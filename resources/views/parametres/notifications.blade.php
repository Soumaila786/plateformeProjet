@extends('layouts.app')
@section('title', 'Préférences de notifications')
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
            <h1 class="param-subpage-title">Préférences de notifications</h1>
            <p class="param-subpage-sub">Choisissez comment être notifié</p>
        </div>
    </div>

    @if(session('success'))
    <div class="param-alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="param-section-card">
        <div class="param-section-header">
            <i class="fas fa-bell"></i><span>Canaux de notification</span>
        </div>
        <div class="param-section-body">
            <form action="{{ route('parametres.notifications.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="param-toggle-list">
                    <div class="param-toggle-item">
                        <div class="param-toggle-info">
                            <p class="param-toggle-label">Notifications par email</p>
                            <p class="param-toggle-desc">Recevoir les alertes sur votre adresse email</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="email_notifications" value="1" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="param-toggle-item">
                        <div class="param-toggle-info">
                            <p class="param-toggle-label">Notifications projets</p>
                            <p class="param-toggle-desc">Soumissions, approbations, validations</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="projet_notifications" value="1" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="param-toggle-item">
                        <div class="param-toggle-info">
                            <p class="param-toggle-label">Notifications commentaires</p>
                            <p class="param-toggle-desc">Demandes de modification et observations</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="commentaire_notifications" value="1" checked>
                            <span class="toggle-slider"></span>
                        </label>
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
