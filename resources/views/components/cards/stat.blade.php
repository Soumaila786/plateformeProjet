@props(['label', 'valeur', 'icon' => null, 'couleur' => 'var(--color-primary)', 'href' => null])

@php
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }} @if($href) href="{{ $href }}" @endif
    {{ $attributes->merge(['class' => 'card border-0 text-decoration-none text-reset']) }}
    style="box-shadow: var(--shadow-md); border-radius: var(--radius-xl);">
    <div class="card-body d-flex align-items-center gap-3">
        @if ($icon)
            <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                 style="width:44px; height:44px; border-radius: var(--radius-md); background: color-mix(in srgb, {{ $couleur }} 15%, white); color:{{ $couleur }};">
                <i class="fas {{ $icon }}" aria-hidden="true"></i>
            </div>
        @endif

        <div>
            <div class="fw-bold" style="font-size: var(--font-xl); line-height:1; color: var(--color-text);">{{ $valeur }}</div>
            <div class="text-muted small mt-1">{{ $label }}</div>
        </div>
    </div>
</{{ $tag }}>
