<?php $__env->startSection('title', 'Accueil'); ?>

<?php $__env->startPush('styles'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/variables.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/typography.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/forms.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/accueil.css')); ?>">
<?php $__env->stopPush(); ?>

<?php
    $getConf = fn ($cle, $defaut = null) => isset($sysConfig) ? ($sysConfig->get($cle, $defaut) ?? $defaut) : $defaut;
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
?>

<?php $__env->startSection('content'); ?>

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.site-header','data' => ['contexte' => 'accueil']]); ?>
<?php $component->withName('site-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['contexte' => 'accueil']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <section class="ac-hero ac-hero-photo">
        <div class="ac-hero-inner">
            <span class="ac-hero-badge ac-reveal" data-reveal="fade-up" data-delay="0">Université Joseph Ki-Zerbo</span>
            <h1 class="ac-hero-title ac-reveal" data-reveal="fade-up" data-delay="100">CIFEU</h1>
            <p class="ac-hero-sub ac-reveal" data-reveal="fade-up" data-delay="200">Circuit Intégré des Financements Extérieurs Universitaires</p>
            <p class="ac-hero-desc ac-reveal" data-reveal="fade-up" data-delay="300">
                <?php echo e($getConf('accueil_hero_texte', "La plateforme de gestion et de suivi de l'ensemble des financements extérieurs de l'UJKZ — projets, conventions, budget, dette, dépenses et évaluation — centralisés dans un circuit unique, transparent et maîtrisé.")); ?>

            </p>
            <a href="<?php echo e(route('login')); ?>" class="ac-btn-hero ac-reveal" data-reveal="fade-up" data-delay="400">
                <i class="fas fa-right-to-bracket"></i> Se connecter
            </a>
        </div>
    </section>

    <section class="ac-apropos" id="apropos">
        <div class="ac-section-inner">
            <h2 class="ac-section-title ac-reveal" data-reveal="fade-up">Contexte</h2>
            <p class="ac-apropos-text ac-apropos-centree ac-reveal" data-reveal="fade-up" data-delay="100">
                <?php echo e($getConf('accueil_contexte_texte', "En tant qu'Établissement Public de l'État, l'UJKZ est financièrement autonome, bien qu'elle bénéficie de financements de l'État et d'autres partenaires pour ses projets et, éventuellement, les frais de formation de ses apprenants. Ces financements extérieurs — prêts, dons, legs, et autres — sont formalisés par des conventions et protocoles d'accord. Face à la diversité des modèles de gestion et des sources de financement des partenaires, CIFEU a été mis en place pour améliorer la gestion et le suivi de ces ressources.")); ?>

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
                        <?php $__currentLoopData = $domaines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $domaine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="ac-domaine-card">
                                <div class="ac-domaine-photo-wrap">
                                    
                                    <img src="<?php echo e(asset('images/'.$domaine['image'])); ?>" alt="<?php echo e($domaine['titre']); ?>" class="ac-domaine-photo">
                                    <?php if($domaine['disponible']): ?>
                                        <span class="ac-domaine-badge ac-domaine-badge-on">Disponible</span>
                                    <?php else: ?>
                                        <span class="ac-domaine-badge ac-domaine-badge-off">À venir</span>
                                    <?php endif; ?>
                                </div>
                                <div class="ac-domaine-body">
                                    <h3><?php echo e($domaine['titre']); ?></h3>
                                    <p><?php echo e($domaine['texte']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    
                    <img src="<?php echo e(asset('images/contact.jpg')); ?>" alt="Contact CIFEU" class="ac-contact-img">
                </div>

                <div class="ac-contact-form-wrap">
                    <?php if(session('contact_success')): ?>
                        <div class="ac-contact-alert ac-contact-alert-success">
                            <i class="fas fa-check-circle"></i> <?php echo e(session('contact_success')); ?>

                        </div>
                    <?php endif; ?>
                    <?php if($errors->any()): ?>
                        <div class="ac-contact-alert ac-contact-alert-error">
                            <i class="fas fa-exclamation-circle"></i> <?php echo e($errors->first()); ?>

                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('contact.envoyer')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Votre email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>" required placeholder="vous@exemple.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Objet</label>
                            <input type="text" name="objet" class="form-control" value="<?php echo e(old('objet')); ?>" required maxlength="255" placeholder="Sujet de votre message">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" rows="5" class="form-control" required><?php echo e(old('message')); ?></textarea>
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
            <img src="<?php echo e(asset('images/logo-cifeu.png')); ?>" alt="CIFEU" style="height:28px; width:auto;">
            <span class="fw-bold" style="font-size:.95rem; color: var(--color-text);">
                <?php echo e($getConf('nom_app', config('app.name'))); ?>

            </span>
        </div>
        <p>&copy; <?php echo e(date('Y')); ?> CIFEU — Université Joseph Ki-Zerbo. Tous droits réservés.</p>
    </footer>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/accueil.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.guest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\accueil.blade.php ENDPATH**/ ?>