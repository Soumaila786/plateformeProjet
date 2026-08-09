// ============================================================
//  OUVERTURE D'UNE MODAL VIA AJAX
// ============================================================
function openModal(url, modalId) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            // Insérer le HTML dans le conteneur
            const container = document.getElementById('modal-container');
            container.innerHTML = html;

            // Afficher la modal Bootstrap
            const modalElement = document.getElementById(modalId);
            const modal = new bootstrap.Modal(modalElement);
            modal.show();

            // Attacher la soumission du formulaire
            const form = document.querySelector(`#${modalId} form`);
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitFormAjax(form, modal);
                });
            }

            // Gérer l'affichage des champs selon le rôle
            const roleSelect = document.querySelector(`#${modalId} select[name="role"]`);
            if (roleSelect) {
                roleSelect.addEventListener('change', function() {
                    toggleRoleFields(this.value, modalId);
                });
                // Appliquer au chargement
                toggleRoleFields(roleSelect.value, modalId);
            }
        })
        .catch(err => console.error('Erreur de chargement de la modal :', err));
}

// ============================================================
//  SOUMISSION AJAX DU FORMULAIRE
// ============================================================
function submitFormAjax(form, modalInstance) {
    const formData = new FormData(form);
    const url = form.action;
    const method = form.method || 'POST';

    fetch(url, {
        method: method,
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (response.ok) {
            // Succès : fermer la modal et recharger la page
            modalInstance.hide();
            window.location.reload();
        } else {
            // Gestion des erreurs de validation
            return response.json().then(data => {
                console.error('Erreurs de validation :', data.errors);
                // Ici vous pouvez afficher les erreurs sous les champs
                // Exemple : afficher une alerte ou injecter des messages
                alert('Des erreurs sont survenues. Consultez la console.');
            });
        }
    })
    .catch(err => console.error('Erreur lors de la soumission :', err));
}

// ============================================================
//  AFFICHAGE/MASQUAGE DES CHAMPS SPÉCIFIQUES AU RÔLE
// ============================================================
function toggleRoleFields(role, modalId) {
    const container = document.querySelector(`#${modalId} #role-fields`);
    if (!container) return;

    // Cacher tous les groupes
    const groups = container.querySelectorAll('.role-group');
    groups.forEach(group => group.classList.add('d-none'));

    // Afficher celui correspondant au rôle
    const target = container.querySelector(`#${role}-fields`);
    if (target) {
        target.classList.remove('d-none');
    }
}

// ============================================================
//  ÉCOUTEURS D'ÉVÉNEMENTS (après chargement du DOM)
// ============================================================
document.addEventListener('DOMContentLoaded', function() {

    // Bouton "Nouvel utilisateur"
    const btnCreate = document.getElementById('btnCreateUser');
    if (btnCreate) {
        btnCreate.addEventListener('click', function() {
            openModal(window.userRoutes.createModal, 'userFormModal');
        });
    }

    // Boutons "Modifier"
    document.querySelectorAll('.btn-edit-user').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.dataset.id;
            // Construire l'URL en remplaçant le placeholder
            const url = window.userRoutes.editModalBase.replace(/\/$/, '') + '/' + userId + '/edit-modal';
            openModal(url, 'userFormModal');
        });
    });

    // Boutons "Voir"
    document.querySelectorAll('.btn-show-user').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.dataset.id;
            const url = window.userRoutes.showModalBase.replace(/\/$/, '') + '/' + userId + '/show-modal';
            openModal(url, 'showUserModal');
        });
    });

});