@extends('layouts.app')
@section('title', 'Mes projets')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/porteur.css') }}">
@endpush

@section('content')
<div class="projets-page">

    {{-- Header --}}
    <div class="projets-header">
        <div>
            <h1 class="projets-title">Mes projets</h1>
            <p class="projets-subtitle">{{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} au total</p>
        </div>
        <a href="{{ route('porteur.projets.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Nouveau projet
        </a>
    </div>

    {{-- Alerte modification demandée --}}
    @php
        $nbModif = $projets->getCollection()->filter(function($p) {
            return $p->statutProjet === 'brouillon' &&
                   $p->commentaires->where('typeCommentaire', 'rejet')->isNotEmpty();
        })->count();
    @endphp
    @if($nbModif > 0)
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>{{ $nbModif }} projet(s)</strong> nécessite(nt) des modifications demandées par l'approbateur.
    </div>
    @endif

    {{-- Flash --}}
    @if(session('success'))
    <div class="port-alert port-alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    {{-- Filtres --}}
    <div class="projets-filters">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="search-input"
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
            <a href="{{ route('porteur.projets.index', array_merge(request()->query(), ['statut'=>$val,'search'=>request('search')])) }}"
               class="status-filter {{ request('statut','') === $val ? 'active' : '' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- Liste --}}
    <div class="projets-list">
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
            $hasModification = $projet->statutProjet === 'brouillon' &&
                               $projet->commentaires->where('typeCommentaire','rejet')->isNotEmpty();
        @endphp

        <div class="projet-card">
            {{-- Avatar --}}
            <div class="projet-avatar">
                {{ strtoupper(substr(optional($projet->secteur)->nomSecteur ?? $projet->titre, 0, 1)) }}
            </div>

            {{-- Infos --}}
            <div class="projet-info">
                <div class="projet-header-line">
                    <a href="{{ route('porteur.projets.show', $projet) }}" class="projet-code">
                        {{ $projet->codeProjet }}
                    </a>
                    <a href="{{ route('porteur.projets.show', $projet) }}" class="projet-titre">
                        {{ $projet->titre }}
                    </a>
                    @if($hasModification)
                    <span class="modif-badge">
                        <i class="fas fa-exclamation-triangle"></i> Modification demandée
                    </span>
                    @endif
                </div>
                <div class="projet-meta">
                    <span><i class="fas fa-tag"></i>{{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
                    <span><i class="far fa-calendar-alt"></i>Créé le {{ optional($projet->dateCreation)->format('d/m/Y') ?? '—' }}</span>
                    <span>
                        <i class="fas fa-coins"></i>
                        <span class="projet-budget">
                            {{ $projet->montantDemande ? number_format($projet->montantDemande, 0, ',', ' ') . ' F CFA' : '—' }}
                        </span>
                    </span>
                </div>
            </div>

            {{-- Badge + actions --}}
            <div class="projet-right">
                <div class="projet-badges">
                    <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                </div>
                <div class="projet-actions">
                    <a href="{{ route('porteur.projets.show', $projet) }}" class="action-icon" title="Voir">
                        <i class="fas fa-eye"></i>
                    </a>
                    @if($projet->isEditable())
                    <a href="{{ route('porteur.projets.edit', $projet) }}" class="action-icon" title="Modifier">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    @endif
                    @if($projet->isSubmittable())
                    <form method="POST" action="{{ route('porteur.projets.soumettre', $projet) }}"
                          onsubmit="return confirm('Soumettre ce projet pour approbation ?')" style="display:inline;">
                        @csrf
                        <button type="submit" class="action-icon action-icon-success" title="Soumettre">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                    @endif
                    @if($projet->isDeletable())
                    <form method="POST" action="{{ route('porteur.projets.destroy', $projet) }}"
                          onsubmit="return confirm('Supprimer définitivement ce projet ?')" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-icon action-icon-danger" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="td-empty" style="background:var(--port-bg-white);border-radius:var(--port-radius-xl);
                                     border:1px solid var(--port-border);padding:48px 20px;text-align:center;
                                     color:var(--port-text-light);">
            <i class="fas fa-folder-open" style="font-size:2rem;display:block;margin-bottom:10px;color:var(--port-border);"></i>
            <p style="font-size:.82rem;margin:0 0 12px;">
                @if(request('statut') || request('search'))
                    Aucun projet ne correspond à votre recherche.
                @else
                    Vous n'avez pas encore de projet.
                @endif
            </p>
            @if(!request('statut') && !request('search'))
            <a href="{{ route('porteur.projets.create') }}" class="btn-add">
                <i class="fas fa-plus"></i> Créer mon premier projet
            </a>
            @endif
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($projets->hasPages())
    <div class="projets-pagination">{{ $projets->withQueryString()->links() }}</div>
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
</script>
@endpush
@endsection
