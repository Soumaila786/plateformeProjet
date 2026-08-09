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
            <p class="page-header-sub">Gérez votre profil, votre sécurité et vos notifications</p>
        </div>
    </div>
@endsection

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/parametres.css') }}">
    @endpush

    @php $onglet = request('onglet', 'profil'); @endphp

    <div class="param-tabs">
        <a href="{{ route('parametres.index', ['onglet' => 'profil']) }}" class="param-tab {{ $onglet === 'profil' ? 'active' : '' }}">
            <i class="fas fa-user me-1"></i> Profil
        </a>
        <a href="{{ route('parametres.index', ['onglet' => 'securite']) }}" class="param-tab {{ $onglet === 'securite' ? 'active' : '' }}">
            <i class="fas fa-shield-halved me-1"></i> Sécurité
        </a>
        <a href="{{ route('parametres.index', ['onglet' => 'notifications']) }}" class="param-tab {{ $onglet === 'notifications' ? 'active' : '' }}">
            <i class="fas fa-bell me-1"></i> Notifications
        </a>
    </div>

    @if ($onglet === 'securite')
        @include('parametres.partials._securite')
    @elseif ($onglet === 'notifications')
        @include('parametres.partials._notifications')
    @else
        @include('parametres.partials._profil')
    @endif
@endsection
