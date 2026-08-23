

<?php $__env->startSection('status_band'); ?>
<div class="status-band green">
    <div class="status-icon green"></div>
    <div>
        <div class="status-label">Projet approuvé</div>
        <div class="status-sub"><?php echo e($projet->codeProjet); ?> — En attente de validation</div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
<p class="greeting">Bonjour <?php echo e($projet->porteur->nomComplet); ?>,</p>
<p class="text">
    Nous avons le plaisir de vous informer que votre projet a été <strong>approuvé</strong>
    par l'équipe d'approbation. Il est désormais transmis aux validateurs pour la décision finale.
</p>

<div class="info-box">
    <div class="info-box-header">Détails du projet</div>
    <div class="info-row">
        <span class="info-label">Code projet</span>
        <span class="info-value"><strong><?php echo e($projet->codeProjet); ?></strong></span>
    </div>
    <div class="info-row">
        <span class="info-label">Titre</span>
        <span class="info-value"><?php echo e($projet->titre); ?></span>
    </div>
    <?php if($projet->secteur): ?>
    <div class="info-row">
        <span class="info-label">Secteur</span>
        <span class="info-value"><?php echo e($projet->secteur->nomSecteur); ?></span>
    </div>
    <?php endif; ?>
    <div class="info-row">
        <span class="info-label">Statut</span>
        <span class="info-value"><span class="badge badge-green">Approuvé</span></span>
    </div>
    <div class="info-row">
        <span class="info-label">Date d'approbation</span>
        <span class="info-value"><?php echo e(now()->format('d/m/Y à H:i')); ?></span>
    </div>
</div>

<p class="text">
    Votre projet est maintenant en attente de la <strong>validation finale</strong>.
    Vous recevrez un email dès qu'une décision sera prise.
</p>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\emails\projet_approuve.blade.php ENDPATH**/ ?>