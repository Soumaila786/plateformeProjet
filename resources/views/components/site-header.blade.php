@props(['contexte' => 'accueil'])

@php
    $getConf = fn ($cle, $defaut = null) => isset($sysConfig) ? ($sysConfig->get($cle, $defaut) ?? $defaut) : $defaut;
@endphp

<header class="ac-header">
    <div class="ac-header-inner">
        {{-- Logo cliquable : ramène toujours à l'accueil, où que l'on soit --}}
        <a href="{{ route('accueil') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none">
            <img src="{{ asset('images/logo-cifeu.jpg') }}" alt="CIFEU" style="height:38px; width:auto;">
            <span class="fw-bold" style="font-size:1.05rem; color: var(--color-text);">
                {{ $getConf('nom_app', config('app.name')) }}
            </span>
        </a>

        <nav class="ac-nav">
            @if ($contexte === 'accueil')
                <a href="#apropos">À propos</a>
                <a href="#domaines">Domaines</a>
                <a href="#contact">Contact</a>
                <a href="{{ route('login') }}" class="ac-btn-login">Connexion</a>
            @else
                <a href="{{ route('accueil') }}#apropos">À propos</a>
                <a href="{{ route('accueil') }}#domaines">Domaines</a>
                <a href="{{ route('accueil') }}#contact">Contact</a>
                <a href="{{ route('accueil') }}" class="ac-btn-login">
                    <i class="fas fa-arrow-left"></i> Accueil
                </a>
            @endif
        </nav>
    </div>
</header>
