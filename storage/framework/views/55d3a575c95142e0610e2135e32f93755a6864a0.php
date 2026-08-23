

<?php $__env->startSection('status_band'); ?>
<div class="status-band blue">
    <div class="status-icon blue"></div>
    <div>
        <div class="status-label">Compte créé avec succès</div>
        <div class="status-sub">Bienvenue sur GesProjet</div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
<p class="greeting">Salut <?php echo e($user->nomComplet); ?>,</p>
<p class="text">
    Votre compte a été créé par un administrateur sur la plateforme <strong>GesProjet</strong>.
    Voici vos informations de connexion :
</p>

<div class="info-box">
    <div class="info-box-header">Informations du compte</div>
    <div class="info-row">
        <span class="info-label">Nom complet</span>
        <span class="info-value"><?php echo e($user->nomComplet); ?></span>
    </div>
    <div class="info-row">
        <span class="info-label">Adresse email</span>
        <span class="info-value"><?php echo e($user->email); ?></span>
    </div>


    <?php if($user->matricule): ?>
        <div class="info-row">
            <span class="info-label">Matricule</span>
            <span class="info-value"><?php echo e($user->matricule); ?></span>
        </div>
    <?php endif; ?>

    <?php if($user->fonction): ?>
        <div class="info-row">
            <span class="info-label">Fonction</span>
            <span class="info-value"><?php echo e($user->fonction); ?></span>
        </div>
    <?php endif; ?>
</div>

<div class="password-box">
    <div class="password-icon"></div>
    <div>
        <div class="password-label">Mot de passe temporaire</div>
        <div class="password-value"><?php echo e($password); ?></div>
    </div>
</div>

<div class="security-note">
    <div class="security-note-icon"></div>
    <div class="security-note-text">
        Pour des raisons de sécurité, veuillez changer votre mot de passe dès votre première connexion
        dans <strong>Paramètres → Sécurité</strong>.
    </div>
</div>

<div class="btn-wrap">
    <a href="http://localhost:8000/login" class="btn">Se connecter à GesProjet</a>
</div>

<div class="divider"></div>
<p class="text" style="font-size:.78rem;color:#94a3b8;text-align:center;">
    Si vous n'êtes pas à l'origine de cette demande, ignorez cet email ou contactez l'administrateur.
</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\emails\compte_cree.blade.php ENDPATH**/ ?>