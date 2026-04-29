@extends('layouts.app')
@section('title', 'Mes projets traités')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/validateur.css') }}">
@endpush

@section('content')
<div class="valid-page">

    {{-- Header --}}
    <div class="valid-header">
        <div>
            <h1 class="valid-header-title">Mes projets traités</h1>
            <p class="valid-header-sub">{{ $projets->total() }} projet(s) traité(s)</p>
        </div>
        <a href="{{ route('validateur.projets.index') }}" class="valid-btn-back">
            <i class="fas fa-arrow-left"></i> À valider
        </a>
    </div>

    {{-- Filtres --}}
    <form method="GET" action="{{ route('validateur.projets.mes_projets') }}" id="filterForm">
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

            <select name="statut" class="valid-select"
                    onchange="document.getElementById('filterForm').submit()">
                <option value="">Tous les statuts</option>
                <option value="valide" {{ request('statut') === 'valide' ? 'selected' : '' }}>Validés</option>
                <option value="rejete" {{ request('statut') === 'rejete' ? 'selected' : '' }}>Rejetés</option>
            </select>

            <button type="submit" class="valid-filter-btn">
                <i class="fas fa-filter"></i> Filtrer
            </button>

            @if(request('search') || request('secteur_id') || request('statut'))
            <a href="{{ route('validateur.projets.mes_projets') }}" class="valid-reset-btn">
                <i class="fas fa-times"></i> Réinitialiser
            </a>
            @endif
        </div>
    </form>

    {{-- Liste --}}
    @forelse($projets as $projet)
    @php
        $stMap = [
            'valide' => ['lbl'=>'Validé', 'cls'=>'valid-badge-valide', 'dot'=>'#15803d'],
            'rejete' => ['lbl'=>'Rejeté', 'cls'=>'valid-badge-rejete', 'dot'=>'#ef4444'],
        ];
        $st = $stMap[$projet->statutProjet] ?? ['lbl'=>$projet->statutProjet,'cls'=>'','dot'=>'#9ca3af'];
        $dateTraitement = $projet->validated_at ?? $projet->updated_at;
    @endphp

    <div class="valid-projet-row {{ $projet->statutProjet }}">

        <div class="valid-projet-avatar"
             style="{{ $projet->statutProjet === 'rejete' ? 'background:var(--valid-red-light);color:var(--valid-red);border-color:var(--valid-red-border);' : '' }}">
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
                @if($dateTraitement)
                <span><i class="fas fa-calendar-check"></i>Traité le {{ $dateTraitement->format('d/m/Y') }}</span>
                @endif
            </p>
            {{-- Motif rejet --}}
            @if($projet->statutProjet === 'rejete' && $projet->motifRejet)
            <div style="margin-top:6px;padding:6px 10px;background:var(--valid-red-light);
                        border:1px solid var(--valid-red-border);border-radius:var(--valid-radius-md);
                        font-size:.74rem;color:var(--valid-red);">
                <i class="fas fa-comment-alt" style="margin-right:4px;"></i>
                <strong>Motif :</strong> {{ $projet->motifRejet }}
            </div>
            @endif
        </div>

        <div class="valid-projet-badges">
            <span class="valid-badge {{ $st['cls'] }}">
                <span class="valid-dot" style="background:{{ $st['dot'] }};"></span>
                {{ $st['lbl'] }}
            </span>
            <a href="{{ route('validateur.projets.show', $projet) }}"
               class="valid-btn valid-btn-outline valid-btn-icon" title="Voir">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>
    @empty
    <div class="valid-empty">
        <i class="fas fa-folder-open"></i>
        <p>
            @if(request('statut') || request('search') || request('secteur_id'))
                Aucun projet ne correspond à votre recherche.
            @else
                Vous n'avez traité aucun projet pour le moment.
            @endif
        </p>
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
