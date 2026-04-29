@extends('layouts.app')
@section('title', 'Projets à approuver')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/approbateur.css') }}">
@endpush

@section('content')
<div class="aprob-page">

    {{-- Header --}}
    <div class="aprob-header">
        <div>
            <h1 class="aprob-header-title">Projets à approuver</h1>
            <p class="aprob-header-sub">{{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} au total</p>
        </div>
        <a href="{{ route('approbateur.projets.mes_projets') }}" class="aprob-btn aprob-btn-secondary">
            <i class="fas fa-history"></i> Mes projets traités
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="aprob-alert aprob-alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    {{-- Filtres --}}
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">

        <div class="aprob-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput"
                   placeholder="Rechercher par titre ou code..."
                   value="{{ request('search') }}">
        </div>

        <select id="secteurSelect" class="aprob-select">
            <option value="">Tous les secteurs</option>
            @foreach($secteurs as $secteur)
            <option value="{{ $secteur->id }}" {{ request('secteur_id') == $secteur->id ? 'selected' : '' }}>
                {{ $secteur->nomSecteur }}
            </option>
            @endforeach
        </select>

        <div class="aprob-status-filters">
            @php $statuts = ['' => 'Tous', 'soumis'=>'Soumis', 'en_examen'=>'En examen', 'approuve'=>'Approuvé', 'rejete'=>'Rejeté']; @endphp
            @foreach($statuts as $val => $label)
            <a href="{{ route('approbateur.projets.index', array_merge(request()->query(), ['statut'=>$val])) }}"
               class="aprob-status-filter {{ request('statut','') === $val ? 'active' : '' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>

        @if(request('search') || request('secteur_id') || request('statut'))
        <a href="{{ route('approbateur.projets.index') }}" class="aprob-reset-btn">
            <i class="fas fa-times"></i> Réinitialiser
        </a>
        @endif
    </div>

    {{-- Liste --}}
    @forelse($projets as $projet)
    @php
        $stMap = [
            'soumis'    => ['lbl'=>'Soumis',    'cls'=>'aprob-badge-soumis',    'dot'=>'#6366f1'],
            'en_examen' => ['lbl'=>'En examen', 'cls'=>'aprob-badge-en_examen', 'dot'=>'#f97316'],
            'approuve'  => ['lbl'=>'Approuvé',  'cls'=>'aprob-badge-approuve',  'dot'=>'#22c55e'],
            'rejete'    => ['lbl'=>'Rejeté',    'cls'=>'aprob-badge-rejete',    'dot'=>'#ef4444'],
        ];
        $st = $stMap[$projet->statutProjet] ?? ['lbl'=>$projet->statutProjet,'cls'=>'aprob-badge-brouillon','dot'=>'#9ca3af'];
    @endphp

    <div class="aprob-projet-row {{ $projet->statutProjet }}">

        {{-- Avatar --}}
        <div class="aprob-projet-avatar">
            {{ strtoupper(substr(optional($projet->secteur)->nomSecteur ?? $projet->titre, 0, 1)) }}
        </div>

        {{-- Infos --}}
        <div class="aprob-projet-info">
            <div class="aprob-projet-top">
                <span class="aprob-projet-code">{{ $projet->codeProjet }}</span>
                <span class="aprob-projet-titre">{{ $projet->titre }}</span>
            </div>
            <p class="aprob-projet-meta">
                <span><i class="fas fa-user"></i>{{ optional($projet->porteur)->nomComplet ?? '—' }}</span>
                <span><i class="fas fa-tag"></i>{{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
                @if($projet->montantDemande)
                <span><i class="fas fa-coins"></i><strong>{{ number_format($projet->montantDemande, 0, ',', ' ') }} F CFA</strong></span>
                @endif
                @if($projet->dateSoumission)
                <span><i class="fas fa-calendar"></i>Soumis le {{ $projet->dateSoumission->format('d/m/Y') }}</span>
                @endif
            </p>
        </div>

        {{-- Badges + actions --}}
        <div class="aprob-projet-badges">
            <span class="aprob-badge {{ $st['cls'] }}">
                <span class="aprob-dot" style="background:{{ $st['dot'] }};"></span>
                {{ $st['lbl'] }}
            </span>

            <a href="{{ route('approbateur.projets.show', $projet) }}"
               class="aprob-btn aprob-btn-outline aprob-btn-icon" title="Voir">
                <i class="fas fa-eye"></i>
            </a>

            @if($projet->statutProjet === 'soumis')
            <form method="POST" action="{{ route('approbateur.projets.examiner', $projet) }}"
                  onsubmit="return confirm('Mettre ce projet en examen ?')">
                @csrf
                <button type="submit" class="aprob-btn aprob-btn-orange aprob-btn-icon" title="Mettre en examen">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            @endif

            @if($projet->statutProjet === 'en_examen')
            <button type="button" class="aprob-btn aprob-btn-green aprob-btn-icon" title="Approuver"
                    onclick="openModal('modalApprouver{{ $projet->id }}')">
                <i class="fas fa-check"></i>
            </button>
            <button type="button" class="aprob-btn aprob-btn-red aprob-btn-icon" title="Rejeter"
                    onclick="openModal('modalRejeter{{ $projet->id }}')">
                <i class="fas fa-times"></i>
            </button>
            @endif
        </div>
    </div>

    {{-- Modal Approuver (inline par projet) --}}
    @if($projet->statutProjet === 'en_examen')
    <div id="modalApprouver{{ $projet->id }}" class="aprob-modal-overlay">
        <div class="aprob-modal-box">
            <div class="aprob-modal-head">
                <h3 class="aprob-modal-title">
                    <i class="fas fa-check-circle" style="color:#22c55e;"></i> Approuver le projet
                </h3>
                <button onclick="closeModal('modalApprouver{{ $projet->id }}')" class="aprob-modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('approbateur.projets.approuver', $projet) }}">
                @csrf
                <div class="aprob-modal-body">
                    <p style="font-size:.82rem;color:#6b7280;margin:0;">
                        Le projet <strong>{{ $projet->titre }}</strong> sera transmis au validateur.
                    </p>
                    <div class="aprob-form-group">
                        <label class="aprob-form-label">Commentaire (optionnel)</label>
                        <textarea name="commentaire" class="aprob-form-textarea" rows="3"
                                  placeholder="Observations..."></textarea>
                    </div>
                </div>
                <div class="aprob-modal-foot">
                    <button type="button" onclick="closeModal('modalApprouver{{ $projet->id }}')"
                            class="aprob-btn aprob-btn-gray">Annuler</button>
                    <button type="submit" class="aprob-btn aprob-btn-green">
                        <i class="fas fa-check-circle"></i> Confirmer
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Rejeter --}}
    <div id="modalRejeter{{ $projet->id }}" class="aprob-modal-overlay">
        <div class="aprob-modal-box">
            <div class="aprob-modal-head">
                <h3 class="aprob-modal-title">
                    <i class="fas fa-times-circle" style="color:#ef4444;"></i> Rejeter le projet
                </h3>
                <button onclick="closeModal('modalRejeter{{ $projet->id }}')" class="aprob-modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('approbateur.projets.rejeter', $projet) }}">
                @csrf
                <div class="aprob-modal-body">
                    <div class="aprob-form-group">
                        <label class="aprob-form-label">Motif du rejet <span style="color:#ef4444;">*</span></label>
                        <textarea name="motifRejet" class="aprob-form-textarea danger" rows="3"
                                  placeholder="Expliquez le motif..." required></textarea>
                    </div>
                </div>
                <div class="aprob-modal-foot">
                    <button type="button" onclick="closeModal('modalRejeter{{ $projet->id }}')"
                            class="aprob-btn aprob-btn-gray">Annuler</button>
                    <button type="submit" class="aprob-btn aprob-btn-red">
                        <i class="fas fa-times-circle"></i> Confirmer le rejet
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @empty
    <div class="aprob-empty">
        <i class="fas fa-folder-open"></i>
        <p>Aucun projet trouvé.</p>
    </div>
    @endforelse

    {{-- Pagination --}}
    <div class="aprob-pagination">
        {{ $projets->withQueryString()->links() }}
    </div>

</div>

@push('scripts')
<script>
function openModal(id) {
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = '';
}
document.querySelectorAll('.aprob-modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); });
});

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
