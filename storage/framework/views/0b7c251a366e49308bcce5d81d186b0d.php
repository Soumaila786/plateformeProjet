<?php $__env->startSection('title', 'Types de projets'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('admin.dashboard')); ?>">Tableau de bord</a><span>/</span>
    <a href="<?php echo e(route('parametres.index')); ?>">Paramètres</a><span>/</span>
    <span>Types de projets</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/parametres.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/listes-projets.css')); ?>">
    <?php $__env->stopPush(); ?>
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div><h1 class="page-header-title">Types de projets</h1><p class="page-header-sub">Gérez les catégories proposées aux porteurs.</p></div>
        <div class="d-flex align-items-center gap-2 flex-wrap"><a href="<?php echo e(route('parametres.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#form-ajout-type"><i class="fas fa-plus me-1"></i>Créer un type</button></div>
    </div>
    <?php echo $__env->make('partials._flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="collapse mb-4" id="form-ajout-type"><div class="card border-0"><div class="card-body">
        <h5 class="fw-bold mb-3">Ajouter un type</h5>
        <form method="POST" action="<?php echo e(route('admin.types-projets.store')); ?>" class="row g-2 align-items-end"><?php echo csrf_field(); ?>
            <div class="col-md-4"><label class="form-label">Nom</label><input name="nom" class="form-control" required maxlength="255"></div>
            <div class="col-md-6"><label class="form-label">Description</label><input name="description" class="form-control" maxlength="1000"></div>
            <div class="col-md-2"><button class="btn btn-primary w-100" type="submit"><i class="fas fa-plus me-1"></i>Ajouter</button></div>
        </form>
    </div></div></div>
    <div>
        <?php $__empty_1 = true; $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="lp-row">
                <div class="lp-avatar"><i class="fas fa-layer-group"></i></div>
                <div class="lp-info">
                    <div class="lp-top"><span class="lp-titre"><?php echo e($type->nom); ?></span></div>
                    <p class="lp-meta">
                        <span><i class="fas fa-folder"></i><?php echo e($type->projets_count); ?> projet<?php echo e($type->projets_count > 1 ? 's' : ''); ?></span>
                        <span><i class="fas fa-align-left"></i><?php echo e($type->description ?: 'Aucune description renseignée.'); ?></span>
                    </p>
                </div>
                <div class="lp-badges">
                    <span class="badge <?php echo e($type->actif ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'); ?>"><?php echo e($type->actif ? 'Actif' : 'Inactif'); ?></span>
                    <button type="button" class="lp-btn" title="Modifier" data-bs-toggle="collapse" data-bs-target="#edit-type-<?php echo e($type->id); ?>"><i class="fas fa-pen"></i></button>
                    <form method="POST" action="<?php echo e(route('admin.types-projets.toggle-status', $type)); ?>" class="d-inline"><?php echo csrf_field(); ?><button type="submit" class="lp-btn <?php echo e($type->actif ? '' : 'lp-btn-green'); ?>" title="<?php echo e($type->actif ? 'Désactiver' : 'Activer'); ?>"><i class="fas <?php echo e($type->actif ? 'fa-toggle-off' : 'fa-toggle-on'); ?>"></i></button></form>
                    <?php if($type->projets_count === 0): ?><form method="POST" action="<?php echo e(route('admin.types-projets.destroy', $type)); ?>" class="d-inline" onsubmit="return confirm('Supprimer ce type ?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="lp-btn lp-btn-red" title="Supprimer"><i class="fas fa-trash"></i></button></form><?php endif; ?>
                </div>
            </div>
            <div class="collapse mb-3" id="edit-type-<?php echo e($type->id); ?>">
                <form method="POST" action="<?php echo e(route('admin.types-projets.update', $type)); ?>" class="lp-row align-items-end"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <div class="flex-grow-1"><label class="form-label small">Nom</label><input name="nom" value="<?php echo e($type->nom); ?>" class="form-control" required></div>
                    <div class="flex-grow-1"><label class="form-label small">Description</label><input name="description" value="<?php echo e($type->description); ?>" class="form-control"></div>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check me-1"></i>Enregistrer</button>
                </form>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="lp-empty"><i class="fas fa-layer-group"></i><p class="mb-0">Aucun type de projet.</p></div>
        <?php endif; ?>
    </div>
    <div class="mt-3"><?php echo e($types->withQueryString()->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\types-projets\index.blade.php ENDPATH**/ ?>