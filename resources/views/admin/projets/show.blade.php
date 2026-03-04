@extends('layouts.app')

@section('title', $projet->titre)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/projet.css') }}">
@endpush

@section('content')

<div class="projets-page">

    {{-- ── Header ── --}}
    <div class="page-header">
        <a href="{{ route('admin.projets.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-header-info">
            <div>
                <h1 class="projets-title">{{ $projet->titre }}</h1>
                <p class="projets-subtitle">{{ $projet->codeProjet }}</p>
            </div>
            @php
                $statusClass = ['brouillon'=>'status-gray','soumis'=>'status-blue','en_examen'=>'status-yellow','approuve'=>'status-green','valide'=>'status-teal','rejete'=>'status-red'][$projet->statutProjet] ?? 'status-gray';
                $statusLabel = ['brouillon'=>'Brouillon','soumis'=>'Soumis','en_examen'=>'En examen','approuve'=>'Approuvé','valide'=>'Validé','rejete'=>'Rejeté'][$projet->statutProjet] ?? $projet->statutProjet;
            @endphp
            <span class="status-badge {{ $statusClass }} status-lg">{{ $statusLabel }}</span>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('admi.projets.edit', $projet) }}" class="btn-edit-main">
                <i class="fas fa-pencil-alt"></i> Modifier
            </a>
            <form method="POST" action="{{ route('admin.projets.destroy', $projet) }}"
                  onsubmit="return confirm('Supprimer ce projet ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-delete-main" title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>

    {{-- ══ BARRE D'ACTIONS ══ --}}
    <div class="projet-actions-bar">

        {{-- Toujours visible : Planifier --}}
        <button type="button" class="action-btn action-btn-blue"
                onclick="openModal('modalPlanifier')">
            <i class="fas fa-calendar-plus"></i>
            Planifier le projet
        </button>

        {{-- Brouillon → Soumettre --}}
        @if($projet->statutProjet === 'brouillon')
        <form method="POST" action="{{ route('projets.statut', $projet) }}">
            @csrf
            <input type="hidden" name="statut" value="soumis">
            <button type="submit" class="action-btn action-btn-indigo"
                    onclick="return confirm('Soumettre ce projet pour examen ?')">
                <i class="fas fa-paper-plane"></i>
                Soumettre le projet
            </button>
        </form>
        @endif

        {{-- Soumis → Mettre en examen --}}
        @if($projet->statutProjet === 'soumis')
        <form method="POST" action="{{ route('projets.statut', $projet) }}">
            @csrf
            <input type="hidden" name="statut" value="en_examen">
            <button type="submit" class="action-btn action-btn-yellow"
                    onclick="return confirm('Mettre ce projet en examen ?')">
                <i class="fas fa-search"></i>
                Mettre en examen
            </button>
        </form>
        @endif

        {{-- En examen → Approuver / Rejeter --}}
        @if($projet->statutProjet === 'en_examen')
        <form method="POST" action="{{ route('projets.statut', $projet) }}">
            @csrf
            <input type="hidden" name="statut" value="approuve">
            <button type="submit" class="action-btn action-btn-green"
                    onclick="return confirm('Approuver ce projet ?')">
                <i class="fas fa-check-circle"></i>
                Approuver
            </button>
        </form>
        <form method="POST" action="{{ route('projets.statut', $projet) }}">
            @csrf
            <input type="hidden" name="statut" value="rejete">
            <button type="submit" class="action-btn action-btn-red"
                    onclick="return confirm('Rejeter ce projet ?')">
                <i class="fas fa-times-circle"></i>
                Rejeter
            </button>
        </form>
        @endif

        {{-- Approuvé → Valider --}}
        @if($projet->statutProjet === 'approuve')
        <form method="POST" action="{{ route('projets.statut', $projet) }}">
            @csrf
            <input type="hidden" name="statut" value="valide">
            <button type="submit" class="action-btn action-btn-teal"
                    onclick="return confirm('Valider définitivement ce projet ?')">
                <i class="fas fa-check-double"></i>
                Valider le projet
            </button>
        </form>
        @endif

    </div>

    {{-- ══ CONTENU PRINCIPAL ══ --}}
    <div class="show-grid">

        {{-- ── Colonne gauche ── --}}
        <div class="show-col-main">

            {{-- Infos générales --}}
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-info-circle"></i>
                    <span>Informations générales</span>
                </div>
                <div class="form-card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Secteur</span>
                            <span class="info-value">{{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Porteur</span>
                            <span class="info-value">{{ optional($projet->porteur)->nomComplet ?? '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Durée</span>
                            <span class="info-value">{{ $projet->duree ? $projet->duree . ' mois' : '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de création</span>
                            <span class="info-value">{{ optional($projet->dateCreation)->format('d/m/Y') ?? '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de début</span>
                            <span class="info-value">{{ optional($projet->dateDebut)->format('d/m/Y') ?? '—' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de fin</span>
                            <span class="info-value">{{ optional($projet->dateFin)->format('d/m/Y') ?? '—' }}</span>
                        </div>
                    </div>

                    @if($projet->description)
                    <div class="info-block">
                        <span class="info-label">Description</span>
                        <p class="info-text">{{ $projet->description }}</p>
                    </div>
                    @endif

                    @if($projet->objectif)
                    <div class="info-block">
                        <span class="info-label">Objectif</span>
                        <p class="info-text">{{ $projet->objectif }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Planifications --}}
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-tasks"></i>
                    <span>Planification ({{ $projet->planifications->count() }})</span>
                    <button type="button" class="card-header-btn"
                            onclick="openModal('modalPlanifier')">
                        <i class="fas fa-plus"></i> Ajouter
                    </button>
                </div>
                @if($projet->planifications->count())
                <div class="form-card-body p-0">
                    <table class="projets-table">
                        <thead>
                            <tr>
                                <th>Activité</th>
                                <th>Début</th>
                                <th>Fin</th>
                                <th>Montant demandé</th>
                                <th>Statut</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projet->planifications as $plan)
                            @php
                                $planStatutClass = ['en_attente'=>'status-gray','en_cours'=>'status-yellow','termine'=>'status-green','annule'=>'status-red'][$plan->statutActivite] ?? 'status-gray';
                                $planStatutLabel = ['en_attente'=>'En attente','en_cours'=>'En cours','termine'=>'Terminé','annule'=>'Annulé'][$plan->statutActivite] ?? $plan->statutActivite;
                            @endphp
                            <tr>
                                <td>
                                    <span class="plan-activite">{{ $plan->activite }}</span>
                                    @if($plan->descriptionActivite)
                                    <span class="plan-desc">{{ $plan->descriptionActivite }}</span>
                                    @endif
                                </td>
                                <td class="td-muted">{{ optional($plan->dateDebut)->format('d/m/Y') ?? '—' }}</td>
                                <td class="td-muted">{{ optional($plan->dateFin)->format('d/m/Y') ?? '—' }}</td>
                                <td class="td-budget">
                                    {{ $plan->montantDemande ? number_format($plan->montantDemande, 0, ',', ' ') . ' F' : '—' }}
                                </td>
                                <td><span class="status-badge {{ $planStatutClass }}">{{ $planStatutLabel }}</span></td>
                                <td>
                                    <form method="POST"
                                          action="{{ route('projets.planifications.destroy', [$projet, $plan]) }}"
                                          onsubmit="return confirm('Supprimer cette activité ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="form-card-body">
                    <div class="doc-empty-state">
                        <i class="fas fa-calendar"></i>
                        <span>Aucune activité planifiée.</span>
                    </div>
                </div>
                @endif
            </div>

        </div>

        {{-- ── Colonne droite ── --}}
        <div class="show-col-side">

            {{-- Budget --}}
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-coins"></i>
                    <span>Budget</span>
                </div>
                <div class="form-card-body">
                    <div class="budget-display">
                        <span class="budget-label-sm">Budget total</span>
                        <span class="budget-value">{{ number_format($projet->budgetTotal, 0, ',', ' ') }} F CFA</span>
                    </div>
                    @if($projet->montantDemande)
                    <div class="budget-display">
                        <span class="budget-label-sm">Montant demandé</span>
                        <span class="budget-value-sm">{{ number_format($projet->montantDemande, 0, ',', ' ') }} F CFA</span>
                    </div>
                    @endif
                    @if($projet->planifications->count())
                    <div class="budget-display">
                        <span class="budget-label-sm">Total planifié</span>
                        <span class="budget-value-sm">
                            {{ number_format($projet->planifications->sum('montantDemande'), 0, ',', ' ') }} F CFA
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Documents --}}
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-paperclip"></i>
                    <span>Documents ({{ $projet->documents->count() }})</span>
                </div>
                <div class="form-card-body">
                    @forelse($projet->documents as $doc)
                    <div class="doc-existing-item">
                        @php
                            $ext = pathinfo($doc->nomFichier, PATHINFO_EXTENSION);
                            $icon = in_array($ext, ['pdf']) ? 'fa-file-pdf' : (in_array($ext, ['doc','docx']) ? 'fa-file-word' : (in_array($ext, ['xls','xlsx']) ? 'fa-file-excel' : (in_array($ext, ['jpg','jpeg','png']) ? 'fa-file-image' : 'fa-file-alt')));
                        @endphp
                        <i class="fas {{ $icon }}"></i>
                        <span class="doc-file-name">{{ $doc->nomFichier }}</span>
                        <span class="doc-badge">{{ $doc->typeDocument }}</span>
                        <a href="{{ route('projets.documents.download', [$projet, $doc]) }}"
                           class="doc-action-link" title="Télécharger">
                            <i class="fas fa-download"></i>
                        </a>
                        <form method="POST"
                              action="{{ route('projets.documents.destroy', [$projet, $doc]) }}"
                              onsubmit="return confirm('Supprimer ce document ?')"
                              style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="doc-action-del" title="Supprimer">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                    @empty
                    <p class="info-empty">Aucun document joint.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ══ MODAL PLANIFICATION ══ --}}
<div id="modalPlanifier" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h2 class="modal-title">
                <i class="fas fa-calendar-plus"></i>
                Ajouter une activité
            </h2>
            <button type="button" class="modal-close" onclick="closeModal('modalPlanifier')">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('projets.planifications.store', $projet) }}">
            @csrf

            <div class="modal-body">

                <div class="form-col form-col-full">
                    <label class="field-label">Activité <span class="required">*</span></label>
                    <input type="text" name="activite"
                           value="{{ old('activite') }}"
                           class="field-input @error('activite') is-invalid @enderror"
                           placeholder="Ex : Analyse des besoins" required>
                    @error('activite')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-col form-col-full">
                    <label class="field-label">Description</label>
                    <textarea name="descriptionActivite" rows="2"
                              class="field-input field-textarea"
                              placeholder="Détails de l'activité...">{{ old('descriptionActivite') }}</textarea>
                </div>

                <div class="modal-row">
                    <div class="form-col">
                        <label class="field-label">Date de début <span class="required">*</span></label>
                        <input type="date" name="dateDebut"
                               value="{{ old('dateDebut') }}"
                               class="field-input @error('dateDebut') is-invalid @enderror" required>
                        @error('dateDebut')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-col">
                        <label class="field-label">Date de fin <span class="required">*</span></label>
                        <input type="date" name="dateFin"
                               value="{{ old('dateFin') }}"
                               class="field-input @error('dateFin') is-invalid @enderror" required>
                        @error('dateFin')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="modal-row">
                    <div class="form-col">
                        <label class="field-label">Montant demandé (F CFA)</label>
                        <input type="number" name="montantDemande"
                               value="{{ old('montantDemande') }}"
                               class="field-input @error('montantDemande') is-invalid @enderror"
                               placeholder="0" min="0" step="1">
                        @error('montantDemande')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-col">
                        <label class="field-label">Statut</label>
                        <select name="statutActivite" class="field-input">
                            <option value="en_attente" {{ old('statutActivite','en_attente') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="en_cours"   {{ old('statutActivite') == 'en_cours'   ? 'selected' : '' }}>En cours</option>
                            <option value="termine"    {{ old('statutActivite') == 'termine'    ? 'selected' : '' }}>Terminé</option>
                            <option value="annule"     {{ old('statutActivite') == 'annule'     ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel"
                        onclick="closeModal('modalPlanifier')">Annuler</button>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
        document.body.style.overflow = '';
    }
    document.querySelectorAll('.modal-overlay').forEach(m => {
        m.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });

    @if($errors->any())
        openModal('modalPlanifier');
    @endif
</script>
@endpush

@endsection
