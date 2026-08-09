@extends('layouts.guest')

@section('title', 'Accueil')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('css/accueil.css') }}">
@endpush

@php
    // Petit repli pour que la page fonctionne même si $sysConfig n'est pas
    // partagé sur les routes 'guest'.
    $getConf = fn ($cle, $defaut = null) => isset($sysConfig) ? ($sysConfig->get($cle, $defaut) ?? $defaut) : $defaut;

    // ──────────────────────────────────────────────────────────────
    // Les 9 domaines de CIFEU. À terme, ce tableau peut devenir des
    // lignes en base (ex: table `domaines_cifeu` gérée depuis une
    // page d'admin dédiée) pour que l'admin les modifie/réordonne/
    // ajoute sans toucher au code — même principe que les entrées
    // de la table `configurations`. Pour l'instant, seul le libellé
    // "Disponible"/"À venir" est piloté ici ; le reste est statique.
    // ──────────────────────────────────────────────────────────────
    $domaines = [
        ['icon' => 'fa-database',              'titre' => 'Base de données des projets',  'texte' => "Constituer et centraliser la base des projets en recherche de financement.", 'disponible' => true],
        ['icon' => 'fa-file-signature',         'titre' => 'Conventions',                  'texte' => "Préparer et suivre les conventions et protocoles d'accord avec les partenaires.", 'disponible' => false],
        ['icon' => 'fa-chart-pie',              'titre' => 'Budget',                       'texte' => "Élaborer, suivre et contrôler le budget des projets financés.", 'disponible' => false],
        ['icon' => 'fa-scale-balanced',         'titre' => 'Dette & FEU',                  'texte' => "Suivre la mobilisation, la gestion de la dette et la comptabilisation des FEU.", 'disponible' => false],
        ['icon' => 'fa-money-bill-wave',        'titre' => 'Dépenses sur FEU',             'texte' => "Gérer et suivre les dépenses réalisées sur les financements extérieurs.", 'disponible' => false],
        ['icon' => 'fa-magnifying-glass-chart', 'titre' => 'Suivi & évaluation',           'texte' => "Suivre et évaluer l'avancement et l'impact des projets financés.", 'disponible' => false],
        ['icon' => 'fa-building-columns',       'titre' => 'Prélèvements institutionnels', 'texte' => "Gérer les prélèvements institutionnels appliqués aux financements.", 'disponible' => false],
        ['icon' => 'fa-graduation-cap',         'titre' => 'Frais de formation / Labo',    'texte' => "Gérer les frais de formation et de laboratoire des étudiants.", 'disponible' => false],
        ['icon' => 'fa-plane-departure',        'titre' => "Voyages d'études",             'texte' => "Programmer, réaliser et suivre les voyages d'études.", 'disponible' => false],
    ];
@endphp

@section('content')

    <header class="ac-header ac-reveal" data-reveal="fade-down">
        <div class="ac-header-inner">
            <div class="d-inline-flex align-items-center gap-2">
                <img src="{{ asset('images/logo_cifeu.jpg') }}" alt="CIFEU" style="height:38px; width:auto;">
                <span class="fw-bold" style="font-size:1.05rem; color: var(--color-text);">
                    {{ $getConf('nom_app', config('app.name')) }}
                </span>
            </div>

            <nav class="ac-nav">
                <a href="#apropos">À propos</a>
                <a href="#domaines">Domaines</a>
                <a href="#contact">Contact</a>
                <a href="{{ route('login') }}" class="ac-btn-login">Connexion</a>
            </nav>
        </div>
    </header>

    <section class="ac-hero">
        <div class="ac-hero-inner">
            <span class="ac-hero-badge ac-reveal" data-reveal="fade-up" data-delay="0">Université Joseph Ki-Zerbo</span>
            <h1 class="ac-hero-title ac-reveal" data-reveal="fade-up" data-delay="100">CIFEU</h1>
            <p class="ac-hero-sub ac-reveal" data-reveal="fade-up" data-delay="200">Circuit Intégré des Financements Extérieurs Universitaires</p>
            {{-- Candidat éditable admin : description longue de l'accueil (ex: configurations.groupe = 'accueil') --}}
            <p class="ac-hero-desc ac-reveal" data-reveal="fade-up" data-delay="300">
                {{ $getConf('accueil_hero_texte', "La plateforme de gestion et de suivi de l'ensemble des financements extérieurs de l'UJKZ — projets, conventions, budget, dette, dépenses et évaluation — centralisés dans un circuit unique, transparent et maîtrisé.") }}
            </p>
            <a href="{{ route('login') }}" class="ac-btn-hero ac-reveal" data-reveal="fade-up" data-delay="400">
                <i class="fas fa-right-to-bracket"></i> Se connecter
            </a>
        </div>

        {{-- Filigrane décoratif "circuit" en fond de hero --}}
        <div class="ac-hero-circuit" aria-hidden="true">
            <div class="ac-hero-circuit-dot" style="--i:0"></div>
            <div class="ac-hero-circuit-dot" style="--i:1"></div>
            <div class="ac-hero-circuit-dot" style="--i:2"></div>
            <div class="ac-hero-circuit-dot" style="--i:3"></div>
            <div class="ac-hero-circuit-dot" style="--i:4"></div>
        </div>
    </section>

    <section class="ac-apropos" id="apropos">
        <div class="ac-section-inner">
            <h2 class="ac-section-title ac-reveal" data-reveal="fade-up">Contexte</h2>
            {{-- Candidat éditable admin --}}
            <p class="ac-apropos-text ac-apropos-centree ac-reveal" data-reveal="fade-up" data-delay="100">
                {{ $getConf('accueil_contexte_texte', "En tant qu'Établissement Public de l'État, l'UJKZ est financièrement autonome, bien qu'elle bénéficie de financements de l'État et d'autres partenaires pour ses projets et, éventuellement, les frais de formation de ses apprenants. Ces financements extérieurs — prêts, dons, legs, et autres — sont formalisés par des conventions et protocoles d'accord. Face à la diversité des modèles de gestion et des sources de financement des partenaires, CIFEU a été mis en place pour améliorer la gestion et le suivi de ces ressources.") }}
            </p>
        </div>
    </section>

    <section class="ac-domaines" id="domaines">
        <div class="ac-section-inner">
            <h2 class="ac-section-title ac-reveal" data-reveal="fade-up">Les domaines couverts par CIFEU</h2>
            <p class="ac-section-sub ac-reveal" data-reveal="fade-up" data-delay="100">
                Un circuit intégré, de la recherche de financement jusqu'au suivi des dépenses
            </p>

            <div class="ac-carousel ac-reveal" data-reveal="fade-up" data-delay="200">
                <button type="button" class="ac-carousel-btn ac-carousel-prev" aria-label="Domaine précédent">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div class="ac-carousel-viewport">
                    <div class="ac-carousel-track" id="acCarouselTrack">
                        @foreach ($domaines as $domaine)
                            <div class="ac-domaine-card">
                                @if ($domaine['disponible'])
                                    <span class="ac-domaine-badge ac-domaine-badge-on">Disponible</span>
                                @else
                                    <span class="ac-domaine-badge ac-domaine-badge-off">À venir</span>
                                @endif
                                <div class="ac-domaine-icon"><i class="fas {{ $domaine['icon'] }}"></i></div>
                                <h3>{{ $domaine['titre'] }}</h3>
                                <p>{{ $domaine['texte'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="button" class="ac-carousel-btn ac-carousel-next" aria-label="Domaine suivant">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <div class="ac-carousel-dots" id="acCarouselDots"></div>
        </div>
    </section>

    <section class="ac-contact" id="contact">
        <div class="ac-section-inner">
            <h2 class="ac-section-title ac-reveal" data-reveal="fade-up">Une question ?</h2>
            <p class="ac-section-sub ac-reveal" data-reveal="fade-up" data-delay="100">
                L'équipe de la DSI-UJKZ reste à votre disposition
            </p>
            {{-- Candidat éditable admin : email de contact --}}
            <a href="mailto:{{ $getConf('contact_email', 'gesprojet@gmail.com') }}"
                class="ac-contact-card ac-reveal"
                data-reveal="fade-up"
                data-delay="200">
                <i class="fas fa-envelope"></i>
                <span>{{ $getConf('contact_email', 'gesprojet@gmail.com') }}</span>
            </a>
        </div>
    </section>

    <footer class="ac-footer">
        <div class="d-inline-flex align-items-center gap-2">
            <img src="{{ asset('images/logo_cifeu.jpg') }}" alt="CIFEU" style="height:28px; width:auto;">
            <span class="fw-bold" style="font-size:.95rem; color: var(--color-text);">
                {{ $getConf('nom_app', config('app.name')) }}
            </span>
        </div>
        <p>&copy; {{ date('Y') }} CIFEU — Université Joseph Ki-Zerbo. Tous droits réservés.</p>
    </footer>

@endsection

@push('scripts')
    <script src="{{ asset('js/accueil.js') }}"></script>
@endpush
