@extends('layouts.app')

@section('title', 'Projets à approuver')

@push('styles')

<link rel="stylesheet" href="{{ asset('css/projet.css') }}">
<link rel="stylesheet" href="{{ asset('css/approbDash.css') }}">
<style>
    .proj-table { width:100%; border-collapse:collapse; }
    .proj-table thead tr { background:#f8fafc; }
    .proj-table th {
        padding:11px 14px; font-size:.7rem; font-weight:700;
        color:#6b7280; text-transform:uppercase; letter-spacing:.05em;
        border-bottom:1.5px solid #e5e7eb; white-space:nowrap;
    }
    .proj-table td {
        padding:12px 14px; font-size:.82rem; color:#374151;
        border-bottom:1px solid #f1f5f9; vertical-align:middle;
    }
    .proj-table tbody tr:hover td { background:#fafafa; }
    .proj-table tbody tr:last-child td { border-bottom:none; }
    .table-wrap {
        border:1px solid #e5e7eb; border-radius:12px;
        overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,.05);
        background:#fff;
    }
    .col-code { font-size:.72rem; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:.05em; }
    .col-titre { font-weight:700; color:#111827; }
    .col-muted { color:#9ca3af; font-size:.78rem; }
    .col-budget { font-weight:700; color:#111827; white-space:nowrap; }
    .s-badge {
        display:inline-flex; align-items:center; gap:5px;
        padding:3px 9px; border-radius:20px;
        font-size:.72rem; font-weight:700; white-space:nowrap;
    }
    .s-dot { width:6px; height:6px; border-radius:50%; display:inline-block; }
    .td-actions { display:flex; align-items:center; gap:6px; justify-content:flex-end; }
    .btn-act {
        width:30px; height:30px; border-radius:7px; border:none;
        display:flex; align-items:center; justify-content:center;
        font-size:.75rem; cursor:pointer; transition:opacity .12s;
        text-decoration:none !important;
    }
    .btn-act:hover { opacity:.8; }
    .btn-view   { background:#eef2ff; color:#6366f1; }
    .btn-exam   { background:#fff7ed; color:#c2410c; }
    .btn-ok     { background:#f0fdf4; color:#15803d; }
    .btn-nok    { background:#fef2f2; color:#dc2626; }
    .filters-bar {
        display:flex; align-items:center; gap:10px;
        flex-wrap:wrap; margin-bottom:14px;
    }
    .s-select {
        padding:8px 12px; border:1px solid #e5e7eb; border-radius:8px;
        font-size:.78rem; color:#374151; background:#fff;
        min-width:160px; cursor:pointer; outline:none;
    }
    .s-select:focus { border-color:#6366f1; }
    .search-box {
        position:relative; flex:1; min-width:200px;
    }
    .search-box i {
        position:absolute; left:10px; top:50%;
        transform:translateY(-50%); color:#9ca3af; font-size:.75rem;
    }
    .search-box input {
        width:100%; padding:8px 10px 8px 30px;
        border:1px solid #e5e7eb; border-radius:8px;
        font-size:.78rem; outline:none;
    }
    .search-box input:focus { border-color:#6366f1; }
    .reset-link {
        padding:8px 12px; background:#f3f4f6; color:#6b7280;
        border-radius:8px; font-size:.75rem; font-weight:600;
        text-decoration:none !important;
    }
    .page-hdr {
        display:flex; align-items:center; justify-content:space-between;
        flex-wrap:wrap; gap:12px; margin-bottom:14px;
    }
    .page-hdr-title { font-size:1.1rem; font-weight:800; color:#111827; margin:0; }
    .page-hdr-sub   { font-size:.75rem; color:#9ca3af; margin:2px 0 0; }
    .btn-secondary {
        display:inline-flex; align-items:center; gap:6px;
        background:#eef2ff; color:#4338ca; border:1px solid #c7d2fe;
        border-radius:8px; padding:8px 14px; font-size:.78rem; font-weight:700;
        text-decoration:none !important;
    }
</style>

@endpush

@section('content')
<div class="projets-page">
    {{-- Header --}}
    <div class="page-hdr">
        <div>
            <h1 class="page-hdr-title">Projets à approuver</h1>
            <p class="page-hdr-sub">{{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} au total</p>
        </div>
        <a href="{{ route('approbateur.projets.mes_projets') }}" class="btn-secondary">
            <i class="fas fa-history"></i> Mes projets traités
        </a>
    </div>
    
    {{-- Filtres --}}
    <div class="filters-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput"
                    placeholder="Rechercher par titre ou code..."
                    value="{{ request('search') }}">
        </div>

        <select id="secteurSelect" class="s-select">
            <option value="">Tous les secteurs</option>
            @foreach($secteurs as $secteur)
            <option value="{{ $secteur->id }}" {{ request('secteur_id') == $secteur->id ? 'selected' : '' }}>
                {{ $secteur->nomSecteur }}
            </option>
            @endforeach
        </select>

        <div class="status-filters">
            @php
                $statuts = [
                    '' => 'Tous', 'soumis'=>'Soumis',
                    'en_examen'=>'En examen', 'approuve'=>'Approuvé', 'rejete'=>'Rejeté',
                ];
            @endphp
            @foreach($statuts as $val => $label)
            <a href="{{ route('approbateur.projets.index', array_merge(request()->query(), ['statut'=>$val])) }}"
                class="status-filter {{ request('statut','') === $val ? 'active' : '' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>

        @if(request('search') || request('secteur_id') || request('statut'))
        <a href="{{ route('approbateur.projets.index') }}" class="reset-link">
            <i class="fas fa-times"></i> Réinitialiser
        </a>
        @endif
    </div>

    {{-- Tableau --}}
    <div class="table-wrap">
        <table class="proj-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Titre</th>
                    <th>Porteur</th>
                    <th>Secteur</th>
                    <th>Montant demandé</th>
                    <th>Statut</th>
                    <th>Soumission</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @forelse($projets as $projet)
            @php
                $stMap = [
                    'soumis'    => ['lbl'=>'Soumis',   'bg'=>'#eef2ff','color'=>'#4338ca','dot'=>'#6366f1'],
                    'en_examen' => ['lbl'=>'En examen','bg'=>'#fff7ed','color'=>'#c2410c','dot'=>'#f97316'],
                    'approuve'  => ['lbl'=>'Approuvé', 'bg'=>'#f0fdf4','color'=>'#15803d','dot'=>'#22c55e'],
                    'rejete'    => ['lbl'=>'Rejeté',   'bg'=>'#fef2f2','color'=>'#b91c1c','dot'=>'#ef4444'],
                ];
                $st = $stMap[$projet->statutProjet] ?? ['lbl'=>$projet->statutProjet,'bg'=>'#f3f4f6','color'=>'#6b7280','dot'=>'#9ca3af'];
            @endphp
            <tr>
                <td><span class="col-code">{{ $projet->codeProjet }}</span></td>
                <td>
                    <a href="{{ route('approbateur.projets.show', $projet) }}" class="col-titre"
                        style="text-decoration:none;color:#111827;">
                        {{ \Illuminate\Support\Str::limit($projet->titre, 45) }}
                    </a>
                </td>
                <td><span class="col-muted">{{ optional($projet->porteur)->nomComplet ?? '—' }}</span></td>
                <td><span class="col-muted">{{ optional($projet->secteur)->nomSecteur ?? '—' }}</span></td>
                <td>
                    <span class="col-budget">
                        {{ $projet->montantDemande ? number_format($projet->montantDemande,0,',',' ').' F CFA' : '—' }}
                    </span>
                </td>
                <td>
                    <span class="s-badge" style="background:{{ $st['bg'] }};color:{{ $st['color'] }};">
                        <span class="s-dot" style="background:{{ $st['dot'] }};"></span>
                        {{ $st['lbl'] }}
                    </span>
                </td>
                <td><span class="col-muted">{{ optional($projet->dateSoumission)->format('d/m/Y') ?? '—' }}</span></td>
                <td>
                    <div class="td-actions">
                        <a href="{{ route('approbateur.projets.show', $projet) }}"
                            class="btn-act btn-view" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($projet->statutProjet === 'soumis')
                        <form method="POST" action="{{ route('approbateur.projets.examiner', $projet) }}"
                                onsubmit="return confirm('Mettre ce projet en examen ?')">
                            @csrf
                            <button type="submit" class="btn-act btn-exam" title="Mettre en examen">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                        @endif
                        @if($projet->statutProjet === 'en_examen')
                        <button type="button" class="btn-act btn-ok" title="Approuver"
                                onclick="openApprouver({{ $projet->id }})">
                            <i class="fas fa-check"></i>
                        </button>
                        <button type="button" class="btn-act btn-nok" title="Rejeter"
                                onclick="openRejeter({{ $projet->id }})">
                            <i class="fas fa-times"></i>
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:40px;color:#9ca3af;">
                    <i class="fas fa-folder-open" style="font-size:1.8rem;margin-bottom:8px;display:block;"></i>
                    Aucun projet trouvé.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($projets->hasPages())
    <div style="margin-top:14px;">{{ $projets->withQueryString()->links() }}</div>
    @endif

</div>

@push('scripts')
    <script>
        // Recherche auto
        let timer;
        document.getElementById('searchInput').addEventListener('input', function () {
            clearTimeout(timer);
            const val = this.value;
            timer = setTimeout(() => {
                const url = new URL(window.location.href);
                url.searchParams.set('search', val);
                url.searchParams.delete('page');
                window.location.href = url.toString();
            }, 450);
        });

        // Filtre secteur
        document.getElementById('secteurSelect').addEventListener('change', function () {
            const url = new URL(window.location.href);
            if (this.value) url.searchParams.set('secteur_id', this.value);
            else url.searchParams.delete('secteur_id');
            url.searchParams.delete('page');
            window.location.href = url.toString();
        });
    </script>
@endpush
@endsection
