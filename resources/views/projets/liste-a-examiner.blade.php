@extends('layouts.app')

@section('title', 'Projets à examiner')

@section('breadcrumb')
    <a href="{{ route('approbateur.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <span>Projets à examiner</span>
@endsection

@section('page-header')
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Projets à examiner</h1>
            <p class="page-header-sub">{{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} au total</p>
        </div>
        <a href="{{ route('approbateur.projets.mes_projets') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-history"></i> Mes projets traités
        </a>
    </div>

    @include('projets.partials._liste_filtres', [
        'secteurs' => $secteurs,
        'statutOptions' => [
            'soumis' => 'Soumis', 'en_examen' => 'En examen', 'approuve' => 'Approuvé', 'rejete' => 'Rejeté',
        ],
    ])
@endsection

@section('content')
    {{-- FIX : nom de route réel = 'approbateur.projets.demande-modification' (tiret) --}}
    @include('projets.partials._liste_lignes', [
        'routeShow' => 'approbateur.projets.show',
        'routeExaminer' => 'approbateur.projets.examiner',
        'routeApprouver' => 'approbateur.projets.approuver',
        'routeRejeter' => 'approbateur.projets.rejeter',
        'routeDemanderModif' => 'approbateur.projets.demande-modification',
    ])
@endsection
