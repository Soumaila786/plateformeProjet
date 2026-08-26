<?php $__env->startSection('title', 'Types de projets'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('admin.dashboard')); ?>">Tableau de bord</a><span>/</span>
    <a href="<?php echo e(route('parametres.index')); ?>">Paramètres</a><span>/</span>
    <span>Types de projets</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?><link rel="stylesheet" href="<?php echo e(asset('css/parametres.css')); ?>"><?php $__env->stopPush(); ?>
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div><h1 class="page-header-title">Types de projets</h1><p class="page-header-sub">Gérez les catégories proposées aux porteurs.</p></div>
        <div class="d-flex align-items-center gap-2 flex-wrap"><a href="<?php echo e(route('parametres.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#form-ajout-type"><i class="fas fa-plus me-1"></i>Créer un type</button></div>
    </div>
    <?php echo $__env->make('partials._flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="collapse mb-4" id="form-ajout-type"><div class="card border-0"><div class="card-body">
        <h5 class="fw-bold mb-3">Ajouter un type</h5>
        <form method="POST" action="<?php echo e(route('admin.types-projets.store')); ?>" class="row g-2 align-items-end"><?php echo csrf_field(); ?>
            <div class="col-md-4"><label class="form-label">Nom</label><input name="nom" class="form-control" required maxlength="255"></div>
            <div class="col-md-6"><label class="form-label">Description</label><input name="description" class="form-control" maxlength="1000"></div>
            <div class="col-md-2"><button class="btn btn-primary w-100" type="submit"><i class="fas fa-plus me-1"></i>Ajouter</button></div>
        </form>
    </div></div></div>
    <div class="card border-0"><div class="card-body p-0"><div class="table-responsive"><table class="table mb-0">
        <thead><tr><th class="ps-4">Type</th><th>Description</th><th>Projets</th><th>État</th><th class="text-end pe-4">Actions</th></tr></thead>
        <tbody><?php $__empty_1 = true; $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr>
            <td class="ps-4"><strong><?php echo e($type->nom); ?></strong></td><td><?php echo e($type->description ?: '—'); ?></td><td><?php echo e($type->projets_count); ?></td>
            <td><span class="badge <?php echo e($type->actif ? 'text-bg-success' : 'text-bg-secondary'); ?>"><?php echo e($type->actif ? 'Actif' : 'Inactif'); ?></span></td>
            <td class="text-end pe-4"><div class="d-flex justify-content-end gap-2">
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#edit-type-<?php echo e($type->id); ?>"><i class="fas fa-pen"></i></button>
                <form method="POST" action="<?php echo e(route('admin.types-projets.toggle-status', $type)); ?>"><?php echo csrf_field(); ?><button class="btn btn-sm btn-outline-secondary" title="Activer ou désactiver"><i class="fas fa-power-off"></i></button></form>
                <?php if($type->projets_count === 0): ?><form method="POST" action="<?php echo e(route('admin.types-projets.destroy', $type)); ?>" onsubmit="return confirm('Supprimer ce type ?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form><?php endif; ?>
            </div></td>
        </tr><tr class="collapse" id="edit-type-<?php echo e($type->id); ?>"><td colspan="5"><form method="POST" action="<?php echo e(route('admin.types-projets.update', $type)); ?>" class="row g-2 p-3"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><div class="col-md-4"><input name="nom" value="<?php echo e($type->nom); ?>" class="form-control" required></div><div class="col-md-6"><input name="description" value="<?php echo e($type->description); ?>" class="form-control"></div><div class="col-md-2"><button class="btn btn-primary w-100">Enregistrer</button></div></form></td></tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="5" class="text-center py-4 text-muted">Aucun type de projet.</td></tr><?php endif; ?></tbody>
    </table></div></div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/types-projets/index.blade.php ENDPATH**/ ?>