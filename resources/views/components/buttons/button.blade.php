@props([
    'variant' => 'primary',  // primary | outline | danger | ghost | success
    'size'    => null,       // null | sm
    'icon'    => null,
    'type'    => 'button',
])

@php
    $classesParVariant = [
        'primary' => 'btn-primary',
        'outline' => 'btn-outline-secondary',
        'danger'  => 'btn-danger',
        'success' => 'btn-success',
        'ghost'   => 'btn-link text-decoration-none',
    ];
    $classe = $classesParVariant[$variant] ?? 'btn-primary';
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'btn '.$classe.($size === 'sm' ? ' btn-sm' : '')]) }}
>
    @if ($icon)
        <i class="fas {{ $icon }}" aria-hidden="true"></i>
    @endif
    {{ $slot }}
</button>
