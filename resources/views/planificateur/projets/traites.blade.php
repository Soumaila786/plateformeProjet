@extends('layouts.app')
@section('title', 'Projets traités')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/planifDash.css') }}">
@endpush

@section('content')
<div class="plan-page">

    {{-- Header --}}
    <div class="plan-header">
        <div>
            <h1 class="plan-header-title">
                <i class="fas fa-folder-open" style="color:var(--plan-primary);font-size:1rem;"></i>
                Projets traités
            </h1>
            <p class="plan-header-sub">Projets ayant déjà des activités de planification</p>
        </div>
        @if($projets->total() > 0)
        <span class="plan-badge plan-badge-green" style="font-size:.78rem;padding:5px 12px;">
            {{ $projets->total() }} projet(s)
        </span>
        @endif
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="plan-alert plan-alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- Recherche --}}
    <form method="GET" class="plan-search-bar">
        <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Rechercher par titre ou code..."
                class="plan-search-input">
        <button type="submit" class="plan-search-btn">
            <i class="fas fa-search"></i> Rechercher
        </button>
        @if(request('search'))
        <a href="{{ route('planificateur.projets.traites') }}" class="plan-reset-btn">
            <i class="fas fa-times"></i> Réinitialiser
        </a>
        @endif
    </form>

    {{-- Liste --}}
    @forelse($projets as $projet)
    @php
        $nbAct  = $projet->planifications->count();
        $cout   = $projet->planifications->sum('coutEstimatif');
        $budget = $projet->budgetTotal ?? 0;
        $pct    = $budget > 0 ? min(100, round($cout / $budget * 100)) : 0;
    @endphp
    <div class="plan-projet-row">

        {{-- Avatar --}}
        <div class="plan-projet-avatar">
            {{ strtoupper(substr(optional($projet->secteur)->nomSecteur ?? $projet->titre, 0, 1)) }}
        </div>

        {{-- Infos --}}
        <div class="plan-projet-info">
            <div class="plan-projet-top">
                <span class="plan-projet-code">{{ $projet->codeProjet }}</span>
                <span class="plan-projet-titre">{{ $projet->titre }}</span>
            </div>
            <p class="plan-projet-meta">
                <span><i class="fas fa-user"></i>{{ optional($projet->user)->nomComplet ?? '—' }}</span>
                <span><i class="fas fa-tag"></i>{{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
            </p>
            {{-- Barre progression coût --}}
            @if($budget > 0)
            <div class="plan-progress-wrap">
                <div class="plan-progress-bar">
                    <div class="plan-progress-fill" style="width:{{ $pct }}%;"></div>
                </div>
                <div class="plan-progress-label">
                    <span>Coût planifié</span>
                    <span>
                        {{ number_format($cout, 0, ',', ' ') }} F / {{ number_format($budget, 0, ',', ' ') }} F ({{ $pct }}%)
                    </span>
                </div>
            </div>
            @endif
        </div>

        {{-- Badges + action --}}
        <div class="plan-projet-badges">
            <span class="plan-badge plan-badge-green">
                <i class="fas fa-check" style="font-size:.6rem;"></i>
                {{ $nbAct }} activité(s)
            </span>
            <a href="{{ route('planificateur.projets.show', $projet) }}" class="plan-btn plan-btn-outline">
                <i class="fas fa-eye"></i> Voir
            </a>
        </div>
    </div>
    @empty
    <div class="plan-empty">
        <i class="fas fa-folder-open"></i>
        <p>Aucun projet traité pour l'instant.</p>
        <a href="{{ route('planificateur.projets.index') }}" class="plan-btn plan-btn-primary" style="margin-top:8px;">
            <i class="fas fa-inbox"></i> Voir les demandes
        </a>
    </div>
    @endforelse

    <div class="plan-pagination">
        {{ $projets->appends(request()->query())->links() }}
    </div>

</div>
@endsection
