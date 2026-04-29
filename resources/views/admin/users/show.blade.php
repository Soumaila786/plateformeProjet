@extends('layouts.app')

@section('title', $user->nomComplet)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

<div class="projets-page">

    <div class="page-header">

        <a href="{{ route('admin.users.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div class="page-header-info">

            <div>
                <h1 class="projets-title">{{ $user->nomComplet }}</h1>
                <p class="projets-subtitle">{{ $user->email }}</p>
            </div>

            <div class="page-header-actions">

                <a href="{{ route('admin.users.edit', $user) }}" class="btn-edit-main">
                    <i class="fas fa-pencil-alt"></i> Modifier
                </a>

                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" style="display:inline;">
                    @csrf

                    <button type="submit" class="btn-save {{ $user->actif ? 'btn-warning' : 'btn-success' }}">
                        <i class="fas {{ $user->actif ? 'fa-user-times' : 'fa-user-check' }}"></i>
                        {{ $user->actif ? 'Désactiver' : 'Activer' }}
                    </button>

                </form>

            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="form-card">

        <div class="form-card-header">
            <i class="fas fa-user"></i>
            <span>Informations</span>
        </div>

        <div class="form-card-body">

            <div class="info-grid">

                <div class="info-item">
                    <span class="info-label">Nom complet</span>
                    <span class="info-value">
                        {{ $user->nomComplet }}
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">
                        {{ $user->email }}
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">Rôle</span>
                    <span class="role-badge role-{{ $user->role }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">Fonction</span>
                    <span class="role-badge role-{{ $user->fonction }}">
                        {{ $user->fonction ?? '—'}}
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">Matricule</span>
                    <span class="role-badge role-{{ $user->matricule }}">
                        {{ $user->matricule ?? '—' }}
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">Statut</span>
                    @if($user->actif)
                        <span class="status-badge status-green">Actif</span>
                    @else
                        <span class="status-badge status-red">Inactif</span>
                    @endif
                </div>

                <div class="info-item">
                    <span class="info-label">Téléphone</span>
                    <span class="info-value">
                        {{ $user->contact ?? '—' }}
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">Organisation</span>
                    <span class="info-value">
                        {{ $user->organisation ?? '—' }}
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">Créé le</span>
                    <span class="info-value">
                        {{  optional($user->dateCreation)->format('d/m/Y') ??
                            optional($user->created_at)->format('d/m/Y') ??
                            '—'
                        }}
                    </span>
                </div>

                @if($user->role === 'porteur')
                    {{-- Champs spécifiques porteur --}}
                    <div class="info-item">
                        <span class="info-label">Structure</span>
                        <span class="info-value">
                            {{ $user->porteur->structure ?? '—' }}
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Spécialité </span>
                        <span class="info-value">
                            {{ $user->porteur->specialite ?? '—' }}
                        </span>
                    </div>

                @endif

                @if($user->role === 'validateur')
                    {{-- Champs spécifiques validateur --}}
                    <div class="info-item">
                        <span class="info-label">Date début Mandat</span>
                        <span class="info-value">
                            {{ $user->validateur->dateDebutMandat ?? '—' }}
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Date fin Mandat</span>
                        <span class="info-value">
                            {{ $user->validateur->dateFinMandat ?? '—' }}
                        </span>
                    </div>

                @endif


                @if ($user->role === 'approbateur')
                <div class="info-item">
                    <span class="info-label">Service</span>
                    <span class="info-value">
                        {{ $user->approbateur->service ?? '—' }}
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">Poste</span>
                    <span class="info-value">
                        {{ $user->approbateur->poste ?? '—' }}
                    </span>
                </div>

                @endif

                @if ($user->role === 'planificateur')
                    <div class="info-item">
                        <span class="info-label">Service</span>
                        <span class="info-value">
                            {{ $user->planificateur->service ?? '—' }}
                        </span>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Projets de l'utilisateur --}}
    @if($user->projets->count() > 0)
    <div class="form-card mt-3">
        <div class="form-card-header">
            <i class="fas fa-folder"></i>
            <span>Projets ({{ $user->projets->count() }})</span>
        </div>
        <div class="form-card-body">
            <div class="table-scroll">
                <table class="projets-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Titre</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($user->projets as $projet)
                        @php
                            $sc = [
                                'brouillon'=>'status-gray',
                                'soumis'=>'status-blue',
                                'en_examen'=>'status-yellow',
                                'approuve'=>'status-green',
                                'valide'=>'status-teal',
                                'rejete'=>'status-red'
                            ];
                            $sl = [
                                'brouillon'=>'Brouillon',
                                'soumis'=>'Soumis',
                                'en_examen'=>'En examen',
                                'approuve'=>'Approuvé',
                                'valide'=>'Validé',
                                'rejete'=>'Rejeté'
                            ];
                        @endphp
                        <tr>
                            <td>{{ $projet->codeProjet }}</td>
                            <td>{{ Str::limit($projet->titre, 40) }}</td>
                            <td>
                                <span class="status-badge {{ $sc[$projet->statutProjet] ?? 'status-gray' }}">
                                    {{ $sl[$projet->statutProjet] ?? $projet->statutProjet }}
                                </span>
                            </td>
                            <td>{{ optional($projet->dateCreation)->format('d/m/Y') ?? '—' }}</td>
                            <td>
                                <a href="{{ route('admin.projets.show', $projet) }}" class="btn-icon">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</div>

@endsection
