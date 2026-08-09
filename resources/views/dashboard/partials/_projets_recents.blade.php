@php
    // Variables attendues : $projetsRecents (Collection de Projet), $routeShow (nom de route)
    $stMap = [
        'brouillon' => ['lbl' => 'Brouillon',  'dot' => '#9ca3af'],
        'soumis'    => ['lbl' => 'Soumis',     'dot' => '#6366f1'],
        'en_examen' => ['lbl' => 'En examen',  'dot' => '#f97316'],
        'approuve'  => ['lbl' => 'Approuvé',   'dot' => '#22c55e'],
        'rejete'    => ['lbl' => 'Rejeté',     'dot' => '#ef4444'],
        'valide'    => ['lbl' => 'Validé',     'dot' => '#0d9488'],
    ];
@endphp

@forelse ($projetsRecents as $projet)
    @php
        $st = $stMap[$projet->statutProjet] ?? ['lbl' => $projet->statutProjet, 'dot' => '#9ca3af'];
        $porteurProjet = $projet->porteur ?? $projet->user ?? null;
    @endphp
    <div class="d-flex align-items-center justify-content-between py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
        <div class="d-flex align-items-center gap-2 min-w-0">
            <div class="d-flex align-items-center justify-content-center rounded fw-bold flex-shrink-0"
                 style="width:34px; height:34px; background:var(--color-primary-light); color:var(--color-primary);">
                {{ strtoupper(substr($projet->secteur->nomSecteur ?? $projet->titre, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <div class="small fw-semibold text-truncate">{{ $projet->titre }}</div>
                <div class="text-muted text-truncate" style="font-size:.74rem;">
                    {{ $projet->codeProjet }}
                    @if ($porteurProjet) · {{ $porteurProjet->nomComplet }} @endif
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 flex-shrink-0">
            <span class="badge rounded-pill" style="background: color-mix(in srgb, {{ $st['dot'] }} 16%, white); color:{{ $st['dot'] }};">
                {{ $st['lbl'] }}
            </span>
            @if (isset($routeShow))
                <a href="{{ route($routeShow, $projet) }}" class="btn btn-sm btn-link text-decoration-none"><i class="fas fa-arrow-right"></i></a>
            @endif
        </div>
    </div>
@empty
    <p class="text-muted small mb-0 py-3 text-center">Aucun projet récent.</p>
@endforelse
