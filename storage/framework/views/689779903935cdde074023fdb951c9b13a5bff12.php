<?php $__env->startSection('title', 'Connexion'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="login-wrapper">
    <div class="login-card">

        
        <div class="login-header">
            <div class="login-logo">GP</div>
            <h1 class="login-title"><?php echo e(config('app.name')); ?></h1>
            <p class="login-subtitle">Gestion de projets — Accès réservé</p>
        </div>

        <div class="login-body">

            
            <?php if(isset($permanentBlock) && $permanentBlock): ?>
            <div class="alert-block alert-permanent">
                <div class="alert-icon"><i class="fas fa-ban"></i></div>
                <div class="alert-content">
                    <p class="alert-title">Compte désactivé</p>
                    <p class="alert-text">Ce compte a été désactivé suite à de trop nombreuses tentatives. Contactez l'administrateur système.</p>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if(isset($blockExpiresAt) && $blockExpiresAt > now()->timestamp): ?>
            <div class="alert-block alert-temp">
                <div class="alert-icon"><i class="fas fa-lock"></i></div>
                <div class="alert-content">
                    <p class="alert-title">Accès temporairement suspendu</p>
                    <p class="alert-text">Trop de tentatives incorrectes. Réessayez dans :</p>
                    <div class="countdown-wrap">
                        <span class="countdown-timer" id="countdown">--:--</span>
                    </div>
                    <div class="countdown-bar-wrap">
                        <div class="countdown-bar" id="countdownBar"></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if($errors->any() && !(isset($blockExpiresAt) && $blockExpiresAt > now()->timestamp)): ?>
            <div class="login-alert">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo e($errors->first()); ?></span>
            </div>
            <?php endif; ?>

            
            <?php if(!(isset($blockExpiresAt) && $blockExpiresAt > now()->timestamp)): ?>
            <form method="POST" action="<?php echo e(route('login.post')); ?>">
                <?php echo csrf_field(); ?>

                
                <div class="form-group">
                    <label class="form-label-top" for="email">Adresse e-mail</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email"
                            value="<?php echo e(old('email')); ?>"
                            class="input-field <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="exemple@domaine.com"
                            required autofocus>
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="form-group">
                    <label class="form-label-top" for="password">Mot de passe</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password"
                            class="input-field <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="••••••••" required>
                        <button type="button" class="toggle-pwd" onclick="togglePassword()">
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="login-options">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                        <span>Se souvenir de moi</span>
                    </label>
                    <a href="#" class="forgot-link">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn-submit">
                    Se connecter
                </button>

            </form>
            <?php endif; ?>

        </div>

        <div class="login-footer">
            <i class="fas fa-shield-alt"></i>
            Connexion sécurisée &nbsp;·&nbsp; &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>

        </div>

    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // ── Afficher/masquer mot de passe ──
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('togglePasswordIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }



    // ── Compte à rebours basé sur le timestamp réel ──
    <?php if(isset($blockExpiresAt) && $blockExpiresAt > now()->timestamp): ?>
    (function() {
        const expiresAt  = <?php echo e($blockExpiresAt); ?>;        // timestamp Unix côté serveur
        const totalSecs  = expiresAt - Math.floor(Date.now() / 1000);
        const timerEl    = document.getElementById('countdown');
        const barEl      = document.getElementById('countdownBar');

        if (!timerEl || totalSecs <= 0) {
            location.reload();
            return;
        }

        function tick() {
            const remaining = expiresAt - Math.floor(Date.now() / 1000);

            if (remaining <= 0) {
                // Blocage expiré → recharger proprement
                location.reload();
                return;
            }

            const m = Math.floor(remaining / 60).toString().padStart(2, '0');
            const s = (remaining % 60).toString().padStart(2, '0');
            timerEl.textContent = m + ':' + s;

            const pct = Math.max(0, (remaining / totalSecs) * 100);
            barEl.style.width = pct + '%';

            setTimeout(tick, 1000);
        }

        tick();
    })();
    <?php endif; ?>
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/auth/login.blade.php ENDPATH**/ ?>