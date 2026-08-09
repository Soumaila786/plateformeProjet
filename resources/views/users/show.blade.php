@extends('layouts.app')

@section('title', $user->nomComplet)

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <a href="{{ route('admin.users.index') }}">Utilisateurs</a>
    <span>/</span>
    <span>{{ $user->nomComplet }}</span>
@endsection

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/listes-projets.css') }}">
    @endpush

    @php
        $champsModifierUser = [
            'nomComplet' => $user->nomComplet, 'email' => $user->email, 'role' => $user->role,
            'fonction' => $user->fonction, 'matricule' => $user->matricule, 'contact' => $user->contact,
            'organisation' => $user->organisation, 'specialite' => $user->specialite,
            'service' => $user->service, 'poste' => $user->poste,
            'dateDebutMandat' => optional($user->dateDebutMandat)->format('Y-m-d'),
            'dateFinMandat' => optional($user->dateFinMandat)->format('Y-m-d'),
        ];
    @endphp

    <x-cards.info class="mb-3">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div class="d-flex align-items-center gap-3">
                <x-avatars.avatar :user="$user" :size="64" />
                <div>
                    <h4 class="fw-bold mb-1">{{ $user->nomComplet }}</h4>
                    <div class="text-muted small">
                        <i class="fas fa-envelope me-1"></i>{{ $user->email }}
                        @if ($user->contact) <span class="mx-2">·</span><i class="fas fa-phone me-1"></i>{{ $user->contact }} @endif
                    </div>
                    <div class="mt-2 d-flex gap-2">
                        <span class="badge bg-primary-subtle text-primary">{{ ucfirst($user->role) }}</span>
                        <span class="badge {{ $user->actif ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                            {{ $user->actif ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
            </div>

            @can('utilisateurs.gerer')
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm"
                            data-modal-edit="modalUserForm"
                            data-modal-action="{{ route('admin.users.update', $user) }}"
                            data-modal-titre-edition="Modifier l'utilisateur"
                            data-modal-fields="{{ json_encode($champsModifierUser) }}">
                        <i class="fas fa-pen"></i> Modifier
                    </button>
                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}"
                          onsubmit="return confirm('{{ $user->actif ? 'Désactiver' : 'Activer' }} ce compte ?')">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                            <i class="fas {{ $user->actif ? 'fa-user-slash' : 'fa-user-check' }}"></i> {{ $user->actif ? 'Désactiver' : 'Activer' }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                          onsubmit="return confirm('Supprimer définitivement cet utilisateur ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            @endcan
        </div>
    </x-cards.info>

    <x-cards.info titre="Informations" icon="fa-id-card">
        <div class="row g-3">
            <div class="col-sm-6 col-lg-4">
                <div class="text-muted small">Fonction</div>
                <div class="fw-semibold">{{ $user->fonction ?? '—' }}</div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="text-muted small">Matricule</div>
                <div class="fw-semibold">{{ $user->matricule ?? '—' }}</div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="text-muted small">Organisation</div>
                <div class="fw-semibold">{{ $user->organisation ?? '—' }}</div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="text-muted small">{{ ucfirst($user->role) }} — détail</div>
                <div class="fw-semibold">{{ $user->detailsRole ?? '—' }}</div>
            </div>
        </div>
    </x-cards.info>

    @can('utilisateurs.gerer')
        @include('modals.user-form')
    @endcan
@endsection
