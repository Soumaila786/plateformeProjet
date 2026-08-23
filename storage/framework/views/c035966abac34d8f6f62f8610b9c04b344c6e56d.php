

<?php $__env->startSection('title', $user->nomComplet); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('admin.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <a href="<?php echo e(route('admin.users.index')); ?>">Utilisateurs</a>
    <span>/</span>
    <span><?php echo e($user->nomComplet); ?></span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/listes-projets.css')); ?>">
    <?php $__env->stopPush(); ?>

    <?php
        $champsModifierUser = [
            'nomComplet' => $user->nomComplet, 'email' => $user->email, 'role' => $user->role,
            'fonction' => $user->fonction, 'matricule' => $user->matricule, 'contact' => $user->contact,
            'organisation' => $user->organisation, 'specialite' => $user->specialite,
            'service' => $user->service, 'poste' => $user->poste,
            'dateDebutMandat' => optional($user->dateDebutMandat)->format('Y-m-d'),
            'dateFinMandat' => optional($user->dateFinMandat)->format('Y-m-d'),
        ];
    ?>

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.info','data' => ['class' => 'mb-3']]); ?>
<?php $component->withName('cards.info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'mb-3']); ?>
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div class="d-flex align-items-center gap-3">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.avatars.avatar','data' => ['user' => $user,'size' => 64]]); ?>
<?php $component->withName('avatars.avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user),'size' => 64]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <div>
                    <h4 class="fw-bold mb-1"><?php echo e($user->nomComplet); ?></h4>
                    <div class="text-muted small">
                        <i class="fas fa-envelope me-1"></i><?php echo e($user->email); ?>

                        <?php if($user->contact): ?> <span class="mx-2">·</span><i class="fas fa-phone me-1"></i><?php echo e($user->contact); ?> <?php endif; ?>
                    </div>
                    <div class="mt-2 d-flex gap-2">
                        <span class="badge bg-primary-subtle text-primary"><?php echo e(ucfirst($user->role)); ?></span>
                        <span class="badge <?php echo e($user->actif ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'); ?>">
                            <?php echo e($user->actif ? 'Actif' : 'Inactif'); ?>

                        </span>
                    </div>
                </div>
            </div>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('utilisateurs.gerer')): ?>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm"
                            data-modal-edit="modalUserForm"
                            data-modal-action="<?php echo e(route('admin.users.update', $user)); ?>"
                            data-modal-titre-edition="Modifier l'utilisateur"
                            data-modal-fields="<?php echo e(json_encode($champsModifierUser)); ?>">
                        <i class="fas fa-pen"></i> Modifier
                    </button>
                    <form method="POST" action="<?php echo e(route('admin.users.toggle-status', $user)); ?>"
                          onsubmit="return confirm('<?php echo e($user->actif ? 'Désactiver' : 'Activer'); ?> ce compte ?')">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                            <i class="fas <?php echo e($user->actif ? 'fa-user-slash' : 'fa-user-check'); ?>"></i> <?php echo e($user->actif ? 'Désactiver' : 'Activer'); ?>

                        </button>
                    </form>
                    <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>"
                          onsubmit="return confirm('Supprimer définitivement cet utilisateur ?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.info','data' => ['titre' => 'Informations','icon' => 'fa-id-card']]); ?>
<?php $component->withName('cards.info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['titre' => 'Informations','icon' => 'fa-id-card']); ?>
        <div class="row g-3">
            <div class="col-sm-6 col-lg-4">
                <div class="text-muted small">Fonction</div>
                <div class="fw-semibold"><?php echo e($user->fonction ?? '—'); ?></div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="text-muted small">Matricule</div>
                <div class="fw-semibold"><?php echo e($user->matricule ?? '—'); ?></div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="text-muted small">Organisation</div>
                <div class="fw-semibold"><?php echo e($user->organisation ?? '—'); ?></div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="text-muted small"><?php echo e(ucfirst($user->role)); ?> — détail</div>
                <div class="fw-semibold"><?php echo e($user->detailsRole ?? '—'); ?></div>
            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('utilisateurs.gerer')): ?>
        <?php echo $__env->make('modals.user-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\users\show.blade.php ENDPATH**/ ?>