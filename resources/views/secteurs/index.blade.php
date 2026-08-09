@extends('layouts.app')

@section('title', 'Secteurs d\'activité')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <span>Secteurs d'activité</span>
@endsection

@section('page-header')
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Secteurs d'activité</h1>
            <p class="page-header-sub">{{ $secteurs->total() }} secteur{{ $secteurs->total() > 1 ? 's' : '' }} au total</p>
        </div>

        @can('secteurs.gerer')
            <button type="button" class="btn btn-primary btn-sm"
                    data-modal-new="modalSecteurForm"
                    data-modal-action="{{ route('admin.secteurs.store') }}"
                    data-modal-titre-creation="Nouveau secteur">
                <i class="fas fa-plus"></i> Nouveau secteur
            </button>
        @endcan
    </div>

    @include('secteurs.partials._liste_filtres')
@endsection

@section('content')
    @include('secteurs.partials._liste_lignes')

    @can('secteurs.gerer')
        @include('modals.secteur-form')
    @endcan
@endsection
