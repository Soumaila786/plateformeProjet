<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="<?php echo e(asset('fontawesome/css/all.min.css')); ?>">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <link rel="stylesheet" href="<?php echo e(asset('css/sidebar.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/fonts.css')); ?>">
    <style>
        * { font-family: 'Poppins', sans-serif; }
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/layouts/app.blade.php ENDPATH**/ ?>