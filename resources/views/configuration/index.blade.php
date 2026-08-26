@extends('layouts.app')

@section('title', 'Configuration système')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <span>Configuration système</span>
@endsection

@section('page-header')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/parametres.css') }}">
    @endpush

    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Configuration système</h1>
            <p class="page-header-sub">Paramètres généraux de l'application</p>
        </div>
        <a href="{{ route('parametres.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a>
    </div>
@endsection

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/configuration.css') }}">
    @endpush

    @php $premierGroupe = $configs->keys()->first(); @endphp

    <div class="conf-tabs">
        @foreach ($configs as $groupeKey => $items)
            <button type="button" class="conf-tab {{ $groupeKey === $premierGroupe ? 'active' : '' }}"
                    data-conf-tab="{{ $groupeKey }}">
                <i class="fas {{ $groupes[$groupeKey]['icon'] ?? 'fa-sliders' }} me-1"></i>
                {{ $groupes[$groupeKey]['label'] ?? ucfirst($groupeKey) }}
            </button>
        @endforeach
    </div>

    <form action="{{ route('admin.configuration.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @foreach ($configs as $groupeKey => $items)
            <div class="conf-groupe {{ $groupeKey === $premierGroupe ? 'active' : '' }}" data-conf-groupe="{{ $groupeKey }}">
                <x-cards.info>
                    @foreach ($items as $config)
                        <div class="conf-field-row">
                            <div>
                                <div class="conf-field-label">{{ $config->label ?? $config->cle }}</div>
                                @if ($config->description)
                                    <div class="conf-field-desc">{{ $config->description }}</div>
                                @endif
                                @error($config->cle)<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            <div class="conf-field-input d-flex align-items-center gap-2">
                                @if ($config->type === 'boolean')
                                    <div class="form-check form-switch mb-0">
                                        <input type="hidden" name="{{ $config->cle }}" value="0">
                                        <input class="form-check-input" type="checkbox" name="{{ $config->cle }}" value="1"
                                               {{ old($config->cle, $config->valeur) === '1' ? 'checked' : '' }}>
                                    </div>

                                @elseif ($config->type === 'color')
                                    <input type="color" name="{{ $config->cle }}" class="form-control form-control-color"
                                           value="{{ old($config->cle, $config->valeur ?: '#6366f1') }}">

                                @elseif ($config->type === 'image')
                                    @if ($config->valeur)
                                        <img src="{{ asset('storage/'.$config->valeur) }}" alt="" class="conf-logo-preview">
                                    @endif
                                    <input type="file" name="{{ $config->cle }}" accept="image/*" class="form-control form-control-sm">

                                @elseif ($config->type === 'number')
                                    <input type="number" name="{{ $config->cle }}" class="form-control"
                                           value="{{ old($config->cle, $config->valeur) }}" min="0">

                                @elseif ($config->type === 'email')
                                    <input type="email" name="{{ $config->cle }}" class="form-control"
                                           value="{{ old($config->cle, $config->valeur) }}">

                                @else
                                    <input type="text" name="{{ $config->cle }}" class="form-control"
                                           value="{{ old($config->cle, $config->valeur) }}">
                                @endif

                                {{-- Réinitialiser : un formulaire POST distinct est créé en JS au clic
                                     (impossible d'imbriquer un <form> dans le formulaire principal, et
                                     formaction ne peut pas contourner le PUT spoofé du formulaire global) --}}
                                <button type="button" class="btn btn-outline-secondary btn-sm" title="Réinitialiser"
                                        data-reset-cle
                                        data-reset-url="{{ route('admin.configuration.reset', $config->cle) }}">
                                    <i class="fas fa-rotate-left"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </x-cards.info>
            </div>
        @endforeach

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-check me-1"></i>Enregistrer les modifications</button>
        </div>
    </form>

    @push('scripts')
        <script src="{{ asset('js/configuration.js') }}"></script>
    @endpush
@endsection
