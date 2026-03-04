@extends('layouts.app')

@section('title', 'Projets')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/projet.css') }}">
@endpush

@section('content')

<div class="projets-page">

    {{-- ── Header ── --}}
    <div class="projets-header">
        <div>
            <h1 class="projets-title">Projets</h1>
            <p class="projets-subtitle">{{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} au total</p>
        </div>
        <a href="{{ route('admin.projets.create') }}" class="btn-add">
            <i class="fas fa-plus"></i>
            Nouveau projet
        </a>
    </div>

    {{-- ── Filtres ── --}}
    <div class="projets-filters">

        {{-- Recherche --}}
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text"
                    id="searchInput"
                    class="search-input"
                    placeholder="Rechercher par titre ou code..."
                    value="{{ request('search') }}">
        </div>

        {{-- Filtres statut --}}
        <div class="status-filters">
            @php
                $statuts = [
                    ''           => 'Tous',
                    'brouillon'  => 'Brouillon',
                    'soumis'     => 'Soumis',
                    'en_examen'  => 'En examen',
                    'approuve'   => 'Approuvé',
                    'valide'     => 'Validé',
                    'rejete'     => 'Rejeté',
                ];
            @endphp
            @foreach($statuts as $val => $label)
            <a href="{{ route('admin.projets.index', array_merge(request()->query(), ['statut' => $val, 'search' => request('search')])) }}"
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
                        <th>Porteur</th>
                        <th>Secteur</th>
                        <th>Budget</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projets as $projet)
                    <tr>
                        <td>
                            <a href="{{ route('admin.projets.show', $projet) }}" class="projet-code">
                                {{ $projet->codeProjet }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.projets.show', $projet) }}" class="projet-titre">
                                {{ $projet->titre }}
                            </a>
                        </td>
                        <td class="td-muted">{{ optional($projet->porteur)->nomComplet ?? '—' }}</td>
                        <td class="td-muted">{{ optional($projet->secteur)->nomSecteur ?? '—' }}</td>
                        <td class="td-budget">{{ number_format($projet->budgetTotal, 0, ',', ' ') }} F CFA</td>
                        <td>
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
                            <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                        </td>
                        <td>
                            <div class="td-actions">
                                <a href="{{ route('admin.projets.show', $projet) }}"
                                    class="btn-icon" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.projets.edit', $projet) }}"
                                    class="btn-icon" title="Modifier">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.projets.destroy', $projet) }}"
                                        onsubmit="return confirm('Supprimer ce projet ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon btn-icon-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="td-empty">
                            <i class="fas fa-folder-open"></i>
                            <p>Aucun projet trouvé</p>
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
    // Recherche avec délai
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
</script>
@endpush

@endsection
