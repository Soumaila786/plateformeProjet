<?php $__env->startSection('title', 'Sous-domaines'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('admin.dashboard')); ?>">Tableau de bord</a><span>/</span>
    <a href="<?php echo e(route('parametres.index')); ?>">Paramètres</a><span>/</span>
    <span>Sous-domaines</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/parametres.css')); ?>">
    <?php $__env->stopPush(); ?>
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="page-header-title">Sous-domaines</h1>
            <p class="page-header-sub">Précisez les domaines proposés aux porteurs.</p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap"><a href="<?php echo e(route('parametres.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#form-ajout-sous-domaine"><i class="fas fa-plus me-1"></i>Créer un sous-domaine</button></div>
        </div>
    <?php echo $__env->make('partials._flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="collapse mb-4" id="form-ajout-sous-domaine"><div class="card border-0"><div class="card-body"><h5 class="fw-bold mb-3">Ajouter un sous-domaine</h5><form method="POST" action="<?php echo e(route('admin.sous-domaines.store')); ?>" class="row g-2 align-items-end"><?php echo csrf_field(); ?>
        <div class="col-md-4"><label class="form-label">Secteur parent</label><select name="secteur_id" class="form-select" required><option value="">Sélectionner...</option><?php $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($secteur->id); ?>"><?php echo e($secteur->nomSecteur); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div class="col-md-4"><label class="form-label">Nom</label><input name="nom" class="form-control" required maxlength="255"></div><div class="col-md-3"><label class="form-label">Description</label><input name="description" class="form-control" maxlength="1000"></div><div class="col-md-1"><button class="btn btn-primary w-100" type="submit"><i class="fas fa-plus"></i></button></div>
    </form></div></div></div>
    <div class="card border-0"><div class="card-body p-0"><div class="table-responsive"><table class="table mb-0"><thead><tr><th class="ps-4">Sous-domaine</th><th>Secteur parent</th><th>Projets</th><th>État</th><th class="text-end pe-4">Actions</th></tr></thead><tbody>
        <?php $__empty_1 = true; $__currentLoopData = $sousDomaines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sousDomaine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td class="ps-4"><strong><?php echo e($sousDomaine->nom); ?></strong><div class="small text-muted"><?php echo e($sousDomaine->description); ?></div></td><td><?php echo e($sousDomaine->secteur->nomSecteur ?? '—'); ?></td><td><?php echo e($sousDomaine->projets_count); ?></td><td><span class="badge <?php echo e($sousDomaine->actif ? 'text-bg-success' : 'text-bg-secondary'); ?>"><?php echo e($sousDomaine->actif ? 'Actif' : 'Inactif'); ?></span></td><td class="text-end pe-4"><div class="d-flex justify-content-end gap-2"><button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#edit-sub-<?php echo e($sousDomaine->id); ?>"><i class="fas fa-pen"></i></button><form method="POST" action="<?php echo e(route('admin.sous-domaines.toggle-status', $sousDomaine)); ?>"><?php echo csrf_field(); ?><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-power-off"></i></button></form><?php if($sousDomaine->projets_count === 0): ?><form method="POST" action="<?php echo e(route('admin.sous-domaines.destroy', $sousDomaine)); ?>" onsubmit="return confirm('Supprimer ce sous-domaine ?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button></form><?php endif; ?></div></td></tr>
        <tr class="collapse" id="edit-sub-<?php echo e($sousDomaine->id); ?>"><td colspan="5"><form method="POST" action="<?php echo e(route('admin.sous-domaines.update', $sousDomaine)); ?>" class="row g-2 p-3"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?><div class="col-md-3"><select name="secteur_id" class="form-select" required><?php $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($secteur->id); ?>" <?php echo e($sousDomaine->secteur_id === $secteur->id ? 'selected' : ''); ?>><?php echo e($secteur->nomSecteur); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div class="col-md-3"><input name="nom" value="<?php echo e($sousDomaine->nom); ?>" class="form-control" required></div><div class="col-md-4"><input name="description" value="<?php echo e($sousDomaine->description); ?>" class="form-control"></div><div class="col-md-2"><button class="btn btn-primary w-100">Enregistrer</button></div></form></td></tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="5" class="text-center py-4 text-muted">Aucun sous-domaine.</td></tr><?php endif; ?>
    </tbody></table></div></div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/sous-domaines/index.blade.php ENDPATH**/ ?>