// Comportement générique des filtres de liste : un champ recherche avec
// data-filter-search (debounce) et des selects avec data-filter-select
// (auto-submit), tous deux réécrivant l'URL courante (?param=valeur).
// Réutilisé par projets, utilisateurs, secteurs, motifs...

function cifeuUpdateQuery(param, value) {
    const url = new URL(window.location.href);
    if (value) url.searchParams.set(param, value);
    else url.searchParams.delete(param);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

document.addEventListener('DOMContentLoaded', () => {

    const search = document.querySelector('[data-filter-search]');
    if (search) {
        let timer;
        search.addEventListener('input', function () {
            clearTimeout(timer);
            const val = this.value;
            const param = this.dataset.filterSearch || 'search';
            timer = setTimeout(() => cifeuUpdateQuery(param, val), 450);
        });
    }

    document.querySelectorAll('[data-filter-select]').forEach((sel) => {
        sel.addEventListener('change', function () {
            cifeuUpdateQuery(this.name, this.value);
        });
    });
});
