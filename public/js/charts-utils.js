// Petites fonctions d'aide autour de Chart.js, utilisées par
// analytique-admin.js / analytique-approbateur.js / analytique-validateur.js.
// Chaque canvas porte ses données en data-* (JSON) — on les lit ici, jamais
// de données injectées dans un <script> inline au milieu des vues.

function cifeuReadData(canvas) {
    try {
        return JSON.parse(canvas.dataset.chart || '{}');
    } catch (e) {
        console.error('Données de graphique invalides pour', canvas.id, e);
        return {};
    }
}

function cifeuBarChart(canvasId) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    const { labels, values, colors, label } = cifeuReadData(canvas);
    new Chart(canvas, {
        type: 'bar',
        data: { labels, datasets: [{ label: label || '', data: values, backgroundColor: colors || 'var(--color-primary)', borderRadius: 6 }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } },
    });
}

function cifeuLineChart(canvasId) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    const { labels, datasets } = cifeuReadData(canvas);
    new Chart(canvas, {
        type: 'line',
        data: { labels, datasets: (datasets || []).map(d => ({ ...d, tension: .35, fill: false })) },
        options: { responsive: true, plugins: { legend: { display: (datasets || []).length > 1 } } },
    });
}

function cifeuDoughnutChart(canvasId) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    const { labels, values, colors } = cifeuReadData(canvas);
    new Chart(canvas, {
        type: 'doughnut',
        data: { labels, datasets: [{ data: values, backgroundColor: colors }] },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } },
    });
}

function cifeuHorizontalBarChart(canvasId) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    const { labels, values, colors, label } = cifeuReadData(canvas);
    new Chart(canvas, {
        type: 'bar',
        data: { labels, datasets: [{ label: label || '', data: values, backgroundColor: colors || 'var(--color-primary)', borderRadius: 6 }] },
        options: { indexAxis: 'y', responsive: true, plugins: { legend: { display: false } } },
    });
}
