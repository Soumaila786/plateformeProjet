@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('breadcrumb')
    <span>Tableau de bord</span>
@endsection

@section('page-header')
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Bonjour, {{ explode(' ', auth()->user()->nomComplet)[0] ?? '' }}</h1>
            <p class="page-header-sub">Voici un aperçu de votre espace {{ ucfirst(auth()->user()->role) }}</p>
        </div>
    </div>
@endsection

@section('content')
    {{-- Un seul point d'entrée : le partial du rôle connecté est inclus ici.
    Pour ajouter/adapter un dashboard, on ne touche QUE son partial dans
    dashboard/partials/, jamais ce fichier. --}}
    @include('dashboard.partials._' . auth()->user()->role)
@endsection
