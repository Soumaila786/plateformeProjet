@extends('layouts.app')

@section('title', 'Journal des activités')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/journal.css') }}">
@endpush

@section('content')
<div class="journal-page">

    {{-- HEADER FIXE --}}
    <div class="journal-header">
        <div class="journal-title-row">
            <h1 class="journal-title">
                <i class="fas fa-history"></i>
                Journal des activités
                @if(isset($logs) && count($logs))
                <span class="journal-count">{{ count($logs) }} entrée(s)</span>
                @endif
            </h1>
            <a href="{{ request()->fullUrl() }}" class="btn-reset">
                <i class="fas fa-sync-alt"></i> Actualiser
            </a>
        </div>

        {{-- Filtres --}}
        <form method="GET" class="journal-filters" id="filterForm">

            <div class="filter-search">
                <i class="fas fa-search"></i>
                <input type="text" name="search"
                        placeholder="Rechercher dans les logs..."
                        value="{{ request('search') }}">
            </div>

            {{-- Pills niveau --}}
            <div class="level-pills">
                @php
                    $levels = [
                        '' => 'Tous',
                        'info' => 'INFO',
                        'warning' => 'WARNING',
                        'error' => 'ERROR'
                    ];
                @endphp
                
                @foreach($levels as $val => $lbl)
                <a href="{{ request()->fullUrlWithQuery(['type' => $val, 'search' => request('search')]) }}"
                    class="level-pill {{ $val ?: 'all' }} {{ request('type', '') === $val ? 'active' : '' }}">
                    {{ $lbl }}
                </a>
                @endforeach
            </div>

            <button type="submit" class="btn-filter">
                <i class="fas fa-filter"></i> Filtrer
            </button>

            @if(request('search') || request('type'))
            <a href="{{ route('admin.logs.index') }}" class="btn-reset">
                <i class="fas fa-times"></i> Réinitialiser
            </a>
            @endif

        </form>
    </div>

    {{-- CORPS SCROLLABLE --}}
    <div class="journal-body">
        <div class="log-table-wrap">
            <table class="log-table">
                <thead>
                    <tr>
                        <th style="width:160px;">Date / Heure</th>
                        <th style="width:110px;">Niveau</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($logs as $log)
                @php
                    $level = strtolower($log['level'] ?? 'info');
                    $rowClass = 'row-' . $level;
                    $badgeClass = 'log-' . $level;
                    $icons = [
                        'info'     => 'fa-info-circle',
                        'warning'  => 'fa-exclamation-triangle',
                        'error'    => 'fa-times-circle',
                        // 'debug'    => 'fa-bug',
                        'critical' => 'fa-skull-crossbones',
                    ];
                    $icon = $icons[$level] ?? 'fa-circle';
                @endphp
                <tr class="{{ $rowClass }}">
                    <td>
                        <span class="log-date">{{ $log['date'] ?? '—' }}</span>
                    </td>
                    <td>
                        <span class="log-badge {{ $badgeClass }}">
                            <i class="fas {{ $icon }}" style="font-size:.65rem;"></i>
                            {{ strtoupper($level) }}
                        </span>
                    </td>
                    <td>
                        <p class="log-message {{ in_array($level, ['error','warning']) ? $level : '' }}">
                            {{ $log['message'] ?? '—' }}
                        </p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">
                        <div class="log-empty">
                            <i class="fas fa-check-circle" style="color:#22c55e;"></i>
                            <p>Aucune entrée de log trouvée.</p>
                            @if(request('search') || request('type'))
                            <a href="{{ route('admin.logs.index') }}" style="font-size:.78rem;color:#7c3aed;">
                                Effacer les filtres
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination si disponible --}}
        @if(isset($logs) && method_exists($logs, 'hasPages') && $logs->hasPages())
        <div style="margin-top:14px;">
            {{ $logs->withQueryString()->links() }}
        </div>
        @endif
    </div>

</div>
@endsection