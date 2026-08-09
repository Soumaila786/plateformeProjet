<div id="modalMotifForm" class="lp-modal-overlay">
    <div class="lp-modal-box">
        <div class="lp-modal-head">
            <h3 class="lp-modal-title" data-modal-titre>Nouveau motif</h3>
            <button onclick="closeModal('modalMotifForm')" class="lp-modal-close"><i class="fas fa-times"></i></button>
        </div>

        <form method="POST" action="{{ route('admin.motifs.store') }}">
            @csrf
            <input type="hidden" name="_method" value="" data-modal-method>

            <div class="lp-modal-body">
                <div class="mb-3">
                    <label class="form-label small">Libellé</label>
                    <input type="text" name="libelle" class="form-control @error('libelle') is-invalid @enderror" required maxlength="255">
                    @error('libelle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-check" data-hide-on-edit>
                    <input type="checkbox" name="actif" value="1" class="form-check-input" id="motifActif" checked disabled>
                    <label class="form-check-label small" for="motifActif">Motif actif (par défaut à la création)</label>
                </div>
            </div>

            <div class="lp-modal-foot">
                <button type="button" onclick="closeModal('modalMotifForm')" class="btn btn-light btn-sm">Annuler</button>
                <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
