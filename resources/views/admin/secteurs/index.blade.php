@extends('layouts.app')

@section('title', 'Secteurs')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

<div class="projets-page">

    <div class="projets-header">
        <div>
            <h1 class="projets-title">Secteurs d'activité</h1>
            <p class="projets-subtitle">{{ $secteurs->count() }} secteur{{ $secteurs->count() > 1 ? 's' : '' }}</p>
        </div>
        <a href="{{ route('admin.secteurs.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Nouveau secteur
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-error"><i class="fas fa-times-circle"></i> {{ session('error') }}</div>
    @endif

    {{-- Cards Grid --}}
    <div class="cards-grid">
        @forelse($secteurs as $secteur)
        <div class="secteur-card">
            <div class="secteur-card-top">
                <div class="secteur-icon">
                    <i class="fas fa-tag"></i>
                </div>
                <div>
                    @if($secteur->statutSecteur)
                        <span class="status-badge status-green">Actif</span>
                    @else
                        <span class="status-badge status-red">Inactif</span>
                    @endif
                </div>
            </div>

            <h3 class="secteur-card-nom">{{ $secteur->nomSecteur }}</h3>

            @if($secteur->description)
            <p class="secteur-card-desc">{{ Str::limit($secteur->description, 80) }}</p>
            @else
            <p class="secteur-card-desc" style="font-style:italic;">Aucune description.</p>
            @endif

            <div class="secteur-card-footer">
                <span class="secteur-projets-count">
                    <i class="fas fa-folder"></i>
                    {{ $secteur->projets->count() }} projet{{ $secteur->projets->count() > 1 ? 's' : '' }}
                </span>
                <div class="user-card-footer" style="border:none;padding:0;">
                    <a href="{{ route('admin.secteurs.edit', $secteur) }}" class="btn-icon" title="Modifier">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.secteurs.toggle-status', $secteur) }}" style="display:inline;">
                        @csrf
                        <button type="submit"
                                class="btn-icon {{ $secteur->statutSecteur ? 'btn-icon-warning' : 'btn-icon-success' }}"
                                title="{{ $secteur->statutSecteur ? 'Désactiver' : 'Activer' }}">
                            <i class="fas {{ $secteur->statutSecteur ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.secteurs.destroy', $secteur) }}"
                            onsubmit="return confirm('Supprimer ce secteur ?')" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-icon btn-icon-danger" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="cards-empty" style="grid-column:1/-1;">
            <i class="fas fa-tags"></i>
            <p>Aucun secteur trouvé.</p>
        </div>
        @endforelse
    </div>

</div>

@endsection
