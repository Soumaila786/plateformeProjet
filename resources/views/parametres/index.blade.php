@extends('layouts.app')
@section('title', 'Paramètres')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/parametre.css') }}">
@endpush
@section('content')
<div class="parametres-page">
    <div class="param-header">
        <h1 class="param-title">Paramètres</h1>
        <p class="param-subtitle">Configuration de votre compte</p>
    </div>
    <div class="param-list">
        <a href="{{ route('parametres.profil') }}" class="param-card">
            <div class="param-icon"><i class="fas fa-user"></i></div>
            <div class="param-info">
                <p class="param-label">Profil</p>
                <p class="param-desc">Modifier vos informations personnelles</p>
            </div>
            <i class="fas fa-chevron-right param-arrow"></i>
        </a>
        <a href="{{ route('parametres.securite') }}" class="param-card">
            <div class="param-icon"><i class="fas fa-shield-alt"></i></div>
            <div class="param-info">
                <p class="param-label">Sécurité</p>
                <p class="param-desc">Mot de passe et authentification</p>
            </div>
            <i class="fas fa-chevron-right param-arrow"></i>
        </a>
        <a href="{{ route('parametres.notifications') }}" class="param-card">
            <div class="param-icon"><i class="fas fa-bell"></i></div>
            <div class="param-info">
                <p class="param-label">Notifications</p>
                <p class="param-desc">Préférences de notification</p>
            </div>
            <i class="fas fa-chevron-right param-arrow"></i>
        </a>
        <a href="{{ route('parametres.general') }}" class="param-card">
            <div class="param-icon"><i class="fas fa-cog"></i></div>
            <div class="param-info">
                <p class="param-label">Général</p>
                <p class="param-desc">Langue, fuseau horaire</p>
            </div>
            <i class="fas fa-chevron-right param-arrow"></i>
        </a>
    </div>
</div>
@endsection
