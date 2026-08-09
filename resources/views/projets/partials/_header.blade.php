@php
    $porteurProjet = $projet->porteur ?? $projet->user ?? null;
@endphp

<x-cards.info class="mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="text-muted small font-monospace">{{ $projet->codeProjet }}</span>
                <x-badges.statut-projet :statut="$projet->statutProjet" />
            </div>
            <h4 class="fw-bold mb-0" style="color: var(--color-text);">{{ $projet->titre }}</h4>
            <div class="ps-header-meta">
                <span><i class="fas fa-user"></i>{{ $porteurProjet->nomComplet ?? '—' }}</span>
                <span><i class="fas fa-building"></i>{{ $projet->secteur->nomSecteur ?? '—' }}</span>
            </div>
        </div>

        @include('projets.partials._actions_bar')
    </div>

    <hr class="my-4" style="border-color: var(--color-border-light);">

    <x-circuit.stepper :statut="$projet->statutProjet" />
</x-cards.info>
