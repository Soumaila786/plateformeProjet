@props([
    'size' => 48,          // taille en pixels (carré)
    'showText' => false,   // afficher le nom de l'appli à côté
    'textSize' => 'md',    // 'md' ou 'lg'
])

@php
    $logoImage = isset($sysConfig) ? $sysConfig->get('logo_image') : null;
    $logoTexte = isset($sysConfig) ? $sysConfig->get('logo_texte', 'GP') : 'GP';
    $nomApp = isset($sysConfig) ? $sysConfig->get('nom_app', config('app.name')) : config('app.name');
    $couleur = isset($sysConfig) ? $sysConfig->get('couleur_primaire', '#3b82f6') : '#3b82f6';
@endphp

{{-- FIX : d-inline-flex (pas d-flex) pour hériter du text-align:center du
     parent (ex: .login-header) au lieu de rester collé à gauche. mb-2 pour
     laisser un peu d'air avant le titre en dessous. --}}
<div class="d-inline-flex align-items-center gap-2 mb-2">
    @if ($logoImage)
        <img src="{{ asset('storage/'.$logoImage) }}" alt="{{ $nomApp }}"
             style="width:{{ $size }}px; height:{{ $size }}px; object-fit:contain; border-radius:12px; flex-shrink:0;">
    @else
        <img src="{{ asset('images/logo-cifeu.jpg') }}" alt="{{ $nomApp }}"
             style="width:{{ $size }}px; height:{{ $size }}px; object-fit:contain; border-radius:12px; flex-shrink:0;">
    @endif

    @if ($showText)
        <span class="fw-bold" style="font-size: {{ $textSize === 'lg' ? '1.4rem' : '1.05rem' }}; color: var(--color-text, #111827);">
            {{ $nomApp }}
        </span>
    @endif
</div>
