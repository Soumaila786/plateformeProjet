@extends('layouts.app')

@section('title', 'Projets')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

<div class="projets-page">

    {{-- ── Header ── --}}
    <div class="projets-header">
        <div>
            <h1 class="projets-title">Projets</h1>
            <p class="projets-subtitle">{{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} au total</p>
        </div>
    </div>

    {{-- ── Filtres ── --}}
    <div class="projets-filters">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="search-input"
                   placeholder="Rechercher par titre ou code..."
                   value="{{ request('search') }}">
        </div>
        <div class="status-filters">
            @php
                $statuts = [
                    ''          => 'Tous',
                    'brouillon' => 'Brouillon',
                    'soumis'    => 'Soumis',
                    'en_examen' => 'En examen',
                    'approuve'  => 'Approuvé',
                    'valide'    => 'Validé',
                    'rejete'    => 'Rejeté',
                ];
            @endphp
            @foreach($statuts as $val => $label)
            <a href="{{ route('admin.projets.index', array_merge(request()->query(), ['statut' => $val])) }}"
               class="status-filter {{ request('statut', '') === $val ? 'active' : '' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- ── Cards ── --}}
    @forelse($projets as $projet)
    @php
        $sc = ['brouillon'=>'status-gray','soumis'=>'status-blue','en_examen'=>'status-yellow','approuve'=>'status-green','valide'=>'status-teal','rejete'=>'status-red'];
        $sl = ['brouillon'=>'Brouillon','soumis'=>'Soumis','en_examen'=>'En examen','approuve'=>'Approuvé','valide'=>'Validé','rejete'=>'Rejeté'];
    @endphp
    <div class="projet-card">
        <div class="projet-card-top">
            <div class="projet-card-meta">
                <span class="projet-card-code">{{ $projet->codeProjet }}</span>
                <span class="status-badge {{ $sc[$projet->statutProjet] ?? 'status-gray' }}">
                    {{ $sl[$projet->statutProjet] ?? $projet->statutProjet }}
                </span>
            </div>
            <div class="projet-card-actions">
                <a href="{{ route('admin.projets.show', $projet) }}"
                   class="btn-icon" title="Voir le détail">
                    <i class="fas fa-eye"></i>
                </a>
                <button type="button" class="btn-icon"
                        onclick="openStatutModal({{ $projet->id }}, '{{ $projet->statutProjet }}')"
                        title="Changer le statut">
                    <i class="fas fa-exchange-alt"></i>
                </button>
                <form method="POST" action="{{ route('admin.projets.destroy', $projet) }}"
                      onsubmit="return confirm('Supprimer ce projet définitivement ?')"
                      style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-icon btn-icon-danger" title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        <h3 class="projet-card-titre">{{ $projet->titre }}</h3>

        @if($projet->description)
        <p class="projet-card-desc">{{ Str::limit($projet->description, 100) }}</p>
        @endif

        <div class="projet-card-footer">
            <div class="projet-card-info-row">
                <span class="projet-card-info">
                    <i class="fas fa-user"></i>
                    {{ optional($projet->porteur)->nomComplet ?? '—' }}
                </span>
                <span class="projet-card-info">
                    <i class="fas fa-tag"></i>
                    {{ optional($projet->secteur)->nomSecteur ?? '—' }}
                </span>
                @if($projet->budgetTotal)
                <span class="projet-card-info">
                    <i class="fas fa-coins"></i>
                    {{ number_format($projet->budgetTotal, 0, ',', ' ') }} F CFA
                </span>
                @endif
                <span class="projet-card-info">
                    <i class="fas fa-calendar"></i>
                    {{ optional($projet->dateCreation)->format('d/m/Y') ?? '—' }}
                </span>
            </div>
        </div>
    </div>
    @empty
    <div class="cards-empty">
        <i class="fas fa-folder-open"></i>
        <p>Aucun projet trouvé.</p>
    </div>
    @endforelse

    @if($projets->hasPages())
    <div class="projets-pagination">
        {{ $projets->withQueryString()->links() }}
    </div>
    @endif

</div>

{{-- ── Modal Changer Statut ── --}}
<div class="modal-overlay" id="modalStatut">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Changer le statut</h3>
            <button type="button" class="modal-close" onclick="closeModal('modalStatut')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" id="formStatut" action="">
            @csrf
            <div class="modal-body">
                <label class="field-label">Nouveau statut</label>
                <select name="statut" id="selectStatut" class="field-input" required>
                    <option value="brouillon">Brouillon</option>
                    <option value="soumis">Soumis</option>
                    <option value="en_examen">En examen</option>
                    <option value="approuve">Approuvé</option>
                    <option value="valide">Validé</option>
                    <option value="rejete">Rejeté</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalStatut')">Annuler</button>
                <button type="submit" class="btn-save">
                    <i class="fas fa-exchange-alt"></i> Appliquer
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let timer;
document.getElementById('searchInput').addEventListener('input', function () {
    clearTimeout(timer);
    const val = this.value;
    timer = setTimeout(() => {
        const url = new URL(window.location.href);
        url.searchParams.set('search', val);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }, 400);
});

function openStatutModal(projetId, currentStatut) {
    document.getElementById('formStatut').action = '/admin/projets/' + projetId + '/statut';
    document.getElementById('selectStatut').value = currentStatut;
    openModal('modalStatut');
}

function openModal(id) {
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = '';
}
document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});
</script>
@endpush

@endsection
