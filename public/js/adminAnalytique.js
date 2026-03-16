// public/js/adminAnalytique.js

const C = {
    indigo: '#6366f1',
    orange: '#f97316',
    green: '#22c55e',
    teal: '#0d9488',
    red: '#ef4444',
    gray: '#9ca3af'
};

// Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    
    // ── Donut ──
    if (document.getElementById('donutChart')) {
        new Chart(document.getElementById('donutChart'), {
            type: 'doughnut',
            data: {
                labels: window.statutLabels || [],
                datasets: [{
                    data: window.statutValues || [],
                    backgroundColor: window.statutColors || [],
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
    if (document.getElementById('evolutionChart')) {
        new Chart(document.getElementById('evolutionChart'), {
            type: 'line',
            data: {
                labels: window.moisLabels || [],
                datasets: [
                    {
                        label: 'Soumissions',
                        data: window.moisSoumis || [],
                        borderColor: C.indigo,
                        backgroundColor: 'rgba(99,102,241,.1)',
                        borderWidth: 2,
                        pointRadius: 4,
                        tension: 0.4,
                        fill: true,
                    },
                    {
                        label: 'Validations',
                        data: window.moisValides || [],
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
                        ticks: { color: '#9ca3af', font: { size: 11 }, stepSize: 1 }
                    }
                }
            }
        });
    }

    // ── Motifs rejet ──
    if (document.getElementById('rejetChart')) {
        new Chart(document.getElementById('rejetChart'), {
            type: 'bar',
            data: {
                labels: window.motifsLabels || [],
                datasets: [{
                    label: 'Occurrences',
                    data: window.motifsValues || [],
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
                        ticks: { color: '#9ca3af', font: { size: 11 }, stepSize: 1 }
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
    if (document.getElementById('secteurChart')) {
        new Chart(document.getElementById('secteurChart'), {
            type: 'bar',
            data: {
                labels: window.sectLabels || [],
                datasets: [
                    {
                        label: 'Nb projets',
                        data: window.sectNb || [],
                        backgroundColor: 'rgba(99,102,241,.12)',
                        borderColor: C.indigo,
                        borderWidth: 2,
                        borderRadius: 4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Nb validés',
                        data: window.sectValide || [],
                        backgroundColor: 'rgba(13,148,136,.12)',
                        borderColor: C.teal,
                        borderWidth: 2,
                        borderRadius: 4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Montant demandé (M)',
                        data: (window.sectDemande || []).map(v => +(v / 1000000).toFixed(1)),
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
                        ticks: { color: '#9ca3af', font: { size: 11 }, stepSize: 1 }
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
    if (document.getElementById('equipeChart')) {
        const equipeColors = (window.equipeRoles || []).map(r =>
            r === 'Approbateur' ? 'rgba(99,102,241,.2)' : 'rgba(13,148,136,.2)'
        );
        const equipeBorders = (window.equipeRoles || []).map(r =>
            r === 'Approbateur' ? C.indigo : C.teal
        );
        
        new Chart(document.getElementById('equipeChart'), {
            type: 'bar',
            data: {
                labels: window.equipeLabels || [],
                datasets: [{
                    label: 'Projets traités',
                    data: window.equipeNb || [],
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
                            label: ctx => {
                                const role = (window.equipeRoles || [])[ctx.dataIndex];
                                return ` ${ctx.parsed.x} projets traités (${role})`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: { color: '#9ca3af', font: { size: 11 }, stepSize: 1 }
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