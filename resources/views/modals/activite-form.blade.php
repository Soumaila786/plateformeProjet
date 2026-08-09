<div id="modalActiviteForm" class="lp-modal-overlay">
    <div class="lp-modal-box">
        <div class="lp-modal-head">
            <h3 class="lp-modal-title" data-modal-titre>Nouvelle activité</h3>
            <button onclick="closeModal('modalActiviteForm')" class="lp-modal-close"><i class="fas fa-times"></i></button>
        </div>

        {{-- action/méthode basculés en JS selon "Nouveau" ou "Modifier" (voir modals-crud.js) --}}
        <form method="POST" action="">
            @csrf
            <input type="hidden" name="_method" value="" data-modal-method>

            <div class="lp-modal-body">
                <div class="mb-3">
                    <label class="form-label small">Intitulé de l'activité</label>
                    <input type="text" name="activitePlanification" class="form-control" required maxlength="255">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small">Indicateur (nombre)</label>
                        <input type="number" name="indicateur" class="form-control" required min="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Unité de l'indicateur</label>
                        <input type="text" name="uniteIndicateur" class="form-control" required maxlength="100" placeholder="Ex : bénéficiaires, unités...">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small">Résultats attendus</label>
                    <textarea name="resultatsAttendues" rows="3" class="form-control" required></textarea>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small">Coût estimatif (FCFA)</label>
                        <input type="number" name="coutEstimatif" class="form-control" required min="0" step="1">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Période</label>
                        <input type="text" name="periode" class="form-control" required maxlength="100" placeholder="Ex : Trimestre 1 2027">
                    </div>
                </div>
            </div>

            <div class="lp-modal-foot">
                <button type="button" onclick="closeModal('modalActiviteForm')" class="btn btn-light btn-sm">Annuler</button>
                <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
