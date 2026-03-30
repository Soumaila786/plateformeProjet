<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', $sysConfig->get('nom_app', config('app.name'))); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('fontawesome/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/sidebar.css')); ?>">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        * { font-family: 'Poppins', sans-serif; }

        
        :root {
            --color-primary: <?php echo e($sysConfig->get('couleur_primaire', '#6366f1')); ?>;
            --color-primary-light: <?php echo e($sysConfig->get('couleur_primaire', '#6366f1')); ?>18;
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>

    <style>
        html, body { height: 100%; margin: 0; padding: 0; overflow: hidden; }
        .app-layout { display: flex; height: 100vh; width: 100%; overflow: hidden; }
        .app-layout .sidebar { flex-shrink: 0; }
        .app-content { flex: 1 1 0; min-width: 0; height: 100vh; overflow-y: auto; transition: all 0.3s ease; }
        .content-area { padding: 1.5rem; min-height: 100%; }
    </style>
</head>
<body>


<?php
    $enMaintenance = $sysConfig->get('mode_maintenance', '0') === '1';
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
?>

<?php if($enMaintenance && !$isAdmin): ?>
    <div style="display:flex;align-items:center;justify-content:center;height:100vh;
                background:#f8fafc;flex-direction:column;gap:16px;text-align:center;padding:20px;">
        <div style="width:60px;height:60px;background:#fef2f2;border-radius:16px;
                    display:flex;align-items:center;justify-content:center;font-size:1.8rem;">
            🔧
        </div>
        <h2 style="font-size:1.4rem;font-weight:800;color:#111827;margin:0;">
            <?php echo e($sysConfig->get('nom_app', 'GesProjet')); ?> est en maintenance
        </h2>
        <p style="font-size:.9rem;color:#6b7280;max-width:400px;margin:0;">
            Nous effectuons des opérations de maintenance. Veuillez réessayer dans quelques instants.
        </p>
        <?php if(auth()->guard()->check()): ?>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" style="padding:8px 18px;background:#f3f4f6;border:1px solid #e5e7eb;
                    border-radius:8px;font-size:.82rem;cursor:pointer;color:#374151;">
                Se déconnecter
            </button>
        </form>
        <?php endif; ?>
    </div>
<?php else: ?>

<div class="app-layout">
    <?php if(auth()->guard()->check()): ?>
        <?php echo $__env->make('partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <div class="app-content">
        
        <?php if(session('success') || session('error') || session('warning')): ?>
        <div class="px-4 pt-4">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if(session('warning')): ?>
                <div class="alert alert-warning alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle me-2"></i><?php echo e(session('warning')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="content-area">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>

<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/layouts/app.blade.php ENDPATH**/ ?>