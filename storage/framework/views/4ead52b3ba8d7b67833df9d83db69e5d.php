

<?php $__env->startSection('title', 'Nouveau projet'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('porteur.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <a href="<?php echo e(route('porteur.projets.index')); ?>">Mes projets</a>
    <span>/</span>
    <span>Nouveau projet</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Nouveau projet</h1>
            <p class="page-header-sub">Renseignez les informations ci-dessous pour créer votre projet</p>
        </div>
        <?php if (isset($component)) { $__componentOriginal297e0cb764496e02c55f24374a33184a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal297e0cb764496e02c55f24374a33184a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons.link','data' => ['href' => route('porteur.projets.index'),'variant' => 'ghost','icon' => 'fa-arrow-left']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('porteur.projets.index')),'variant' => 'ghost','icon' => 'fa-arrow-left']); ?>
            Retour à mes projets
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal297e0cb764496e02c55f24374a33184a)): ?>
<?php $attributes = $__attributesOriginal297e0cb764496e02c55f24374a33184a; ?>
<?php unset($__attributesOriginal297e0cb764496e02c55f24374a33184a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal297e0cb764496e02c55f24374a33184a)): ?>
<?php $component = $__componentOriginal297e0cb764496e02c55f24374a33184a; ?>
<?php unset($__componentOriginal297e0cb764496e02c55f24374a33184a); ?>
<?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/projet-form.css')); ?>">
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('scripts'); ?>
        <script src="<?php echo e(asset('js/listes-projets.js')); ?>"></script>
    <?php $__env->stopPush(); ?>

    <form action="<?php echo e(route('porteur.projets.store')); ?>"
        method="POST"
        enctype="multipart/form-data"
        class="pf-form">
        <?php echo csrf_field(); ?>

        <div class="pf-layout">
            <div class="pf-main">

                <div class="pf-section">
                    <div class="pf-section-head">
                        <div class="pf-section-icon">
                            <i class="fas fa-circle-info"></i>
                        </div>
                        <div>
                            <h2 class="pf-section-title">
                                Informations générales
                            </h2>
                            <p class="pf-section-sub">
                                Le titre et la description de votre projet
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Titre du projet</label>
                        <input type="text" name="titre" value="<?php echo e(old('titre')); ?>"
                            class="form-control <?php $__errorArgs = ['titre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required maxlength="255"
                            placeholder="Ex : Réhabilitation du laboratoire de chimie">
                        <?php $__errorArgs = ['titre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="5" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required
                                placeholder="Décrivez le contexte et le contenu du projet..."><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Objectif</label>
                        <textarea name="objectif" rows="3" class="form-control <?php $__errorArgs = ['objectif'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Quel résultat ce projet doit-il atteindre ?"><?php echo e(old('objectif')); ?></textarea>
                        <?php $__errorArgs = ['objectif'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="pf-section">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fas fa-calendar-days"></i></div>
                        <div>
                            <h2 class="pf-section-title">Planning</h2>
                            <p class="pf-section-sub">Classification, durée et dates prévisionnelles</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Type de projet</label>
                            <select name="type_projet_id" class="form-select <?php $__errorArgs = ['type_projet_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Sélectionner...</option>
                                <?php $__currentLoopData = $typesProjets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type->id); ?>" <?php echo e((string) old('type_projet_id') === (string) $type->id ? 'selected' : ''); ?>>
                                        <?php echo e($type->nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['type_projet_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Secteur d'activité</label>
                            <select name="secteur_id" id="secteurProjet" class="form-select <?php $__errorArgs = ['secteur_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Sélectionner...</option>
                                <?php $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($secteur->id); ?>" <?php echo e((string) old('secteur_id') === (string) $secteur->id ? 'selected' : ''); ?>>
                                        <?php echo e($secteur->nomSecteur); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['secteur_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sous-domaine</label>
                            <select name="sous_domaine_id" id="sousDomaineProjet" class="form-select <?php $__errorArgs = ['sous_domaine_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Aucun sous-domaine</option>
                                <?php $__currentLoopData = $sousDomaines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sousDomaine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($sousDomaine->id); ?>" data-secteur="<?php echo e($sousDomaine->secteur_id); ?>"
                                        <?php echo e((string) old('sous_domaine_id') === (string) $sousDomaine->id ? 'selected' : ''); ?>>
                                        <?php echo e($sousDomaine->nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['sous_domaine_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Durée (mois)</label>
                            <input type="number" 
                                name="duree" min="1" 
                                value="<?php echo e(old('duree')); ?>" 
                                class="form-control <?php $__errorArgs = ['duree'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['duree'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date de début</label>
                            <input type="date" 
                                name="dateDebut" 
                                value="<?php echo e(old('dateDebut')); ?>" 
                                class="form-control <?php $__errorArgs = ['dateDebut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['dateDebut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date de fin</label>
                            <input type="date"
                                name="dateFin"
                                value="<?php echo e(old('dateFin')); ?>"
                                class="form-control <?php $__errorArgs = ['dateFin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['dateFin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <div class="pf-section">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fas fa-coins"></i></div>
                        <div>
                            <h2 class="pf-section-title">Budget</h2>
                            <p class="pf-section-sub">Choisissez la devise de chaque montant</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Budget total</label>
                            <div class="input-group">
                                <input type="number"
                                    name="budgetTotal"
                                    min="0" step="0.01"
                                    value="<?php echo e(old('budgetTotal')); ?>"
                                    class="form-control <?php $__errorArgs = ['budgetTotal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <select name="budgetDevise" class="form-select <?php $__errorArgs = ['budgetDevise'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="USD" <?php echo e(old('budgetDevise', 'XOF') === 'USD' ? 'selected' : ''); ?>>$ (USD)</option>
                                    <option value="XOF" <?php echo e(old('budgetDevise', 'XOF') === 'XOF' ? 'selected' : ''); ?>>FCFA (XOF)</option>
                                    <option value="EUR" <?php echo e(old('budgetDevise', 'XOF') === 'EUR' ? 'selected' : ''); ?>>€ (EUR)</option>
                                </select>
                            </div>
                            <?php $__errorArgs = ['budgetTotal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php $__errorArgs = ['budgetDevise'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Montant demandé</label>
                            <div class="input-group">
                                <input type="number"
                                    name="montantDemande"
                                    min="0"
                                    step="0.01"
                                    value="<?php echo e(old('montantDemande')); ?>"
                                    class="form-control <?php $__errorArgs = ['montantDemande'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <select name="montantDemandeDevise" class="form-select <?php $__errorArgs = ['montantDemandeDevise'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="USD" <?php echo e(old('montantDemandeDevise', 'XOF') === 'USD' ? 'selected' : ''); ?>>$ (USD)</option>
                                    <option value="XOF" <?php echo e(old('montantDemandeDevise', 'XOF') === 'XOF' ? 'selected' : ''); ?>>FCFA (XOF)</option>
                                    <option value="EUR" <?php echo e(old('montantDemandeDevise', 'XOF') === 'EUR' ? 'selected' : ''); ?>>€ (EUR)</option>
                                </select>
                            </div>
                            <?php $__errorArgs = ['montantDemande'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php $__errorArgs = ['montantDemandeDevise'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <div class="pf-section">
                    <div class="pf-section-head">
                        <div class="pf-section-icon"><i class="fas fa-paperclip"></i></div>
                        <div>
                            <h2 class="pf-section-title">Documents</h2>
                            <p class="pf-section-sub">Optionnel — pdf, doc, xls, images (10 Mo max chacun)</p>
                        </div>
                    </div>

                    <div class="row g-2 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label small mb-1">Fichier</label>
                            <input type="file" name="documents[]" class="form-control form-control-sm <?php $__errorArgs = ['documents'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <?php $__errorArgs = ['documents'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small mb-1">Nom à afficher (optionnel)</label>
                            <input type="text" name="document_names[]" class="form-control form-control-sm" maxlength="255" placeholder="Ex. Rapport financier 2026">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pf-aside">
                <div class="pf-aside-card">
                    <h3 class="pf-aside-title"><i class="fas fa-lightbulb"></i> Avant de soumettre</h3>
                    <ul class="pf-checklist">
                        <li>Le projet est créé en <strong>brouillon</strong> — vous pourrez encore le modifier</li>
                        <li>Ajoutez vos documents justificatifs si vous les avez déjà</li>
                        <li>Vous soumettrez le projet pour examen depuis sa page de détail</li>
                    </ul>

                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check me-1"></i>Créer le projet</button>
                        <?php if (isset($component)) { $__componentOriginal297e0cb764496e02c55f24374a33184a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal297e0cb764496e02c55f24374a33184a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons.link','data' => ['href' => route('porteur.projets.index'),'variant' => 'ghost']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('porteur.projets.index')),'variant' => 'ghost']); ?>Annuler <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal297e0cb764496e02c55f24374a33184a)): ?>
<?php $attributes = $__attributesOriginal297e0cb764496e02c55f24374a33184a; ?>
<?php unset($__attributesOriginal297e0cb764496e02c55f24374a33184a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal297e0cb764496e02c55f24374a33184a)): ?>
<?php $component = $__componentOriginal297e0cb764496e02c55f24374a33184a; ?>
<?php unset($__componentOriginal297e0cb764496e02c55f24374a33184a); ?>
<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const secteur = document.getElementById('secteurProjet');
            const sousDomaine = document.getElementById('sousDomaineProjet');

            if (!secteur || !sousDomaine) return;

            const filtrerSousDomaines = function () {
                const secteurId = secteur.value;
                Array.from(sousDomaine.options).forEach(function (option) {
                    option.hidden = option.value !== '' && option.dataset.secteur !== secteurId;
                    if (option.hidden && option.selected) sousDomaine.value = '';
                });
            };

            secteur.addEventListener('change', filtrerSousDomaines);
            filtrerSousDomaines();

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\projets\create.blade.php ENDPATH**/ ?>