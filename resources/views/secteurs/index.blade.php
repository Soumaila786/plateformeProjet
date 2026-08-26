@extends('layouts.app')

@section('title', "Secteurs d'activité")

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <a href="{{ route('parametres.index') }}">Paramètres</a>
    <span>/</span>
    <span>Secteurs d'activité</span>
@endsection

@section('page-header')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/parametres.css') }}">
    @endpush

    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Secteurs d'activité</h1>
            <p class="page-header-sub">{{ $secteurs->total() }} secteur{{ $secteurs->total() > 1 ? 's' : '' }} au total</p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('parametres.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a>
            @can('secteurs.gerer')<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#form-ajout-secteur"><i class="fas fa-plus me-1"></i>Créer un secteur</button>@endcan
        </div>
    </div>

    @include('secteurs.partials._liste_filtres')
@endsection

@section('content')
    @can('secteurs.gerer')
        <div class="collapse mb-4" id="form-ajout-secteur"><div class="card border-0"><div class="card-body"><h5 class="fw-bold mb-3">Ajouter un secteur d’activité</h5><form method="POST" action="{{ route('admin.secteurs.store') }}" class="row g-2 align-items-end">@csrf<div class="col-md-4"><label class="form-label">Nom</label><input name="nomSecteur" class="form-control" required maxlength="255"></div><div class="col-md-6"><label class="form-label">Description</label><input name="description" class="form-control" maxlength="500"></div><div class="col-md-2"><button class="btn btn-primary w-100" type="submit"><i class="fas fa-plus me-1"></i>Ajouter</button></div></form></div></div></div>
    @endcan
    @include('secteurs.partials._liste_lignes')

    @can('secteurs.gerer')
        @include('modals.secteur-form')
    @endcan
@endsection
