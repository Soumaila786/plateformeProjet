<x-cards.info titre="Historique" icon="fa-clock-rotate-left">

    @forelse ($projet->commentaires->sortByDesc('dateEnvoi') as $commentaire)
        <div class="d-flex gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
            <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle"
                 style="width:32px; height:32px; background: color-mix(in srgb, {{ $commentaire->couleur() }} 15%, white); color: {{ $commentaire->couleur() }};">
                <i class="fas {{ $commentaire->icone() }}"></i>
            </div>
            <div>
                <div class="small fw-semibold">
                    {{ $commentaire->utilisateur->nomComplet ?? '—' }}
                    <span class="text-muted fw-normal">· {{ optional($commentaire->dateEnvoi)->format('d/m/Y H:i') }}</span>
                </div>

                @if ($commentaire->relationLoaded('motifs') && $commentaire->motifs->isNotEmpty())
                    <div class="d-flex flex-wrap gap-1 my-1">
                        @foreach ($commentaire->motifs as $motif)
                            <span class="badge bg-light text-dark border">{{ $motif->libelle }}</span>
                        @endforeach
                    </div>
                @endif

                @if ($commentaire->message)
                    <p class="mb-0 small">{{ $commentaire->message }}</p>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted small mb-0">Aucun échange pour l'instant.</p>
    @endforelse
</x-cards.info>
