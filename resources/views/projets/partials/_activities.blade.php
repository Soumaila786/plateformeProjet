@php
    $role = auth()->user()->role;
    $labelsStatutActivite = [
        'en_attente' => ['label' => 'En attente', 'color' => 'secondary'],
        'financee'   => ['label' => 'Financée',   'color' => 'success'],
        'en_cours'   => ['label' => 'En cours',   'color' => 'primary'],
        'termine'    => ['label' => 'Terminée',   'color' => 'info'],
        'annule'     => ['label' => 'Annulée',    'color' => 'danger'],
    ];
    // Nom de route selon le rôle connecté (porteur ou planificateur peuvent
    // tous deux gérer des activités, chacun sous son propre préfixe de route).
    $routeStoreActivite = $role.'.planifications.store';
    $routeUpdateActivite = $role.'.planifications.update';
@endphp

@if ($projet->activites->isNotEmpty() || in_array($role, ['porteur', 'planificateur']))
<x-cards.info titre="Planification" icon="fa-list-check" class="mb-3">

    @forelse ($projet->activites as $activite)
        @php $sa = $labelsStatutActivite[$activite->statutActivite] ?? ['label' => $activite->statutActivite, 'color' => 'secondary']; @endphp
        <div class="d-flex justify-content-between align-items-start py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
            <div>
                <div class="fw-semibold">{{ $activite->activite }}</div>
                <div class="text-muted small">
                    {{ $activite->indicateur }} {{ $activite->uniteIndicateur }} · {{ $activite->periode }}
                    · <span class="font-monospace">{{ number_format($activite->coutEstimatif, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                @if ($role === 'approbateur')
                    <form action="{{ route('approbateur.projets.activite.statut', [$projet, $activite]) }}" method="POST">
                        @csrf
                        <select name="statutActivite" class="form-select form-select-sm" onchange="this.form.submit()">
                            @foreach ($labelsStatutActivite as $key => $conf)
                                <option value="{{ $key }}" {{ $activite->statutActivite === $key ? 'selected' : '' }}>{{ $conf['label'] }}</option>
                            @endforeach
                        </select>
                    </form>
                @else
                    <span class="badge bg-{{ $sa['color'] }}-subtle text-{{ $sa['color'] }}">{{ $sa['label'] }}</span>
                @endif

                @if (in_array($role, ['porteur', 'planificateur']) && Route::has($routeUpdateActivite))
                    @php
                        $champsModifierActivite = [
                            'activitePlanification' => $activite->activite,
                            'indicateur' => $activite->indicateur,
                            'uniteIndicateur' => $activite->uniteIndicateur,
                            'resultatsAttendues' => $activite->resultatsAttendues,
                            'coutEstimatif' => $activite->coutEstimatif,
                            'periode' => $activite->periode,
                        ];
                    @endphp
                    <button type="button" class="btn btn-sm btn-link text-decoration-none" title="Modifier l'activité"
                            data-modal-edit="modalActiviteForm"
                            data-modal-action="{{ route($routeUpdateActivite, [$projet, $activite]) }}"
                            data-modal-titre-edition="Modifier l'activité"
                            data-modal-fields="{{ json_encode($champsModifierActivite) }}">
                        <i class="fas fa-pen"></i>
                    </button>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted small mb-0">Aucune activité de planification pour l'instant.</p>
    @endforelse

    @if (in_array($role, ['porteur', 'planificateur']) && Route::has($routeStoreActivite))
        <button type="button" class="btn btn-outline-secondary btn-sm mt-3"
                data-modal-new="modalActiviteForm"
                data-modal-action="{{ route($routeStoreActivite, $projet) }}"
                data-modal-titre-creation="Nouvelle activité">
            <i class="fas fa-plus"></i> Ajouter une activité
        </button>

        @include('modals.activite-form')
    @endif
</x-cards.info>
@endif
