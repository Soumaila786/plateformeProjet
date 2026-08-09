function ouvrirModal(id) {
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
}

function fermerModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = '';
}

function ouvrirModalApprouver(actionUrl, titreProjet) {
    const form = document.getElementById('formApprouver');
    if (!form) return;
    form.action = actionUrl;
    document.getElementById('modalApprouverTexte').textContent =
        'Le projet « ' + titreProjet + ' » sera transmis à l’étape suivante.';
    ouvrirModal('modalApprouver');
}

function ouvrirModalRejeter(actionUrl, titreProjet) {
    const form = document.getElementById('formRejeter');
    if (!form) return;
    form.action = actionUrl;
    document.getElementById('modalRejeterTitre').textContent = titreProjet;
    // Réinitialise les cases cochées d'un précédent projet
    form.querySelectorAll('input[name="motifs[]"]').forEach(cb => cb.checked = false);
    form.querySelector('textarea[name="commentaire_libre"]').value = '';
    ouvrirModal('modalRejeter');
}

function ouvrirModalDemandeModification(actionUrl, titreProjet) {
    const form = document.getElementById('formDemandeModification');
    if (!form) return;
    form.action = actionUrl;
    document.getElementById('modalDemandeModificationTitre').textContent = titreProjet;
    form.querySelectorAll('input[name="motifs[]"]').forEach(cb => cb.checked = false);
    form.querySelector('textarea[name="commentaire_libre"]').value = '';
    ouvrirModal('modalDemandeModification');
}

function ouvrirModalActivite(actionUrl, mode, donnees) {
    const form = document.getElementById('formActivite');
    if (!form) return;

    form.action = actionUrl;

    const methodDiv = document.getElementById('formActiviteMethod');
    const titre = document.getElementById('modalActiviteTitre');
    const boutonTexte = document.getElementById('modalActiviteBoutonTexte');

    const champs = ['activite', 'indicateur', 'uniteIndicateur', 'periode', 'coutEstimatif', 'resultatsAttendues'];

    if (mode === 'edit' && donnees) {
        methodDiv.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        titre.innerHTML = '<i class="fas fa-pencil-alt"></i> Modifier l\'activité';
        boutonTexte.textContent = 'Mettre à jour';

        document.getElementById('activiteChamp_activite').value = donnees.activite || '';
        document.getElementById('activiteChamp_indicateur').value = donnees.indicateur || '';
        document.getElementById('activiteChamp_uniteIndicateur').value = donnees.uniteIndicateur || '';
        document.getElementById('activiteChamp_periode').value = donnees.periode || '';
        document.getElementById('activiteChamp_coutEstimatif').value = donnees.coutEstimatif || '';
        document.getElementById('activiteChamp_resultatsAttendues').value = donnees.resultatsAttendues || '';
    } else {
        methodDiv.innerHTML = '';
        titre.innerHTML = '<i class="fas fa-tasks"></i> Ajouter une activité';
        boutonTexte.textContent = 'Enregistrer';
        champs.forEach(c => {
            const el = document.getElementById('activiteChamp_' + c);
            if (el) el.value = '';
        });
    }

    ouvrirModal('modalActivite');
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.modal-overlay').forEach(m => {
        m.addEventListener('click', e => { if (e.target === m) fermerModal(m.id); });
    });
});
