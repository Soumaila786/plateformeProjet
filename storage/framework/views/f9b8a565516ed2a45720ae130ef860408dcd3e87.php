<?php
    // Variables attendues : $projetsRecents (Collection de Projet), $routeShow (nom de route)
    $stMap = [
        'brouillon' => ['lbl' => 'Brouillon',  'dot' => '#9ca3af'],
        'soumis'    => ['lbl' => 'Soumis',     'dot' => '#6366f1'],
        'en_examen' => ['lbl' => 'En examen',  'dot' => '#f97316'],
        'approuve'  => ['lbl' => 'Approuvé',   'dot' => '#22c55e'],
        'rejete'    => ['lbl' => 'Rejeté',     'dot' => '#ef4444'],
        'valide'    => ['lbl' => 'Validé',     'dot' => '#0d9488'],
    ];
?>

<?php $__empty_1 = true; $__currentLoopData = $projetsRecents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $st = $stMap[$projet->statutProjet] ?? ['lbl' => $projet->statutProjet, 'dot' => '#9ca3af'];
        $porteurProjet = $projet->porteur ?? $projet->user ?? null;
    ?>
    <div class="d-flex align-items-center justify-content-between py-2 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?>">
        <div class="d-flex align-items-center gap-2 min-w-0">
            <div class="d-flex align-items-center justify-content-center rounded fw-bold flex-shrink-0"
                 style="width:34px; height:34px; background:var(--color-primary-light); color:var(--color-primary);">
                <?php echo e(strtoupper(substr($projet->secteur->nomSecteur ?? $projet->titre, 0, 1))); ?>

            </div>
            <div class="min-w-0">
                <div class="small fw-semibold text-truncate"><?php echo e($projet->titre); ?></div>
                <div class="text-muted text-truncate" style="font-size:.74rem;">
                    <?php echo e($projet->codeProjet); ?>

                    <?php if($porteurProjet): ?> · <?php echo e($porteurProjet->nomComplet); ?> <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 flex-shrink-0">
            <span class="badge rounded-pill" style="background: color-mix(in srgb, <?php echo e($st['dot']); ?> 16%, white); color:<?php echo e($st['dot']); ?>;">
                <?php echo e($st['lbl']); ?>

            </span>
            <?php if(isset($routeShow)): ?>
                <a href="<?php echo e(route($routeShow, $projet)); ?>" class="btn btn-sm btn-link text-decoration-none"><i class="fas fa-arrow-right"></i></a>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="text-muted small mb-0 py-3 text-center">Aucun projet récent.</p>
<?php endif; ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/dashboard/partials/_projets_recents.blade.php ENDPATH**/ ?>