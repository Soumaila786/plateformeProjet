// Comportements partagés par toutes les listes de projets (admin, porteur,
// approbateur, validateur, planificateur) — généralisé depuis l'existant
// (recherche/openModal/closeModal du profil approbateur).

function openModal(id) {
    document.getElementById(id)?.classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id)?.classList.remove('active');
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', () => {

    // Fermeture au clic sur l'overlay
    document.querySelectorAll('.lp-modal-overlay').forEach((m) => {
        m.addEventListener('click', (e) => { if (e.target === m) closeModal(m.id); });
    });

    // Recherche avec debounce (recharge la page avec ?search=...)
    const searchInput = document.getElementById('lpSearchInput');
    if (searchInput) {
        let timer;
        searchInput.addEventListener('input', function () {
            clearTimeout(timer);
            const val = this.value;
            timer = setTimeout(() => {
                const url = new URL(window.location.href);
                url.searchParams.set('search', val);
                url.searchParams.delete('page');
                window.location.href = url.toString();
            }, 450);
        });
    }

    // Filtre secteur (auto-submit au changement)
    const secteurSelect = document.getElementById('lpSecteurSelect');
    secteurSelect?.addEventListener('change', function () {
        const url = new URL(window.location.href);
        if (this.value) url.searchParams.set('secteur_id', this.value);
        else url.searchParams.delete('secteur_id');
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    // Filtre statut (auto-submit au changement)
    const statutSelect = document.getElementById('lpStatutSelect');
    statutSelect?.addEventListener('change', function () {
        const url = new URL(window.location.href);
        if (this.value) url.searchParams.set('statut', this.value);
        else url.searchParams.delete('statut');
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    // ── Modale mutualisée création/modification (ex: projet, utilisateur...) ──
    // Bouton "Nouveau" : data-modal-new="idModal" data-modal-action="url de création"
    document.querySelectorAll('[data-modal-new]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const modalId = btn.dataset.modalNew;
            const form = document.querySelector('#' + modalId + ' form');
            form.reset();
            form.action = btn.dataset.modalAction;
            form.querySelector('[data-modal-method]').value = '';
            const titre = document.querySelector('#' + modalId + ' [data-modal-titre]');
            if (titre) titre.textContent = btn.dataset.modalTitreCreation || 'Créer';

            const champDocuments = document.getElementById('lpDocumentsUpload');
            if (champDocuments) champDocuments.style.display = '';

            openModal(modalId);
        });
    });

    // Bouton "Modifier" : data-modal-edit="idModal" data-modal-action="url de mise à jour"
    // data-modal-fields='{"champ1":"valeur1", ...}' (JSON, clés = attribut name des inputs)
    document.querySelectorAll('[data-modal-edit]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const modalId = btn.dataset.modalEdit;
            const form = document.querySelector('#' + modalId + ' form');
            form.reset();
            form.action = btn.dataset.modalAction;
            form.querySelector('[data-modal-method]').value = 'PUT';

            const titre = document.querySelector('#' + modalId + ' [data-modal-titre]');
            if (titre) titre.textContent = btn.dataset.modalTitreEdition || 'Modifier';

            const champs = JSON.parse(btn.dataset.modalFields || '{}');
            Object.entries(champs).forEach(([nom, valeur]) => {
                const champ = form.querySelector(`[name="${nom}"]`);
                if (champ) champ.value = valeur ?? '';
            });

            const champDocuments = document.getElementById('lpDocumentsUpload');
            if (champDocuments) champDocuments.style.display = 'none';

            openModal(modalId);
        });
    });
});
