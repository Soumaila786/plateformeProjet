@extends('layouts.app')

@section('title', 'Tableau analytique')

@section('breadcrumb')
    <a href="{{ route(auth()->user()->role.'.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <span>Analytique</span>
@endsection

@section('page-header')
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Tableau analytique</h1>
            <p class="page-header-sub">Statistiques et tendances de vos projets</p>
        </div>
    </div>
@endsection

@section('content')
    @include('analytique.partials._' . auth()->user()->role)
@endsection
