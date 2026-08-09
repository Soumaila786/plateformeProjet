<x-cards.info titre="Informations du projet" icon="fa-circle-info" class="mb-3">
    <p class="mb-3">{{ $projet->description }}</p>

    @if ($projet->objectif)
        <p class="text-muted small mb-3"><strong>Objectif :</strong> {{ $projet->objectif }}</p>
    @endif

    <div class="row g-3">
        <div class="col-sm-6 col-lg-3">
            <div class="text-muted small">Durée</div>
            <div class="fw-semibold">{{ $projet->duree ? $projet->duree.' mois' : '—' }}</div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="text-muted small">Période</div>
            <div class="fw-semibold">
                {{ optional($projet->dateDebut)->format('d/m/Y') ?? '—' }} → {{ optional($projet->dateFin)->format('d/m/Y') ?? '—' }}
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="text-muted small">Budget total</div>
            <div class="fw-semibold font-monospace">{{ number_format($projet->budgetTotal ?? 0, 0, ',', ' ') }} FCFA</div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="text-muted small">Montant demandé</div>
            <div class="fw-semibold font-monospace">{{ number_format($projet->montantDemande ?? 0, 0, ',', ' ') }} FCFA</div>
        </div>
    </div>

    <hr class="my-3">

    <div class="row g-3 text-muted small">
        <div class="col-sm-4">
            <i class="fas fa-paper-plane me-1"></i>Soumis le {{ optional($projet->dateSoumission)->format('d/m/Y') ?? '—' }}
        </div>
        <div class="col-sm-4">
            <i class="fas fa-check me-1"></i>Approuvé le {{ optional($projet->dateApprobation)->format('d/m/Y') ?? '—' }}
        </div>
        <div class="col-sm-4">
            <i class="fas fa-check-double me-1"></i>Validé le {{ optional($projet->dateValidation)->format('d/m/Y') ?? '—' }}
        </div>
    </div>
</x-cards.info>
