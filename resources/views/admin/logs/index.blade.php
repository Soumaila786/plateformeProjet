@extends('layouts.app')
@section('title', 'Journal des activités')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/journal.css') }}">
@endpush

@section('content')
<div class="journal-page">

    {{--  HEADER FIXe --}}
    <div class="journal-top">
        <div class="journal-title-row">
            <div>
                <h1 class="journal-title">
                    <i class="fas fa-history"></i>
                    Journal des activités
                    @if(isset($logs) && count($logs) > 0)
                    <span class="journal-count">{{ count($logs) }} entrée(s)</span>
                    @endif
                </h1>
                <p class="journal-subtitle">Historique complet des événements système</p>
            </div>
            <a href="{{ request()->url() }}" class="btn-reset-f">
                <i class="fas fa-sync-alt"></i> Actualiser
            </a>
        </div>

        {{-- Filtres --}}
        <form method="GET" action="{{ route('admin.logs.index') }}" class="journal-filters">

            <div class="filter-search">
                <i class="fas fa-search fi"></i>
                <input type="text" name="search"
                        placeholder="Rechercher dans les logs..."
                        value="{{ request('search') }}">
            </div>

            {{-- Pills niveau --}}
            <div class="level-pills">
                @php
                    $niveaux = [
                        ''        => ['lbl'=>'Tous',    'cls'=>'lp-all'],
                        'info'    => ['lbl'=>'INFO',    'cls'=>'lp-info'],
                        'warning' => ['lbl'=>'WARNING', 'cls'=>'lp-warning'],
                        'error'   => ['lbl'=>'ERROR',   'cls'=>'lp-error'],
                        'debug'   => ['lbl'=>'DEBUG',   'cls'=>'lp-debug'],
                    ];
                @endphp
                @foreach($niveaux as $val => $n)
                <a href="{{ request()->fullUrlWithQuery(['type'=>$val,'search'=>request('search')]) }}"
                    class="level-pill {{ $n['cls'] }} {{ request('type','') === $val ? 'active' : '' }}">
                    {{ $n['lbl'] }}
                </a>
                @endforeach
            </div>

            <button type="submit" class="btn-filter">
                <i class="fas fa-filter"></i> Filtrer
            </button>

            @if(request('search') || request('type'))
            <a href="{{ route('admin.logs.index') }}" class="btn-reset-f">
                <i class="fas fa-times"></i> Réinitialiser
            </a>
            @endif

        </form>
    </div>

    {{--  ALERTES (errors + warnings) --}}
    @php
        $errors_count   = isset($logs) ? collect($logs)->where('level', 'error')->count()    : 0;
        $warnings_count = isset($logs) ? collect($logs)->where('level', 'warning')->count()  : 0;
        $critical_count = isset($logs) ? collect($logs)->where('level', 'critical')->count() : 0;
    @endphp

    @if($critical_count > 0 || $errors_count > 0 || $warnings_count > 0)
    <div class="journal-alerts">

        @if($critical_count > 0)
        <div class="alert-banner alert-error" id="alertCritical">
            <i class="fas fa-skull-crossbones al-icon"></i>
            <div class="al-body">
                <p class="al-title">{{ $critical_count }} erreur(s) critique(s) détectée(s)</p>
                <p class="al-msg">Des erreurs critiques nécessitent une attention immédiate.</p>
            </div>
            <button class="alert-close" onclick="this.closest('.alert-banner').remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        @if($errors_count > 0)
        <div class="alert-banner alert-error" id="alertErrors">
            <i class="fas fa-times-circle al-icon"></i>
            <div class="al-body">
                <p class="al-title">{{ $errors_count }} erreur(s) dans les logs</p>
                <p class="al-msg">Des erreurs ont été enregistrées. Vérifiez les entrées marquées en rouge.</p>
            </div>
            <button class="alert-close" onclick="this.closest('.alert-banner').remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        @if($warnings_count > 0)
        <div class="alert-banner alert-warning" id="alertWarnings">
            <i class="fas fa-exclamation-triangle al-icon"></i>
            <div class="al-body">
                <p class="al-title">{{ $warnings_count }} avertissement(s) détecté(s)</p>
                <p class="al-msg">Des avertissements ont été enregistrés. Vérifiez les entrées en orange.</p>
            </div>
            <button class="alert-close" onclick="this.closest('.alert-banner').remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

    </div>
    @endif

    {{--  CORPS + TABLEAU --}}
    <div class="journal-body">
        <div class="log-table-wrap">
            <div class="log-scroll">
                <table class="log-table">

                    {{-- THEAD FIXE via CSS sticky --}}
                    <thead>
                        <tr>
                            <th style="width:155px;">Date / Heure</th>
                            <th style="width:110px;">Niveau</th>
                            <th>Message</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($logs as $log)
                    @php
                        $level     = strtolower($log['level'] ?? 'info');
                        $rowClass  = 'row-'   . $level;
                        $badgeCls  = 'lb-'    . $level;
                        $msgCls    = in_array($level, ['error','warning','critical']) ? 'msg-'.$level : '';
                        $icons = [
                            'info'     => 'fa-info-circle',
                            'warning'  => 'fa-exclamation-triangle',
                            'error'    => 'fa-times-circle',
                            'debug'    => 'fa-bug',
                            'critical' => 'fa-skull-crossbones',
                        ];
                        $icon = $icons[$level] ?? 'fa-circle';
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td>
                            <span class="log-date">{{ $log['date'] ?? '—' }}</span>
                        </td>
                        <td>
                            <span class="log-badge {{ $badgeCls }}">
                                <i class="fas {{ $icon }}" style="font-size:.6rem;"></i>
                                {{ strtoupper($level) }}
                            </span>
                        </td>
                        <td>
                            <p class="log-msg {{ $msgCls }}">{{ $log['message'] ?? '—' }}</p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">
                            <div class="log-empty">
                                <i class="fas fa-check-circle" style="color:#22c55e;"></i>
                                <p>Aucune entrée de log trouvée.</p>
                                @if(request('search') || request('type'))
                                <a href="{{ route('admin.logs.index') }}"
                                    style="font-size:.78rem;color:#7c3aed;font-weight:600;">
                                    <i class="fas fa-times"></i> Effacer les filtres
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if(isset($logs) && method_exists($logs, 'hasPages') && $logs->hasPages())
        <div style="margin-top:12px;flex-shrink:0;">
            {{ $logs->withQueryString()->links() }}
        </div>
        @endif
    </div>

</div>
@endsection