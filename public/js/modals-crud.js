// Comportement générique des modales mutualisées créer/modifier, réutilisé par
// projets, utilisateurs, secteurs, motifs de rejet... Un seul modal par entité,
// rempli différemment selon qu'on clique "Nouveau" ou "Modifier".

function openModal(id) {
    document.getElementById(id)?.classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id)?.classList.remove('active');
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.lp-modal-overlay').forEach((m) => {
        m.addEventListener('click', (e) => { if (e.target === m) closeModal(m.id); });
    });

    // Bouton "Nouveau X" : data-modal-new="idModal" data-modal-action="url de création"
    document.querySelectorAll('[data-modal-new]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const modalId = btn.dataset.modalNew;
            const form = document.querySelector('#' + modalId + ' form');
            form.reset();
            form.action = btn.dataset.modalAction;
            const methodField = form.querySelector('[data-modal-method]');
            if (methodField) methodField.value = '';

            const titre = document.querySelector('#' + modalId + ' [data-modal-titre]');
            if (titre) titre.textContent = btn.dataset.modalTitreCreation || 'Créer';

            // Hook optionnel : un champ à cacher en création (ex: upload doc en édition seule)
            document.querySelectorAll('#' + modalId + ' [data-hide-on-edit]').forEach(el => el.style.display = '');

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
            const methodField = form.querySelector('[data-modal-method]');
            if (methodField) methodField.value = 'PUT';

            const titre = document.querySelector('#' + modalId + ' [data-modal-titre]');
            if (titre) titre.textContent = btn.dataset.modalTitreEdition || 'Modifier';

            const champs = JSON.parse(btn.dataset.modalFields || '{}');
            Object.entries(champs).forEach(([nom, valeur]) => {
                const champ = form.querySelector(`[name="${nom}"]`);
                if (!champ) return;
                if (champ.type === 'checkbox') champ.checked = !!valeur;
                else champ.value = valeur ?? '';
                // Déclenche les listeners 'change' (utile pour les champs conditionnels par rôle)
                champ.dispatchEvent(new Event('change'));
            });

            document.querySelectorAll('#' + modalId + ' [data-hide-on-edit]').forEach(el => el.style.display = 'none');

            openModal(modalId);
        });
    });
});
