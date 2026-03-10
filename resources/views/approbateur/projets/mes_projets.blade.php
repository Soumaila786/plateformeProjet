@extends('layouts.app')

@section('title', 'Mes projets traités')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/projet.css') }}">
@endpush

@section('content')

<div class="projets-page">

    {{-- ── Header ── --}}
    <div class="projets-header">
        <div>
            <h1 class="projets-title">Mes projets traités</h1>
            <p class="projets-subtitle">{{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} traité{{ $projets->total() > 1 ? 's' : '' }}</p>
        </div>
    </div>

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
                    'en_examen' => 'En examen',
                    'approuve'  => 'Approuvé',
                    'rejete'    => 'Rejeté',
                ];
            @endphp
            @foreach($statuts as $val => $label)
            <a href="{{ route('approbateur.mes-projets', array_merge(request()->query(), ['statut' => $val, 'search' => request('search')])) }}"
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
                        <th>Montant demandé</th>
                        <th>Statut</th>
                        <th>Date traitement</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projets as $projet)
                    @php
                        $statusClass = [
                            'en_examen' => 'status-yellow',
                            'approuve'  => 'status-green',
                            'rejete'    => 'status-red',
                        ][$projet->statutProjet] ?? 'status-gray';
                        $statusLabel = [
                            'en_examen' => 'En examen',
                            'approuve'  => 'Approuvé',
                            'rejete'    => 'Rejeté',
                        ][$projet->statutProjet] ?? $projet->statutProjet;
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ route('approbateur.projets.show', $projet) }}" class="projet-code">
                                {{ $projet->codeProjet }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('approbateur.projets.show', $projet) }}" class="projet-titre">
                                {{ $projet->titre }}
                            </a>
                        </td>
                        <td class="td-muted">{{ optional($projet->porteur)->nomComplet ?? '—' }}</td>
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
                            {{-- Date approbation ou date rejet (updated_at) --}}
                            @if($projet->dateApprobation)
                                {{ $projet->dateApprobation->format('d/m/Y') }}
                            @else
                                {{ $projet->updated_at->format('d/m/Y') }}
                            @endif
                        </td>
                        <td>
                            <div class="td-actions">
                                <a href="{{ route('approbateur.projets.show', $projet) }}"
                                   class="btn-icon" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="td-empty">
                            <i class="fas fa-folder-open"></i>
                            <p>
                                @if(request('statut') || request('search'))
                                    Aucun projet ne correspond à votre recherche.
                                @else
                                    Aucun projet traité pour l'instant.
                                @endif
                            </p>
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
