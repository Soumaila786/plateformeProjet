@props(['titre' => null, 'icon' => null])

<div {{ $attributes->merge(['class' => 'card border-0']) }} style="box-shadow: var(--shadow-md); border-radius: var(--radius-xl);">
    <div class="card-body">
        @if ($titre)
            <div class="d-flex align-items-center gap-2 pb-3 mb-3" style="border-bottom: 1px solid var(--color-border-light);">
                @if ($icon)
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:32px; height:32px; border-radius: var(--radius-md); background: var(--color-primary-light); color: var(--color-primary);">
                        <i class="fas {{ $icon }}" aria-hidden="true"></i>
                    </div>
                @endif
                <h5 class="mb-0 fw-bold" style="color: var(--color-text); font-size: var(--font-lg);">{{ $titre }}</h5>
            </div>
        @endif

        {{ $slot }}
    </div>
</div>
