@extends('layouts.app')

@section('title', 'Journal des activités')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <a href="{{ route('parametres.index') }}">Paramètres</a>
    <span>/</span>
    <span>Journal des activités</span>
@endsection

@section('page-header')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/listes-projets.css') }}">
        <link rel="stylesheet" href="{{ asset('css/logs.css') }}">
        <link rel="stylesheet" href="{{ asset('css/parametres.css') }}">
    @endpush

    @include('parametres.partials._tabs')

    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Journal des activités</h1>
            <p class="page-header-sub">{{ count($logs) }} entrée{{ count($logs) > 1 ? 's' : '' }} (200 dernières lignes max)</p>
        </div>
    </div>

    <div class="lp-filtres">
        <div class="lp-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Rechercher dans les logs..." value="{{ request('search') }}"
                   data-filter-search="search">
        </div>

        <select class="lp-select" name="type" data-filter-select>
            <option value="">Tous les niveaux</option>
            <option value="error" {{ request('type') === 'error' ? 'selected' : '' }}>Erreur</option>
            <option value="warning" {{ request('type') === 'warning' ? 'selected' : '' }}>Avertissement</option>
            <option value="info" {{ request('type') === 'info' ? 'selected' : '' }}>Info</option>
            <option value="debug" {{ request('type') === 'debug' ? 'selected' : '' }}>Debug</option>
        </select>

        @if (request('search') || request('type'))
            <a href="{{ request()->url() }}" class="lp-reset-btn"><i class="fas fa-times"></i> Réinitialiser</a>
        @endif
    </div>
@endsection

@section('content')
    <x-cards.info>
        @forelse ($logs as $entree)
            @php
                $niveau = is_array($entree) ? ($entree['niveau'] ?? $entree['level'] ?? 'info') : ($entree->niveau ?? $entree->level ?? 'info');
                $message = is_array($entree) ? ($entree['message'] ?? '') : ($entree->message ?? (string) $entree);
                $date = is_array($entree) ? ($entree['date'] ?? null) : ($entree->date ?? null);
                $niveauLower = strtolower($niveau);

                if (strpos($niveauLower, 'error') !== false) {
                    $classeNiveau = 'log-level-error';
                } elseif (strpos($niveauLower, 'warning') !== false) {
                    $classeNiveau = 'log-level-warning';
                } elseif (strpos($niveauLower, 'debug') !== false) {
                    $classeNiveau = 'log-level-debug';
                } else {
                    $classeNiveau = 'log-level-info';
                }
            @endphp
            <div class="log-entry">
                <span class="log-level {{ $classeNiveau }}">{{ strtoupper($niveau) }}</span>
                <span class="log-message">{{ $message }}</span>
                @if ($date)
                    <span class="log-date">{{ $date }}</span>
                @endif
            </div>
        @empty
            <p class="text-muted small text-center py-4 mb-0">Aucune entrée de log trouvée.</p>
        @endforelse
    </x-cards.info>

    @push('scripts')
        <script src="{{ asset('js/filtres-liste.js') }}"></script>
    @endpush
@endsection
