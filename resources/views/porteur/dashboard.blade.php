@extends('layouts.app')

@section('title', 'Tableau de bord')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')

<div class="dashboard">

    {{---- Header -----}}
    <div class="dash-header">
        <div>
            <h1 class="dash-title">Tableau de bord</h1>
            <p class="dash-subtitle">Vue d'ensemble de la gestion des projets</p>
        </div>
    </div>

</div>

@endsection