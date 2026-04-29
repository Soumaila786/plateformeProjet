@extends('layouts.app')
@section('title', 'Projet — ' . $projet->titre)
@push('styles')
<link rel="stylesheet" href="{{ asset('css/planifDash.css') }}">
@endpush

@section('content')
<div class="plan-page">

    {{-- Breadcrumb --}}
    <div class="plan-breadcrumb">
        <a href="{{ route('planificateur.dashboard') }}"><i class="fas fa-home"></i></a>
        <span>/</span>
        <a href="{{ route('planificateur.projets.index') }}">Projets</a>
        <span>/</span>
        <span>{{ $projet->codeProjet }}</span>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="plan-alert plan-alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="plan-alert plan-alert-error">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif

    {{-- Header --}}
    <div class="plan-header">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                <span class="plan-projet-code">{{ $projet->codeProjet }}</span>
                @if($projet->planification_demandee)
                <span class="plan-badge plan-badge-orange">
                    <i class="fas fa-hourglass-half" style="font-size:.6rem;"></i> Planification demandée
                </span>
                @else
                <span class="plan-badge plan-badge-green">
                    <i class="fas fa-check" style="font-size:.6rem;"></i> Planifié
                </span>
                @endif
            </div>
            <h1 class="plan-header-title">{{ $projet->titre }}</h1>
            <p class="plan-projet-meta" style="margin-top:4px;">
                <span><i class="fas fa-user"></i>{{ optional($projet->user)->nomComplet ?? '—' }}</span>
                <span><i class="fas fa-tag"></i>{{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
                @if($projet->dateSoumission)
                <span><i class="fas fa-calendar"></i>Soumis le {{ $projet->dateSoumission->format('d/m/Y') }}</span>
                @endif
            </p>
        </div>
        <a href="{{ route('planificateur.projets.index') }}" class="plan-btn-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    {{-- Barre d'actions --}}
    <div class="plan-actions-bar">
        <a href="{{ route('planificateur.planifications.create', $projet) }}"
            class="plan-action-btn plan-action-violet">
            <i class="fas fa-plus"></i> Ajouter une activité
        </a>
    </div>

    {{-- Contenu --}}
    <div class="plan-show-grid">

        {{-- Colonne principale --}}
        <div class="plan-show-main">

            {{-- Infos générales --}}
            <div class="plan-info-card">
                <div class="plan-info-card-head">
                    <span class="plan-info-card-title">
                        <i class="fas fa-info-circle"></i> Informations générales
                    </span>
                </div>
                <div class="plan-info-grid">
                    <div>
                        <p class="plan-info-lbl">Secteur</p>
                        <p class="plan-info-val">{{ optional($projet->secteur)->nomSecteur ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="plan-info-lbl">Durée</p>
                        <p class="plan-info-val">{{ $projet->duree ? $projet->duree.' mois' : '—' }}</p>
                    </div>
                    <div>
                        <p class="plan-info-lbl">Date début</p>
                        <p class="plan-info-val">{{ optional($projet->dateDebut)->format('d/m/Y') ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="plan-info-lbl">Date fin</p>
                        <p class="plan-info-val">{{ optional($projet->dateFin)->format('d/m/Y') ?? '—' }}</p>
                    </div>
                    @if($projet->objectif)
                    <div class="plan-info-full">
                        <p class="plan-info-lbl">Objectif</p>
                        <p class="plan-info-val">{{ $projet->objectif }}</p>
                    </div>
                    @endif
                    <div class="plan-info-full">
                        <p class="plan-info-lbl">Description</p>
                        <p class="plan-info-val" style="white-space:pre-line;">{{ $projet->description ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Activités de planification --}}
            <div class="plan-info-card">
                <div class="plan-info-card-head">
                    <span class="plan-info-card-title">
                        <i class="fas fa-tasks"></i>
                        Activités planifiées
                        <span class="plan-info-count">{{ $projet->planifications->count() }}</span>
                    </span>
                    <a href="{{ route('planificateur.planifications.create', $projet) }}"
                        class="plan-btn plan-btn-outline" style="font-size:.72rem;padding:5px 10px;">
                        <i class="fas fa-plus"></i> Ajouter
                    </a>
                </div>

                <div class="plan-activite-list">
                    @forelse($projet->planifications as $plan)
                    <div class="plan-activite-item">
                        <div class="plan-activite-head">
                            <div class="plan-activite-left">
                                <div class="plan-activite-num">{{ $loop->iteration }}</div>
                                <p class="plan-activite-titre">{{ $plan->activitePlanification }}</p>
                            </div>
                            <div class="plan-activite-actions">
                                <a href="{{ route('planificateur.planifications.edit', [$projet, $plan]) }}"
                                    class="plan-btn plan-btn-edit" title="Modifier">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form method="POST"
                                        action="{{ route('planificateur.planifications.destroy', [$projet, $plan]) }}"
                                        onsubmit="return confirm('Supprimer cette activité ?')"
                                        style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="plan-btn plan-btn-del" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="plan-activite-details">
                            @if($plan->indicateur)
                            <div>
                                <span class="plan-activite-detail-lbl">Indicateur : </span>
                                <span class="plan-activite-detail-val">
                                    {{ $plan->indicateur }}
                                    @if($plan->uniteIndicateur) ({{ $plan->uniteIndicateur }}) @endif
                                </span>
                            </div>
                            @endif
                            @if($plan->periode)
                            <div>
                                <span class="plan-activite-detail-lbl">Période : </span>
                                <span class="plan-activite-detail-val">{{ $plan->periode }}</span>
                            </div>
                            @endif
                            @if($plan->coutEstimatif)
                            <div>
                                <span class="plan-activite-detail-lbl">Coût : </span>
                                <span class="plan-activite-cout">
                                    {{ number_format($plan->coutEstimatif, 0, ',', ' ') }} F CFA
                                </span>
                            </div>
                            @endif
                            @if($plan->resultatsAttendues)
                            <div class="plan-activite-detail-full">
                                <span class="plan-activite-detail-lbl">Résultats attendus : </span>
                                <span class="plan-activite-detail-val">{{ $plan->resultatsAttendues }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="plan-empty" style="padding:24px 16px;">
                        <i class="fas fa-calendar-plus"></i>
                        <p>Aucune activité planifiée.</p>
                        <a href="{{ route('planificateur.planifications.create', $projet) }}"
                            class="plan-btn plan-btn-primary" style="margin-top:8px;">
                            <i class="fas fa-plus"></i> Ajouter une activité
                        </a>
                    </div>
                    @endforelse
                </div>

                @if($projet->planifications->count() > 0)
                <div class="plan-total-bar">
                    <span class="plan-total-label">Total estimé :</span>
                    <span class="plan-total-val">
                        {{ number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ') }} F CFA
                    </span>
                </div>
                @endif
            </div>

            {{-- Documents --}}
            @if($projet->documents->count())
            <div class="plan-info-card">
                <div class="plan-info-card-head">
                    <span class="plan-info-card-title">
                        <i class="fas fa-paperclip"></i> Documents
                        <span class="plan-info-count">{{ $projet->documents->count() }}</span>
                    </span>
                </div>
                <div style="display:flex;flex-direction:column;gap:6px;">
                    @foreach($projet->documents as $doc)
                    <a href="{{ asset('storage/'.$doc->cheminFichier) }}" target="_blank"
                        style="display:flex;align-items:center;gap:8px;padding:8px 10px;
                                border-radius:var(--plan-radius-md);background:var(--plan-bg-light);
                                border:1px solid var(--plan-border);text-decoration:none;
                                color:var(--plan-text-gray);font-size:.8rem;
                                transition:background var(--plan-transition);"
                        onmouseover="this.style.background='var(--plan-primary-light)'"
                        onmouseout="this.style.background='var(--plan-bg-light)'">
                        <i class="fas fa-file-alt" style="color:var(--plan-primary);"></i>
                        <span style="flex:1;">{{ $doc->nomFichier ?? basename($doc->cheminFichier) }}</span>
                        <i class="fas fa-external-link-alt" style="font-size:.65rem;color:var(--plan-text-light);"></i>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- Colonne aside --}}
        <div class="plan-show-aside">

            {{-- Budget --}}
            <div class="plan-aside-card">
                <p class="plan-aside-title"><i class="fas fa-wallet"></i> Budget</p>
                <div class="plan-fin-rows">
                    <div class="plan-fin-row">
                        <span>Budget total</span>
                        <strong>{{ number_format($projet->budgetTotal ?? 0, 0, ',', ' ') }} F CFA</strong>
                    </div>
                    <div class="plan-fin-row">
                        <span>Montant demandé</span>
                        <strong>{{ number_format($projet->montantDemande ?? 0, 0, ',', ' ') }} F CFA</strong>
                    </div>
                    @if($projet->planifications->count())
                    <div class="plan-fin-row">
                        <span>Coût planifié</span>
                        <strong style="color:var(--plan-primary);">
                            {{ number_format($projet->planifications->sum('coutEstimatif'), 0, ',', ' ') }} F CFA
                        </strong>
                    </div>
                    @if(($projet->budgetTotal ?? 0) > 0)
                    @php $pct = min(100, round($projet->planifications->sum('coutEstimatif') / $projet->budgetTotal * 100)); @endphp
                    <div class="plan-fin-row" style="border-bottom:none;">
                        <span>Couverture</span>
                        <strong>{{ $pct }}%</strong>
                    </div>
                    <div style="margin-top:6px;">
                        <div class="plan-progress-bar">
                            <div class="plan-progress-fill" style="width:{{ $pct }}%;"></div>
                        </div>
                    </div>
                    @endif
                    @endif
                </div>
            </div>

            {{-- Porteur --}}
            <div class="plan-aside-card">
                <p class="plan-aside-title"><i class="fas fa-user"></i> Porteur</p>
                <div class="plan-porteur-block">
                    <div class="plan-porteur-avatar">
                        {{ strtoupper(substr(optional($projet->user)->nomComplet ?? 'P', 0, 1)) }}
                    </div>
                    <div>
                        <p class="plan-porteur-name">{{ optional($projet->user)->nomComplet ?? '—' }}</p>
                        <p class="plan-porteur-email">{{ optional($projet->user)->email ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Durée --}}
            @if($projet->dateDebut && $projet->dateFin)
            <div class="plan-aside-card">
                <p class="plan-aside-title"><i class="fas fa-calendar-alt"></i> Calendrier</p>
                <div class="plan-fin-rows">
                    <div class="plan-fin-row">
                        <span>Début</span>
                        <strong>{{ $projet->dateDebut->format('d/m/Y') }}</strong>
                    </div>
                    <div class="plan-fin-row">
                        <span>Fin</span>
                        <strong>{{ $projet->dateFin->format('d/m/Y') }}</strong>
                    </div>
                    @if($projet->duree)
                    <div class="plan-fin-row">
                        <span>Durée</span>
                        <strong>{{ $projet->duree }} mois</strong>
                    </div>
                    @endif
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
