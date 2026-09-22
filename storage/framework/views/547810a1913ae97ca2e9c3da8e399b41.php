<?php $__empty_1 = true; $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $champsModifierSecteur = [
            'nomSecteur' => $secteur->nomSecteur,
            'description' => $secteur->description,
            'statutSecteur' => (bool) $secteur->statutSecteur,
        ];
    ?>
    <div class="lp-row">
        <div class="lp-avatar"><?php echo e(strtoupper(substr($secteur->nomSecteur, 0, 1))); ?></div>

        <div class="lp-info">
            <div class="lp-top">
                <span class="lp-titre"><?php echo e($secteur->nomSecteur); ?></span>
            </div>
            <?php if($secteur->description): ?>
                <p class="secteur-desc mb-0"><?php echo e(\Illuminate\Support\Str::limit($secteur->description, 90)); ?></p>
            <?php endif; ?>
            <p class="secteur-nb-projets mb-0 mt-1"><i class="fas fa-folder me-1"></i><?php echo e($secteur->projets->count()); ?> projet(s)</p>
        </div>

        <div class="lp-badges">
            <span class="badge <?php echo e($secteur->statutSecteur ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'); ?>">
                <?php echo e($secteur->statutSecteur ? 'Actif' : 'Inactif'); ?>

            </span>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('secteurs.gerer')): ?>
                <button type="button" class="lp-btn" title="Modifier"
                        data-modal-edit="modalSecteurForm"
                        data-modal-action="<?php echo e(route('admin.secteurs.update', $secteur)); ?>"
                        data-modal-titre-edition="Modifier le secteur"
                        data-modal-fields="<?php echo e(json_encode($champsModifierSecteur)); ?>">
                    <i class="fas fa-pen"></i>
                </button>

                <form method="POST" action="<?php echo e(route('admin.secteurs.toggle-status', $secteur)); ?>" class="d-inline"
                      onsubmit="return confirm('<?php echo e($secteur->statutSecteur ? 'Désactiver' : 'Activer'); ?> ce secteur ?')">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="lp-btn <?php echo e($secteur->statutSecteur ? '' : 'lp-btn-green'); ?>" title="<?php echo e($secteur->statutSecteur ? 'Désactiver' : 'Activer'); ?>">
                        <i class="fas <?php echo e($secteur->statutSecteur ? 'fa-toggle-off' : 'fa-toggle-on'); ?>"></i>
                    </button>
                </form>

                <?php if($secteur->projets->count() === 0): ?>
                    <form method="POST" action="<?php echo e(route('admin.secteurs.destroy', $secteur)); ?>" class="d-inline"
                          onsubmit="return confirm('Supprimer définitivement ce secteur ?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="lp-btn lp-btn-red" title="Supprimer"><i class="fas fa-trash"></i></button>
                    </form>
                <?php else: ?>
                    <span class="lp-btn" style="opacity:.4; cursor:not-allowed;" title="Impossible : ce secteur contient des projets"><i class="fas fa-trash"></i></span>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="lp-empty">
        <i class="fas fa-building"></i>
        <p class="mb-0">Aucun secteur trouvé.</p>
    </div>
<?php endif; ?>

<div class="mt-3"><?php echo e($secteurs->withQueryString()->links()); ?></div>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/filtres-liste.js')); ?>"></script>
    <script src="<?php echo e(asset('js/modals-crud.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\secteurs\partials\_liste_lignes.blade.php ENDPATH**/ ?>