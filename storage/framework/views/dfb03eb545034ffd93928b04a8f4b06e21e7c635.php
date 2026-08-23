<?php
    $roleColors = [
        'admin' => '#6366f1', 'porteur' => '#0d9488', 'approbateur' => '#f97316',
        'validateur' => '#22c55e', 'planificateur' => '#9333ea',
    ];
    $roleLabels = [
        'admin' => 'Admin', 'porteur' => 'Porteur', 'approbateur' => 'Approbateur',
        'validateur' => 'Validateur', 'planificateur' => 'Planificateur',
    ];
?>

<?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $couleurRole = $roleColors[$u->role] ?? '#9ca3af';
        $champsModifierUser = [
            'nomComplet' => $u->nomComplet, 'email' => $u->email, 'role' => $u->role,
            'fonction' => $u->fonction, 'matricule' => $u->matricule, 'contact' => $u->contact,
            'organisation' => $u->organisation, 'specialite' => $u->specialite,
            'service' => $u->service, 'poste' => $u->poste,
            'dateDebutMandat' => optional($u->dateDebutMandat)->format('Y-m-d'),
            'dateFinMandat' => optional($u->dateFinMandat)->format('Y-m-d'),
        ];
    ?>
    <div class="lp-row">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.avatars.avatar','data' => ['user' => $u,'size' => 42]]); ?>
<?php $component->withName('avatars.avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($u),'size' => 42]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <div class="lp-info">
            <div class="lp-top">
                <span class="lp-titre"><?php echo e($u->nomComplet); ?></span>
            </div>
            <p class="lp-meta">
                <span><i class="fas fa-envelope"></i><?php echo e($u->email); ?></span>
                <?php if($u->contact): ?>
                    <span><i class="fas fa-phone"></i><?php echo e($u->contact); ?></span>
                <?php endif; ?>
                <?php if($u->fonction || $u->organisation): ?>
                    <span><i class="fas fa-briefcase"></i><?php echo e($u->fonction ?? $u->organisation); ?></span>
                <?php endif; ?>
            </p>
        </div>

        <div class="lp-badges">
            <span class="lp-badge" style="background: color-mix(in srgb, <?php echo e($couleurRole); ?> 16%, white); color: <?php echo e($couleurRole); ?>;">
                <span class="lp-dot" style="background:<?php echo e($couleurRole); ?>;"></span><?php echo e($roleLabels[$u->role] ?? $u->role); ?>

            </span>
            <span class="badge <?php echo e($u->actif ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'); ?>">
                <?php echo e($u->actif ? 'Actif' : 'Inactif'); ?>

            </span>

            <button type="button" class="lp-btn" title="Voir" onclick="openModal('modalUserView<?php echo e($u->id); ?>')">
                <i class="fas fa-eye"></i>
            </button>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('utilisateurs.gerer')): ?>
                <button type="button" class="lp-btn" title="Modifier"
                        data-modal-edit="modalUserForm"
                        data-modal-action="<?php echo e(route('admin.users.update', $u)); ?>"
                        data-modal-titre-edition="Modifier l'utilisateur"
                        data-modal-fields="<?php echo e(json_encode($champsModifierUser)); ?>">
                    <i class="fas fa-pen"></i>
                </button>

                <form method="POST" action="<?php echo e(route('admin.users.toggle-status', $u)); ?>" class="d-inline"
                      onsubmit="return confirm('<?php echo e($u->actif ? 'Désactiver' : 'Activer'); ?> ce compte ?')">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="lp-btn <?php echo e($u->actif ? '' : 'lp-btn-green'); ?>" title="<?php echo e($u->actif ? 'Désactiver' : 'Activer'); ?>">
                        <i class="fas <?php echo e($u->actif ? 'fa-user-slash' : 'fa-user-check'); ?>"></i>
                    </button>
                </form>

                <form method="POST" action="<?php echo e(route('admin.users.destroy', $u)); ?>" class="d-inline"
                      onsubmit="return confirm('Supprimer définitivement cet utilisateur ?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="lp-btn lp-btn-red" title="Supprimer"><i class="fas fa-trash"></i></button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <div id="modalUserView<?php echo e($u->id); ?>" class="lp-modal-overlay">
        <div class="lp-modal-box">
            <div class="lp-modal-head">
                <h3 class="lp-modal-title"><i class="fas fa-id-card"></i> <?php echo e($u->nomComplet); ?></h3>
                <button onclick="closeModal('modalUserView<?php echo e($u->id); ?>')" class="lp-modal-close"><i class="fas fa-times"></i></button>
            </div>
            <div class="lp-modal-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.avatars.avatar','data' => ['user' => $u,'size' => 56]]); ?>
<?php $component->withName('avatars.avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($u),'size' => 56]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <div class="d-flex gap-2">
                        <span class="badge bg-primary-subtle text-primary"><?php echo e($roleLabels[$u->role] ?? $u->role); ?></span>
                        <span class="badge <?php echo e($u->actif ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'); ?>">
                            <?php echo e($u->actif ? 'Actif' : 'Inactif'); ?>

                        </span>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="text-muted small">Email</div>
                        <div class="fw-semibold"><?php echo e($u->email); ?></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Contact</div>
                        <div class="fw-semibold"><?php echo e($u->contact ?? '—'); ?></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Fonction</div>
                        <div class="fw-semibold"><?php echo e($u->fonction ?? '—'); ?></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Matricule</div>
                        <div class="fw-semibold"><?php echo e($u->matricule ?? '—'); ?></div>
                    </div>
                    <div class="col-12">
                        <div class="text-muted small">Organisation</div>
                        <div class="fw-semibold"><?php echo e($u->organisation ?? '—'); ?></div>
                    </div>
                    <div class="col-12">
                        <div class="text-muted small"><?php echo e($roleLabels[$u->role] ?? ucfirst($u->role)); ?> — détail</div>
                        <div class="fw-semibold"><?php echo e($u->detailsRole ?? '—'); ?></div>
                    </div>
                </div>
            </div>
            <div class="lp-modal-foot">
                <button type="button" onclick="closeModal('modalUserView<?php echo e($u->id); ?>')" class="btn btn-light btn-sm">Fermer</button>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="lp-empty">
        <i class="fas fa-user-slash"></i>
        <p class="mb-0">Aucun utilisateur trouvé.</p>
    </div>
<?php endif; ?>

<div class="mt-3"><?php echo e($users->withQueryString()->links()); ?></div>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/filtres-liste.js')); ?>"></script>
    <script src="<?php echo e(asset('js/modals-crud.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\users\partials\_liste_lignes.blade.php ENDPATH**/ ?>