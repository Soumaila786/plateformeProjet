<?php $__env->startSection('title', 'Mot de passe oublié'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="login-wrapper">
    <div class="login-card">

        <div class="login-header">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.brand.logo','data' => ['size' => 48]]); ?>
<?php $component->withName('brand.logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['size' => 48]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <h1 class="login-title">Mot de passe oublié</h1>
            <p class="login-subtitle">Entrez votre email pour recevoir un lien de réinitialisation</p>
        </div>

        <div class="login-body">

            <?php if(session('success')): ?>
            <div class="login-alert" style="background:#f0fdf4;color:#15803d;border-color:#bbf7d0;">
                <i class="fas fa-check-circle"></i>
                <span><?php echo e(session('success')); ?></span>
            </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
            <div class="login-alert">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo e($errors->first()); ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('password.email')); ?>">
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

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Envoyer le lien de réinitialisation
                </button>
            </form>

            <div style="text-align:center;margin-top:16px;">
                <a href="<?php echo e(route('login')); ?>" class="forgot-link">
                    <i class="fas fa-arrow-left"></i> Retour à la connexion
                </a>
            </div>

        </div>

        <div class="login-footer">
            <i class="fas fa-shield-alt"></i>
            Connexion sécurisée &nbsp;·&nbsp; &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>

        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>