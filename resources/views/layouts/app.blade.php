<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- APRÈS (local) --}}
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    @stack('styles')
    <style>
        html, body { height: 100%; margin: 0; padding: 0; overflow: hidden; }
        .app-layout { display: flex; height: 100vh; width: 100%; overflow: hidden; }
        .app-layout .sidebar { flex-shrink: 0; }
        .app-content { flex: 1 1 0; min-width: 0; height: 100vh; overflow-y: auto; transition: all 0.3s ease; }
        .content-area { padding: 1.5rem; min-height: 100%; }
    </style>
</head>
<body>
<div class="app-layout">
    @auth
        @include('partials.sidebar')
    @endauth
    <div class="app-content">
        @if(session('success') || session('error') || session('warning'))
        <div class="px-4 pt-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
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
