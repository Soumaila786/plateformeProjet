<?php $__env->startSection('title', 'Connexion'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="login-wrapper">
    <div class="login-card">

        
        <div class="login-header">
            <h1 class="login-title"><?php echo e(config('app.name')); ?></h1>
            <p class="login-subtitle">Gestion de projets — Accès réservé</p>
        </div>

        <div class="login-body">

            

            
            <?php if($errors->any()): ?>
            <div class="login-alert">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo e($errors->first()); ?></span>
            </div>
            <?php endif; ?>

            <?php if(session('status')): ?>
            <div class="login-alert" style="background:#f0fdf4;color:#15803d;border-color:#bbf7d0;">
                <i class="fas fa-check-circle"></i>
                <span><?php echo e(session('status')); ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>">
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
                    <a href="<?php echo e(route('password.request')); ?>" class="forgot-link">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn-submit">
                    Se connecter
                </button>

            </form>

        </div>

        <div class="login-footer">
            <i class="fas fa-shield-alt"></i>
            Connexion sécurisée &nbsp;·&nbsp; &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>

        </div>

    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
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
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/auth/login.blade.php ENDPATH**/ ?>