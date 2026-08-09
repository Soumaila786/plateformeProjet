<div id="modalSecteurForm" class="lp-modal-overlay">
    <div class="lp-modal-box">
        <div class="lp-modal-head">
            <h3 class="lp-modal-title" data-modal-titre>Nouveau secteur</h3>
            <button onclick="closeModal('modalSecteurForm')" class="lp-modal-close"><i class="fas fa-times"></i></button>
        </div>

        <form method="POST" action="{{ route('admin.secteurs.store') }}">
            @csrf
            <input type="hidden" name="_method" value="" data-modal-method>

            <div class="lp-modal-body">
                <div class="mb-3">
                    <label class="form-label small">Nom du secteur</label>
                    <input type="text" name="nomSecteur" class="form-control @error('nomSecteur') is-invalid @enderror" required maxlength="255">
                    @error('nomSecteur')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label small">Description</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror" maxlength="500"></textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-check">
                    <input type="checkbox" name="statutSecteur" value="1" class="form-check-input" id="secteurStatutActif" checked>
                    <label class="form-check-label small" for="secteurStatutActif">Secteur actif</label>
                </div>
            </div>

            <div class="lp-modal-foot">
                <button type="button" onclick="closeModal('modalSecteurForm')" class="btn btn-light btn-sm">Annuler</button>
                <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
