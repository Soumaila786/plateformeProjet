@extends('layouts.app')

@section('title', 'Tableau de bord')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')

<div class="dashboard">

    {{---- Header -----}}
    <div class="dash-header">
        <div>
            <h1 class="dash-title">Tableau de bord</h1>
            <p class="dash-subtitle">Vue d'ensemble de la gestion des projets</p>
        </div>
    </div>

    {{------ Stats ------}}
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Projets</span>
                <div class="stat-icon icon-blue">
                    <i class="fas fa-folder"></i>
                </div>
            </div>
            <div class="stat-value">6</div>
            <div class="stat-footer">
                <span class="stat-badge badge-green"><i class="fas fa-arrow-up"></i> +12%</span>
                <span class="stat-note">ce mois</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Utilisateurs</span>
                <div class="stat-icon icon-green">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-value">5</div>
            <div class="stat-footer">
                <span class="stat-note">8 au total</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Approuvés</span>
                <div class="stat-icon icon-yellow">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="stat-value">2</div>
            <div class="stat-footer">
                <span class="stat-badge badge-green"><i class="fas fa-arrow-up"></i> +8%</span>
                <span class="stat-note">ce mois</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">En cours d'examen</span>
                <div class="stat-icon icon-cyan">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="stat-value">2</div>
        </div>

    </div>

    {{-- ── Budget + Projets récents ── --}}
    <div class="dash-row">

        {{-- Budget --}}
        <div class="dash-card budget-card">
            <h2 class="card-title">Budget global</h2>
            <div class="budget-total">875 000 000 F CFA</div>
            <p class="budget-label">Budget total alloué</p>
            <div class="budget-list">
                <div class="budget-item">
                    <span class="budget-name">Digitalisation des services publics</span>
                    <span class="budget-amount">150M FCFA</span>
                </div>
                <div class="budget-item">
                    <span class="budget-name">Programme Agri-Tech</span>
                    <span class="budget-amount">85M FCFA</span>
                </div>
                <div class="budget-item">
                    <span class="budget-name">Centres de santé communautaires</span>
                    <span class="budget-amount">320M FCFA</span>
                </div>
                <div class="budget-item">
                    <span class="budget-name">Formation des enseignants</span>
                    <span class="budget-amount">45M FCFA</span>
                </div>
            </div>
        </div>

        {{-- Projets récents --}}
        <div class="dash-card projects-card">
            <div class="card-head">
                <h2 class="card-title">Projets récents</h2>
                <a href="/admin/projets" class="card-link">
                    Voir tout <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="project-list">

                <a href="/admin/projets/1" class="project-row">
                    <div class="project-info">
                        <div class="project-meta">
                            <span class="project-ref">PRJ-2024-001</span>
                            <span class="status-badge status-green">Approuvé</span>
                        </div>
                        <p class="project-name">Digitalisation des services publics</p>
                        <p class="project-sub">Fatou Sow · 24 mois</p>
                    </div>
                    <span class="project-budget">150M FCFA</span>
                </a>

                <a href="/admin/projets/2" class="project-row">
                    <div class="project-info">
                        <div class="project-meta">
                            <span class="project-ref">PRJ-2024-002</span>
                            <span class="status-badge status-yellow">En examen</span>
                        </div>
                        <p class="project-name">Programme Agri-Tech</p>
                        <p class="project-sub">Ibrahima Fall · 18 mois</p>
                    </div>
                    <span class="project-budget">85M FCFA</span>
                </a>

                <a href="/admin/projets/3" class="project-row">
                    <div class="project-info">
                        <div class="project-meta">
                            <span class="project-ref">PRJ-2024-003</span>
                            <span class="status-badge status-gray">Brouillon</span>
                        </div>
                        <p class="project-name">Centres de santé communautaires</p>
                        <p class="project-sub">Fatou Sow · 36 mois</p>
                    </div>
                    <span class="project-budget">320M FCFA</span>
                </a>

            </div>
        </div>

    </div>

    {{-- ── Planification ── --}}
    <div class="dash-card">
        <h2 class="card-title mb-4">Planification en cours</h2>
        <div class="plan-list">

            <div class="plan-row">
                <div class="plan-info">
                    <p class="plan-name">Analyse des besoins</p>
                    <p class="plan-sub">Digitalisation des services publics · 15 000 000 F CFA</p>
                </div>
                <div class="plan-bar-wrap">
                    <div class="plan-bar">
                        <div class="plan-fill fill-yellow" style="width: 55%"></div>
                    </div>
                    <span class="plan-pct">55%</span>
                </div>
                <span class="status-badge status-yellow">En cours</span>
            </div>

            <div class="plan-row">
                <div class="plan-info">
                    <p class="plan-name">Développement Phase 1</p>
                    <p class="plan-sub">Digitalisation des services publics · 50 000 000 F CFA</p>
                </div>
                <div class="plan-bar-wrap">
                    <div class="plan-bar">
                        <div class="plan-fill fill-gray" style="width: 0%"></div>
                    </div>
                    <span class="plan-pct">0%</span>
                </div>
                <span class="status-badge status-gray">En attente</span>
            </div>

            <div class="plan-row">
                <div class="plan-info">
                    <p class="plan-name">Déploiement pilote</p>
                    <p class="plan-sub">Digitalisation des services publics · 30 000 000 F CFA</p>
                </div>
                <div class="plan-bar-wrap">
                    <div class="plan-bar">
                        <div class="plan-fill fill-gray" style="width: 0%"></div>
                    </div>
                    <span class="plan-pct">0%</span>
                </div>
                <span class="status-badge status-gray">En attente</span>
            </div>

        </div>
    </div>

</div>

@endsection