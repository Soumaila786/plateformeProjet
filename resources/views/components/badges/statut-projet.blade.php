@props(['statut'])

@php
    $config = [
        'brouillon' => ['label' => 'Brouillon',  'color' => 'var(--status-brouillon)'],
        'soumis'    => ['label' => 'Soumis',     'color' => 'var(--status-soumis)'],
        'en_examen' => ['label' => 'En examen',  'color' => 'var(--status-en-examen)'],
        'approuve'  => ['label' => 'Approuvé',   'color' => 'var(--status-approuve)'],
        'rejete'    => ['label' => 'Rejeté',     'color' => 'var(--status-rejete)'],
        'valide'    => ['label' => 'Validé',     'color' => 'var(--status-valide)'],
    ];
    $c = $config[$statut] ?? ['label' => ucfirst($statut ?? '—'), 'color' => '#6b7280'];
@endphp

<span {{ $attributes->merge(['class' => 'badge rounded-pill']) }}
      style="background-color: color-mix(in srgb, {{ $c['color'] }} 16%, white); color: {{ $c['color'] }}; font-weight:600;">
    {{ $c['label'] }}
</span>
