<?php
    // Variables attendues à l'@include :
    // - $secteurs (optionnel)      : pour afficher le select secteur
    // - $statutOptions (optionnel) : [valeur => libellé] pour les puces de statut
?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/listes-projets.css')); ?>">
<?php $__env->stopPush(); ?>

<div class="lp-filtres">
    <div class="lp-search-wrap">
        <i class="fas fa-search"></i>
        <input type="text" id="lpSearchInput" placeholder="Rechercher par titre ou code..." value="<?php echo e(request('search')); ?>">
    </div>

    <?php if(isset($statutOptions)): ?>
        <select id="lpStatutSelect" class="lp-select">
            <option value="">Tous les statuts</option>
            <?php $__currentLoopData = $statutOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valeur => $libelle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($valeur); ?>" <?php echo e(request('statut') === $valeur ? 'selected' : ''); ?>><?php echo e($libelle); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    <?php endif; ?>

    <?php if(isset($secteurs)): ?>
        <select id="lpSecteurSelect" class="lp-select">
            <option value="">Tous les secteurs</option>
            <?php $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($secteur->id); ?>" <?php echo e((string) request('secteur_id') === (string) $secteur->id ? 'selected' : ''); ?>>
                    <?php echo e($secteur->nomSecteur); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    <?php endif; ?>

    <?php if(request('search') || request('secteur_id') || request('statut')): ?>
        <a href="<?php echo e(request()->url()); ?>" class="lp-reset-btn"><i class="fas fa-times"></i> Réinitialiser</a>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/projets/partials/_liste_filtres.blade.php ENDPATH**/ ?>