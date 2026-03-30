<?php $__env->startSection('title', $user->nomComplet); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="projets-page">

    <div class="page-header">
        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-header-info">
            <div>
                <h1 class="projets-title"><?php echo e($user->nomComplet); ?></h1>
                <p class="projets-subtitle"><?php echo e($user->email); ?></p>
            </div>
            <div class="page-header-actions">
                <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn-edit-main">
                    <i class="fas fa-pencil-alt"></i> Modifier
                </a>
                <form method="POST" action="<?php echo e(route('admin.users.toggle-status', $user)); ?>" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                            class="btn-save <?php echo e($user->actif ? 'btn-warning' : 'btn-success'); ?>">
                        <i class="fas <?php echo e($user->actif ? 'fa-user-times' : 'fa-user-check'); ?>"></i>
                        <?php echo e($user->actif ? 'Désactiver' : 'Activer'); ?>

                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="form-card">
        <div class="form-card-header">
            <i class="fas fa-user"></i>
            <span>Informations</span>
        </div>
        <div class="form-card-body">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nom complet</span>
                    <span class="info-value"><?php echo e($user->nomComplet); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value"><?php echo e($user->email); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Rôle</span>
                    <span class="role-badge role-<?php echo e($user->role); ?>"><?php echo e(ucfirst($user->role)); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Statut</span>
                    <?php if($user->actif): ?>
                        <span class="status-badge status-green">Actif</span>
                    <?php else: ?>
                        <span class="status-badge status-red">Inactif</span>
                    <?php endif; ?>
                </div>
                <div class="info-item">
                    <span class="info-label">Téléphone</span>
                    <span class="info-value"><?php echo e($user->telephone ?? '—'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Organisation</span>
                    <span class="info-value"><?php echo e($user->organisation ?? '—'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Créé le</span>
                    <span class="info-value"><?php echo e(optional($user->dateCreation)->format('d/m/Y') ?? optional($user->created_at)->format('d/m/Y') ?? '—'); ?></span>
                </div>
            </div>
        </div>
    </div>

    
    <?php if($user->projets->count() > 0): ?>
    <div class="form-card mt-3">
        <div class="form-card-header">
            <i class="fas fa-folder"></i>
            <span>Projets (<?php echo e($user->projets->count()); ?>)</span>
        </div>
        <div class="form-card-body">
            <div class="table-scroll">
                <table class="projets-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Titre</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $user->projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $sc = ['brouillon'=>'status-gray','soumis'=>'status-blue','en_examen'=>'status-yellow','approuve'=>'status-green','valide'=>'status-teal','rejete'=>'status-red'];
                            $sl = ['brouillon'=>'Brouillon','soumis'=>'Soumis','en_examen'=>'En examen','approuve'=>'Approuvé','valide'=>'Validé','rejete'=>'Rejeté'];
                        ?>
                        <tr>
                            <td><?php echo e($projet->codeProjet); ?></td>
                            <td><?php echo e(Str::limit($projet->titre, 40)); ?></td>
                            <td><span class="status-badge <?php echo e($sc[$projet->statutProjet] ?? 'status-gray'); ?>"><?php echo e($sl[$projet->statutProjet] ?? $projet->statutProjet); ?></span></td>
                            <td><?php echo e(optional($projet->dateCreation)->format('d/m/Y') ?? '—'); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.projets.show', $projet)); ?>" class="btn-icon">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/admin/users/show.blade.php ENDPATH**/ ?>