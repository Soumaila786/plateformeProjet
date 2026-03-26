@extends('layouts.app')
@section('title', 'Mes projets traités')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/validDash.css') }}">
@endpush

@section('content')
<div class="vpage">

    {{-- Header --}}
    <div class="page-header" style="margin-bottom:16px;">
        <div>
            <h1 class="page-title">Mes projets traités</h1>
            <p class="page-sub">{{ $projets->total() }} projet(s) traité(s) par vous</p>
        </div>
        <a href="{{ route('validateur.projets.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> À valider
        </a>
    </div>

    {{-- Filtres --}}
    <form method="GET" action="{{ route('validateur.projets.mes_projets') }}" id="filterForm">
        <div style="display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap;align-items:center;">

            {{-- Recherche --}}
            <div style="position:relative;flex:1;min-width:200px;">
                <i class="fas fa-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:.75rem;"></i>
                <input type="text" name="search" id="searchInput"
                        value="{{ request('search') }}"
                        placeholder="Rechercher par titre ou code..."
                        style="width:100%;padding:8px 10px 8px 30px;border:1px solid #e5e7eb;
                                border-radius:8px;font-size:.78rem;outline:none;">
            </div>

            {{-- Secteur --}}
            <select name="secteur_id" onchange="document.getElementById('filterForm').submit()"
                    style="padding:8px 12px;border:1px solid #e5e7eb;border-radius:8px;
                           font-size:.78rem;color:#374151;background:#fff;min-width:160px;">
                <option value="">Tous les secteurs</option>
                @foreach($secteurs as $secteur)
                <option value="{{ $secteur->id }}" {{ request('secteur_id') == $secteur->id ? 'selected' : '' }}>
                    {{ $secteur->nomSecteur }}
                </option>
                @endforeach
            </select>

            {{-- Statut --}}
            <select name="statut" onchange="document.getElementById('filterForm').submit()"
                    style="padding:8px 12px;border:1px solid #e5e7eb;border-radius:8px;
                           font-size:.78rem;color:#374151;background:#fff;min-width:130px;">
                <option value="">Tous les statuts</option>
                <option value="valide"  {{ request('statut') === 'valide'  ? 'selected' : '' }}>Validés</option>
                <option value="rejete"  {{ request('statut') === 'rejete'  ? 'selected' : '' }}>Rejetés</option>
            </select>

            <button type="submit"
                    style="padding:8px 16px;background:#0d9488;color:#fff;border:none;
                           border-radius:8px;font-size:.78rem;font-weight:700;cursor:pointer;">
                <i class="fas fa-filter"></i> Filtrer
            </button>

            @if(request('search') || request('secteur_id') || request('statut'))
            <a href="{{ route('validateur.projets.mes_projets') }}"
               style="padding:8px 12px;background:#f3f4f6;color:#6b7280;border-radius:8px;
                      font-size:.78rem;font-weight:600;text-decoration:none;">
                <i class="fas fa-times"></i> Réinitialiser
            </a>
            @endif
        </div>
    </form>

    {{-- Liste --}}
    @forelse($projets as $projet)
    @php
        $stMap = [
            'valide' => ['lbl'=>'Validé', 'bg'=>'#f0fdfa','color'=>'#0f766e','dot'=>'#0d9488'],
            'rejete' => ['lbl'=>'Rejeté', 'bg'=>'#fef2f2','color'=>'#b91c1c','dot'=>'#ef4444'],
        ];
        $st = $stMap[$projet->statutProjet] ?? $stMap['valide'];
    @endphp
    <div class="proj-card" style="margin-bottom:10px;">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;">
            <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                    <span style="font-size:.68rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;">
                        {{ $projet->codeProjet }}
                    </span>
                    <span class="status-badge" style="background:{{ $st['bg'] }};color:{{ $st['color'] }};">
                        <span class="dot" style="background:{{ $st['dot'] }};"></span>{{ $st['lbl'] }}
                    </span>
                </div>
                <h3 style="font-size:.9rem;font-weight:700;color:#111827;margin:0 0 6px;line-height:1.3;">
                    {{ $projet->titre }}
                </h3>
                <div style="display:flex;flex-wrap:wrap;gap:12px;font-size:.73rem;color:#9ca3af;">
                    <span><i class="fas fa-user" style="margin-right:3px;"></i>{{ optional($projet->porteur)->nomComplet ?? '—' }}</span>
                    <span><i class="fas fa-tag" style="margin-right:3px;"></i>{{ optional($projet->secteur)->nomSecteur ?? '—' }}</span>
                    <span><i class="fas fa-wallet" style="margin-right:3px;"></i>{{ number_format($projet->montantDemande ?? 0, 0, ',', ' ') }} F CFA</span>
                    <span><i class="fas fa-calendar-check" style="margin-right:3px;"></i>
                        Traité le {{ optional($projet->validated_at)->format('d/m/Y') ?? '—' }}
                    </span>
                </div>

                {{-- Motif rejet --}}
                @if($projet->statutProjet === 'rejete' && $projet->motifRejet)
                <div style="margin-top:8px;padding:8px 12px;background:#fef2f2;
                            border:1px solid #fecaca;border-radius:8px;
                            font-size:.76rem;color:#b91c1c;">
                    <i class="fas fa-comment-alt" style="margin-right:5px;"></i>
                    <strong>Motif :</strong> {{ $projet->motifRejet }}
                </div>
                @endif
            </div>

            <a href="{{ route('validateur.projets.show', $projet) }}"
               style="display:inline-flex;align-items:center;gap:6px;
                      background:#eef2ff;color:#6366f1;border-radius:8px;
                      padding:7px 12px;font-size:.75rem;font-weight:700;
                      text-decoration:none;flex-shrink:0;">
                <i class="fas fa-eye"></i> Voir
            </a>
        </div>
    </div>
    @empty
    <div class="empty-state" style="margin-top:30px;">
        <i class="fas fa-folder-open" style="font-size:2rem;color:#9ca3af;margin-bottom:8px;"></i>
        <p>Vous n'avez traité aucun projet pour le moment.</p>
    </div>
    @endforelse

    {{-- Pagination --}}
    @if($projets->hasPages())
    <div style="margin-top:16px;">{{ $projets->withQueryString()->links() }}</div>
    @endif

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
    }, 500);
});
</script>
@endpush
@endsection
