

<?php $__env->startSection('status_band'); ?>
<div class="status-band red">
  <div class="status-icon red"></div>
  <div>
    <div class="status-label">Compte désactivé</div>
    <div class="status-sub">Accès à la plateforme suspendu</div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
<p class="greeting">Bonjour <?php echo e($user->nomComplet); ?>,</p>
<p class="text">
  Nous vous informons que votre compte sur la plateforme <strong>GesProjet</strong>
  a été <strong>désactivé</strong> par un administrateur.
</p>

<div class="info-box">
  <div class="info-box-header">Détails du compte</div>
  <div class="info-row">
    <span class="info-label">Nom complet</span>
    <span class="info-value"><?php echo e($user->nomComplet); ?></span>
  </div>
  <div class="info-row">
    <span class="info-label">Adresse email</span>
    <span class="info-value"><?php echo e($user->email); ?></span>
  </div>
  <div class="info-row">
    <span class="info-label">Statut</span>
    <span class="info-value"><span class="badge badge-red">Désactivé</span></span>
  </div>
  <div class="info-row">
    <span class="info-label">Date</span>
    <span class="info-value"><?php echo e(now()->format('d/m/Y à H:i')); ?></span>
  </div>
</div>

<p class="text">
  Vous ne pouvez plus accéder à la plateforme avec ce compte.
  Si vous pensez qu'il s'agit d'une erreur ou souhaitez plus d'informations,
  veuillez contacter votre administrateur.
</p>

<div class="divider"></div>
<p class="text" style="font-size:.78rem;color:#94a3b8;text-align:center;">
  Pour toute question, rapprochez-vous de l'administration GesProjet.
</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\emails\compte_desactive.blade.php ENDPATH**/ ?>