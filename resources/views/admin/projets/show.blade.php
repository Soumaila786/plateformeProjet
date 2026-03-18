@extends('layouts.app')

@section('title', $projet->titre)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

<div class="projets-page">

    {{-- ── Header ── --}}
    <div class="page-header">
        <a href="{{ route('admin.projets.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-header-info">
            <div>
                <h1 class="projets-title">{{ $projet->titre }}</h1>
                <p class="projets-subtitle">{{ $projet->codeProjet }}</p>
            </div>
            <div class="page-header-actions">
                @php
                    $sc = ['brouillon'=>'status-gray','soumis'=>'status-blue','en_examen'=>'status-yellow','approuve'=>'status-green','valide'=>'status-teal','rejete'=>'status-red'];
                    $sl = ['brouillon'=>'Brouillon','soumis'=>'Soumis','en_examen'=>'En examen','approuve'=>'Approuvé','valide'=>'Validé','rejete'=>'Rejeté'];
                @endphp
                <span class="status-badge {{ $sc[$projet->statutProjet] ?? 'status-gray' }} status-lg">
                    {{ $sl[$projet->statutProjet] ?? $projet->statutProjet }}
                </span>
                <button type="button" class="btn-edit-main" onclick="openModal('modalStatut')">
                    <i class="fas fa-exchange-alt"></i> Changer le statut
                </button>
                <form method="POST" action="{{ route('admin.projets.destroy', $projet) }}"
                        onsubmit="return confirm('Supprimer définitivement ce projet ?')" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger btn-sm">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-error"><i class="fas fa-times-circle"></i> {{ session('error') }}</div>
    @endif

    {{-- ── Informations générales ── --}}
    <div class="form-card">
        <div class="form-card-header">
            <i class="fas fa-project-diagram"></i>
            <span>Informations générales</span>
        </div>
        <div class="form-card-body">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Porteur</span>
                    <span class="info-value">
                        <a href="{{ route('admin.users.show', $projet->porteur) }}">
                            {{ optional($projet->porteur)->nomComplet ?? '—' }}
                        </a>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Secteur</span>
                    <span class="info-value">{{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Durée</span>
                    <span class="info-value">{{ $projet->duree ? $projet->duree . ' mois' : '—' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date création</span>
                    <span class="info-value">{{ optional($projet->dateCreation)->format('d/m/Y') ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date soumission</span>
                    <span class="info-value">{{ optional($projet->dateSoumission)->format('d/m/Y') ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date approbation</span>
                    <span class="info-value">{{ optional($projet->dateApprobation)->format('d/m/Y') ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date validation</span>
                    <span class="info-value">{{ optional($projet->dateValidation)->format('d/m/Y') ?? '—' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Budget total</span>
                    <span class="info-value">{{ $projet->budgetTotal ? number_format($projet->budgetTotal, 0, ',', ' ') . ' F CFA' : '—' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Montant demandé</span>
                    <span class="info-value">{{ $projet->montantDemande ? number_format($projet->montantDemande, 0, ',', ' ') . ' F CFA' : '—' }}</span>
                </div>
            </div>

            @if($projet->description)
            <div class="info-block mt-3">
                <span class="info-label">Description</span>
                <p class="info-text">{{ $projet->description }}</p>
            </div>
            @endif

            @if($projet->objectif)
            <div class="info-block mt-2">
                <span class="info-label">Objectif</span>
                <p class="info-text">{{ $projet->objectif }}</p>
            </div>
            @endif

            @if($projet->motifRejet)
            <div class="info-block mt-2 alert-rejet">
                <span class="info-label"><i class="fas fa-times-circle"></i> Motif de rejet</span>
                <p class="info-text">{{ $projet->motifRejet }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- ── activites ── --}}
    <div class="form-card">
        <div class="form-card-header">
            <i class="fas fa-tasks"></i>
            <span>Planification ({{ $projet->activites->count() }})</span>
        </div>
        <div class="form-card-body">
            @forelse($projet->activites as $plan)
            <div class="plan-item">
                <div class="plan-info">
                    <span class="plan-titre">{{ $plan->activite }}</span>
                    <span class="plan-dates">
                        {{ optional($plan->dateDebut)->format('d/m/Y') }} →
                        {{ optional($plan->dateFin)->format('d/m/Y') }}
                    </span>
                </div>
                <span class="plan-budget">{{ $plan->budget ? number_format($plan->budget, 0, ',', ' ') . ' F' : '' }}</span>
            </div>
            @empty
            <p class="info-empty">Aucune étape de planification.</p>
            @endforelse
        </div>
    </div>

    {{-- ── Documents ── --}}
    <div class="form-card">
        <div class="form-card-header">
            <i class="fas fa-paperclip"></i>
            <span>Documents ({{ $projet->documents->count() }})</span>
        </div>
        <div class="form-card-body">
            @forelse($projet->documents as $doc)
            <div class="doc-existing-item">
                @php
                    $ext  = pathinfo($doc->nomFichier, PATHINFO_EXTENSION);
                    $icon = in_array($ext, ['pdf']) ? 'fa-file-pdf'
                          : (in_array($ext, ['doc','docx']) ? 'fa-file-word'
                          : (in_array($ext, ['xls','xlsx']) ? 'fa-file-excel'
                          : (in_array($ext, ['jpg','jpeg','png']) ? 'fa-file-image' : 'fa-file-alt')));
                @endphp
                <i class="fas {{ $icon }}"></i>
                <span class="doc-file-name">{{ $doc->nomFichier }}</span>
                <span class="doc-badge">{{ $doc->typeDocument }}</span>
                <span class="doc-uploader">{{ optional($doc->uploader)->nomComplet ?? '—' }}</span>
                <a href="{{ route('admin.projets.documents.download', [$projet, $doc]) }}"
                   class="doc-action-link" title="Télécharger">
                    <i class="fas fa-download"></i>
                </a>
            </div>
            @empty
            <p class="info-empty">Aucun document joint.</p>
            @endforelse
        </div>
    </div>

    {{-- ── Timeline commentaires ── --}}
    @if($projet->commentaires->count() > 0)
    <div class="form-card mt-3">
        <div class="form-card-header">
            <i class="fas fa-comments"></i>
            <span>Historique des actions ({{ $projet->commentaires->count() }})</span>
        </div>
        <div class="form-card-body">
            <div class="timeline">
                @foreach($projet->commentaires->sortByDesc('dateEnvoi') as $commentaire)
                @php
                    $icons  = ['approbation'=>'fa-check-circle','rejet'=>'fa-times-circle','demande'=>'fa-exclamation-circle','info'=>'fa-info-circle'];
                    $colors = ['approbation'=>'#16a34a','rejet'=>'#dc2626','demande'=>'#d97706','info'=>'#2563eb'];
                    $icon   = $icons[$commentaire->typeCommentaire]  ?? 'fa-comment';
                    $color  = $colors[$commentaire->typeCommentaire] ?? '#6b7280';
                @endphp
                <div class="timeline-item">
                    <div class="timeline-icon" style="background:{{ $color }}15;color:{{ $color }};">
                        <i class="fas {{ $icon }}"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <span class="timeline-author">{{ optional($commentaire->utilisateur)->nomComplet ?? '—' }}</span>
                            <span class="timeline-date">{{ $commentaire->dateEnvoi->format('d/m/Y à H:i') }}</span>
                        </div>
                        <p class="timeline-message">{{ $commentaire->message }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

</div>

{{-- ── Modal Changer statut ── --}}
<div class="modal-overlay" id="modalStatut">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Changer le statut</h3>
            <button type="button" class="modal-close" onclick="closeModal('modalStatut')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.projets.statut', $projet) }}">
            @csrf
            <div class="modal-body">
                <label class="field-label">Nouveau statut</label>
                <select name="statut" class="field-input" required>
                    @foreach(['brouillon'=>'Brouillon','soumis'=>'Soumis','en_examen'=>'En examen','approuve'=>'Approuvé','valide'=>'Validé','rejete'=>'Rejeté'] as $val => $label)
                    <option value="{{ $val }}" {{ $projet->statutProjet === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
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
function openModal(id) {
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = '';
}
document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', function(e) { if (e.target === this) closeModal(this.id); });
});

const newDocInput  = document.getElementById('newDocuments');
const newFileList  = document.getElementById('newFileList');
const submitDocBtn = document.getElementById('submitDocBtn');

newDocInput.addEventListener('change', function() {
    const files = Array.from(this.files);
    if (!files.length) return;
    newFileList.style.display = 'block';
    submitDocBtn.style.display = 'block';
    newFileList.innerHTML = files.map(f => `
        <div class="doc-file-item">
            <i class="${getIcon(f.name)} doc-file-icon"></i>
            <div class="doc-file-info">
                <span class="doc-file-name">${f.name}</span>
                <span class="doc-file-size">${formatSize(f.size)}</span>
            </div>
            <span class="doc-file-ok"><i class="fas fa-check-circle"></i> Accepté</span>
        </div>`).join('');
});

function resetDocForm() {
    newDocInput.value = '';
    newFileList.innerHTML = ''; newFileList.style.display = 'none';
    submitDocBtn.style.display = 'none';
}

function getIcon(name) {
    const ext = name.split('.').pop().toLowerCase();
    if (['pdf'].includes(ext))              return 'fas fa-file-pdf';
    if (['doc','docx'].includes(ext))       return 'fas fa-file-word';
    if (['xls','xlsx'].includes(ext))       return 'fas fa-file-excel';
    if (['jpg','jpeg','png'].includes(ext)) return 'fas fa-file-image';
    return 'fas fa-file-alt';
}

function formatSize(b) {
    if (b < 1024) return b + ' o';
    if (b < 1048576) return (b/1024).toFixed(1) + ' Ko';
    return (b/1048576).toFixed(1) + ' Mo';
}
</script>
@endpush

@endsection
