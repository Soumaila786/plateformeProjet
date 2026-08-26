@extends('layouts.app')

@section('title', 'Paramètres')

@section('breadcrumb')
    <a href="{{ route(auth()->user()->role.'.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <span>Paramètres</span>
@endsection

@section('page-header')
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Paramètres</h1>
            <p class="page-header-sub">Choisissez une rubrique pour gérer votre espace et les référentiels CIFEU.</p>
        </div>
    </div>
@endsection

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/parametres.css') }}">
    @endpush

    @include('parametres.partials._tabs')
@endsection
