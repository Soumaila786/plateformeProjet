@extends('layouts.app')

@section('title', $projet->titre)

@section('breadcrumb')
    <a href="{{ route(auth()->user()->role.'.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <span>{{ $projet->codeProjet }}</span>
@endsection

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/projet-show.css') }}">
    @endpush

    @include('projets.partials._header')

    <div class="row g-4">
        <div class="col-lg-8 ps-main">
            @include('projets.partials._main_info')
            @include('projets.partials._activities')
            @include('projets.partials._documents')
        </div>
        <div class="col-lg-4">
            @include('projets.partials._history')
        </div>
    </div>
@endsection
