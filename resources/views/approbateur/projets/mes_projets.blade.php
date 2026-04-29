@extends('layouts.app')
@section('title', 'Mes projets traités')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/approbateur.css') }}">
@endpush

@section('content')
<div class="aprob-page">

    {{-- Header --}}
    <div class="aprob-header">

        <div>
            <h1 class="aprob-header-title">Mes projets traités</h1>
            <p class="aprob-header-sub">
                {{ $projets->total() }}
                projet{{ $projets->total() > 1 ? 's' : '' }}
                traité{{ $projets->total() > 1 ? 's' : '' }}
            </p>
        </div>

        <a href="{{ route('approbateur.projets.index') }}" class="aprob-btn aprob-btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Projets à approuver
        </a>

    </div>

    {{-- Filtres --}}
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">

        <div class="aprob-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput"
                    placeholder="Rechercher par titre ou code..."
                    value="{{ request('search') }}">
        </div>

        <select id="secteurSelect" class="aprob-select">
            <option value="">Tous les secteurs</option>
            @foreach($secteurs as $secteur)
            <option value="{{ $secteur->id }}" {{ request('secteur_id') == $secteur->id ? 'selected' : '' }}>
                {{ $secteur->nomSecteur }}
            </option>
            @endforeach
        </select>

        <div class="aprob-status-filters">
            @php
                $statuts = [
                    '' => 'Tous',
                    'en_examen'=>'En examen',
                    'approuve'=>'Approuvé',
                    'rejete'=>'Rejeté'
                ];
            @endphp
            @foreach($statuts as $val => $label)
            <a href="{{ route('approbateur.projets.mes_projets', array_merge(request()->query(), ['statut'=>$val])) }}"
                class="aprob-status-filter {{ request('statut','') === $val ? 'active' : '' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>

        @if(request('search') || request('secteur_id') || request('statut'))
        <a href="{{ route('approbateur.projets.mes_projets') }}" class="aprob-reset-btn">
            <i class="fas fa-times"></i>
            Réinitialiser
        </a>
        @endif
    </div>

    {{-- Liste --}}
    @forelse($projets as $projet)
    @php
        $stMap = [
            'en_examen' => ['lbl'=>'En examen', 'cls'=>'aprob-badge-en_examen', 'dot'=>'#f97316'],
            'approuve'  => ['lbl'=>'Approuvé',  'cls'=>'aprob-badge-approuve',  'dot'=>'#22c55e'],
            'rejete'    => ['lbl'=>'Rejeté',    'cls'=>'aprob-badge-rejete',    'dot'=>'#ef4444'],
        ];
        $st = $stMap[$projet->statutProjet] ?? ['lbl'=>$projet->statutProjet,'cls'=>'aprob-badge-brouillon','dot'=>'#9ca3af'];
        $dateTraitement = $projet->dateApprobation ?? $projet->updated_at;
    @endphp

    <div class="aprob-projet-row {{ $projet->statutProjet }}">

        <div class="aprob-projet-avatar">
            {{ strtoupper(substr(optional($projet->secteur)->nomSecteur ?? $projet->titre, 0, 1)) }}
        </div>

        <div class="aprob-projet-info">

            <div class="aprob-projet-top">
                <span class="aprob-projet-code">{{ $projet->codeProjet }}</span>
                <span class="aprob-projet-titre">{{ $projet->titre }}</span>
            </div>

            <p class="aprob-projet-meta">
                <span><i class="fas fa-user"></i>{{ optional($projet->porteur)->nomComplet ?? '—' }}</span>
                <span><i class="fas fa-tag"></i>{{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
                @if($projet->montantDemande)
                <span>
                    <i class="fas fa-coins"></i>
                    <strong>{{ number_format($projet->montantDemande, 0, ',', ' ') }} F CFA</strong>
                </span>
                @endif
                @if($dateTraitement)
                <span>
                    <i class="fas fa-calendar-check"></i>
                    Traité le {{ $dateTraitement->format('d/m/Y') }}
                </span>
                @endif
            </p>

        </div>

        <div class="aprob-projet-badges">
            <span class="aprob-badge {{ $st['cls'] }}">
                <span class="aprob-dot" style="background:{{ $st['dot'] }};"></span>
                {{ $st['lbl'] }}
            </span>
            <a href="{{ route('approbateur.projets.show', $projet) }}"
                class="aprob-btn aprob-btn-outline aprob-btn-icon" title="Voir">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>
    @empty
    <div class="aprob-empty">
        <i class="fas fa-folder-open"></i>
        <p>
            @if(request('statut') || request('search') || request('secteur_id'))
                Aucun projet ne correspond à votre recherche.
            @else
                Aucun projet traité pour l'instant.
            @endif
        </p>
    </div>
    @endforelse

    {{-- Pagination --}}
    <div class="aprob-pagination">
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

    document.getElementById('secteurSelect').addEventListener('change', function () {
        const url = new URL(window.location.href);
        if (this.value) url.searchParams.set('secteur_id', this.value);
        else url.searchParams.delete('secteur_id');
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

</script>
@endpush
@endsection
