@extends('layouts.app')

@section('title', 'Notifications')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/notification.css') }}">
@endpush

@section('content')
<div class="notif-page">

    {{--  Header  --}}
    <div class="notif-header">
        <div>
            <h1 class="notif-page-title">
                <i class="fas fa-bell" style="color:var(--primary);margin-right:10px;"></i>Notifications
            </h1>
            <p class="notif-page-sub">
                @php $nonLues = $notifications->where('statut','non_lu')->count(); @endphp
                @if($nonLues > 0)
                    <span style="color:var(--primary);font-weight:600;">{{ $nonLues }} non lue{{ $nonLues > 1 ? 's' : '' }}</span>
                    · {{ $notifications->total() }} au total
                @else
                    {{ $notifications->total() }} notification{{ $notifications->total() > 1 ? 's' : '' }}
                @endif
            </p>
        </div>

        <div class="notif-actions">
            <form method="POST" action="{{ route($role . '.notifications.toutes-lues') }}">
                @csrf
                <button type="submit" class="btn-mark-read">
                    <i class="fas fa-check-double"></i> Tout marquer lu
                </button>
            </form>
            <form method="POST" action="{{ route($role . '.notifications.destroy-lues') }}"
                    onsubmit="return confirm('Supprimer toutes les notifications lues ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-delete-read">
                    <i class="fas fa-trash"></i> Supprimer les lues
                </button>
            </form>
        </div>
    </div>

    {{--  Succès  --}}
    @if(session('success'))
    <div class="notif-alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    {{--  Liste  --}}
    @if($notifications->count() > 0)
    <div class="notif-list">
        @foreach($notifications as $notif)
        @php
            $isNonLue = $notif->statut === 'non_lu';
            $icons = [
                'statut_change' => ['icon'=>'fa-exchange-alt', 'bg'=>'#eff6ff', 'color'=>'#2563eb'],
                'approbation'   => ['icon'=>'fa-check-circle',  'bg'=>'#f0fdf4', 'color'=>'#16a34a'],
                'validation'    => ['icon'=>'fa-badge-check',   'bg'=>'#f0fdfa', 'color'=>'#0d9488'],
                'rejet'         => ['icon'=>'fa-times-circle',  'bg'=>'#fef2f2', 'color'=>'#dc2626'],
                'modification'  => ['icon'=>'fa-edit',          'bg'=>'#fffbeb', 'color'=>'#d97706'],
                'soumission'    => ['icon'=>'fa-paper-plane',   'bg'=>'#eef2ff', 'color'=>'#6366f1'],
                'info'          => ['icon'=>'fa-info-circle',   'bg'=>'#f9fafb', 'color'=>'#6b7280'],
            ];
            $ic = $icons[$notif->type] ?? $icons['info'];
        @endphp

        <div class="notif-item {{ $isNonLue ? 'non-lue' : 'lue' }}">

            <div class="notif-icon" style="background:{{ $ic['bg'] }};color:{{ $ic['color'] }};">
                <i class="fas {{ $ic['icon'] }}"></i>
            </div>

            <div class="notif-body">
                <p class="notif-message">{{ $notif->message }}</p>
                <div class="notif-meta">
                    <span class="notif-date">
                        <i class="fas fa-clock"></i>
                        {{ $notif->dateEnvoi ? $notif->dateEnvoi->diffForHumans() : '—' }}
                    </span>
                    @if($notif->projet)
                    <a href="{{ route($role . '.projets.show', $notif->projet) }}" class="notif-projet-link">
                        <i class="fas fa-folder-open"></i>
                        {{ $notif->projet->codeProjet }} — {{ Str::limit($notif->projet->titre, 40) }}
                    </a>
                    @endif
                </div>
            </div>

            <div class="notif-side">
                @if($isNonLue)
                <span class="notif-dot" title="Non lue"></span>
                @endif
                <form method="POST"
                        action="{{ route($role . '.notifications.destroy', $notif) }}"
                        onsubmit="return confirm('Supprimer cette notification ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="notif-del-btn" title="Supprimer">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
            </div>

        </div>
        @endforeach
    </div>

    @if($notifications->hasPages())
    {{-- <div class="notif-pagination">{{ $notifications->links() }}</div> --}}
    @endif

    @else
    <div class="notif-list">
        <div class="notif-empty">
            <i class="fas fa-bell-slash"></i>
            <p>Aucune notification pour le moment.</p>
        </div>
    </div>
    @endif

</div>
@endsection
