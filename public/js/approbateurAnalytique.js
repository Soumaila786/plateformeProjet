// public/js/approbateurAnalytique.js

document.addEventListener('DOMContentLoaded', function() {
    // Vérifier que les données existent
    if (!window.approbateurData) return;

    const data = window.approbateurData;

    const animationConfig = { duration: 1800, easing: 'easeOutQuart' };

    // Configuration des couleurs
    const C = {
        indigo:  '#6366f1',
        orange:  '#f97316',
        green:   '#22c55e',
        teal:    '#0d9488',
        red:     '#ef4444',
        gray:    '#9ca3af',
        blue:    '#1d4ed8'
    };

    // Fonction helper pour la transparence
    const T = v => v + '1a';

    //  Donut Chart
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
                animation: animationConfig,
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

    //  Courbe temporelle
    const tempoCanvas = document.getElementById('tempoChart');
    if (tempoCanvas && data.temporel) {
        new Chart(tempoCanvas, {
            type: 'line',
            data: {
                labels: data.temporel.labels,
                datasets: [
                    {
                        label: 'Soumissions',
                        data: data.temporel.soumis,
                        borderColor: C.indigo,
                        backgroundColor: 'rgba(99,102,241,.1)',
                        borderWidth: 2,
                        pointRadius: 4,
                        tension: 0.4,
                        fill: true,
                    },
                    {
                        label: 'Créations',
                        data: data.temporel.creation,
                        borderColor: C.gray,
                        backgroundColor: 'rgba(156,163,175,.07)',
                        borderWidth: 2,
                        borderDash: [5, 4],
                        pointRadius: 3,
                        tension: 0.4,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: animationConfig,
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

    //  Motifs rejet
    const rejetCanvas = document.getElementById('rejetChart');
    if (rejetCanvas && data.motifs) {
        new Chart(rejetCanvas, {
            type: 'bar',
            data: {
                labels: data.motifs.labels,
                datasets: [{
                    label: 'Nombre de rejets',
                    data: data.motifs.values,
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
                animation: animationConfig,
                plugins: { legend: { display: false } },
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

    //  Budget vs demande
    const budgetCanvas = document.getElementById('budgetChart');
    if (budgetCanvas && data.budget) {
        new Chart(budgetCanvas, {
            type: 'bar',
            data: {
                labels: data.budget.labels,
                datasets: [
                    {
                        label: 'Budget déclaré',
                        data: data.budget.totaux,
                        backgroundColor: 'rgba(99,102,241,.12)',
                        borderColor: C.indigo,
                        borderWidth: 2,
                        borderRadius: 4
                    },
                    {
                        label: 'Montant demandé',
                        data: data.budget.demande,
                        backgroundColor: 'rgba(13,148,136,.12)',
                        borderColor: C.teal,
                        borderWidth: 2,
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: animationConfig,
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
                        ticks: {
                            color: '#9ca3af',
                            font: { size: 10 },
                            maxRotation: 30
                        }
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

    //  Distribution tranches
    const trancheCanvas = document.getElementById('trancheChart');
    if (trancheCanvas && data.tranches) {
        new Chart(trancheCanvas, {
            type: 'bar',
            data: {
                labels: data.tranches.labels,
                datasets: [{
                    label: 'Nombre de projets',
                    data: data.tranches.values,
                    backgroundColor: 'rgba(99,102,241,.12)',
                    borderColor: C.indigo,
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: animationConfig,
                plugins: { legend: { display: false } },
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

    //  Secteurs
    const secteurCanvas = document.getElementById('secteurChart');
    if (secteurCanvas && data.secteurs) {
        new Chart(secteurCanvas, {
            type: 'bar',
            data: {
                labels: data.secteurs.labels,
                datasets: [
                    {
                        label: 'Nombre de projets',
                        data: data.secteurs.nb,
                        backgroundColor: 'rgba(99,102,241,.12)',
                        borderColor: C.indigo,
                        borderWidth: 2,
                        borderRadius: 4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Montant demandé',
                        data: data.secteurs.demande,
                        backgroundColor: 'rgba(13,148,136,.12)',
                        borderColor: C.teal,
                        borderWidth: 2,
                        borderRadius: 4,
                        yAxisID: 'y2'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: animationConfig,
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
                            callback: function(v) {
                                return v >= 1000000 ? (v/1000000).toFixed(0) + 'M' : v;
                            }
                        }
                    }
                }
            }
        });
    }

    //  Matrice scatter
    const matriceCanvas = document.getElementById('matriceChart');
    if (matriceCanvas && data.matrice && data.matrice.length > 0) {
        new Chart(matriceCanvas, {
            type: 'bubble',
            data: {
                datasets: [{
                    label: 'Projets en attente',
                    data: data.matrice.map(p => ({
                        x: p.x,
                        y: p.y,
                        r: Math.max(5, Math.min(20, p.age / 3))
                    })),
                    backgroundColor: 'rgba(99,102,241,.2)',
                    borderColor: C.indigo,
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: animationConfig,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                const p = data.matrice[ctx.dataIndex];
                                return [
                                    `${p.label}`,
                                    `Montant: ${p.x}M F CFA`,
                                    `Durée: ${p.y} mois`,
                                    `Age: ${p.age} j`
                                ];
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Montant demandé (M F CFA)',
                            color: '#9ca3af',
                            font: { size: 11 }
                        },
                        grid: { color: '#f3f4f6' },
                        ticks: { color: '#9ca3af', font: { size: 11 } }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Durée (mois)',
                            color: '#9ca3af',
                            font: { size: 11 }
                        },
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: { color: '#9ca3af', font: { size: 11 } }
                    }
                }
            }
        });
    }
});
