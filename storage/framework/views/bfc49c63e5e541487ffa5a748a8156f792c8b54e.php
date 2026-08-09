<?php $__empty_1 = true; $__currentLoopData = $motifs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $champsModifierMotif = ['libelle' => $motif->libelle, 'actif' => (bool) $motif->actif];
    ?>
    <div class="lp-row">
        <div class="lp-avatar"><i class="fas fa-ban"></i></div>

        <div class="lp-info">
            <span class="motif-libelle"><?php echo e($motif->libelle); ?></span>
        </div>

        <div class="lp-badges">
            <span class="badge <?php echo e($motif->actif ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'); ?>">
                <?php echo e($motif->actif ? 'Actif' : 'Inactif'); ?>

            </span>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('motifs.gerer')): ?>
                <button type="button" class="lp-btn" title="Modifier"
                        data-modal-edit="modalMotifForm"
                        data-modal-action="<?php echo e(route('admin.motifs.update', $motif)); ?>"
                        data-modal-titre-edition="Modifier le motif"
                        data-modal-fields="<?php echo e(json_encode($champsModifierMotif)); ?>">
                    <i class="fas fa-pen"></i>
                </button>

                <form method="POST" action="<?php echo e(route('admin.motifs.toggle-status', $motif)); ?>" class="d-inline"
                      onsubmit="return confirm('<?php echo e($motif->actif ? 'Désactiver' : 'Activer'); ?> ce motif ?')">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="lp-btn <?php echo e($motif->actif ? '' : 'lp-btn-green'); ?>" title="<?php echo e($motif->actif ? 'Désactiver' : 'Activer'); ?>">
                        <i class="fas <?php echo e($motif->actif ? 'fa-toggle-off' : 'fa-toggle-on'); ?>"></i>
                    </button>
                </form>

                <form method="POST" action="<?php echo e(route('admin.motifs.destroy', $motif)); ?>" class="d-inline"
                      onsubmit="return confirm('Supprimer ce motif ? (s\'il a déjà été utilisé, il sera désactivé au lieu d\'être supprimé)')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="lp-btn lp-btn-red" title="Supprimer"><i class="fas fa-trash"></i></button>
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="lp-empty">
        <i class="fas fa-ban"></i>
        <p class="mb-0">Aucun motif de rejet configuré.</p>
    </div>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/filtres-liste.js')); ?>"></script>
    <script src="<?php echo e(asset('js/modals-crud.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/motifs/partials/_liste_lignes.blade.php ENDPATH**/ ?>