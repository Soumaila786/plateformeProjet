<?php $__env->startSection('title', 'Sous-domaines'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('admin.dashboard')); ?>">Tableau de bord</a><span>/</span>
    <a href="<?php echo e(route('parametres.index')); ?>">Paramètres</a><span>/</span>
    <span>Sous-domaines</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/parametres.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/listes-projets.css')); ?>">
    <?php $__env->stopPush(); ?>
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="page-header-title">Sous-domaines</h1>
            <p class="page-header-sub">Précisez les domaines proposés aux porteurs.</p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap"><a href="<?php echo e(route('parametres.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#form-ajout-sous-domaine"><i class="fas fa-plus me-1"></i>Créer un sous-domaine</button></div>
        </div>
    <?php echo $__env->make('partials._flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="collapse mb-4" id="form-ajout-sous-domaine"><div class="card border-0"><div class="card-body"><h5 class="fw-bold mb-3">Ajouter un sous-domaine</h5><form method="POST" action="<?php echo e(route('admin.sous-domaines.store')); ?>" class="row g-2 align-items-end"><?php echo csrf_field(); ?>
        <div class="col-md-4"><label class="form-label">Secteur parent</label><select name="secteur_id" class="form-select" required><option value="">Sélectionner...</option><?php $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($secteur->id); ?>"><?php echo e($secteur->nomSecteur); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div class="col-md-4"><label class="form-label">Nom</label><input name="nom" class="form-control" required maxlength="255"></div><div class="col-md-3"><label class="form-label">Description</label><input name="description" class="form-control" maxlength="1000"></div><div class="col-md-1"><button class="btn btn-primary w-100" type="submit"><i class="fas fa-plus"></i></button></div>
    </form></div></div></div>
    <div>
        <?php $__empty_1 = true; $__currentLoopData = $sousDomaines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sousDomaine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="lp-row">
                <div class="lp-avatar"><i class="fas fa-sitemap"></i></div>
                <div class="lp-info">
                    <div class="lp-top"><span class="lp-titre"><?php echo e($sousDomaine->nom); ?></span></div>
                    <p class="lp-meta">
                        <span><i class="fas fa-layer-group"></i><?php echo e($sousDomaine->secteur->nomSecteur ?? 'Secteur non défini'); ?></span>
                        <span><i class="fas fa-folder"></i><?php echo e($sousDomaine->projets_count); ?> projet<?php echo e($sousDomaine->projets_count > 1 ? 's' : ''); ?></span>
                        <?php if($sousDomaine->description): ?><span><i class="fas fa-align-left"></i><?php echo e($sousDomaine->description); ?></span><?php endif; ?>
                    </p>
                </div>
                <div class="lp-badges">
                    <span class="badge <?php echo e($sousDomaine->actif ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'); ?>"><?php echo e($sousDomaine->actif ? 'Actif' : 'Inactif'); ?></span>
                    <button type="button" class="lp-btn" title="Modifier" data-bs-toggle="collapse" data-bs-target="#edit-sub-<?php echo e($sousDomaine->id); ?>"><i class="fas fa-pen"></i></button>
                    <form method="POST" action="<?php echo e(route('admin.sous-domaines.toggle-status', $sousDomaine)); ?>" class="d-inline"><?php echo csrf_field(); ?><button type="submit" class="lp-btn <?php echo e($sousDomaine->actif ? '' : 'lp-btn-green'); ?>" title="<?php echo e($sousDomaine->actif ? 'Désactiver' : 'Activer'); ?>"><i class="fas <?php echo e($sousDomaine->actif ? 'fa-toggle-off' : 'fa-toggle-on'); ?>"></i></button></form>
                    <?php if($sousDomaine->projets_count === 0): ?><form method="POST" action="<?php echo e(route('admin.sous-domaines.destroy', $sousDomaine)); ?>" class="d-inline" onsubmit="return confirm('Supprimer ce sous-domaine ?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="lp-btn lp-btn-red" title="Supprimer"><i class="fas fa-trash"></i></button></form><?php endif; ?>
                </div>
            </div>
            <div class="collapse mb-3" id="edit-sub-<?php echo e($sousDomaine->id); ?>">
                <form method="POST" action="<?php echo e(route('admin.sous-domaines.update', $sousDomaine)); ?>" class="lp-row align-items-end"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <div class="flex-grow-1"><label class="form-label small">Secteur parent</label><select name="secteur_id" class="form-select" required><?php $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($secteur->id); ?>" <?php echo e($sousDomaine->secteur_id === $secteur->id ? 'selected' : ''); ?>><?php echo e($secteur->nomSecteur); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
                    <div class="flex-grow-1"><label class="form-label small">Nom</label><input name="nom" value="<?php echo e($sousDomaine->nom); ?>" class="form-control" required></div>
                    <div class="flex-grow-1"><label class="form-label small">Description</label><input name="description" value="<?php echo e($sousDomaine->description); ?>" class="form-control"></div>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check me-1"></i>Enregistrer</button>
                </form>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="lp-empty"><i class="fas fa-sitemap"></i><p class="mb-0">Aucun sous-domaine.</p></div>
        <?php endif; ?>
    </div>
    <div class="mt-3"><?php echo e($sousDomaines->withQueryString()->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\sous-domaines\index.blade.php ENDPATH**/ ?>