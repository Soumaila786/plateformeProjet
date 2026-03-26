// public/js/adminAnalytique.js

document.addEventListener('DOMContentLoaded', function() {
    // Vérifier que les données existent
    if (!window.adminAnalytiqueData) return;

    const data = window.adminAnalytiqueData;

    // Configuration des couleurs
    const C = {
        indigo: '#6366f1',
        orange: '#f97316',
        green: '#22c55e',
        teal: '#0d9488',
        red: '#ef4444',
        gray: '#9ca3af'
    };

    // ── Donut Chart ──
    const donutCanvas = document.getElementById('donutChart');
    if (donutCanvas && data.donut) {
        new Chart(donutCanvas, {
            type: 'doughnut',
            data: {
                labels: data.donut.labels,
                datasets: [{
                    data: data.donut.values,
                    backgroundColor: data.donut.colors,
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 6
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
                            padding: 12,
                            boxWidth: 12
                        }
                    }
                }
            }
        });
    }

    // ── Évolution mensuelle ──
    const evolutionCanvas = document.getElementById('evolutionChart');
    if (evolutionCanvas && data.evolution) {
        new Chart(evolutionCanvas, {
            type: 'line',
            data: {
                labels: data.evolution.labels,
                datasets: [
                    {
                        label: 'Soumissions',
                        data: data.evolution.soumis,
                        borderColor: C.indigo,
                        backgroundColor: 'rgba(99,102,241,.1)',
                        borderWidth: 2,
                        pointRadius: 4,
                        tension: 0.4,
                        fill: true,
                    },
                    {
                        label: 'Validations',
                        data: data.evolution.valides,
                        borderColor: C.teal,
                        backgroundColor: 'rgba(13,148,136,.08)',
                        borderWidth: 2,
                        borderDash: [5, 4],
                        pointRadius: 4,
                        tension: 0.4,
                        fill: false,
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
                            padding: 12,
                            boxWidth: 12
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9ca3af', font: { size: 11 } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: {
                            color: '#9ca3af',
                            font: { size: 11 },
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // ── Motifs rejet ──
    const rejetCanvas = document.getElementById('rejetChart');
    if (rejetCanvas && data.rejets) {
        new Chart(rejetCanvas, {
            type: 'bar',
            data: {
                labels: data.rejets.labels,
                datasets: [{
                    label: 'Occurrences',
                    data: data.rejets.values,
                    backgroundColor: 'rgba(239,68,68,.12)',
                    borderColor: C.red,
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
                        ticks: {
                            color: '#9ca3af',
                            font: { size: 11 },
                            stepSize: 1
                        }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { color: '#374151', font: { size: 11 } }
                    }
                }
            }
        });
    }

    // ── Secteurs double axe ──
    const secteurCanvas = document.getElementById('secteurChart');
    if (secteurCanvas && data.secteurs) {
        new Chart(secteurCanvas, {
            type: 'bar',
            data: {
                labels: data.secteurs.labels,
                datasets: [
                    {
                        label: 'Nb projets',
                        data: data.secteurs.nb,
                        backgroundColor: 'rgba(99,102,241,.12)',
                        borderColor: C.indigo,
                        borderWidth: 2,
                        borderRadius: 4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Nb validés',
                        data: data.secteurs.valides,
                        backgroundColor: 'rgba(13,148,136,.12)',
                        borderColor: C.teal,
                        borderWidth: 2,
                        borderRadius: 4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Montant demandé (M)',
                        data: data.secteurs.demande.map(v => +(v / 1000000).toFixed(1)),
                        backgroundColor: 'rgba(249,115,22,.12)',
                        borderColor: C.orange,
                        borderWidth: 2,
                        borderRadius: 4,
                        yAxisID: 'y2',
                        type: 'line',
                        pointRadius: 4,
                        tension: 0.3,
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
                            padding: 12,
                            boxWidth: 12
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9ca3af', font: { size: 11 } }
                    },
                    y: {
                        position: 'left',
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: {
                            color: '#9ca3af',
                            font: { size: 11 },
                            stepSize: 1
                        }
                    },
                    y2: {
                        position: 'right',
                        beginAtZero: true,
                        grid: { display: false },
                        ticks: {
                            color: '#9ca3af',
                            font: { size: 11 },
                            callback: v => v + 'M'
                        }
                    }
                }
            }
        });
    }

    // ── Charge équipes ──
    const equipeCanvas = document.getElementById('equipeChart');
    if (equipeCanvas && data.equipes) {
        const equipeColors = data.equipes.roles.map(r =>
            r === 'Approbateur' ? 'rgba(99,102,241,.2)' : 'rgba(13,148,136,.2)'
        );
        const equipeBorders = data.equipes.roles.map(r =>
            r === 'Approbateur' ? C.indigo : C.teal
        );

        new Chart(equipeCanvas, {
            type: 'bar',
            data: {
                labels: data.equipes.labels,
                datasets: [{
                    label: 'Projets traités',
                    data: data.equipes.nb,
                    backgroundColor: equipeColors,
                    borderColor: equipeBorders,
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                const role = data.equipes.roles[ctx.dataIndex];
                                return ` ${ctx.parsed.x} projets traités (${role})`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: {
                            color: '#9ca3af',
                            font: { size: 11 },
                            stepSize: 1
                        }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { color: '#374151', font: { size: 11 } }
                    }
                }
            }
        });
    }
});
