@extends('layouts.app')

@section('title', 'Projets à approuver')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/projet.css') }}">
@endpush

@section('content')

<div class="projets-page">

    {{-- Header --}}
    <div class="projets-header">
        <div>
            <h1 class="projets-title">Projets à approuver</h1>
            <p class="projets-subtitle">
                {{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} au total
            </p>
        </div>
    </div>

    {{-- Filtres --}}
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
                    'soumis'    => 'Soumis',
                    'en_examen' => 'En examen',
                    'approuve'  => 'Approuvé',
                    'rejete'    => 'Rejeté',
                ];
            @endphp

            @foreach($statuts as $val => $label)
                <a href="{{ route('approbateur.projets.index',
                    array_merge(request()->query(),
                    ['statut' => $val, 'search' => request('search')])) }}"
                    class="status-filter {{ request('statut','') === $val ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

    </div>

    {{-- Tableau --}}
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
                    <th>Date soumission</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>

                @forelse($projets as $projet)

                    @php
                        $statusClass = [
                            'soumis'=>'status-blue',
                            'en_examen'=>'status-yellow',
                            'approuve'=>'status-green',
                            'rejete'=>'status-red'
                        ][$projet->statutProjet] ?? 'status-gray';

                        $statusLabel = [
                            'soumis'=>'Soumis',
                            'en_examen'=>'En examen',
                            'approuve'=>'Approuvé',
                            'rejete'=>'Rejeté'
                        ][$projet->statutProjet] ?? $projet->statutProjet;
                    @endphp

                    <tr>

                        <td>
                            <a href="{{ route('approbateur.projets.show',$projet) }}"
                                class="projet-code">
                                {{ $projet->codeProjet }}
                            </a>
                        </td>

                        <td>
                            <a href="{{ route('approbateur.projets.show',$projet) }}"
                                class="projet-titre">
                                {{ $projet->titre }}
                            </a>
                        </td>

                        <td class="td-muted">
                            {{ optional($projet->porteur)->nomComplet ?? '—' }}
                        </td>

                        <td class="td-muted">
                            {{ optional($projet->secteur)->nomSecteur ?? '—' }}
                        </td>

                        <td class="td-budget">
                            {{ $projet->montantDemande
                                ? number_format($projet->montantDemande,0,',',' ')
                                .' F CFA'
                                : '—' }}
                        </td>

                        <td>
                            <span class="status-badge {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>

                        <td class="td-muted">
                            {{ optional($projet->dateSoumission)->format('d/m/Y') ?? '—' }}
                        </td>

                        <td>

                            <div class="td-actions">

                                {{-- voir --}}
                                <a href="{{ route('approbateur.projets.show',$projet) }}"
                                    class="btn-icon"
                                    title="Examiner">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- mettre en examen --}}
                                @if($projet->statutProjet === 'soumis')

                                    <form method="POST"
                                            action="{{ route('approbateur.projets.examiner',$projet) }}"
                                            onsubmit="return confirm('Mettre ce projet en examen ?')">

                                        @csrf

                                        <button type="submit"
                                                class="btn-icon btn-icon-warning"
                                                title="Mettre en examen">
                                            <i class="fas fa-search"></i>
                                        </button>

                                    </form>

                                @endif


                                {{-- approuver / rejeter --}}
                                @if($projet->statutProjet === 'en_examen')

                                    <button type="button"
                                            class="btn-icon btn-icon-success"
                                            title="Approuver"
                                            onclick="openApprouver({{ $projet->id }})">

                                        <i class="fas fa-check"></i>

                                    </button>

                                    <button type="button"
                                            class="btn-icon btn-icon-danger"
                                            title="Rejeter"
                                            onclick="openRejeter({{ $projet->id }})">

                                        <i class="fas fa-times"></i>

                                    </button>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="td-empty">
                            <i class="fas fa-folder-open"></i>
                            <p>Aucun projet trouvé.</p>
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>
    </div>


    {{-- Pagination --}}
    @if($projets->hasPages())

        <div class="projets-pagination">
            {{ $projets->withQueryString()->links() }}
        </div>

    @endif

</div>

@endsection
