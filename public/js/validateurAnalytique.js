// public/js/validateurAnalytique.js

document.addEventListener('DOMContentLoaded', function() {
    // Vérifier que les éléments existent avant de créer les graphiques
    const donutCanvas = document.getElementById('donutChart');
    const delaiCanvas = document.getElementById('delaiChart');
    const secteurCanvas = document.getElementById('secteurChart');
    const evolutionCanvas = document.getElementById('evolutionChart');

    // Configuration des couleurs
    const TEAL = '#0d9488';
    const TEAL_T = 'rgba(13,148,136,.12)';
    const INDIGO = '#6366f1';
    const PALETTE = [TEAL, '#6366f1', '#22c55e', '#f97316', '#ef4444', '#9ca3af', '#1d4ed8'];

    // Récupérer les données depuis les attributs data ou depuis les variables globales
    const chartData = window.chartData || {};

    // ── Donut Chart ──
    if (donutCanvas && chartData.donut) {
        new Chart(donutCanvas, {
            type: 'doughnut',
            data: {
                labels: chartData.donut.labels,
                datasets: [{
                    data: chartData.donut.values,
                    backgroundColor: PALETTE,
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 11 },
                            color: '#6b7280',
                            padding: 14,
                            boxWidth: 12
                        }
                    }
                }
            }
        });
    }

    // ── Délais Chart ──
    if (delaiCanvas && chartData.delais) {
        new Chart(delaiCanvas, {
            type: 'bar',
            data: {
                labels: chartData.delais.labels,
                datasets: [{
                    label: 'Jours (moyenne)',
                    data: chartData.delais.values,
                    backgroundColor: [TEAL_T, 'rgba(99,102,241,.12)', 'rgba(249,115,22,.12)'],
                    borderColor: [TEAL, INDIGO, '#f97316'],
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: { color: '#9ca3af', font: { size: 11 } },
                        title: { display: true, text: 'Jours', color: '#9ca3af', font: { size: 11 } }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { color: '#374151', font: { size: 11 } }
                    }
                }
            }
        });
    }

    // ── Secteurs barres groupées ──
    if (secteurCanvas && chartData.secteurs) {
        new Chart(secteurCanvas, {
            type: 'bar',
            data: {
                labels: chartData.secteurs.labels,
                datasets: [
                    {
                        label: 'Budget déclaré',
                        data: chartData.secteurs.budget,
                        backgroundColor: TEAL_T,
                        borderColor: TEAL,
                        borderWidth: 2,
                        borderRadius: 4,
                    },
                    {
                        label: 'Montant demandé',
                        data: chartData.secteurs.demande,
                        backgroundColor: 'rgba(99,102,241,.12)',
                        borderColor: INDIGO,
                        borderWidth: 2,
                        borderRadius: 4,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 11 },
                            color: '#6b7280',
                            boxWidth: 12,
                            padding: 14
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9ca3af', font: { size: 11 } }
                    },
                    y: {
                        grid: { color: '#f3f4f6' },
                        ticks: {
                            color: '#9ca3af',
                            font: { size: 11 },
                            callback: function(v) {
                                return v >= 1000000 ? (v/1000000).toFixed(1) + 'M' : v;
                            }
                        }
                    }
                }
            }
        });
    }

    // ── Évolution cumulative ──
    if (evolutionCanvas && chartData.evolution) {
        new Chart(evolutionCanvas, {
            type: 'line',
            data: {
                labels: chartData.evolution.labels,
                datasets: [{
                    label: 'Cumul demandes (F CFA)',
                    data: chartData.evolution.values,
                    borderColor: TEAL,
                    backgroundColor: TEAL_T,
                    borderWidth: 2.5,
                    pointBackgroundColor: TEAL,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9ca3af', font: { size: 11 } }
                    },
                    y: {
                        grid: { color: '#f3f4f6' },
                        beginAtZero: true,
                        ticks: {
                            color: '#9ca3af',
                            font: { size: 11 },
                            callback: function(v) {
                                return v >= 1000000 ? (v/1000000).toFixed(1) + 'M' : v;
                            }
                        }
                    }
                }
            }
        });
    }
});
