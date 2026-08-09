@extends('layouts.app')

@section('title', 'Notifications')

@section('breadcrumb')
    <a href="{{ route(auth()->user()->role.'.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <span>Notifications</span>
@endsection

@section('page-header')
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Notifications</h1>
            <p class="page-header-sub">{{ $notifications->total() }} notification{{ $notifications->total() > 1 ? 's' : '' }} au total</p>
        </div>

        <div class="d-flex gap-2">
            <form method="POST" action="{{ route($role.'.notifications.toutes-lues') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-check-double"></i> Tout marquer comme lu
                </button>
            </form>
            <form method="POST" action="{{ route($role.'.notifications.destroy-lues') }}"
                onsubmit="return confirm('Supprimer toutes les notifications déjà lues ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-trash"></i> Supprimer les lues
                </button>
            </form>
        </div>
    </div>
@endsection

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
    @endpush

    @forelse ($notifications as $notif)
        <div class="notif-item {{ $notif->statut === 'non_lu' ? 'is-unread' : '' }}">
            <div class="notif-icon" style="background: color-mix(in srgb, {{ $notif->couleur() }} 15%, white); color: {{ $notif->couleur() }};">
                <i class="fas {{ $notif->icone() }}"></i>
            </div>

            <div class="notif-body">
                <p class="notif-message">{{ $notif->message }}</p>
                <div class="notif-date">{{ optional($notif->dateEnvoi)->format('d/m/Y à H:i') }}</div>
            </div>

            <div class="notif-actions">
                @if ($notif->projet && Route::has($role.'.projets.show'))
                    <a href="{{ route($role.'.projets.show', $notif->projet) }}" class="btn btn-sm btn-link text-decoration-none" title="Voir le projet">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
                <form method="POST" action="{{ route($role.'.notifications.destroy', $notif) }}"
                    onsubmit="return confirm('Supprimer cette notification ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-link text-danger text-decoration-none" title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center text-muted py-5">
            <i class="fas fa-bell-slash" style="font-size:2rem; color: var(--color-border); display:block; margin-bottom:.5rem;"></i>
            <p class="mb-0">Aucune notification pour l'instant.</p>
        </div>
    @endforelse

    <div class="mt-3">
        {{ $notifications->withQueryString()->links() }}
    </div>
@endsection
