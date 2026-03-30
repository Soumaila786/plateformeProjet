@extends('layouts.app')
@section('title', 'Configuration système')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/adminDash.css') }}">
    <link rel="stylesheet" href="{{ asset('css/configuration.css') }}">
@endpush

@section('content')
<div class="config-page">

    {{-- Header --}}
    <div class="config-header">
        <div>
            <h1><i class="fas fa-cogs" style="color:#6366f1; margin-right:8px;"></i>Configuration système</h1>
            <p>Gérez les paramètres globaux de l'application</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-reset-all">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    {{-- Les messages d'alerte --}}
    @if(session('success'))
    <div style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#f0fdf4;
                border:1px solid #bbf7d0;border-radius:8px;margin-bottom:14px;
                font-size:.8rem;color:#15803d;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    @php
        $generalGroup = $configs->get('general');
        // Si $generalGroup existe, alors cherche la config dont la clé est 'mode_maintenance' et prends la première. Sinon, mets null.
        $maintenance  = $generalGroup ? $generalGroup->where('cle','mode_maintenance')->first() : null;
        $modeMaintenanceActif = $maintenance && $maintenance->valeur === '1';
    @endphp

    @if($modeMaintenanceActif)
    <div class="maintenance-alert">
        <i class="fas fa-exclamation-triangle"></i>
        <div>
            <strong>Mode maintenance actif</strong> — Les utilisateurs ne peuvent pas accéder à l'application.
            Désactivez-le dès que la maintenance est terminée.
        </div>
    </div>
    @endif

    {{-- Tabs --}}
    <div class="config-tabs">
        @foreach($groupes as $key => $groupe)
        <a href="#" class="config-tab {{ $key === 'general' ? 'active' : '' }}"
            onclick="showSection('{{ $key }}'); return false;">
            <i class="fas {{ $groupe['icon'] }}"></i> {{ $groupe['label'] }}
        </a>
        @endforeach
    </div>

    {{-- Formulaire --}}
    <form method="POST" action="{{ route('admin.configuration.update') }}">
        @csrf @method('PUT')

        @foreach($groupes as $key => $groupe)

        <div class="config-section {{ $key === 'general' ? 'active' : '' }}" id="section-{{ $key }}">

            @if($configs->has($key))
                <div class="config-card">
                    {{-- Header --}}
                    <div class="config-card-head">
                        <div class="config-card-icon">
                            <i class="fas {{ $groupe['icon'] }}"></i>
                        </div>
                        <h3 class="config-card-title">
                            Paramètres {{ $groupe['label'] }}
                        </h3>
                    </div>
                    {{-- Body --}}
                    <div class="config-card-body">
                        <div class="field-row">
                            @foreach($configs->get($key) as $config)

                                @php
                                    $isFullWidth = in_array($config->type, ['boolean']) || strlen($config->description ?? '') > 60;
                                @endphp

                                <div class="field-group {{ $config->type === 'boolean' ? 'field-full' : '' }}">

                                    @if($config->type === 'boolean')

                                    {{-- Toggle switch --}}
                                    <label class="field-label">{{ $config->label }}</label>
                                    @if($config->description)
                                    <p class="field-desc">{{ $config->description }}</p>
                                    @endif
                                    <div class="toggle-wrap">
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="{{ $config->cle }}"
                                                    {{ $config->valeur === '1' ? 'checked' : '' }}>
                                            <span class="toggle-slider"></span>
                                        </label>
                                        <span class="toggle-label">
                                            {{ $config->valeur === '1' ? 'Activé' : 'Désactivé' }}
                                        </span>
                                    </div>

                                    @elseif($config->type === 'color')
                                    {{-- Color picker --}}
                                    <label class="field-label">
                                        {{ $config->label }}
                                    </label>
                                    @if($config->description)
                                    <p class="field-desc">{{ $config->description }}</p>
                                    @endif
                                    <div class="color-wrap">
                                        <input type="color" id="color_{{ $config->cle }}"
                                                value="{{ $config->valeur }}"
                                                class="color-preview"
                                                oninput="document.getElementById('text_{{ $config->cle }}').value=this.value">
                                        <input type="text" id="text_{{ $config->cle }}"
                                                name="{{ $config->cle }}"
                                                value="{{ $config->valeur }}"
                                                class="color-text"
                                                oninput="document.getElementById('color_{{ $config->cle }}').value=this.value">
                                    </div>

                                    @else
                                    {{-- Champ texte/email/number --}}
                                    <label class="field-label">
                                        {{ $config->label }}
                                        @if($config->type === 'number')
                                        <small style="font-weight:400;color:#9ca3af;">numérique</small>
                                        @endif
                                    </label>
                                    @if($config->description)
                                    <p class="field-desc">{{ $config->description }}</p>
                                    @endif
                                    <input type="{{ $config->type === 'email' ? 'email' : ($config->type === 'number' ? 'number' : 'text') }}"
                                            name="{{ $config->cle }}"
                                            value="{{ old($config->cle, $config->valeur) }}"
                                            class="field-input"
                                            {{ $config->type === 'number' ? 'min=0 step=1' : '' }}>
                                    @if($errors->has($config->cle))
                                    <p style="font-size:.7rem;color:#dc2626;margin:2px 0 0;">{{ $errors->first($config->cle) }}</p>
                                    @endif
                                    @endif

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
        @endforeach

        {{-- Actions --}}
        <div class="config-actions">
            <button type="button" class="btn-reset-all"
                    onclick="return confirm('Réinitialiser TOUS les paramètres aux valeurs par défaut ?') && document.getElementById('resetAllForm').submit()">
                <i class="fas fa-undo"></i> Réinitialiser tout
            </button>
            <button type="submit" class="btn-save-config">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
        </div>
    </form>

</div>

@push('scripts')
<script>

    function showSection(key) {
        // Masquer toutes les sections
        document.querySelectorAll('.config-section').forEach(s => s.classList.remove('active'));
        document.querySelectorAll('.config-tab').forEach(t => t.classList.remove('active'));
        // Afficher la section cible
        document.getElementById('section-' + key).classList.add('active');
        document.querySelector('[onclick*="' + key + '"]').classList.add('active');
    }

    // Mise à jour du label toggle en temps réel
    document.querySelectorAll('.toggle-switch input[type="checkbox"]').forEach(function(cb) {
        cb.addEventListener('change', function() {
            const label = this.closest('.toggle-wrap').querySelector('.toggle-label');
            label.textContent = this.checked ? 'Activé' : 'Désactivé';
        });
    });
</script>
@endpush
@endsection
