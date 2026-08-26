@extends('layouts.app')

@section('title', 'Types de projets')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Tableau de bord</a><span>/</span>
    <a href="{{ route('parametres.index') }}">Paramètres</a><span>/</span>
    <span>Types de projets</span>
@endsection

@section('content')
    @push('styles')<link rel="stylesheet" href="{{ asset('css/parametres.css') }}">@endpush
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div><h1 class="page-header-title">Types de projets</h1><p class="page-header-sub">Gérez les catégories proposées aux porteurs.</p></div>
        <div class="d-flex align-items-center gap-2 flex-wrap"><a href="{{ route('parametres.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#form-ajout-type"><i class="fas fa-plus me-1"></i>Créer un type</button></div>
    </div>
    @include('partials._flash')
    <div class="collapse mb-4" id="form-ajout-type"><div class="card border-0"><div class="card-body">
        <h5 class="fw-bold mb-3">Ajouter un type</h5>
        <form method="POST" action="{{ route('admin.types-projets.store') }}" class="row g-2 align-items-end">@csrf
            <div class="col-md-4"><label class="form-label">Nom</label><input name="nom" class="form-control" required maxlength="255"></div>
            <div class="col-md-6"><label class="form-label">Description</label><input name="description" class="form-control" maxlength="1000"></div>
            <div class="col-md-2"><button class="btn btn-primary w-100" type="submit"><i class="fas fa-plus me-1"></i>Ajouter</button></div>
        </form>
    </div></div></div>
    <div class="card border-0"><div class="card-body p-0"><div class="table-responsive"><table class="table mb-0">
        <thead><tr><th class="ps-4">Type</th><th>Description</th><th>Projets</th><th>État</th><th class="text-end pe-4">Actions</th></tr></thead>
        <tbody>@forelse($types as $type)<tr>
            <td class="ps-4"><strong>{{ $type->nom }}</strong></td><td>{{ $type->description ?: '—' }}</td><td>{{ $type->projets_count }}</td>
            <td><span class="badge {{ $type->actif ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $type->actif ? 'Actif' : 'Inactif' }}</span></td>
            <td class="text-end pe-4"><div class="d-flex justify-content-end gap-2">
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#edit-type-{{ $type->id }}"><i class="fas fa-pen"></i></button>
                <form method="POST" action="{{ route('admin.types-projets.toggle-status', $type) }}">@csrf<button class="btn btn-sm btn-outline-secondary" title="Activer ou désactiver"><i class="fas fa-power-off"></i></button></form>
                @if($type->projets_count === 0)<form method="POST" action="{{ route('admin.types-projets.destroy', $type) }}" onsubmit="return confirm('Supprimer ce type ?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form>@endif
            </div></td>
        </tr><tr class="collapse" id="edit-type-{{ $type->id }}"><td colspan="5"><form method="POST" action="{{ route('admin.types-projets.update', $type) }}" class="row g-2 p-3">@csrf @method('PUT')<div class="col-md-4"><input name="nom" value="{{ $type->nom }}" class="form-control" required></div><div class="col-md-6"><input name="description" value="{{ $type->description }}" class="form-control"></div><div class="col-md-2"><button class="btn btn-primary w-100">Enregistrer</button></div></form></td></tr>
        @empty<tr><td colspan="5" class="text-center py-4 text-muted">Aucun type de projet.</td></tr>@endforelse</tbody>
    </table></div></div></div>
@endsection
