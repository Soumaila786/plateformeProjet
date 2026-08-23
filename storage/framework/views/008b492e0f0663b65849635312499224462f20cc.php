<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', $sysConfig->get('nom_app', config('app.name'))); ?></title>

    <link rel="stylesheet" href="<?php echo e(asset('css/variables.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/typography.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/forms.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('fontawesome/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/sidebar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/responsive.css')); ?>">
    <script src="<?php echo e(asset('js/responsive-sidebar.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        * { font-family: 'Poppins', sans-serif; }

        :root {
            --color-primary: <?php echo e($sysConfig->get('couleur_primaire', '#6366f1')); ?>;
            --color-primary-light: <?php echo e($sysConfig->get('couleur_primaire', '#6366f1')); ?>18;

            /* Couleurs de statut projet — mêmes valeurs que dans les tableaux
               analytiques (Chart.js), pour rester cohérent partout dans l'appli. */
            --status-brouillon: #9ca3af;
            --status-soumis: #6366f1;
            --status-en-examen: #f97316;
            --status-approuve: #22c55e;
            --status-rejete: #ef4444;
            --status-valide: #0d9488;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/ui-polish.css')); ?>">

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .app-layout {
            display: flex;
            height: 100vh;
            width: 100%;
            overflow: hidden;
        }
        .app-layout .sidebar {
            flex-shrink: 0;
        }
        .app-content {
            flex: 1 1 0;
            min-width: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .app-content__fixed {
            flex-shrink: 0;
        }
        .page-header {
            padding: 1.25rem 1.5rem 0;
        }
        .page-header-top {
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            flex-wrap:wrap;
            gap:.75rem;
        }
        .page-header-title {
            font-size: 1.3rem;
            font-weight: 800;
            margin: 0;
        }
        .page-header-sub {
            font-size: .85rem;
            color: #6b7280;
            margin: 0;
        }
        .page-body {
            flex: 1 1 0;
            min-height: 0;
            overflow-y: auto;
        }
        .content-area {
            padding: 1.5rem;
            min-height: 100%;
        }
    </style>
</head>
<body>


<?php
    $enMaintenance = $sysConfig->get('mode_maintenance', '0') === '1';
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
?>

<?php if($enMaintenance && !$isAdmin): ?>
    <?php echo $__env->make('partials.maintenance', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>

<div class="app-layout">
    <?php if(auth()->guard()->check()): ?>
        <?php echo $__env->make('partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <div class="app-content">
        <div class="app-content__fixed">
            
            <?php if (! empty(trim($__env->yieldContent('breadcrumb')))): ?>
                <div class="px-4 pt-3">
                    <nav class="d-flex align-items-center gap-2 small text-muted">
                        <?php echo $__env->yieldContent('breadcrumb'); ?>
                    </nav>
                </div>
            <?php endif; ?>

            
            <?php echo $__env->make('partials._flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            
            <?php if (! empty(trim($__env->yieldContent('page-header')))): ?>
                <div class="page-header">
                    <?php echo $__env->yieldContent('page-header'); ?>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="page-body">
            <div class="content-area">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/layouts/app.blade.php ENDPATH**/ ?>