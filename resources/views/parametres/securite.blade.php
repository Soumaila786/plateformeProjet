@extends('layouts.app')

@section('title', 'Sécurité')

@section('breadcrumb')
    <a href="{{ route(auth()->user()->role.'.dashboard') }}">Tableau de bord</a><span>/</span>
    <a href="{{ route('parametres.index') }}">Paramètres</a><span>/</span><span>Sécurité</span>
@endsection

@section('page-header')
    <div class="page-header-top"><div><h1 class="page-header-title">Sécurité</h1><p class="page-header-sub">Protégez l’accès à votre compte.</p></div><a href="{{ route('parametres.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a></div>
@endsection

@section('content')
    @push('styles')<link rel="stylesheet" href="{{ asset('css/parametres.css') }}">@endpush
    @include('parametres.partials._securite')
@endsection