document.addEventListener('DOMContentLoaded', function () {

    const sidebar    = document.getElementById('mainSidebar');
    const toggleBtn  = document.getElementById('toggleSidebar');
    const toggleIcon = document.getElementById('toggleIcon');
    const toggleText = document.querySelector('.toggle-text');

    if (!sidebar || !toggleBtn) return;

    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        sidebar.classList.add('collapsed');
        toggleIcon.classList.replace('fa-chevron-left', 'fa-chevron-right');
        if (toggleText) toggleText.textContent = 'Agrandir';
    }

    toggleBtn.addEventListener('click', function (e) {
        e.preventDefault();
        sidebar.classList.toggle('collapsed');
        const collapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', collapsed);
        if (collapsed) {
            toggleIcon.classList.remove('fa-chevron-left');
            toggleIcon.classList.add('fa-chevron-right');
            if (toggleText) toggleText.textContent = 'Agrandir';
        } else {
            toggleIcon.classList.remove('fa-chevron-right');
            toggleIcon.classList.add('fa-chevron-left');
            if (toggleText) toggleText.textContent = 'Réduire';
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth <= 768) sidebar.classList.remove('collapsed');
    });
});
