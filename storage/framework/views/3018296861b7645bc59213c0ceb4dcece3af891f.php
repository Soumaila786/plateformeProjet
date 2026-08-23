<h1>Bienvenue <?php echo e($user->name); ?> !</h1>

<p>Votre compte a été créé avec succès.</p>

<?php if($temporaryPassword): ?>
    <p><strong>Email:</strong> <?php echo e($user->email); ?></p>
    <p><strong>Mot de passe temporaire:</strong> <?php echo e($temporaryPassword); ?></p>
<?php endif; ?>

<a href="<?php echo e(url('/login')); ?>">Se connecter</a><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\emails\welcome.blade.php ENDPATH**/ ?>