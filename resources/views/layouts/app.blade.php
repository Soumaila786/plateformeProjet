<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles personnalisés -->
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    @stack('styles')

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        /* Layout principal : sidebar + contenu côte à côte */
        .app-layout {
            display: flex;
            height: 100vh;
            width: 100%;
            overflow: hidden;
        }

        /* La sidebar garde sa propre largeur (gérée dans sidebar.css) */
        .app-layout .sidebar {
            flex-shrink: 0; /* ne se compresse pas */
        }

        /* La zone contenu prend TOUT l'espace restant */
        .app-content {
            flex: 1 1 0;        /* grandit pour remplir l'espace */
            min-width: 0;       /* évite le débordement */
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        /* Zone de contenu interne */
        .content-area {
            padding: 1.5rem;
            min-height: 100%;
        }
    </style>
</head>
<body>
    <div class="app-layout">

        @auth
            {{-- Sidebar --}}
            @php $role = Auth::user()->role; @endphp
            @if(view()->exists("partials.sidebar.{$role}"))
                @include("partials.sidebar.{$role}")
            @elseif(view()->exists("partials.sidebars.{$role}"))
                @include("partials.sidebars.{$role}")
            @else
                <div class="sidebar">Sidebar par défaut</div>
            @endif
        @endauth

        {{-- Contenu principal --}}
        <div class="app-content">

            {{-- Messages flash --}}
            @if(session('success') || session('error'))
                <div class="px-4 pt-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                </div>
            @endif

            <div class="content-area">
                @yield('content')
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
