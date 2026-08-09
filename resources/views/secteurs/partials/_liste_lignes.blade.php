@forelse ($secteurs as $secteur)
    @php
        $champsModifierSecteur = [
            'nomSecteur' => $secteur->nomSecteur,
            'description' => $secteur->description,
            'statutSecteur' => (bool) $secteur->statutSecteur,
        ];
    @endphp
    <div class="lp-row">
        <div class="lp-avatar">{{ strtoupper(substr($secteur->nomSecteur, 0, 1)) }}</div>

        <div class="lp-info">
            <div class="lp-top">
                <span class="lp-titre">{{ $secteur->nomSecteur }}</span>
            </div>
            @if ($secteur->description)
                <p class="secteur-desc mb-0">{{ \Illuminate\Support\Str::limit($secteur->description, 90) }}</p>
            @endif
            <p class="secteur-nb-projets mb-0 mt-1"><i class="fas fa-folder me-1"></i>{{ $secteur->projets->count() }} projet(s)</p>
        </div>

        <div class="lp-badges">
            <span class="badge {{ $secteur->statutSecteur ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                {{ $secteur->statutSecteur ? 'Actif' : 'Inactif' }}
            </span>

            @can('secteurs.gerer')
                <button type="button" class="lp-btn" title="Modifier"
                        data-modal-edit="modalSecteurForm"
                        data-modal-action="{{ route('admin.secteurs.update', $secteur) }}"
                        data-modal-titre-edition="Modifier le secteur"
                        data-modal-fields="{{ json_encode($champsModifierSecteur) }}">
                    <i class="fas fa-pen"></i>
                </button>

                <form method="POST" action="{{ route('admin.secteurs.toggle-status', $secteur) }}" class="d-inline"
                      onsubmit="return confirm('{{ $secteur->statutSecteur ? 'Désactiver' : 'Activer' }} ce secteur ?')">
                    @csrf
                    <button type="submit" class="lp-btn {{ $secteur->statutSecteur ? '' : 'lp-btn-green' }}" title="{{ $secteur->statutSecteur ? 'Désactiver' : 'Activer' }}">
                        <i class="fas {{ $secteur->statutSecteur ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                    </button>
                </form>

                @if ($secteur->projets->count() === 0)
                    <form method="POST" action="{{ route('admin.secteurs.destroy', $secteur) }}" class="d-inline"
                          onsubmit="return confirm('Supprimer définitivement ce secteur ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="lp-btn lp-btn-red" title="Supprimer"><i class="fas fa-trash"></i></button>
                    </form>
                @else
                    <span class="lp-btn" style="opacity:.4; cursor:not-allowed;" title="Impossible : ce secteur contient des projets"><i class="fas fa-trash"></i></span>
                @endif
            @endcan
        </div>
    </div>
@empty
    <div class="lp-empty">
        <i class="fas fa-building"></i>
        <p class="mb-0">Aucun secteur trouvé.</p>
    </div>
@endforelse

<div class="mt-3">{{ $secteurs->withQueryString()->links() }}</div>

@push('scripts')
    <script src="{{ asset('js/filtres-liste.js') }}"></script>
    <script src="{{ asset('js/modals-crud.js') }}"></script>
@endpush
