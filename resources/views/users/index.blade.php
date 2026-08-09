@extends('layouts.app')

@section('title', 'Utilisateurs')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <span>Utilisateurs</span>
@endsection

@section('page-header')
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Utilisateurs</h1>
            <p class="page-header-sub">
                {{ $users->total() }} utilisateur{{ $users->total() > 1 ? 's' : '' }} au total
            </p>
        </div>

        @can('utilisateurs.gerer')
            <button type="button"
                    class="btn btn-primary btn-sm"
                    data-modal-new="modalUserForm"
                    data-modal-action="{{ route('admin.users.store') }}"
                    data-modal-titre-creation="Nouvel utilisateur">
                <i class="fas fa-plus"></i>
                Nouvel utilisateur
            </button>
        @endcan
    </div>

    @include('users.partials._liste_filtres')
@endsection

@section('content')
    @include('users.partials._liste_lignes')

    @can('utilisateurs.gerer')
        @include('modals.user-form')
    @endcan
@endsection
