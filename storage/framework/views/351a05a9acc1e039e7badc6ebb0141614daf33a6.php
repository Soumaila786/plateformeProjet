<?php $__env->startSection('title', 'Utilisateurs'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/users.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="projets-page">

    <div class="ulist-header">
        <div>
            <h1 class="ulist-title">Utilisateurs</h1>
            <p class="ulist-subtitle"><?php echo e($users->total()); ?> utilisateur<?php echo e($users->total() > 1 ? 's' : ''); ?></p>
        </div>
        <a href="<?php echo e(route('admin.users.create')); ?>" class="ulist-btn-add">
            <i class="fas fa-plus"></i> Nouvel utilisateur
        </a>
    </div>

    
    <div class="ulist-filters">
        <div class="ulist-search-wrapper">
            <i class="fas fa-search ulist-search-icon"></i>
            <input type="text" id="searchInput" class="ulist-search-input"
                    placeholder="Rechercher par nom, email..." value="<?php echo e(request('search')); ?>">
        </div>
        <div class="ulist-role-filters">
            <?php $__currentLoopData = ['' => 'Tous', 'admin' => 'Admin', 'porteur' => 'Porteur', 'approbateur' => 'Approbateur', 'validateur' => 'Validateur']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('admin.users.index', array_merge(request()->query(), ['role' => $val]))); ?>"
                class="ulist-role-pill <?php echo e(request('role', '') === $val ? 'active' : ''); ?>">
                <?php echo e($label); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="ulist-table">

        
        <div class="ulist-thead">
            <div class="ulist-th ulist-col-user">Utilisateur</div>
            <div class="ulist-th ulist-col-info">Informations</div>
            <div class="ulist-th ulist-col-role">Rôle</div>
            <div class="ulist-th ulist-col-statut">Statut</div>
            <div class="ulist-th ulist-col-actions">Actions</div>
        </div>

        
        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="ulist-row">

            
            <div class="ulist-col-user">
                <div class="ulist-avatar ulist-avatar-<?php echo e($user->role); ?>">
                    <?php echo e(strtoupper(substr($user->nomComplet, 0, 1))); ?>

                </div>
                <div class="ulist-user-name-block">
                    <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="ulist-user-name">
                        <?php echo e($user->nomComplet); ?>

                    </a>
                    <?php if($user->organisation): ?>
                    <span class="ulist-user-org"><i class="fas fa-building"></i> <?php echo e($user->organisation); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="ulist-col-info">
                <span class="ulist-info-item"><i class="fas fa-envelope"></i> <?php echo e($user->email); ?></span>
                <?php if($user->contact): ?>
                <span class="ulist-info-item"><i class="fas fa-phone"></i> <?php echo e($user->contact); ?></span>
                <?php endif; ?>
                <?php if($user->fonction): ?>
                <span class="ulist-info-item"><i class="fas fa-briefcase"></i> <?php echo e($user->fonction); ?></span>
                <?php endif; ?>
            </div>

            
            <div class="ulist-col-role">
                <span class="ulist-role-badge ulist-role-<?php echo e($user->role); ?>">
                    <?php echo e(ucfirst($user->role)); ?>

                </span>
            </div>

            
            <div class="ulist-col-statut">
                <?php if($user->actif): ?>
                    <span class="ulist-status ulist-status-actif">
                        <span class="ulist-status-dot"></span> Actif
                    </span>
                <?php else: ?>
                    <span class="ulist-status ulist-status-inactif">
                        <span class="ulist-status-dot"></span> Inactif
                    </span>
                <?php endif; ?>
            </div>

            
            <div class="ulist-col-actions">
                <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="ulist-action-btn" title="Voir">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="ulist-action-btn" title="Modifier">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <form method="POST" action="<?php echo e(route('admin.users.toggle-status', $user)); ?>" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                            class="ulist-action-btn <?php echo e($user->actif ? 'ulist-action-warn' : 'ulist-action-success'); ?>"
                            title="<?php echo e($user->actif ? 'Désactiver' : 'Activer'); ?>">
                        <i class="fas <?php echo e($user->actif ? 'fa-user-times' : 'fa-user-check'); ?>"></i>
                    </button>
                </form>
                <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>"
                        onsubmit="return confirm('Supprimer cet utilisateur ?')" style="display:inline;">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="ulist-action-btn ulist-action-danger" title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="ulist-empty">
            <i class="fas fa-users-slash"></i>
            <p>Aucun utilisateur trouvé.</p>
        </div>
        <?php endif; ?>

    </div>

    <?php if($users->hasPages()): ?>
    <div class="projets-pagination"><?php echo e($users->withQueryString()->links()); ?></div>
    <?php endif; ?>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
let timer;
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(timer);
    const val = this.value;
    timer = setTimeout(() => {
        const url = new URL(window.location.href);
        url.searchParams.set('search', val);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }, 400);
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/admin/users/index.blade.php ENDPATH**/ ?>