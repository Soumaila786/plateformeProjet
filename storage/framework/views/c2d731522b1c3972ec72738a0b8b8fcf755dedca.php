<?php $__env->startSection('title', 'Ajouter une activité'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/porteur.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="projets-page">

    
    <div class="page-header">
        <a href="<?php echo e(route('porteur.projets.show', $projet)); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="page-header-info">
            <div>
                <h1 class="projets-title">Ajouter une activité de planification</h1>
                <p class="projets-subtitle"><?php echo e($projet->codeProjet); ?> — <?php echo e($projet->titre); ?></p>
            </div>
        </div>
    </div>

    
    <?php if($errors->any()): ?>
    <div class="port-alert port-alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <ul style="margin:0;padding-left:16px;">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    
    <form method="POST" action="<?php echo e(route('porteur.planifications.store', $projet)); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-tasks"></i>
                <span>Détails de l'activité</span>
            </div>
            <div class="form-card-body">

                
                <div class="form-grid-1">
                    <div class="form-group">
                        <label class="form-label">
                            Activité de planification <span class="req">*</span>
                        </label>
                        <input type="text" name="activitePlanification"
                                value="<?php echo e(old('activitePlanification')); ?>"
                                class="form-input"
                                placeholder="Ex : Mise en œuvre du projet" required>
                        <?php $__errorArgs = ['activitePlanification'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="form-error"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                
                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Indicateur</label>
                        <input type="text" name="indicateur"
                                value="<?php echo e(old('indicateur')); ?>"
                                class="form-input"
                                placeholder="Ex : Nombre de bénéficiaires">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unité de l'indicateur</label>
                        <input type="text" name="uniteIndicateur"
                                value="<?php echo e(old('uniteIndicateur')); ?>"
                                class="form-input"
                                placeholder="Ex : Personnes, %, Km">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Période</label>
                        <input type="text" name="periode"
                                value="<?php echo e(old('periode')); ?>"
                                class="form-input"
                                placeholder="Ex : T1 2026, Annuel">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Coût estimatif (F CFA)</label>
                        <input type="number" name="coutEstimatif"
                                value="<?php echo e(old('coutEstimatif')); ?>"
                                class="form-input"
                                placeholder="0" min="0" step="1">
                        <?php $__errorArgs = ['coutEstimatif'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="form-error"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                
                <div class="form-group" style="margin-top:14px;">
                    <label class="form-label">Résultats attendus</label>
                    <textarea name="resultatsAttendues" rows="3"
                                class="form-textarea"
                                placeholder="Décrire les résultats attendus..."><?php echo e(old('resultatsAttendues')); ?></textarea>
                </div>

                
                <div class="form-actions">
                    <a href="<?php echo e(route('porteur.projets.show', $projet)); ?>" class="btn-cancel">
                        Annuler
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/porteur/planifications/create.blade.php ENDPATH**/ ?>