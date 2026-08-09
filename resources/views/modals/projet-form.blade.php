<div id="modalProjetForm" class="lp-modal-overlay">
    <div class="lp-modal-box lp-modal-lg">
        <div class="lp-modal-head">
            <h3 class="lp-modal-title" data-modal-titre>Nouveau projet</h3>
            <button onclick="closeModal('modalProjetForm')"
                class="lp-modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- action/méthode réinitialisés en JS selon "Nouveau" ou "Modifier" (voir listes-projets.js) --}}
        <form method="POST" action="{{ route('porteur.projets.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="" data-modal-method>

            <div class="lp-modal-body">
                @php $projet = null; @endphp
                @include('projets.partials._form')
            </div>

            <div class="lp-modal-foot">
                <button type="button" onclick="closeModal('modalProjetForm')" class="btn btn-light btn-sm">Annuler</button>
                <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
