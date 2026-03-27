<?php $__env->startSection('title', 'Configuration système'); ?>
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/adminDash.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/configuration.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="config-page">

    
    <div class="config-header">
        <div>
            <h1><i class="fas fa-cogs" style="color:#6366f1; margin-right:8px;"></i>Configuration système</h1>
            <p>Gérez les paramètres globaux de l'application</p>
        </div>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn-reset-all">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    
    <?php if(session('success')): ?>
    <div style="display:flex;align-items:center;gap:8px;padding:11px 14px;background:#f0fdf4;
                border:1px solid #bbf7d0;border-radius:8px;margin-bottom:14px;
                font-size:.8rem;color:#15803d;">
        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <?php
        $generalGroup = $configs->get('general');
        $maintenance  = $generalGroup ? $generalGroup->where('cle','mode_maintenance')->first() : null;
        $modeMaintenanceActif = $maintenance && $maintenance->valeur === '1';
    ?>
    <?php if($modeMaintenanceActif): ?>
    <div class="maintenance-alert">
        <i class="fas fa-exclamation-triangle"></i>
        <div>
            <strong>Mode maintenance actif</strong> — Les utilisateurs ne peuvent pas accéder à l'application.
            Désactivez-le dès que la maintenance est terminée.
        </div>
    </div>
    <?php endif; ?>

    
    <div class="config-tabs">
        <?php $__currentLoopData = $groupes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $groupe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="#" class="config-tab <?php echo e($key === 'general' ? 'active' : ''); ?>"
            onclick="showSection('<?php echo e($key); ?>'); return false;">
            <i class="fas <?php echo e($groupe['icon']); ?>"></i> <?php echo e($groupe['label']); ?>

        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <form method="POST" action="<?php echo e(route('admin.configuration.update')); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

        <?php $__currentLoopData = $groupes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $groupe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="config-section <?php echo e($key === 'general' ? 'active' : ''); ?>" id="section-<?php echo e($key); ?>">

            <?php if($configs->has($key)): ?>
                <div class="config-card">

                    <div class="config-card-head">
                        <div class="config-card-icon">
                            <i class="fas <?php echo e($groupe['icon']); ?>"></i>
                        </div>
                        <h3 class="config-card-title">
                            Paramètres <?php echo e($groupe['label']); ?>

                        </h3>
                    </div>

                    <div class="config-card-body">
                        <div class="field-row">
                            <?php $__currentLoopData = $configs->get($key); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $config): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $isFullWidth = in_array($config->type, ['boolean']) || strlen($config->description ?? '') > 60;
                                ?>
                                <div class="field-group <?php echo e($config->type === 'boolean' ? 'field-full' : ''); ?>">

                                    <?php if($config->type === 'boolean'): ?>
                                    
                                    <label class="field-label"><?php echo e($config->label); ?></label>
                                    <?php if($config->description): ?>
                                    <p class="field-desc"><?php echo e($config->description); ?></p>
                                    <?php endif; ?>
                                    <div class="toggle-wrap">
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="<?php echo e($config->cle); ?>"
                                                    <?php echo e($config->valeur === '1' ? 'checked' : ''); ?>>
                                            <span class="toggle-slider"></span>
                                        </label>
                                        <span class="toggle-label">
                                            <?php echo e($config->valeur === '1' ? 'Activé' : 'Désactivé'); ?>

                                        </span>
                                    </div>

                                    <?php elseif($config->type === 'color'): ?>
                                    
                                    <label class="field-label">
                                        <?php echo e($config->label); ?>

                                    </label>
                                    <?php if($config->description): ?>
                                    <p class="field-desc"><?php echo e($config->description); ?></p>
                                    <?php endif; ?>
                                    <div class="color-wrap">
                                        <input type="color" id="color_<?php echo e($config->cle); ?>"
                                                value="<?php echo e($config->valeur); ?>"
                                                class="color-preview"
                                                oninput="document.getElementById('text_<?php echo e($config->cle); ?>').value=this.value">
                                        <input type="text" id="text_<?php echo e($config->cle); ?>"
                                                name="<?php echo e($config->cle); ?>"
                                                value="<?php echo e($config->valeur); ?>"
                                                class="color-text"
                                                oninput="document.getElementById('color_<?php echo e($config->cle); ?>').value=this.value">
                                    </div>

                                    <?php else: ?>
                                    
                                    <label class="field-label">
                                        <?php echo e($config->label); ?>

                                        <?php if($config->type === 'number'): ?>
                                        <small style="font-weight:400;color:#9ca3af;">numérique</small>
                                        <?php endif; ?>
                                    </label>
                                    <?php if($config->description): ?>
                                    <p class="field-desc"><?php echo e($config->description); ?></p>
                                    <?php endif; ?>
                                    <input type="<?php echo e($config->type === 'email' ? 'email' : ($config->type === 'number' ? 'number' : 'text')); ?>"
                                            name="<?php echo e($config->cle); ?>"
                                            value="<?php echo e(old($config->cle, $config->valeur)); ?>"
                                            class="field-input"
                                            <?php echo e($config->type === 'number' ? 'min=0 step=1' : ''); ?>>
                                    <?php if($errors->has($config->cle)): ?>
                                    <p style="font-size:.7rem;color:#dc2626;margin:2px 0 0;"><?php echo e($errors->first($config->cle)); ?></p>
                                    <?php endif; ?>
                                    <?php endif; ?>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <div class="config-actions">
            <button type="button" class="btn-reset-all"
                    onclick="return confirm('Réinitialiser TOUS les paramètres aux valeurs par défaut ?') && document.getElementById('resetAllForm').submit()">
                <i class="fas fa-undo"></i> Réinitialiser tout
            </button>
            <button type="submit" class="btn-save-config">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
        </div>
    </form>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function showSection(key) {
        // Masquer toutes les sections
        document.querySelectorAll('.config-section').forEach(s => s.classList.remove('active'));
        document.querySelectorAll('.config-tab').forEach(t => t.classList.remove('active'));
        // Afficher la section cible
        document.getElementById('section-' + key).classList.add('active');
        document.querySelector('[onclick*="' + key + '"]').classList.add('active');
    }

    // Mise à jour du label toggle en temps réel
    document.querySelectorAll('.toggle-switch input[type="checkbox"]').forEach(function(cb) {
        cb.addEventListener('change', function() {
            const label = this.closest('.toggle-wrap').querySelector('.toggle-label');
            label.textContent = this.checked ? 'Activé' : 'Désactivé';
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/admin/configuration/index.blade.php ENDPATH**/ ?>