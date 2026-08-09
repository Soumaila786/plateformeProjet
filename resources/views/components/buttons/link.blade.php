@props([
    'href',
    'variant' => 'outline',
    'size'    => null,
    'icon'    => null,
])

@php
    $classesParVariant = [
        'primary' => 'btn-primary',
        'outline' => 'btn-outline-secondary',
        'danger'  => 'btn-danger',
        'success' => 'btn-success',
        'ghost'   => 'btn-link text-decoration-none',
    ];
    $classe = $classesParVariant[$variant] ?? 'btn-outline-secondary';
@endphp

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => 'btn '.$classe.($size === 'sm' ? ' btn-sm' : '')]) }}
>
    @if ($icon)
        <i class="fas {{ $icon }}" aria-hidden="true"></i>
    @endif
    {{ $slot }}
</a>
