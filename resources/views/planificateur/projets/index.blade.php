@extends('layouts.app')
@section('title', 'Projets à traiter')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/planifDash.css') }}">
@endpush

@section('content')
<div class="plan-page">

    {{-- Header --}}
    <div class="plan-header">
        <div>
            <h1 class="plan-header-title">
                <i class="fas fa-inbox" style="color:var(--plan-primary);font-size:1rem;"></i>
                Projets à planifier
            </h1>
            <p class="plan-header-sub">Projets dont le porteur a demandé une planification</p>
        </div>
        @if($projets->total() > 0)
        <span class="plan-badge plan-badge-violet" style="font-size:.78rem;padding:5px 12px;">
            {{ $projets->total() }} demande(s)
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
    @if(session('error'))
    <div class="plan-alert plan-alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
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
        <a href="{{ route('planificateur.projets.index') }}" class="plan-reset-btn">
            <i class="fas fa-times"></i> Réinitialiser
        </a>
        @endif
    </form>

    {{-- Liste --}}
    @forelse($projets as $projet)
    <div class="plan-projet-row urgent">

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
        </div>

        {{-- Badge + action --}}
        <div class="plan-projet-badges">
            <span class="plan-badge plan-badge-orange">
                @if($projet->updated_at)
                <i class="fas fa-clock" style="font-size:.6rem;"></i>
                {{ $projet->updated_at->diffForHumans() }}
                @endif
            </span>
            <a href="{{ route('planificateur.projets.show', $projet) }}" class="plan-btn-planifier">
                <i class="fas fa-calendar-plus"></i> Planifier
            </a>
        </div>
    </div>
    @empty
    <div class="plan-empty">
        <i class="fas fa-inbox"></i>
        <p>Aucune demande de planification en attente.</p>
        <p style="font-size:.75rem;color:var(--plan-text-light);">
            Les demandes des porteurs apparaîtront ici.
        </p>
    </div>
    @endforelse

    {{-- Pagination --}}
    <div class="plan-pagination mt-4">
        {{ $projets->appends(request()->query())->links() }}
    </div>

</div>
@endsection
