@push('styles')
    <link rel="stylesheet" href="{{ asset('css/listes-projets.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/modals-crud.js') }}"></script>
@endpush

@php
    $u = auth()->user();
    $estOperateur = !$u->hasRole('admin');
    $porteurProjet = $projet->porteur ?? $projet->user ?? null;
    $estProprietaire = $porteurProjet && $porteurProjet->id === $u->id;
    $champsModifierProjet = [
        'titre' => $projet->titre, 'description' => $projet->description,
        'objectif' => $projet->objectif, 'secteur_id' => $projet->secteur_id,
        'duree' => $projet->duree,
        'dateDebut' => optional($projet->dateDebut)->format('Y-m-d'),
        'dateFin' => optional($projet->dateFin)->format('Y-m-d'),
        'budgetTotal' => $projet->budgetTotal, 'montantDemande' => $projet->montantDemande,
    ];
@endphp

<div class="d-flex flex-wrap gap-2">

    @if ($estOperateur && $u->can('projets.examiner') && $projet->statutProjet === 'soumis')
        <form action="{{ route('approbateur.projets.examiner', $projet) }}" method="POST" class="d-inline">
            @csrf
            <x-buttons.button variant="outline" icon="fa-magnifying-glass" type="submit">
                Mettre en examen
            </x-buttons.button>
        </form>
    @endif

    @if ($estOperateur && $u->can('projets.approuver') && $projet->statutProjet === 'en_examen')
        <x-buttons.button variant="success" icon="fa-check" data-bs-toggle="modal" data-bs-target="#modalApprouver">
            Approuver
        </x-buttons.button>
    @endif

    @if ($estOperateur && $u->can('projets.valider') && $projet->statutProjet === 'approuve')
        <x-buttons.button variant="success" icon="fa-check-double" data-bs-toggle="modal" data-bs-target="#modalValider">
            Valider
        </x-buttons.button>
    @endif

    @if ($estOperateur && $u->can('projets.demander_modification') && in_array($projet->statutProjet, ['en_examen', 'approuve']))
        <x-buttons.button variant="outline" icon="fa-pen" data-bs-toggle="modal" data-bs-target="#modalDemandeModif">
            Demander modification
        </x-buttons.button>
    @endif

    @if ($estOperateur && $u->can('projets.rejeter') && in_array($projet->statutProjet, ['en_examen', 'approuve']))
        <x-buttons.button variant="danger" icon="fa-xmark" data-bs-toggle="modal" data-bs-target="#modalRejeter">
            Rejeter
        </x-buttons.button>
    @endif

    @if ($estProprietaire && $u->can('projets.modifier') && $projet->isEditable())
        <button type="button" class="btn btn-outline-secondary btn-sm"
                data-modal-edit="modalProjetForm"
                data-modal-action="{{ route('porteur.projets.update', $projet) }}"
                data-modal-titre-edition="Modifier le projet"
                data-modal-fields="{{ json_encode($champsModifierProjet) }}">
            <i class="fas fa-pen"></i> Modifier
        </button>
    @endif

    @if ($estProprietaire && $u->can('projets.soumettre') && $projet->isSubmittable())
        <form action="{{ route('porteur.projets.soumettre', $projet) }}" method="POST" class="d-inline">
            @csrf
            <x-buttons.button variant="primary" icon="fa-paper-plane" type="submit">
                {{ $projet->isRejected() ? 'Soumettre à nouveau' : 'Soumettre' }}
            </x-buttons.button>
        </form>
    @endif

    {{-- FIX : visible uniquement en brouillon (avant soumission) — une fois
         soumis, le projet entre en phase d'approbation/validation et ce
         bouton n'a plus lieu d'être. --}}
    @if ($estProprietaire && $u->can('projets.gerer_planification') && $projet->statutProjet === 'brouillon' && !$projet->planification_demandee)
        <form action="{{ route('porteur.demande.planification', $projet) }}" method="POST" class="d-inline">
            @csrf
            <x-buttons.button variant="outline" icon="fa-calendar-check" type="submit">
                Demander une planification
            </x-buttons.button>
        </form>
    @endif

    @if ($estProprietaire && $u->can('projets.supprimer') && $projet->isDeletable())
        <x-buttons.button variant="danger" icon="fa-trash" data-bs-toggle="modal" data-bs-target="#modalSupprimer">
            Supprimer
        </x-buttons.button>
    @endif
</div>

@if ($estOperateur && ($u->can('projets.approuver') || $u->can('projets.valider')))
    <x-modals.confirm id="modalApprouver" titre="Approuver le projet" :action="route('approbateur.projets.approuver', $projet)"
        boutonLabel="Approuver" boutonVariant="success">
        <p class="text-muted small">Le projet passera à l'étape suivante du circuit.</p>
        <label class="form-label small">Commentaire (optionnel)</label>
        <textarea name="commentaire" class="form-control" rows="3" maxlength="1000"></textarea>
    </x-modals.confirm>

    <x-modals.confirm id="modalValider" titre="Valider le projet" :action="route('validateur.projets.valider', $projet)"
        boutonLabel="Valider" boutonVariant="success">
        <p class="text-muted small">Le projet sera marqué comme validé.</p>
        <label class="form-label small">Commentaire (optionnel)</label>
        <textarea name="commentaire" class="form-control" rows="3" maxlength="1000"></textarea>
    </x-modals.confirm>
@endif

@if ($estOperateur && $u->can('projets.rejeter'))
    @php $routeRejeter = $u->hasRole('approbateur') ? 'approbateur.projets.rejeter' : 'validateur.projets.rejeter'; @endphp
    <x-modals.confirm id="modalRejeter" titre="Rejeter le projet" :action="route($routeRejeter, $projet)"
        boutonLabel="Rejeter" boutonVariant="danger">
        <p class="text-muted small">Sélectionnez au moins un motif de rejet.</p>
        @foreach ($motifsDisponibles ?? [] as $motif)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="motifs[]" value="{{ $motif->id }}" id="rejet-motif-{{ $motif->id }}">
                <label class="form-check-label small" for="rejet-motif-{{ $motif->id }}">{{ $motif->libelle }}</label>
            </div>
        @endforeach
        <label class="form-label small mt-2">Commentaire libre (optionnel)</label>
        <textarea name="commentaire_libre" class="form-control" rows="3" maxlength="1000"></textarea>
    </x-modals.confirm>
@endif

@if ($u->can('projets.demander_modification'))
    @php $routeDemande = $u->hasRole('approbateur') ? 'approbateur.projets.demande-modification' : 'validateur.projets.demande-modification'; @endphp
    <x-modals.confirm id="modalDemandeModif" titre="Demander une modification" :action="route($routeDemande, $projet)"
        boutonLabel="Envoyer la demande" boutonVariant="primary">
        <p class="text-muted small">Le projet repassera en brouillon pour que le porteur corrige.</p>
        @foreach ($motifsDisponibles ?? [] as $motif)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="motifs[]" value="{{ $motif->id }}" id="modif-motif-{{ $motif->id }}">
                <label class="form-check-label small" for="modif-motif-{{ $motif->id }}">{{ $motif->libelle }}</label>
            </div>
        @endforeach
        <label class="form-label small mt-2">Commentaire libre (optionnel)</label>
        <textarea name="commentaire_libre" class="form-control" rows="3" maxlength="1000"></textarea>
    </x-modals.confirm>
@endif

@if ($u->can('projets.supprimer') && ($estProprietaire || $u->hasRole('admin')))
    <x-modals.confirm id="modalSupprimer" titre="Supprimer ce projet ?"
        :action="route(($u->hasRole('admin') ? 'admin' : 'porteur').'.projets.destroy', $projet)" method="DELETE"
        boutonLabel="Supprimer" boutonVariant="danger">
        <p class="text-muted small mb-0">Cette action est irréversible et supprimera également les documents associés.</p>
    </x-modals.confirm>
@endif

@can('projets.creer')
    @include('modals.projet-form')
@endcan
