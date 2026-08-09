document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('userFormRole');
    if (!select) return;

    function appliquer() {
        const role = select.value;
        document.querySelectorAll('.champ-role').forEach((champ) => {
            const roles = (champ.dataset.roleVisible || '').split(',');
            champ.style.display = roles.includes(role) ? '' : 'none';
        });
    }

    select.addEventListener('change', appliquer);
    appliquer();
});
