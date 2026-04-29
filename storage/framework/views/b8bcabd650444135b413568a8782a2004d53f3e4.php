<?php $__env->startSection('title', 'Modifier une activité'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/planifDash.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="plan-page">

    
    <div class="plan-breadcrumb">
        <a href="<?php echo e(route('planificateur.dashboard')); ?>"><i class="fas fa-home"></i></a>
        <span>/</span>
        <a href="<?php echo e(route('planificateur.projets.index')); ?>">Projets</a>
        <span>/</span>
        <a href="<?php echo e(route('planificateur.projets.show', $projet)); ?>"><?php echo e($projet->codeProjet); ?></a>
        <span>/</span>
        <span>Modifier activité</span>
    </div>

    
    <div class="plan-header">
        <div>
            <h1 class="plan-header-title">Modifier l'activité de planification</h1>
            <p class="plan-header-sub">
                Projet : <strong style="color:var(--plan-text-gray);"><?php echo e($projet->titre); ?></strong>
            </p>
        </div>
        <a href="<?php echo e(route('planificateur.projets.show', $projet)); ?>" class="plan-btn-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    
    <?php if($errors->any()): ?>
    <div class="plan-alert plan-alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <ul style="margin:0;padding-left:16px;">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    
    <form method="POST" action="<?php echo e(route('planificateur.planifications.update', [$projet, $planification])); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="plan-form-card">
            <div class="plan-form-card-head">
                <i class="fas fa-edit"></i> Modifier l'activité
            </div>
            <div class="plan-form-card-body">

                <div class="plan-form-grid-1">
                    <div class="plan-form-group">
                        <label class="plan-form-label">
                            Activité de planification <span class="req">*</span>
                        </label>
                        <input type="text" name="activitePlanification"
                               value="<?php echo e(old('activitePlanification', $planification->activitePlanification)); ?>"
                               class="plan-form-input" required>
                        <?php $__errorArgs = ['activitePlanification'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="plan-form-error"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="plan-form-grid-2">
                    <div class="plan-form-group">
                        <label class="plan-form-label">Indicateur</label>
                        <input type="text" name="indicateur"
                               value="<?php echo e(old('indicateur', $planification->indicateur)); ?>"
                               class="plan-form-input">
                    </div>
                    <div class="plan-form-group">
                        <label class="plan-form-label">Unité de l'indicateur</label>
                        <input type="text" name="uniteIndicateur"
                               value="<?php echo e(old('uniteIndicateur', $planification->uniteIndicateur)); ?>"
                               class="plan-form-input">
                    </div>
                </div>

                <div class="plan-form-grid-2">
                    <div class="plan-form-group">
                        <label class="plan-form-label">Période</label>
                        <input type="text" name="periode"
                               value="<?php echo e(old('periode', $planification->periode)); ?>"
                               class="plan-form-input">
                    </div>
                    <div class="plan-form-group">
                        <label class="plan-form-label">Coût estimatif (F CFA)</label>
                        <input type="number" name="coutEstimatif"
                               value="<?php echo e(old('coutEstimatif', $planification->coutEstimatif)); ?>"
                               class="plan-form-input" min="0" step="1">
                        <?php $__errorArgs = ['coutEstimatif'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="plan-form-error"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="plan-form-group">
                    <label class="plan-form-label">Résultats attendus</label>
                    <textarea name="resultatsAttendues" rows="3"
                              class="plan-form-textarea"><?php echo e(old('resultatsAttendues', $planification->resultatsAttendues)); ?></textarea>
                </div>

                <div class="plan-form-actions">
                    <a href="<?php echo e(route('planificateur.projets.show', $projet)); ?>" class="plan-btn-cancel">
                        Annuler
                    </a>
                    <button type="submit" class="plan-btn-save">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/planificateur/planifications/edit.blade.php ENDPATH**/ ?>