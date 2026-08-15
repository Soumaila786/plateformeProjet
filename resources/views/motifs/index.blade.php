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

    @include('parametres.partials._tabs')

    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Motifs de rejet</h1>
            <p class="page-header-sub">{{ count($motifs) }} motif{{ count($motifs) > 1 ? 's' : '' }} configuré{{ count($motifs) > 1 ? 's' : '' }}</p>
        </div>

        @can('motifs.gerer')
            <button type="button" class="btn btn-primary btn-sm"
                    data-modal-new="modalMotifForm"
                    data-modal-action="{{ route('admin.motifs.store') }}"
                    data-modal-titre-creation="Nouveau motif">
                <i class="fas fa-plus"></i> Nouveau motif
            </button>
        @endcan
    </div>

    @include('motifs.partials._liste_filtres')
@endsection

@section('content')
    @include('motifs.partials._liste_lignes')

    @can('motifs.gerer')
        @include('modals.motif-form')
    @endcan
@endsection
