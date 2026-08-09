@props([
    'user' => null,       // instance User ; par défaut auth()->user()
    'size' => 38,          // taille en pixels
    'nom' => null,         // permet de forcer un nom sans instance User (ex: aperçu)
    'photo' => null,       // permet de forcer une URL de photo
])

@php
    $u = $user ?? auth()->user();
    $nomComplet = $nom ?? ($u->nomComplet ?? '?');
    $cheminPhoto = $photo ?? ($u->photo ?? null);
    $initiales = collect(explode(' ', trim($nomComplet)))
        ->map(fn ($m) => mb_strtoupper(mb_substr($m, 0, 1)))
        ->take(2)
        ->implode('');
@endphp

@if ($cheminPhoto)
    <img src="{{ asset('storage/'.$cheminPhoto) }}" alt="{{ $nomComplet }}"
         {{ $attributes->merge(['class' => 'rounded-circle']) }}
         style="width:{{ $size }}px; height:{{ $size }}px; object-fit:cover; flex-shrink:0;">
@else
    <div {{ $attributes->merge(['class' => 'rounded-circle d-flex align-items-center justify-content-center fw-bold text-white']) }}
         style="width:{{ $size }}px; height:{{ $size }}px; background:var(--color-primary); font-size:{{ round($size * 0.4) }}px; flex-shrink:0;">
        {{ $initiales ?: '?' }}
    </div>
@endif
