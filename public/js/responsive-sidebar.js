// Sidebar mobile : sous 992px, la sidebar (classe .sidebar existante) devient
// un tiroir plein écran. Ce script est autonome — il n'entre pas en conflit
// avec js/sidebar-toggle.js (qui gère le collapse desktop "Réduire").

document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.sidebar');
    if (!sidebar) return;

    // Bouton hamburger (injecté une seule fois, visible seulement < 992px via CSS)
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'mobile-menu-btn';
    btn.setAttribute('aria-label', 'Ouvrir le menu');
    btn.innerHTML = '<i class="fas fa-bars"></i>';
    document.body.appendChild(btn);

    // Rideau (backdrop) pour fermer au clic en dehors
    const backdrop = document.createElement('div');
    backdrop.className = 'sidebar-backdrop';
    document.body.appendChild(backdrop);

    function ouvrir() {
        sidebar.classList.add('is-open');
        backdrop.classList.add('is-visible');
    }
    function fermer() {
        sidebar.classList.remove('is-open');
        backdrop.classList.remove('is-visible');
    }

    btn.addEventListener('click', () => {
        sidebar.classList.contains('is-open') ? fermer() : ouvrir();
    });
    backdrop.addEventListener('click', fermer);

    // Fermer automatiquement après avoir cliqué un lien du menu (mobile)
    sidebar.querySelectorAll('a.nav-link').forEach((lien) => {
        lien.addEventListener('click', () => {
            if (window.innerWidth < 992) fermer();
        });
    });

    // Si on repasse en desktop, s'assurer que le rideau ne reste pas affiché
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 992) fermer();
    });
});
