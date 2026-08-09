@extends('layouts.app')

@section('title', 'Projets')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <span>Projets</span>
@endsection

@section('page-header')
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Tous les projets</h1>
            <p class="page-header-sub">{{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} au total</p>
        </div>
    </div>

    @include('projets.partials._liste_filtres', [
        'statutOptions' => [
            'brouillon' => 'Brouillon', 'soumis' => 'Soumis', 'en_examen' => 'En examen',
            'approuve' => 'Approuvé', 'valide' => 'Validé', 'rejete' => 'Rejeté',
        ],
    ])
@endsection

@section('content')
    @include('projets.partials._liste_lignes', ['routeShow' => 'admin.projets.show'])
@endsection
