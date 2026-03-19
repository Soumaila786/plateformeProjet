<?php $__env->startSection('status_band'); ?>
<div class="status-band red">
    <div class="status-icon red"></div>
    <div>
        <div class="status-label">Projet rejeté</div>
        <div class="status-sub"><?php echo e($projet->codeProjet); ?> — Décision finale</div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
<p class="greeting">Bonjour <?php echo e($projet->porteur->nomComplet); ?>,</p>
<p class="text">
    Nous vous informons que votre projet a été <strong>rejeté</strong>
    par l'équipe d'approbation.
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
        <span class="info-value"><span class="badge badge-red">Rejeté</span></span>
    </div>
    <div class="info-row">
        <span class="info-label">Date de décision</span>
        <span class="info-value"><?php echo e(now()->format('d/m/Y à H:i')); ?></span>
    </div>
</div>

<!-- SECTION COMMENTAIRE DE REJET -->
<div class="info-box" style="background: #fff3f3; border-left: 4px solid #dc3545;">
    <div class="info-box-header" style="color: #dc3545;">Motif du rejet</div>
    <div class="info-row">
        <p style="margin: 10px 0; font-size: 15px;">
            <?php echo e($commentaire->message); ?>

        </p>
    </div>
    <div class="info-row">
        <span class="info-label">Date du commentaire</span>
        <span class="info-value"><?php echo e(\Carbon\Carbon::parse($commentaire->dateEnvoi)->format('d/m/Y à H:i')); ?></span>
    </div>
</div>

<p class="text">
    Vous pouvez modifier votre projet en tenant compte des remarques ci-dessus
    et le soumettre à nouveau pour une nouvelle évaluation.
</p>

<div style="text-align: center; margin: 30px 0;">
    <a href="#"
        style="background: #007bff; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
        Modifier mon projet
    </a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('emails.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/emails/projet_rejete.blade.php ENDPATH**/ ?>