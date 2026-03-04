@extends('layouts.app')

@section('title', 'Secteurs d\'activité')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/secteur.css') }}">
@endpush

@section('content')

<div class="secteurs-page">

    {{-- ── Header ── --}}
    <div class="secteurs-header">
        <div>
            <h1 class="secteurs-title">Secteurs d'activité</h1>
            <p class="secteurs-subtitle">{{ $secteurs->count() }} secteur{{ $secteurs->count() > 1 ? 's' : '' }}</p>
        </div>
        <a href="{{ route('admin.secteurs.create') }}" class="btn-add">
            <i class="fas fa-plus"></i>
            Ajouter
        </a>
    </div>

    {{-- ── Grille ── --}}
    <div class="secteurs-grid">

        @forelse($secteurs as $secteur)
        <div class="secteur-card">
            <div class="secteur-inner">

                <div class="secteur-icon">
                    <i class="fas fa-building"></i>
                </div>

                <div class="secteur-body">
                    <div class="secteur-name-row">
                        <h3 class="secteur-name">{{ $secteur->nomSecteur }}</h3>
                        <span class="secteur-dot {{ $secteur->statutSecteur ? 'dot-active' : 'dot-inactive' }}"
                              title="{{ $secteur->statutSecteur ? 'Actif' : 'Inactif' }}">
                        </span>
                    </div>
                    <p class="secteur-desc">{{ $secteur->description ?? '—' }}</p>
                    <p class="secteur-count">
                        {{ $secteur->projets->count() }} projets{{ $secteur->projets->count() > 1 ? 's' : '' }}
                    </p>

                    {{-- Actions --}}
                    <div class="secteur-actions">
                        <a href="{{ route('admin.secteurs.edit', $secteur) }}" class="btn-action btn-edit">
                            <i class="fas fa-pencil-alt"></i> Modifier
                        </a>
                        <form method="POST" action="{{ route('admin.secteurs.destroy', $secteur) }}"
                              onsubmit="return confirm('Supprimer ce secteur ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        @empty
        <div class="secteurs-empty">
            <i class="fas fa-building"></i>
            <p>Aucun secteur enregistré.</p>
            <a href="{{ route('admin.secteurs.create') }}" class="btn-add" style="margin-top:0.5rem;">
                <i class="fas fa-plus"></i> Créer le premier secteur
            </a>
        </div>
        @endforelse

    </div>

</div>

@endsection
