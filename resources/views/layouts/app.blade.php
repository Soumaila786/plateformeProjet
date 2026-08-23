<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $sysConfig->get('nom_app', config('app.name')))</title>

    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <script src="{{ asset('js/responsive-sidebar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        * { font-family: 'Poppins', sans-serif; }

        :root {
            --color-primary: {{ $sysConfig->get('couleur_primaire', '#6366f1') }};
            --color-primary-light: {{ $sysConfig->get('couleur_primaire', '#6366f1') }}18;

            /* Couleurs de statut projet — mêmes valeurs que dans les tableaux
               analytiques (Chart.js), pour rester cohérent partout dans l'appli. */
            --status-brouillon: #9ca3af;
            --status-soumis: #6366f1;
            --status-en-examen: #f97316;
            --status-approuve: #22c55e;
            --status-rejete: #ef4444;
            --status-valide: #0d9488;
        }
    </style>
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/ui-polish.css') }}">

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .app-layout {
            display: flex;
            height: 100vh;
            width: 100%;
            overflow: hidden;
        }
        .app-layout .sidebar {
            flex-shrink: 0;
        }
        .app-content {
            flex: 1 1 0;
            min-width: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .app-content__fixed {
            flex-shrink: 0;
        }
        .page-header {
            padding: 1.25rem 1.5rem 0;
        }
        .page-header-top {
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            flex-wrap:wrap;
            gap:.75rem;
        }
        .page-header-title {
            font-size: 1.3rem;
            font-weight: 800;
            margin: 0;
        }
        .page-header-sub {
            font-size: .85rem;
            color: #6b7280;
            margin: 0;
        }
        .page-body {
            flex: 1 1 0;
            min-height: 0;
            overflow-y: auto;
        }
        .content-area {
            padding: 1.5rem;
            min-height: 100%;
        }
    </style>
</head>
<body>

{{-- Mode maintenance : bloquer les non-admins --}}
@php
    $enMaintenance = $sysConfig->get('mode_maintenance', '0') === '1';
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
@endphp

@if($enMaintenance && !$isAdmin)
    @include('partials.maintenance')
@else

<div class="app-layout">
    @auth
        @include('partials.sidebar')
    @endauth

    <div class="app-content">
        <div class="app-content__fixed">
            {{-- Fil d'Ariane transverse, alimenté par @section('breadcrumb') dans chaque vue --}}
            @hasSection('breadcrumb')
                <div class="px-4 pt-3">
                    <nav class="d-flex align-items-center gap-2 small text-muted">
                        @yield('breadcrumb')
                    </nav>
                </div>
            @endif

            {{-- Alertes session : succès / erreur / avertissement --}}
            @include('partials._flash')

            {{-- En-tête de page (titre + sous-titre + filtres) : non scrollable.
                Alimenté par @section('page-header') dans les vues de liste --}}
            @hasSection('page-header')
                <div class="page-header">
                    @yield('page-header')
                </div>
            @endif
        </div>

        {{-- Corps de la page : seule zone scrollable --}}
        <div class="page-body">
            <div class="content-area">
                @yield('content')
            </div>
        </div>
    </div>
</div>

@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
