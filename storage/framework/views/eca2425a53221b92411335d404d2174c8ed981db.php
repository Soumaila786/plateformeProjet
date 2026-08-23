<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>ProjetGov</title>
<link rel="stylesheet" href="<?php echo e(asset('css/email.css')); ?>">

</head>
<body>
    <div class="outer">
        <div class="wrapper">

            
            <div class="email-header">
                <div class="email-logo">
                <div style="width: 38px; height: 38px; background: linear-gradient(135deg, #3b82f6, #8b5cf6);
                        border-radius: 10px; display: flex; align-items: center; justify-content: center;
                        color: white; font-weight: 800; font-size: 0.95rem; letter-spacing: 0.5px;">
                    GP
                </div>
                <div class="logo-text">Ges<span>Projet</span></div>
                </div>
                <div class="header-tagline">Plateforme de gestion de projets</div>
            </div>

            
            <?php echo $__env->yieldContent('status_band'); ?>

            
            <div class="email-body">
                <?php echo $__env->yieldContent('body'); ?>
            </div>

            
            <div class="email-footer">
            <p class="footer-text">
                Cet email a été envoyé automatiquement par <span class="footer-brand">GesProjet</span>.<br>
                Merci de ne pas répondre directement à ce message.<br>
                © <?php echo e(date('Y')); ?> GesProjet — Tous droits réservés.
            </p>
            </div>

        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\emails\layout.blade.php ENDPATH**/ ?>