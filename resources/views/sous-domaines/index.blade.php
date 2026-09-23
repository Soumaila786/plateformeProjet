@extends('layouts.app')

@section('title', 'Sous-domaines')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Tableau de bord</a><span>/</span>
    <a href="{{ route('parametres.index') }}">Paramètres</a><span>/</span>
    <span>Sous-domaines</span>
@endsection

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/parametres.css') }}">
        <link rel="stylesheet" href="{{ asset('css/listes-projets.css') }}">
    @endpush
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="page-header-title">Sous-domaines</h1>
            <p class="page-header-sub">Précisez les domaines proposés aux porteurs.</p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap"><a href="{{ route('parametres.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#form-ajout-sous-domaine"><i class="fas fa-plus me-1"></i>Créer un sous-domaine</button></div>
        </div>
    @include('partials._flash')
    <div class="collapse mb-4" id="form-ajout-sous-domaine"><div class="card border-0"><div class="card-body"><h5 class="fw-bold mb-3">Ajouter un sous-domaine</h5><form method="POST" action="{{ route('admin.sous-domaines.store') }}" class="row g-2 align-items-end">@csrf
        <div class="col-md-4"><label class="form-label">Secteur parent</label><select name="secteur_id" class="form-select" required><option value="">Sélectionner...</option>@foreach($secteurs as $secteur)<option value="{{ $secteur->id }}">{{ $secteur->nomSecteur }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">Nom</label><input name="nom" class="form-control" required maxlength="255"></div><div class="col-md-3"><label class="form-label">Description</label><input name="description" class="form-control" maxlength="1000"></div><div class="col-md-1"><button class="btn btn-primary w-100" type="submit"><i class="fas fa-plus"></i></button></div>
    </form></div></div></div>
    <div>
        @forelse($sousDomaines as $sousDomaine)
            <div class="lp-row">
                <div class="lp-avatar"><i class="fas fa-sitemap"></i></div>
                <div class="lp-info">
                    <div class="lp-top"><span class="lp-titre">{{ $sousDomaine->nom }}</span></div>
                    <p class="lp-meta">
                        <span><i class="fas fa-layer-group"></i>{{ $sousDomaine->secteur->nomSecteur ?? 'Secteur non défini' }}</span>
                        <span><i class="fas fa-folder"></i>{{ $sousDomaine->projets_count }} projet{{ $sousDomaine->projets_count > 1 ? 's' : '' }}</span>
                        @if($sousDomaine->description)<span><i class="fas fa-align-left"></i>{{ $sousDomaine->description }}</span>@endif
                    </p>
                </div>
                <div class="lp-badges">
                    <span class="badge {{ $sousDomaine->actif ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">{{ $sousDomaine->actif ? 'Actif' : 'Inactif' }}</span>
                    <button type="button" class="lp-btn" title="Modifier" data-bs-toggle="collapse" data-bs-target="#edit-sub-{{ $sousDomaine->id }}"><i class="fas fa-pen"></i></button>
                    <form method="POST" action="{{ route('admin.sous-domaines.toggle-status', $sousDomaine) }}" class="d-inline">@csrf<button type="submit" class="lp-btn {{ $sousDomaine->actif ? '' : 'lp-btn-green' }}" title="{{ $sousDomaine->actif ? 'Désactiver' : 'Activer' }}"><i class="fas {{ $sousDomaine->actif ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i></button></form>
                    @if($sousDomaine->projets_count === 0)<form method="POST" action="{{ route('admin.sous-domaines.destroy', $sousDomaine) }}" class="d-inline" onsubmit="return confirm('Supprimer ce sous-domaine ?')">@csrf @method('DELETE')<button type="submit" class="lp-btn lp-btn-red" title="Supprimer"><i class="fas fa-trash"></i></button></form>@endif
                </div>
            </div>
            <div class="collapse mb-3" id="edit-sub-{{ $sousDomaine->id }}">
                <form method="POST" action="{{ route('admin.sous-domaines.update', $sousDomaine) }}" class="lp-row align-items-end">@csrf @method('PUT')
                    <div class="flex-grow-1"><label class="form-label small">Secteur parent</label><select name="secteur_id" class="form-select" required>@foreach($secteurs as $secteur)<option value="{{ $secteur->id }}" {{ $sousDomaine->secteur_id === $secteur->id ? 'selected' : '' }}>{{ $secteur->nomSecteur }}</option>@endforeach</select></div>
                    <div class="flex-grow-1"><label class="form-label small">Nom</label><input name="nom" value="{{ $sousDomaine->nom }}" class="form-control" required></div>
                    <div class="flex-grow-1"><label class="form-label small">Description</label><input name="description" value="{{ $sousDomaine->description }}" class="form-control"></div>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check me-1"></i>Enregistrer</button>
                </form>
            </div>
        @empty
            <div class="lp-empty"><i class="fas fa-sitemap"></i><p class="mb-0">Aucun sous-domaine.</p></div>
        @endforelse
    </div>
    <div class="mt-3">{{ $sousDomaines->withQueryString()->links() }}</div>
@endsection
