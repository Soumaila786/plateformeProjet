@props(['statut'])

@php
    $etapes = [
        ['key' => 'soumis',    'label' => 'Soumis',    'color' => 'var(--status-soumis)'],
        ['key' => 'en_examen', 'label' => 'En examen', 'color' => 'var(--status-en-examen)'],
        ['key' => 'approuve',  'label' => 'Approuvé',  'color' => 'var(--status-approuve)'],
        ['key' => 'valide',    'label' => 'Validé',    'color' => 'var(--status-valide)'],
    ];
    $ordre = array_column($etapes, 'key');
    $positionActuelle = array_search($statut, $ordre);
    $estRejete = $statut === 'rejete';
@endphp

<div class="d-flex align-items-center py-2" role="img" aria-label="Progression du projet : {{ $statut }}">
    @foreach ($etapes as $i => $etape)
        @php
            $estFait   = !$estRejete && $positionActuelle !== false && $i < $positionActuelle;
            $estActuel = !$estRejete && $i === $positionActuelle;
            $couleur   = $estRejete ? 'var(--status-rejete)' : $etape['color'];
        @endphp

        <div class="d-flex flex-column align-items-center">
            <div style="width:13px; height:13px; border-radius:50%; flex-shrink:0;
                        border:2px solid {{ ($estFait || $estActuel) ? $couleur : '#dee2e6' }};
                        background: {{ $estFait ? $couleur : '#fff' }};
                        {{ $estActuel ? 'box-shadow:0 0 0 3px color-mix(in srgb, '.$couleur.' 25%, transparent);' : '' }}">
            </div>
            <span class="text-muted mt-1" style="font-size:.72rem; width:90px; text-align:center;">{{ $etape['label'] }}</span>
        </div>

        @if (!$loop->last)
            <div style="flex:1; height:2px; margin:0 .3rem;
                        background: {{ $estFait ? $etape['color'] : '#dee2e6' }};"></div>
        @endif
    @endforeach

    @if ($estRejete)
        <div class="ms-3 d-flex align-items-center gap-1 fw-bold" style="color:var(--status-rejete); font-size:.8rem;">
            <i class="fas fa-circle-xmark"></i> Rejeté
        </div>
    @endif
</div>
