<?php $__env->startSection('title', 'Secteurs'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="projets-page">

    <div class="projets-header">
        <div>
            <h1 class="projets-title">Secteurs d'activité</h1>
            <p class="projets-subtitle"><?php echo e($secteurs->count()); ?> secteur<?php echo e($secteurs->count() > 1 ? 's' : ''); ?></p>
        </div>
        <a href="<?php echo e(route('admin.secteurs.create')); ?>" class="btn-add">
            <i class="fas fa-plus"></i> Nouveau secteur
        </a>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
    <div class="alert alert-error"><i class="fas fa-times-circle"></i> <?php echo e(session('error')); ?></div>
    <?php endif; ?>

    
    <div class="cards-grid">
        <?php $__empty_1 = true; $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="secteur-card">
            <div class="secteur-card-top">
                <div class="secteur-icon">
                    <i class="fas fa-tag"></i>
                </div>
                <div>
                    <?php if($secteur->statutSecteur): ?>
                        <span class="status-badge status-green">Actif</span>
                    <?php else: ?>
                        <span class="status-badge status-red">Inactif</span>
                    <?php endif; ?>
                </div>
            </div>

            <h3 class="secteur-card-nom"><?php echo e($secteur->nomSecteur); ?></h3>

            <?php if($secteur->description): ?>
            <p class="secteur-card-desc"><?php echo e(Str::limit($secteur->description, 80)); ?></p>
            <?php else: ?>
            <p class="secteur-card-desc" style="font-style:italic;">Aucune description.</p>
            <?php endif; ?>

            <div class="secteur-card-footer">
                <span class="secteur-projets-count">
                    <i class="fas fa-folder"></i>
                    <?php echo e($secteur->projets->count()); ?> projet<?php echo e($secteur->projets->count() > 1 ? 's' : ''); ?>

                </span>
                <div class="user-card-footer" style="border:none;padding:0;">
                    <a href="<?php echo e(route('admin.secteurs.edit', $secteur)); ?>" class="btn-icon" title="Modifier">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <form method="POST" action="<?php echo e(route('admin.secteurs.toggle-status', $secteur)); ?>" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                                class="btn-icon <?php echo e($secteur->statutSecteur ? 'btn-icon-warning' : 'btn-icon-success'); ?>"
                                title="<?php echo e($secteur->statutSecteur ? 'Désactiver' : 'Activer'); ?>">
                            <i class="fas <?php echo e($secteur->statutSecteur ? 'fa-toggle-off' : 'fa-toggle-on'); ?>"></i>
                        </button>
                    </form>
                    <form method="POST" action="<?php echo e(route('admin.secteurs.destroy', $secteur)); ?>"
                            onsubmit="return confirm('Supprimer ce secteur ?')" style="display:inline;">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn-icon btn-icon-danger" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="cards-empty" style="grid-column:1/-1;">
            <i class="fas fa-tags"></i>
            <p>Aucun secteur trouvé.</p>
        </div>
        <?php endif; ?>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/admin/secteurs/index.blade.php ENDPATH**/ ?>