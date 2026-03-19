<?php $__env->startSection('title', 'Modifier la planification'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/approbDash.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="vpage">

    
    <div class="breadcrumb">
        <a href="<?php echo e(route('approbateur.dashboard')); ?>"><i class="fas fa-home"></i></a>
        <span>/</span>
        <a href="<?php echo e(route('approbateur.projets.index')); ?>">Projets</a>
        <span>/</span>
        <a href="<?php echo e(route('approbateur.projets.show', $projet)); ?>"><?php echo e($projet->codeProjet); ?></a>
        <span>/</span>
        <span>Modifier planification</span>
    </div>

    
    <div class="show-header">
        <div>
            <h1 class="show-title">Modifier la planification</h1>
            <p style="font-size:.78rem;color:#9ca3af;margin:4px 0 0;">
                Projet : <strong style="color:#374151;"><?php echo e($projet->titre); ?></strong>
            </p>
        </div>
        <a href="<?php echo e(route('approbateur.projets.show', $projet)); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    
    <form method="POST" action="<?php echo e(route('approbateur.planification.update', [$projet, $planification])); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="info-card">

            <div style="display:flex;flex-direction:column;gap:16px;">

                <div class="form-group">
                    <label class="form-label">Activité de planification <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="activitePlanification"
                            value="<?php echo e(old('activitePlanification', $planification->activitePlanification)); ?>"
                            class="form-textarea" style="border-radius:8px;padding:9px 12px;"
                            placeholder="Ex : Mise en œuvre du projet" required>
                    <?php $__errorArgs = ['activitePlanification'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">

                    <div class="form-group">
                        <label class="form-label">Indicateur</label>
                        <input type="text" name="indicateur"
                                value="<?php echo e(old('indicateur', $planification->indicateur)); ?>"
                                class="form-textarea" style="border-radius:8px;padding:9px 12px;"
                                placeholder="Ex : Nombre de bénéficiaires">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                    <div class="form-group">
                        <label class="form-label">Unité de l'indicateur</label>
                        <input type="text" name="uniteIndicateur"
                                value="<?php echo e(old('uniteIndicateur', $planification->uniteIndicateur)); ?>"
                                class="form-textarea" style="border-radius:8px;padding:9px 12px;"
                                placeholder="Ex : Personnes, %, Km">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Période</label>
                        <input type="text" name="periode"
                                value="<?php echo e(old('periode', $planification->periode)); ?>"
                                class="form-textarea" style="border-radius:8px;padding:9px 12px;"
                                placeholder="Ex : T1 2026, Annuel">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Résultats attendus</label>
                    <textarea name="resultatsAttendues" rows="3" class="form-textarea"
                                placeholder="Décrire les résultats attendus..."><?php echo e(old('resultatsAttendues', $planification->resultatsAttendues)); ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Coût estimatif (F CFA)</label>
                    <input type="number" name="coutEstimatif"
                            value="<?php echo e(old('coutEstimatif', $planification->coutEstimatif)); ?>"
                            class="form-textarea" style="border-radius:8px;padding:9px 12px;"
                            placeholder="0" min="0" step="1">
                    <?php $__errorArgs = ['coutEstimatif'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="form-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;
                            padding-top:12px;border-top:1px solid #f3f4f6;">
                    <a href="<?php echo e(route('approbateur.projets.show', $projet)); ?>" class="btn-cancel">
                        Annuler
                    </a>
                    <button type="submit" class="btn-valider" style="width:auto;padding:9px 20px;">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>

            </div>
        </div>
    </form>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/approbateur/planification/edit.blade.php ENDPATH**/ ?>