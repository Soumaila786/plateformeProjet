@forelse ($motifs as $motif)
    @php
        $champsModifierMotif = ['libelle' => $motif->libelle, 'actif' => (bool) $motif->actif];
    @endphp
    <div class="lp-row">
        <div class="lp-avatar"><i class="fas fa-ban"></i></div>

        <div class="lp-info">
            <span class="motif-libelle">{{ $motif->libelle }}</span>
        </div>

        <div class="lp-badges">
            <span class="badge {{ $motif->actif ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                {{ $motif->actif ? 'Actif' : 'Inactif' }}
            </span>

            @can('motifs.gerer')
                <button type="button" class="lp-btn" title="Modifier"
                        data-modal-edit="modalMotifForm"
                        data-modal-action="{{ route('admin.motifs.update', $motif) }}"
                        data-modal-titre-edition="Modifier le motif"
                        data-modal-fields="{{ json_encode($champsModifierMotif) }}">
                    <i class="fas fa-pen"></i>
                </button>

                <form method="POST" action="{{ route('admin.motifs.toggle-status', $motif) }}" class="d-inline"
                      onsubmit="return confirm('{{ $motif->actif ? 'Désactiver' : 'Activer' }} ce motif ?')">
                    @csrf
                    <button type="submit" class="lp-btn {{ $motif->actif ? '' : 'lp-btn-green' }}" title="{{ $motif->actif ? 'Désactiver' : 'Activer' }}">
                        <i class="fas {{ $motif->actif ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.motifs.destroy', $motif) }}" class="d-inline"
                      onsubmit="return confirm('Supprimer ce motif ? (s\'il a déjà été utilisé, il sera désactivé au lieu d\'être supprimé)')">
                    @csrf @method('DELETE')
                    <button type="submit" class="lp-btn lp-btn-red" title="Supprimer"><i class="fas fa-trash"></i></button>
                </form>
            @endcan
        </div>
    </div>
@empty
    <div class="lp-empty">
        <i class="fas fa-ban"></i>
        <p class="mb-0">Aucun motif de rejet configuré.</p>
    </div>
@endforelse

@push('scripts')
    <script src="{{ asset('js/filtres-liste.js') }}"></script>
    <script src="{{ asset('js/modals-crud.js') }}"></script>
@endpush
