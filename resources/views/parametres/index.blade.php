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
            <p class="page-header-sub">Gérez votre profil et, pour l'admin, l'ensemble des réglages de l'application</p>
        </div>
    </div>
@endsection

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/parametres.css') }}">
    @endpush

    @include('parametres.partials._tabs')

    @php $onglet = request('onglet', 'profil'); @endphp

    @if ($onglet === 'securite')
        @include('parametres.partials._securite')
    @elseif ($onglet === 'notifications')
        @include('parametres.partials._notifications')
    @else
        @include('parametres.partials._profil')
    @endif
@endsection
