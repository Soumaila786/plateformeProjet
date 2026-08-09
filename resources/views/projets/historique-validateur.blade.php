@extends('layouts.app')

@section('title', 'Mes projets traités')

@section('breadcrumb')
    <a href="{{ route('validateur.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <span>Mes projets traités</span>
@endsection

@section('page-header')
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Mes projets traités</h1>
            <p class="page-header-sub">{{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} au total</p>
        </div>
        <a href="{{ route('validateur.projets.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-inbox"></i> À valider
        </a>
    </div>

    @include('projets.partials._liste_filtres', [
        'secteurs' => $secteurs,
        'statutOptions' => ['valide' => 'Validé', 'rejete' => 'Rejeté'],
    ])
@endsection

@section('content')
    @include('projets.partials._liste_lignes', ['routeShow' => 'validateur.projets.show'])
@endsection
