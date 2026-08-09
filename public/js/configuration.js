document.addEventListener('DOMContentLoaded', () => {

    // ── Onglets par groupe ──
    document.querySelectorAll('[data-conf-tab]').forEach((tab) => {
        tab.addEventListener('click', () => {
            const groupe = tab.dataset.confTab;

            document.querySelectorAll('[data-conf-tab]').forEach((t) => t.classList.remove('active'));
            tab.classList.add('active');

            document.querySelectorAll('[data-conf-groupe]').forEach((g) => {
                g.classList.toggle('active', g.dataset.confGroupe === groupe);
            });
        });
    });

    // ── Réinitialisation d'un champ ──
    // On ne peut pas imbriquer un <form> dans le formulaire principal (qui est
    // en PUT spoofé), donc on construit un petit formulaire POST à la volée.
    document.querySelectorAll('[data-reset-cle]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = btn.dataset.resetUrl;
            form.style.display = 'none';

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrf);

            document.body.appendChild(form);
            form.submit();
        });
    });
});
