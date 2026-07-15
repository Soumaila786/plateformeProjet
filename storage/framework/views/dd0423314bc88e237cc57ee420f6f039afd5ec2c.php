<?php $__env->startSection('title', 'Journal des activités'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/journal.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="journal-page">

    
    <div class="journal-top">
        <div class="journal-title-row">
            <div>
                <h1 class="journal-title">
                    <i class="fas fa-history"></i>
                    Journal des activités
                    <?php if(isset($logs) && count($logs) > 0): ?>
                    <span class="journal-count"><?php echo e(count($logs)); ?> entrée(s)</span>
                    <?php endif; ?>
                </h1>
                <p class="journal-subtitle">Historique complet des événements système</p>
            </div>
            <a href="<?php echo e(request()->url()); ?>" class="btn-reset-f">
                <i class="fas fa-sync-alt"></i> Actualiser
            </a>
        </div>

        
        <form method="GET" action="<?php echo e(route('admin.logs.index')); ?>" class="journal-filters">

            <div class="filter-search">
                <i class="fas fa-search fi"></i>
                <input type="text" name="search"
                        placeholder="Rechercher dans les logs..."
                        value="<?php echo e(request('search')); ?>">
            </div>

            
            <div class="level-pills">
                <?php
                    $niveaux = [
                        ''        => ['lbl'=>'Tous',    'cls'=>'lp-all'],
                        'info'    => ['lbl'=>'INFO',    'cls'=>'lp-info'],
                        'warning' => ['lbl'=>'WARNING', 'cls'=>'lp-warning'],
                        'error'   => ['lbl'=>'ERROR',   'cls'=>'lp-error'],
                    ];
                ?>
                <?php $__currentLoopData = $niveaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(request()->fullUrlWithQuery(['type'=>$val,'search'=>request('search')])); ?>"
                    class="level-pill <?php echo e($n['cls']); ?> <?php echo e(request('type','') === $val ? 'active' : ''); ?>">
                    <?php echo e($n['lbl']); ?>

                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <button type="submit" class="btn-filter">
                <i class="fas fa-filter"></i> Filtrer
            </button>

            <?php if(request('search') || request('type')): ?>
            <a href="<?php echo e(route('admin.logs.index')); ?>" class="btn-reset-f">
                <i class="fas fa-times"></i> Réinitialiser
            </a>
            <?php endif; ?>

        </form>
    </div>

    
    <?php
        $errors_count   = isset($logs) ? collect($logs)->where('level', 'error')->count()    : 0;
        $warnings_count = isset($logs) ? collect($logs)->where('level', 'warning')->count()  : 0;
        $critical_count = isset($logs) ? collect($logs)->where('level', 'critical')->count() : 0;
    ?>

    <?php if($critical_count > 0 || $errors_count > 0 || $warnings_count > 0): ?>
    <div class="journal-alerts">

        <?php if($critical_count > 0): ?>
        <div class="alert-banner alert-error" id="alertCritical">
            <i class="fas fa-skull-crossbones al-icon"></i>
            <div class="al-body">
                <p class="al-title"><?php echo e($critical_count); ?> erreur(s) critique(s) détectée(s)</p>
                <p class="al-msg">Des erreurs critiques nécessitent une attention immédiate.</p>
            </div>
            <button class="alert-close" onclick="this.closest('.alert-banner').remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php endif; ?>

        <?php if($errors_count > 0): ?>
        <div class="alert-banner alert-error" id="alertErrors">
            <i class="fas fa-times-circle al-icon"></i>
            <div class="al-body">
                <p class="al-title"><?php echo e($errors_count); ?> erreur(s) dans les logs</p>
                <p class="al-msg">Des erreurs ont été enregistrées. Vérifiez les entrées marquées en rouge.</p>
            </div>
            <button class="alert-close" onclick="this.closest('.alert-banner').remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php endif; ?>

        <?php if($warnings_count > 0): ?>
        <div class="alert-banner alert-warning" id="alertWarnings">
            <i class="fas fa-exclamation-triangle al-icon"></i>
            <div class="al-body">
                <p class="al-title"><?php echo e($warnings_count); ?> avertissement(s) détecté(s)</p>
                <p class="al-msg">Des avertissements ont été enregistrés. Vérifiez les entrées en orange.</p>
            </div>
            <button class="alert-close" onclick="this.closest('.alert-banner').remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php endif; ?>

    </div>
    <?php endif; ?>

    
    <div class="journal-body">
        <div class="log-table-wrap">
            <div class="log-scroll">
                <table class="log-table">

                    
                    <thead>
                        <tr>
                            <th style="width:155px;">Date / Heure</th>
                            <th style="width:110px;">Niveau</th>
                            <th>Message</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $level     = strtolower($log['level'] ?? 'info');
                        $rowClass  = 'row-'   . $level;
                        $badgeCls  = 'lb-'    . $level;
                        $msgCls    = in_array($level, ['error','warning','critical']) ? 'msg-'.$level : '';
                        $icons = [
                            'info'     => 'fa-info-circle',
                            'warning'  => 'fa-exclamation-triangle',
                            'error'    => 'fa-times-circle',
                            'debug'    => 'fa-bug',
                            'critical' => 'fa-skull-crossbones',
                        ];
                        $icon = $icons[$level] ?? 'fa-circle';
                    ?>
                    <tr class="<?php echo e($rowClass); ?>">
                        <td>
                            <span class="log-date"><?php echo e($log['date'] ?? '—'); ?></span>
                        </td>
                        <td>
                            <span class="log-badge <?php echo e($badgeCls); ?>">
                                <i class="fas <?php echo e($icon); ?>" style="font-size:.6rem;"></i>
                                <?php echo e(strtoupper($level)); ?>

                            </span>
                        </td>
                        <td>
                            <p class="log-msg <?php echo e($msgCls); ?>"><?php echo e($log['message'] ?? '—'); ?></p>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3">
                            <div class="log-empty">
                                <i class="fas fa-check-circle" style="color:#22c55e;"></i>
                                <p>Aucune entrée de log trouvée.</p>
                                <?php if(request('search') || request('type')): ?>
                                <a href="<?php echo e(route('admin.logs.index')); ?>"
                                    style="font-size:.78rem;color:#7c3aed;font-weight:600;">
                                    <i class="fas fa-times"></i> Effacer les filtres
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>

        
        <?php if(isset($logs) && method_exists($logs, 'hasPages') && $logs->hasPages()): ?>
        <div style="margin-top:12px;flex-shrink:0;">
            <?php echo e($logs->withQueryString()->links()); ?>

        </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/admin/logs/index.blade.php ENDPATH**/ ?>