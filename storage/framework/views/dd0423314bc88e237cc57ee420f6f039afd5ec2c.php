<?php $__env->startSection('title', 'Journal des activités'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/journal.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="journal-page">

    
    <div class="journal-header">
        <div class="journal-title-row">
            <h1 class="journal-title">
                <i class="fas fa-history"></i>
                Journal des activités
                <?php if(isset($logs) && count($logs)): ?>
                <span class="journal-count"><?php echo e(count($logs)); ?> entrée(s)</span>
                <?php endif; ?>
            </h1>
            <a href="<?php echo e(request()->fullUrl()); ?>" class="btn-reset">
                <i class="fas fa-sync-alt"></i> Actualiser
            </a>
        </div>

        
        <form method="GET" class="journal-filters" id="filterForm">

            <div class="filter-search">
                <i class="fas fa-search"></i>
                <input type="text" name="search"
                        placeholder="Rechercher dans les logs..."
                        value="<?php echo e(request('search')); ?>">
            </div>

            
            <div class="level-pills">
                <?php
                    $levels = [
                        '' => 'Tous',
                        'info' => 'INFO',
                        'warning' => 'WARNING',
                        'error' => 'ERROR'
                    ];
                ?>
                
                <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(request()->fullUrlWithQuery(['type' => $val, 'search' => request('search')])); ?>"
                    class="level-pill <?php echo e($val ?: 'all'); ?> <?php echo e(request('type', '') === $val ? 'active' : ''); ?>">
                    <?php echo e($lbl); ?>

                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <button type="submit" class="btn-filter">
                <i class="fas fa-filter"></i> Filtrer
            </button>

            <?php if(request('search') || request('type')): ?>
            <a href="<?php echo e(route('admin.logs.index')); ?>" class="btn-reset">
                <i class="fas fa-times"></i> Réinitialiser
            </a>
            <?php endif; ?>

        </form>
    </div>

    
    <div class="journal-body">
        <div class="log-table-wrap">
            <table class="log-table">
                <thead>
                    <tr>
                        <th style="width:160px;">Date / Heure</th>
                        <th style="width:110px;">Niveau</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $level = strtolower($log['level'] ?? 'info');
                    $rowClass = 'row-' . $level;
                    $badgeClass = 'log-' . $level;
                    $icons = [
                        'info'     => 'fa-info-circle',
                        'warning'  => 'fa-exclamation-triangle',
                        'error'    => 'fa-times-circle',
                        // 'debug'    => 'fa-bug',
                        'critical' => 'fa-skull-crossbones',
                    ];
                    $icon = $icons[$level] ?? 'fa-circle';
                ?>
                <tr class="<?php echo e($rowClass); ?>">
                    <td>
                        <span class="log-date"><?php echo e($log['date'] ?? '—'); ?></span>
                    </td>
                    <td>
                        <span class="log-badge <?php echo e($badgeClass); ?>">
                            <i class="fas <?php echo e($icon); ?>" style="font-size:.65rem;"></i>
                            <?php echo e(strtoupper($level)); ?>

                        </span>
                    </td>
                    <td>
                        <p class="log-message <?php echo e(in_array($level, ['error','warning']) ? $level : ''); ?>">
                            <?php echo e($log['message'] ?? '—'); ?>

                        </p>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="3">
                        <div class="log-empty">
                            <i class="fas fa-check-circle" style="color:#22c55e;"></i>
                            <p>Aucune entrée de log trouvée.</p>
                            <?php if(request('search') || request('type')): ?>
                            <a href="<?php echo e(route('admin.logs.index')); ?>" style="font-size:.78rem;color:#7c3aed;">
                                Effacer les filtres
                            </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if(isset($logs) && method_exists($logs, 'hasPages') && $logs->hasPages()): ?>
        <div style="margin-top:14px;">
            <?php echo e($logs->withQueryString()->links()); ?>

        </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/admin/logs/index.blade.php ENDPATH**/ ?>