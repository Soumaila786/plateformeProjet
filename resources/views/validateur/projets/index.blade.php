@extends('layouts.app')
@section('title', 'Projets à valider')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/validDash.css') }}">
@endpush

@section('content')
<div class="vpage">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Projets à valider</h1>
            <p class="page-sub">{{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} au total</p>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="filters">
        <div class="search-wrap">
            <i class="fas fa-search search-ico"></i>
            <input type="text" id="searchInput" class="search-input"
                    placeholder="Rechercher par titre ou code..."
                    value="{{ request('search') }}">
        </div>
        <select id="secteurFilter" class="filter-select">
            <option value="">Tous les secteurs</option>
            @foreach($secteurs ?? [] as $secteur)
            <option value="{{ $secteur->id }}" {{ request('secteur') == $secteur->id ? 'selected' : '' }}>
                {{ $secteur->nomSecteur }}
            </option>
            @endforeach
        </select>
        <div class="status-pills">
            @php $statuts = ['' => 'Tous', 'approuve' => 'Approuvés', 'valide' => 'Validés', 'rejete' => 'Rejetés']; @endphp
            @foreach($statuts as $val => $lbl)
            <a href="{{ route('validateur.projets.index', array_merge(request()->query(), ['statut'=>$val])) }}"
                class="pill {{ request('statut','') === $val ? 'active' : '' }}">{{ $lbl }}</a>
            @endforeach
        </div>
    </div>

    {{-- Grille projets --}}
    <div class="proj-grid">
        @forelse($projets as $projet)
        @php
            $map = [
                'approuve' => ['lbl'=>'Approuvé','dot'=>'#22c55e','bg'=>'#f0fdf4','color'=>'#15803d'],
                'valide'   => ['lbl'=>'Validé',  'dot'=>'#0d9488','bg'=>'#f0fdfa','color'=>'#0f766e'],
                'rejete'   => ['lbl'=>'Rejeté',  'dot'=>'#ef4444','bg'=>'#fef2f2','color'=>'#b91c1c'],
            ];
            $s = $map[$projet->statutProjet] ?? $map['approuve'];
        @endphp
        <div class="proj-card">
            <div class="proj-card-head">
                <span class="status-badge" style="background:{{ $s['bg'] }};color:{{ $s['color'] }};">
                    <span class="dot" style="background:{{ $s['dot'] }};"></span>{{ $s['lbl'] }}
                </span>
                <span class="proj-code">{{ $projet->codeProjet }}</span>
            </div>
            <h3 class="proj-titre">{{ Str::limit($projet->titre, 55) }}</h3>
            <p class="proj-objectif">{{ Str::limit($projet->objectif ?? '—', 80) }}</p>
            <div class="proj-details">
                <div class="proj-detail">
                    <i class="fas fa-wallet"></i>
                    <span>Budget : <strong>{{ number_format($projet->budgetTotal ?? 0, 0, ',', ' ') }} F CFA</strong></span>
                </div>
                <div class="proj-detail">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>Demandé : <strong>{{ number_format($projet->montantDemande ?? 0, 0, ',', ' ') }} F CFA</strong></span>
                </div>
                <div class="proj-detail">
                    <i class="fas fa-tag"></i>
                    <span>{{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
                </div>
                <div class="proj-detail">
                    <i class="fas fa-user"></i>
                    <span>{{ optional($projet->porteur)->nomComplet ?? '—' }}</span>
                </div>
            </div>
            <a href="{{ route('validateur.projets.show', $projet) }}" class="btn-examiner">
                <i class="fas fa-shield-alt"></i> Examiner le projet
            </a>
        </div>
        @empty
        <div class="empty-state" style="grid-column:1/-1;">
            <i class="fas fa-check-double"></i>
            <p>Aucun projet en attente de validation.</p>
        </div>
        @endforelse
    </div>

    @if($projets->hasPages())
    <div style="margin-top:16px;">{{ $projets->withQueryString()->links() }}</div>
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
document.getElementById('secteurFilter').addEventListener('change', function () {
    const url = new URL(window.location.href);
    this.value ? url.searchParams.set('secteur', this.value) : url.searchParams.delete('secteur');
    url.searchParams.delete('page');
    window.location.href = url.toString();
});
</script>
@endpush
@endsection
