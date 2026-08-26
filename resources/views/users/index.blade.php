@extends('layouts.app')

@section('title', 'Utilisateurs')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <a href="{{ route('parametres.index') }}">Paramètres</a>
    <span>/</span>
    <span>Utilisateurs</span>
@endsection

@section('page-header')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/parametres.css') }}">
    @endpush

    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Utilisateurs</h1>
            <p class="page-header-sub">{{ $users->total() }} utilisateur{{ $users->total() > 1 ? 's' : '' }} au total</p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('parametres.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a>
            @can('utilisateurs.gerer')
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#form-ajout-utilisateur" aria-expanded="false"><i class="fas fa-plus me-1"></i>Créer un utilisateur</button>
            @endcan
        </div>
    </div>

    @include('users.partials._liste_filtres')
@endsection

@section('content')
    @can('utilisateurs.gerer')
        <div class="collapse mb-4" id="form-ajout-utilisateur"><div class="card border-0"><div class="card-body">
            <h5 class="fw-bold mb-3">Ajouter un utilisateur</h5>
            <form method="POST" action="{{ route('admin.users.store') }}">@csrf
                @include('users.partials._form')
                <div class="d-flex justify-content-end mt-3"><button class="btn btn-primary" type="submit"><i class="fas fa-plus me-1"></i>Créer le compte</button></div>
            </form>
        </div></div></div>
    @endcan
    @include('users.partials._liste_lignes')
    @can('utilisateurs.gerer')
        @include('modals.user-form')
    @endcan
@endsection

@push('scripts')
    <script src="{{ asset('js/users-form.js') }}"></script>
@endpush
