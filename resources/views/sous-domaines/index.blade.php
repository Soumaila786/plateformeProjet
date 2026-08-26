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
    <div class="card border-0"><div class="card-body p-0"><div class="table-responsive"><table class="table mb-0"><thead><tr><th class="ps-4">Sous-domaine</th><th>Secteur parent</th><th>Projets</th><th>État</th><th class="text-end pe-4">Actions</th></tr></thead><tbody>
        @forelse($sousDomaines as $sousDomaine)<tr><td class="ps-4"><strong>{{ $sousDomaine->nom }}</strong><div class="small text-muted">{{ $sousDomaine->description }}</div></td><td>{{ $sousDomaine->secteur->nomSecteur ?? '—' }}</td><td>{{ $sousDomaine->projets_count }}</td><td><span class="badge {{ $sousDomaine->actif ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $sousDomaine->actif ? 'Actif' : 'Inactif' }}</span></td><td class="text-end pe-4"><div class="d-flex justify-content-end gap-2"><button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#edit-sub-{{ $sousDomaine->id }}"><i class="fas fa-pen"></i></button><form method="POST" action="{{ route('admin.sous-domaines.toggle-status', $sousDomaine) }}">@csrf<button class="btn btn-sm btn-outline-secondary"><i class="fas fa-power-off"></i></button></form>@if($sousDomaine->projets_count === 0)<form method="POST" action="{{ route('admin.sous-domaines.destroy', $sousDomaine) }}" onsubmit="return confirm('Supprimer ce sous-domaine ?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form>@endif</div></td></tr>
        <tr class="collapse" id="edit-sub-{{ $sousDomaine->id }}"><td colspan="5"><form method="POST" action="{{ route('admin.sous-domaines.update', $sousDomaine) }}" class="row g-2 p-3">@csrf @method('PUT')<div class="col-md-3"><select name="secteur_id" class="form-select" required>@foreach($secteurs as $secteur)<option value="{{ $secteur->id }}" {{ $sousDomaine->secteur_id === $secteur->id ? 'selected' : '' }}>{{ $secteur->nomSecteur }}</option>@endforeach</select></div><div class="col-md-3"><input name="nom" value="{{ $sousDomaine->nom }}" class="form-control" required></div><div class="col-md-4"><input name="description" value="{{ $sousDomaine->description }}" class="form-control"></div><div class="col-md-2"><button class="btn btn-primary w-100">Enregistrer</button></div></form></td></tr>
        @empty<tr><td colspan="5" class="text-center py-4 text-muted">Aucun sous-domaine.</td></tr>@endforelse
    </tbody></table></div></div></div>
@endsection
