@extends('layouts.guest')

@section('title', 'Accueil')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/accueil.css') }}">
@endpush

@php
    $getConf = fn ($cle, $defaut = null) => isset($sysConfig) ? ($sysConfig->get($cle, $defaut) ?? $defaut) : $defaut;

    // ──────────────────────────────────────────────────────────────
    // Chaque domaine a maintenant une vraie image (balise <img> plus
    // bas). REMPLACE le fichier correspondant dans public/images/domaines/
    // par ta propre photo — même nom de fichier, ou ajuste le chemin ici.
    // ──────────────────────────────────────────────────────────────
    $domaines = [
        ['image' => 'domaines/base-donnees-projets.jpg',  'titre' => 'Base de données des projets',  'texte' => "Constituer et centraliser la base des projets en recherche de financement.", 'disponible' => true],
        ['image' => 'domaines/conventions.jpg',           'titre' => 'Conventions',                  'texte' => "Préparer et suivre les conventions et protocoles d'accord avec les partenaires.", 'disponible' => false],
        ['image' => 'domaines/budget.jpg',                'titre' => 'Budget',                       'texte' => "Élaborer, suivre et contrôler le budget des projets financés.", 'disponible' => false],
        ['image' => 'domaines/dette-feu.jpg',             'titre' => 'Dette & FEU',                  'texte' => "Suivre la mobilisation, la gestion de la dette et la comptabilisation des FEU.", 'disponible' => false],
        ['image' => 'domaines/depenses-feu.jpg',          'titre' => 'Dépenses sur FEU',             'texte' => "Gérer et suivre les dépenses réalisées sur les financements extérieurs.", 'disponible' => false],
        ['image' => 'domaines/suivi-evaluation.jpg',      'titre' => 'Suivi & évaluation',           'texte' => "Suivre et évaluer l'avancement et l'impact des projets financés.", 'disponible' => false],
        ['image' => 'domaines/prelevements.jpg',          'titre' => 'Prélèvements institutionnels', 'texte' => "Gérer les prélèvements institutionnels appliqués aux financements.", 'disponible' => false],
        ['image' => 'domaines/frais-formation.jpg',       'titre' => 'Frais de formation / Labo',    'texte' => "Gérer les frais de formation et de laboratoire des étudiants.", 'disponible' => false],
        ['image' => 'domaines/voyages-etudes.jpg',        'titre' => "Voyages d'études",             'texte' => "Programmer, réaliser et suivre les voyages d'études.", 'disponible' => false],
    ];
@endphp

@section('content')

    <x-site-header contexte="accueil" />

    <section class="ac-hero ac-hero-photo">
        <div class="ac-hero-inner">
            <span class="ac-hero-badge ac-reveal" data-reveal="fade-up" data-delay="0">Université Joseph Ki-Zerbo</span>
            <h1 class="ac-hero-title ac-reveal" data-reveal="fade-up" data-delay="100">CIFEU</h1>
            <p class="ac-hero-sub ac-reveal" data-reveal="fade-up" data-delay="200">Circuit Intégré des Financements Extérieurs Universitaires</p>
            <p class="ac-hero-desc ac-reveal" data-reveal="fade-up" data-delay="300">
                {{ $getConf('accueil_hero_texte', "La plateforme de gestion et de suivi de l'ensemble des financements extérieurs de l'UJKZ — projets, conventions, budget, dette, dépenses et évaluation — centralisés dans un circuit unique, transparent et maîtrisé.") }}
            </p>
            <a href="{{ route('login') }}" class="ac-btn-hero ac-reveal" data-reveal="fade-up" data-delay="400">
                <i class="fas fa-right-to-bracket"></i> Se connecter
            </a>
        </div>
    </section>

    <section class="ac-apropos" id="apropos">
        <div class="ac-section-inner">
            <h2 class="ac-section-title ac-reveal" data-reveal="fade-up">Contexte</h2>
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
                                <div class="ac-domaine-photo-wrap">
                                    {{-- REMPLACE chaque image par la tienne (même nom de fichier) --}}
                                    <img src="{{ asset('images/'.$domaine['image']) }}" alt="{{ $domaine['titre'] }}" class="ac-domaine-photo">
                                    @if ($domaine['disponible'])
                                        <span class="ac-domaine-badge ac-domaine-badge-on">Disponible</span>
                                    @else
                                        <span class="ac-domaine-badge ac-domaine-badge-off">À venir</span>
                                    @endif
                                </div>
                                <div class="ac-domaine-body">
                                    <h3>{{ $domaine['titre'] }}</h3>
                                    <p>{{ $domaine['texte'] }}</p>
                                </div>
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
            <h2 class="ac-section-title ac-reveal" data-reveal="fade-up">Nous contacter</h2>
            <p class="ac-section-sub ac-reveal" data-reveal="fade-up" data-delay="100">
                Une question, un problème d'accès ? Écrivez-nous directement
            </p>

            <div class="ac-contact-grid ac-reveal" data-reveal="fade-up" data-delay="200">
                <div class="ac-contact-img-wrap">
                    {{-- REMPLACE par ton image --}}
                    <img src="{{ asset('images/contact.jpg') }}" alt="Contact CIFEU" class="ac-contact-img">
                </div>

                <div class="ac-contact-form-wrap">
                    @if (session('contact_success'))
                        <div class="ac-contact-alert ac-contact-alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('contact_success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="ac-contact-alert ac-contact-alert-error">
                            <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.envoyer') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Votre email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="vous@exemple.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Objet</label>
                            <input type="text" name="objet" class="form-control" value="{{ old('objet') }}" required maxlength="255" placeholder="Sujet de votre message">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" rows="5" class="form-control" required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="ac-btn-hero" style="box-shadow:none; background:var(--color-primary); color:#fff !important;">
                            <i class="fas fa-paper-plane"></i> Envoyer le message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="ac-footer">
        <div class="d-inline-flex align-items-center gap-2">
            <img src="{{ asset('images/logo-cifeu.png') }}" alt="CIFEU" style="height:28px; width:auto;">
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
