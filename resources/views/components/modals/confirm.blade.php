@props([
    'id',
    'titre',
    'action',
    'method'        => 'POST',
    'boutonLabel'   => 'Confirmer',
    'boutonVariant' => 'primary',
    'icon'          => null,
])

@php
    $iconesParVariant = [
        'success' => 'fa-check',
        'danger'  => 'fa-triangle-exclamation',
        'primary' => 'fa-circle-info',
    ];
    $icone = $icon ?? ($iconesParVariant[$boutonVariant] ?? 'fa-circle-info');
@endphp

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}-titre" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content pf-modal-content">
            <form action="{{ $action }}" method="POST">
                @csrf
                @if (strtoupper($method) !== 'POST')
                    @method($method)
                @endif

                <div class="modal-header pf-modal-header">
                    <div class="pf-modal-icon pf-modal-icon-{{ $boutonVariant }}">
                        <i class="fas {{ $icone }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="modal-title pf-modal-title" id="{{ $id }}-titre">{{ $titre }}</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <div class="modal-body pf-modal-body">
                    {{ $slot }}
                </div>

                <div class="modal-footer pf-modal-footer">
                    <x-buttons.button type="button" variant="ghost" data-bs-dismiss="modal">
                        Annuler
                    </x-buttons.button>
                    <x-buttons.button type="submit" :variant="$boutonVariant">
                        {{ $boutonLabel }}
                    </x-buttons.button>
                </div>
            </form>
        </div>
    </div>
</div>
