@extends('layouts.app')

@section('title', 'Projets à valider')

@section('breadcrumb')
    <a href="{{ route('validateur.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <span>Projets à valider</span>
@endsection

@section('page-header')
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Projets à valider</h1>
            <p class="page-header-sub">{{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} au total</p>
        </div>
        <a href="{{ route('validateur.projets.mes_projets') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-history"></i> Mes projets traités
        </a>
    </div>

    @include('projets.partials._liste_filtres', ['secteurs' => $secteurs])
@endsection

@section('content')
    {{-- FIX : nom de route réel = 'validateur.projets.demande-modification' (tiret) --}}
    @include('projets.partials._liste_lignes', [
        'routeShow' => 'validateur.projets.show',
        'routeValider' => 'validateur.projets.valider',
        'routeRejeter' => 'validateur.projets.rejeter',
        'routeDemanderModif' => 'validateur.projets.demande-modification',
    ])
@endsection
