@php
    $stMap = [
        'brouillon' => ['lbl' => 'Brouillon',  'dot' => '#9ca3af'],
        'soumis'    => ['lbl' => 'Soumis',     'dot' => '#6366f1'],
        'en_examen' => ['lbl' => 'En examen',  'dot' => '#f97316'],
        'approuve'  => ['lbl' => 'Approuvé',   'dot' => '#22c55e'],
        'rejete'    => ['lbl' => 'Rejeté',     'dot' => '#ef4444'],
        'valide'    => ['lbl' => 'Validé',     'dot' => '#0d9488'],
    ];
@endphp

@forelse ($projets as $projet)
    @php
        $st = $stMap[$projet->statutProjet] ?? ['lbl' => $projet->statutProjet, 'dot' => '#9ca3af'];
        $porteurProjet = $projet->porteur ?? $projet->user ?? null;
        $estProprietaire = $porteurProjet && $porteurProjet->id === auth()->id();
        $champsModifierProjet = [
            'titre' => $projet->titre, 'description' => $projet->description,
            'objectif' => $projet->objectif, 'secteur_id' => $projet->secteur_id,
            'duree' => $projet->duree,
            'dateDebut' => optional($projet->dateDebut)->format('Y-m-d'),
            'dateFin' => optional($projet->dateFin)->format('Y-m-d'),
            'budgetTotal' => $projet->budgetTotal, 'montantDemande' => $projet->montantDemande,
        ];
    @endphp

    <div class="lp-row">
        <div class="lp-avatar">{{ strtoupper(substr($projet->secteur->nomSecteur ?? $projet->titre, 0, 1)) }}</div>

        <div class="lp-info">
            <div class="lp-top">
                <span class="lp-code">{{ $projet->codeProjet }}</span>
                <span class="lp-titre">{{ $projet->titre }}</span>
            </div>
            <p class="lp-meta">
                @if ($porteurProjet)
                    <span><i class="fas fa-user"></i>{{ $porteurProjet->nomComplet }}</span>
                @endif
                <span><i class="fas fa-tag"></i>{{ $projet->secteur->nomSecteur ?? '—' }}</span>
                @if ($projet->montantDemande)
                    <span><i class="fas fa-coins"></i><strong>{{ number_format($projet->montantDemande, 0, ',', ' ') }} FCFA</strong></span>
                @endif
                @if ($projet->statutProjet === 'rejete' && !empty($projet->motifRejet))
                    <span class="text-truncate" style="max-width:260px;"><i class="fas fa-circle-info"></i>{{ $projet->motifRejet }}</span>
                @endif
            </p>
        </div>

        <div class="lp-badges">
            <span class="lp-badge" style="background: color-mix(in srgb, {{ $st['dot'] }} 16%, white); color: {{ $st['dot'] }};">
                <span class="lp-dot" style="background:{{ $st['dot'] }};"></span>{{ $st['lbl'] }}
            </span>

            @if (isset($routeShow))
                <a href="{{ route($routeShow, $projet) }}" class="lp-btn" title="Voir"><i class="fas fa-eye"></i></a>
            @endif

            @if (isset($routeExaminer) && auth()->user()->can('projets.examiner') && $projet->statutProjet === 'soumis')
                <form method="POST" action="{{ route($routeExaminer, $projet) }}" onsubmit="return confirm('Mettre ce projet en examen ?')" class="d-inline">
                    @csrf
                    <button type="submit" class="lp-btn lp-btn-orange" title="Mettre en examen"><i class="fas fa-magnifying-glass"></i></button>
                </form>
            @endif

            @if (isset($routeApprouver) && auth()->user()->can('projets.approuver') && $projet->statutProjet === 'en_examen')
                <button type="button" class="lp-btn lp-btn-green" title="Approuver" onclick="openModal('modalApprouver{{ $projet->id }}')"><i class="fas fa-check"></i></button>
            @endif
            @if (isset($routeValider) && auth()->user()->can('projets.valider') && $projet->statutProjet === 'approuve')
                <button type="button" class="lp-btn lp-btn-green" title="Valider" onclick="openModal('modalValider{{ $projet->id }}')"><i class="fas fa-check-double"></i></button>
            @endif

            @if (isset($routeDemanderModif) && auth()->user()->can('projets.demander_modification') && in_array($projet->statutProjet, ['en_examen', 'approuve']))
                <button type="button" class="lp-btn" title="Demander une modification" onclick="openModal('modalDemandeModif{{ $projet->id }}')"><i class="fas fa-pen"></i></button>
            @endif

            @if (isset($routeRejeter) && auth()->user()->can('projets.rejeter') && in_array($projet->statutProjet, ['en_examen', 'approuve']))
                <button type="button" class="lp-btn lp-btn-red" title="Rejeter" onclick="openModal('modalRejeter{{ $projet->id }}')"><i class="fas fa-times"></i></button>
            @endif

            @if ($estProprietaire && auth()->user()->can('projets.modifier') && $projet->isEditable())
                <button type="button" class="lp-btn" title="Modifier"
                        data-modal-edit="modalProjetForm"
                        data-modal-action="{{ route('porteur.projets.update', $projet) }}"
                        data-modal-titre-edition="Modifier le projet"
                        data-modal-fields="{{ json_encode($champsModifierProjet) }}">
                    <i class="fas fa-pen"></i>
                </button>
            @endif
            @if ($estProprietaire && auth()->user()->can('projets.supprimer') && $projet->isDeletable())
                <form method="POST" action="{{ route('porteur.projets.destroy', $projet) }}" onsubmit="return confirm('Supprimer ce projet ?')" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="lp-btn lp-btn-red" title="Supprimer"><i class="fas fa-trash"></i></button>
                </form>
            @endif
        </div>
    </div>

    @if (isset($routeApprouver) && auth()->user()->can('projets.approuver') && $projet->statutProjet === 'en_examen')
        <div id="modalApprouver{{ $projet->id }}" class="lp-modal-overlay">
            <div class="lp-modal-box">
                <div class="lp-modal-head">
                    <h3 class="lp-modal-title"><i class="fas fa-check-circle" style="color:#22c55e;"></i> Approuver le projet</h3>
                    <button onclick="closeModal('modalApprouver{{ $projet->id }}')" class="lp-modal-close"><i class="fas fa-times"></i></button>
                </div>
                <form method="POST" action="{{ route($routeApprouver, $projet) }}">
                    @csrf
                    <div class="lp-modal-body">
                        <p class="text-muted small">Le projet <strong>{{ $projet->titre }}</strong> passera à l'étape suivante.</p>
                        <label class="form-label small">Commentaire (optionnel)</label>
                        <textarea name="commentaire" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="lp-modal-foot">
                        <button type="button" onclick="closeModal('modalApprouver{{ $projet->id }}')" class="btn btn-light btn-sm">Annuler</button>
                        <button type="submit" class="btn btn-success btn-sm">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if (isset($routeValider) && auth()->user()->can('projets.valider') && $projet->statutProjet === 'approuve')
        <div id="modalValider{{ $projet->id }}" class="lp-modal-overlay">
            <div class="lp-modal-box">
                <div class="lp-modal-head">
                    <h3 class="lp-modal-title"><i class="fas fa-check-double" style="color:#22c55e;"></i> Valider le projet</h3>
                    <button onclick="closeModal('modalValider{{ $projet->id }}')" class="lp-modal-close"><i class="fas fa-times"></i></button>
                </div>
                <form method="POST" action="{{ route($routeValider, $projet) }}">
                    @csrf
                    <div class="lp-modal-body">
                        <p class="text-muted small">Le projet <strong>{{ $projet->titre }}</strong> sera marqué comme validé.</p>
                        <label class="form-label small">Commentaire (optionnel)</label>
                        <textarea name="commentaire" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="lp-modal-foot">
                        <button type="button" onclick="closeModal('modalValider{{ $projet->id }}')" class="btn btn-light btn-sm">Annuler</button>
                        <button type="submit" class="btn btn-success btn-sm">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if (isset($routeRejeter) && auth()->user()->can('projets.rejeter') && in_array($projet->statutProjet, ['en_examen', 'approuve']))
        <div id="modalRejeter{{ $projet->id }}" class="lp-modal-overlay">
            <div class="lp-modal-box">
                <div class="lp-modal-head">
                    <h3 class="lp-modal-title"><i class="fas fa-times-circle" style="color:#ef4444;"></i> Rejeter le projet</h3>
                    <button onclick="closeModal('modalRejeter{{ $projet->id }}')" class="lp-modal-close"><i class="fas fa-times"></i></button>
                </div>
                <form method="POST" action="{{ route($routeRejeter, $projet) }}">
                    @csrf
                    <div class="lp-modal-body">
                        <label class="form-label small">Motif(s) de rejet <span class="text-danger">*</span></label>
                        @foreach ($motifsDisponibles ?? [] as $motif)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="motifs[]" value="{{ $motif->id }}" id="rej-{{ $projet->id }}-{{ $motif->id }}">
                                <label class="form-check-label small" for="rej-{{ $projet->id }}-{{ $motif->id }}">{{ $motif->libelle }}</label>
                            </div>
                        @endforeach
                        <label class="form-label small mt-2">Commentaire libre (optionnel)</label>
                        <textarea name="commentaire_libre" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="lp-modal-foot">
                        <button type="button" onclick="closeModal('modalRejeter{{ $projet->id }}')" class="btn btn-light btn-sm">Annuler</button>
                        <button type="submit" class="btn btn-danger btn-sm">Confirmer le rejet</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if (isset($routeDemanderModif) && auth()->user()->can('projets.demander_modification') && in_array($projet->statutProjet, ['en_examen', 'approuve']))
        <div id="modalDemandeModif{{ $projet->id }}" class="lp-modal-overlay">
            <div class="lp-modal-box">
                <div class="lp-modal-head">
                    <h3 class="lp-modal-title"><i class="fas fa-pen" style="color:#f97316;"></i> Demander une modification</h3>
                    <button onclick="closeModal('modalDemandeModif{{ $projet->id }}')" class="lp-modal-close"><i class="fas fa-times"></i></button>
                </div>
                <form method="POST" action="{{ route($routeDemanderModif, $projet) }}">
                    @csrf
                    <div class="lp-modal-body">
                        <p class="text-muted small">Le projet repassera en brouillon pour que le porteur corrige.</p>
                        <label class="form-label small">Motif(s) <span class="text-danger">*</span></label>
                        @foreach ($motifsDisponibles ?? [] as $motif)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="motifs[]" value="{{ $motif->id }}" id="mod-{{ $projet->id }}-{{ $motif->id }}">
                                <label class="form-check-label small" for="mod-{{ $projet->id }}-{{ $motif->id }}">{{ $motif->libelle }}</label>
                            </div>
                        @endforeach
                        <label class="form-label small mt-2">Commentaire libre (optionnel)</label>
                        <textarea name="commentaire_libre" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="lp-modal-foot">
                        <button type="button" onclick="closeModal('modalDemandeModif{{ $projet->id }}')" class="btn btn-light btn-sm">Annuler</button>
                        <button type="submit" class="btn btn-warning btn-sm">Envoyer la demande</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

@empty
    <div class="lp-empty">
        <i class="fas fa-folder-open"></i>
        <p class="mb-0">Aucun projet trouvé.</p>
    </div>
@endforelse

<div class="mt-3">{{ $projets->withQueryString()->links() }}</div>

@push('scripts')
    <script src="{{ asset('js/listes-projets.js') }}"></script>
@endpush
