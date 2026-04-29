@extends('layouts.app')
@section('title', 'Projets à valider')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/validateur.css') }}">
@endpush

@section('content')
<div class="valid-page">

    {{-- Header --}}
    <div class="valid-header">
        <div>
            <h1 class="valid-header-title">Projets à valider</h1>
            <p class="valid-header-sub">{{ $projets->total() }} projet(s) en attente de validation</p>
        </div>
        <a href="{{ route('validateur.projets.mes_projets') }}" class="valid-btn valid-btn-outline">
            <i class="fas fa-history"></i> Mes projets traités
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="valid-alert valid-alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    {{-- Filtres --}}
    <form method="GET" action="{{ route('validateur.projets.index') }}" id="filterForm">
        <div class="valid-search-bar">
            <div class="valid-search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" name="search" id="searchInput"
                       value="{{ request('search') }}"
                       placeholder="Rechercher par titre ou code...">
            </div>

            <select name="secteur_id" class="valid-select"
                    onchange="document.getElementById('filterForm').submit()">
                <option value="">Tous les secteurs</option>
                @foreach($secteurs as $secteur)
                <option value="{{ $secteur->id }}" {{ request('secteur_id') == $secteur->id ? 'selected' : '' }}>
                    {{ $secteur->nomSecteur }}
                </option>
                @endforeach
            </select>

            <button type="submit" class="valid-filter-btn">
                <i class="fas fa-filter"></i> Filtrer
            </button>

            @if(request('search') || request('secteur_id'))
            <a href="{{ route('validateur.projets.index') }}" class="valid-reset-btn">
                <i class="fas fa-times"></i> Réinitialiser
            </a>
            @endif
        </div>
    </form>

    {{-- Liste --}}
    @forelse($projets as $projet)
    <div class="valid-projet-row approuve">

        <div class="valid-projet-avatar">
            {{ strtoupper(substr(optional($projet->secteur)->nomSecteur ?? $projet->titre, 0, 1)) }}
        </div>

        <div class="valid-projet-info">
            <div class="valid-projet-top">
                <span class="valid-projet-code">{{ $projet->codeProjet }}</span>
                <span class="valid-projet-titre">{{ $projet->titre }}</span>
            </div>
            <p class="valid-projet-meta">
                <span><i class="fas fa-user"></i>{{ optional($projet->porteur)->nomComplet ?? '—' }}</span>
                <span><i class="fas fa-tag"></i>{{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
                @if($projet->montantDemande)
                <span><i class="fas fa-coins"></i><strong>{{ number_format($projet->montantDemande, 0, ',', ' ') }} F CFA</strong></span>
                @endif
                @if($projet->dateApprobation)
                <span><i class="fas fa-calendar-check"></i>Approuvé le {{ $projet->dateApprobation->format('d/m/Y') }}</span>
                @endif
            </p>
        </div>

        <div class="valid-projet-badges">
            <span class="valid-badge valid-badge-approuve">
                <span class="valid-dot" style="background:#0d9488;"></span>
                Approuvé
            </span>
            <a href="{{ route('validateur.projets.show', $projet) }}"
                class="valid-btn valid-btn-primary" style="font-size:.75rem;padding:7px 13px;">
                <i class="fas fa-eye"></i> Examiner
            </a>
        </div>
    </div>
    @empty
    <div class="valid-empty">
        <i class="fas fa-check-double" style="color:var(--valid-primary);"></i>
        <p>Aucun projet en attente de validation.</p>
    </div>
    @endforelse

    <div class="valid-pagination">
        {{ $projets->withQueryString()->links() }}
    </div>

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
    }, 450);
});
</script>
@endpush
@endsection
