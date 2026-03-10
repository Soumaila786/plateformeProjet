@extends('layouts.app')

@section('title', 'Mes projets')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/projet.css') }}">
@endpush

@section('content')

<div class="projets-page">

    {{-- ── Header ── --}}
    <div class="projets-header">
        <div>
            <h1 class="projets-title">Mes projets</h1>
            <p class="projets-subtitle">{{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} au total</p>
        </div>
        <a href="{{ route('porteur.projets.create') }}" class="btn-add">
            <i class="fas fa-plus"></i>
            Nouveau projet
        </a>
    </div>

    {{-- ── Alerte modification demandée ── --}}
    @php
        $nbModif = $projets->getCollection()
            ->filter(fn($p) => $p->messageModification && $p->statutProjet === 'brouillon')
            ->count();
    @endphp
    @if($nbModif > 0)
    <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>{{ $nbModif }} projet(s)</strong> nécessite(nt) des modifications demandées par l'approbateur.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- ── Filtres ── --}}
    <div class="projets-filters">

        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text"
                    id="searchInput"
                    class="search-input"
                    placeholder="Rechercher par titre ou code..."
                    value="{{ request('search') }}">
        </div>

        <div class="status-filters">
            @php
                $statuts = [
                    ''          => 'Tous',
                    'brouillon' => 'Brouillon',
                    'soumis'    => 'Soumis',
                    'en_examen' => 'En examen',
                    'approuve'  => 'Approuvé',
                    'valide'    => 'Validé',
                    'rejete'    => 'Rejeté',
                ];
            @endphp
            @foreach($statuts as $val => $label)
            <a href="{{ route('porteur.projets.index', array_merge(request()->query(), ['statut' => $val, 'search' => request('search')])) }}"
                class="status-filter {{ request('statut', '') === $val ? 'active' : '' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>

    </div>

    {{-- ── Tableau ── --}}
    <div class="projets-table-wrap">
        <div class="table-scroll">
            <table class="projets-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Titre</th>
                        <th>Secteur</th>
                        <th>Montant demandé</th>
                        <th>Statut</th>
                        <th>Date création</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projets as $projet)
                    @php
                        $statusClass = [
                            'brouillon' => 'status-gray',
                            'soumis'    => 'status-blue',
                            'en_examen' => 'status-yellow',
                            'approuve'  => 'status-green',
                            'valide'    => 'status-teal',
                            'rejete'    => 'status-red',
                        ][$projet->statutProjet] ?? 'status-gray';

                        $statusLabel = [
                            'brouillon' => 'Brouillon',
                            'soumis'    => 'Soumis',
                            'en_examen' => 'En examen',
                            'approuve'  => 'Approuvé',
                            'valide'    => 'Validé',
                            'rejete'    => 'Rejeté',
                        ][$projet->statutProjet] ?? $projet->statutProjet;
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ route('porteur.projets.show', $projet) }}" class="projet-code">
                                {{ $projet->codeProjet }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('porteur.projets.show', $projet) }}" class="projet-titre">
                                {{ $projet->titre }}
                            </a>
                            @if($projet->messageModification && $projet->statutProjet === 'brouillon')
                            <br><small style="color:#d97706;font-size:.72rem;">
                                <i class="fas fa-exclamation-triangle"></i> Modification demandée
                            </small>
                            @endif
                        </td>
                        <td class="td-muted">{{ optional($projet->secteur)->nomSecteur ?? '—' }}</td>
                        <td class="td-budget">
                            {{ $projet->montantDemande ? number_format($projet->montantDemande, 0, ',', ' ') . ' F CFA' : '—' }}
                        </td>
                        <td>
                            <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                            @if($projet->statutProjet === 'rejete' && $projet->motifRejet)
                            <br>
                            <small data-bs-toggle="tooltip" title="{{ $projet->motifRejet }}"
                                    style="color:#dc2626;cursor:pointer;font-size:.7rem;">
                                <i class="fas fa-info-circle"></i> Motif
                            </small>
                            @endif
                        </td>
                        <td class="td-muted">
                            {{ optional($projet->dateCreation)->format('d/m/Y') ?? '—' }}
                        </td>
                        <td>
                            <div class="td-actions">
                                <a href="{{ route('porteur.projets.show', $projet) }}"
                                    class="btn-icon" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($projet->isEditable())
                                <a href="{{ route('porteur.projets.edit', $projet) }}"
                                    class="btn-icon" title="Modifier">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                @endif

                                @if($projet->isSubmittable())
                                <form method="POST" action="{{ route('porteur.projets.soumettre', $projet) }}"
                                        onsubmit="return confirm('Soumettre ce projet pour approbation ?')">
                                    @csrf
                                    <button type="submit" class="btn-icon btn-icon-success" title="Soumettre">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                                @endif

                                @if($projet->isDeletable())
                                <form method="POST" action="{{ route('porteur.projets.destroy', $projet) }}"
                                        onsubmit="return confirm('Supprimer définitivement ce projet ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon btn-icon-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="td-empty">
                            <i class="fas fa-folder-open"></i>
                            <p>
                                @if(request('statut') || request('search'))
                                    Aucun projet ne correspond à votre recherche.
                                @else
                                    Vous n'avez pas encore de projet.
                                @endif
                            </p>
                            @if(!request('statut') && !request('search'))
                            <a href="{{ route('porteur.projets.create') }}" class="btn-add mt-2">
                                <i class="fas fa-plus"></i> Créer mon premier projet
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Pagination ── --}}
    @if($projets->hasPages())
    <div class="projets-pagination">
        {{ $projets->withQueryString()->links() }}
    </div>
    @endif

</div>

@push('scripts')
<script>
let timer;
document.getElementById('searchInput').addEventListener('input', function () {
    clearTimeout(timer);
    const val = this.value;
    timer = setTimeout(() => {
        const url = new URL(window.location.href);
        url.searchParams.set('search', val);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }, 400);
});

document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
    new bootstrap.Tooltip(el);
});
</script>
@endpush

@endsection
