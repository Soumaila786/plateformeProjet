@extends('layouts.app')

@section('title', 'Notifications')

@section('breadcrumb')
    <a href="{{ route(auth()->user()->role.'.dashboard') }}">Tableau de bord</a><span>/</span>
    <a href="{{ route('parametres.index') }}">Paramètres</a><span>/</span><span>Notifications</span>
@endsection

@section('page-header')
    <div class="page-header-top"><div><h1 class="page-header-title">Notifications</h1><p class="page-header-sub">Choisissez les alertes importantes que vous souhaitez recevoir.</p></div><a href="{{ route('parametres.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a></div>
@endsection

@section('content')
    @push('styles')<link rel="stylesheet" href="{{ asset('css/parametres.css') }}">@endpush
    @include('parametres.partials._notifications')
@endsection