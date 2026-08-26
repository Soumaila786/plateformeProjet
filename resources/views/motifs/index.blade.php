@extends('layouts.app')

@section('title', 'Motifs de rejet')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <a href="{{ route('parametres.index') }}">Paramètres</a>
    <span>/</span>
    <span>Motifs de rejet</span>
@endsection

@section('page-header')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/parametres.css') }}">
    @endpush

    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Motifs de rejet</h1>
            <p class="page-header-sub">{{ count($motifs) }} motif{{ count($motifs) > 1 ? 's' : '' }} configuré{{ count($motifs) > 1 ? 's' : '' }}</p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('parametres.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a>
            @can('motifs.gerer')<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#form-ajout-motif"><i class="fas fa-plus me-1"></i>Créer un motif</button>@endcan
        </div>
    </div>

    @include('motifs.partials._liste_filtres')
@endsection

@section('content')
    @can('motifs.gerer')
        <div class="collapse mb-4" id="form-ajout-motif"><div class="card border-0"><div class="card-body"><h5 class="fw-bold mb-3">Ajouter un motif de rejet</h5><form method="POST" action="{{ route('admin.motifs.store') }}" class="row g-2 align-items-end">@csrf<div class="col-md-10"><label class="form-label">Libellé</label><input name="libelle" class="form-control" required maxlength="255"></div><div class="col-md-2"><button class="btn btn-primary w-100" type="submit"><i class="fas fa-plus me-1"></i>Ajouter</button></div></form></div></div></div>
    @endcan
    @include('motifs.partials._liste_lignes')
    @can('motifs.gerer')
        @include('modals.motif-form')
    @endcan
@endsection
