@extends('layouts.app')

@section('title', 'Demandes à planifier')

@section('breadcrumb')
    <a href="{{ route('planificateur.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <span>Demandes à planifier</span>
@endsection

@section('page-header')
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Demandes de planification</h1>
            <p class="page-header-sub">{{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} au total</p>
        </div>
        <a href="{{ route('planificateur.projets.traites') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-history"></i> Projets traités
        </a>
    </div>

    @include('projets.partials._liste_filtres')
@endsection

@section('content')
    @include('projets.partials._liste_lignes', ['routeShow' => 'planificateur.projets.show'])
@endsection
