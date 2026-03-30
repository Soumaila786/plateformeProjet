<?php $__env->startSection('title', 'Nouveau projet'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/projet.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="projets-page">

    <div class="page-header">
        <a href="<?php echo e(route('porteur.projets.index')); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="projets-title">Nouveau projet</h1>
            <p class="projets-subtitle">Remplissez les informations de votre projet</p>
        </div>
    </div>

    <form action="<?php echo e(route('porteur.projets.store')); ?>" method="POST" class="projet-form" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-project-diagram"></i>
                <span>Informations générales</span>
            </div>
            <div class="form-card-body">
                <div class="form-row">

                    <div class="form-col form-col-full">
                        <label class="field-label">Titre <span class="required">*</span></label>
                        <input type="text" name="titre"
                                value="<?php echo e(old('titre')); ?>"
                                class="field-input <?php $__errorArgs = ['titre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Titre du projet" required>
                        <?php $__errorArgs = ['titre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-col form-col-full">
                        <label class="field-label">Description <span class="required">*</span></label>
                        <textarea name="description" rows="3"
                                    class="field-input field-textarea <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="Description du projet..." required><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-col form-col-full">
                        <label class="field-label">Objectif</label>
                        <textarea name="objectif" rows="2"
                                    class="field-input field-textarea <?php $__errorArgs = ['objectif'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="Objectif principal..."><?php echo e(old('objectif')); ?></textarea>
                        <?php $__errorArgs = ['objectif'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-col">
                        <label class="field-label">Secteur <span class="required">*</span></label>
                        <select name="secteur_id" class="field-input <?php $__errorArgs = ['secteur_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">— Sélectionner —</option>
                            <?php $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($secteur->id); ?>" <?php echo e(old('secteur_id') == $secteur->id ? 'selected' : ''); ?>>
                                <?php echo e($secteur->nomSecteur); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['secteur_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-col">
                        <label class="field-label">Durée (mois)</label>
                        <input type="number" name="duree"
                                value="<?php echo e(old('duree')); ?>"
                                class="field-input <?php $__errorArgs = ['duree'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Ex : 12" min="1">
                        <?php $__errorArgs = ['duree'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                </div>
            </div>
        </div>

        
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-coins"></i>
                <span>Budget </span>
            </div>
            <div class="form-card-body">
                <div class="form-row">

                    <div class="form-col">
                        <label class="field-label">Budget total (F CFA)</label>
                        <input type="number" name="budgetTotal"
                                value="<?php echo e(old('budgetTotal')); ?>"
                                class="field-input <?php $__errorArgs = ['budgetTotal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="0" min="0" step="1">
                        <?php $__errorArgs = ['budgetTotal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-col">
                        <label class="field-label">Montant demandé (F CFA) <span class="required">*</span></label>
                        <input type="number" name="montantDemande"
                                value="<?php echo e(old('montantDemande')); ?>"
                                class="field-input <?php $__errorArgs = ['montantDemande'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="0" min="0" step="1" required>
                        <?php $__errorArgs = ['montantDemande'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-col">
                        <label class="field-label">Date de début probable</label>
                        <input type="date" name="dateDebut"
                                value="<?php echo e(old('dateDebut')); ?>"
                                class="field-input <?php $__errorArgs = ['dateDebut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['dateDebut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-col">
                        <label class="field-label">Date de fin probable</label>
                        <input type="date" name="dateFin"
                                value="<?php echo e(old('dateFin')); ?>"
                                class="field-input <?php $__errorArgs = ['dateFin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['dateFin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                </div>
            </div>
        </div>

        
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-paperclip"></i>
                <span>Documents joints</span>
            </div>
            <div class="form-card-body">

                <input type="file" id="documents" name="documents[]"
                        multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                        style="display:none">

                <div class="doc-toolbar">
                    <button type="button" class="btn-attach" onclick="document.getElementById('documents').click()">
                        <i class="fas fa-plus"></i>
                        Joindre des fichiers
                    </button>
                    <select name="typeDocument" class="field-input doc-type-select">
                        <option value="rapport">Rapport</option>
                        <option value="budget">Budget</option>
                        <option value="contrat">Contrat</option>
                        <option value="etude">Étude de faisabilité</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>

                <p class="doc-hint">PDF, Word, Excel, images — Max 10 Mo par fichier</p>

                <div id="fileList" class="doc-file-list">
                    <div class="doc-empty-state">
                        <i class="fas fa-folder-open"></i>
                        <span>Aucun fichier sélectionné</span>
                    </div>
                </div>

                <?php $__errorArgs = ['documents.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="field-error"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?php echo e(route('porteur.projets.index')); ?>" class="btn-cancel">Annuler</a>
            <button type="submit" name="action" value="brouillon" class="btn-cancel">
                <i class="fas fa-save"></i> Enregistrer en brouillon
            </button>
            <button type="submit" name="action" value="soumettre" class="btn-save"
                    onclick="return confirm('Soumettre ce projet ? Vous ne pourrez plus le modifier.')">
                <i class="fas fa-paper-plane"></i> Enregistrer et soumettre
            </button>
        </div>

    </form>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
const fileInput  = document.getElementById('documents');
const fileListEl = document.getElementById('fileList');

fileInput.addEventListener('change', function() {
    renderFiles(Array.from(this.files));
});

function getIcon(name) {
    const ext = name.split('.').pop().toLowerCase();
    if (['pdf'].includes(ext))              return 'fas fa-file-pdf';
    if (['doc','docx'].includes(ext))       return 'fas fa-file-word';
    if (['xls','xlsx'].includes(ext))       return 'fas fa-file-excel';
    if (['jpg','jpeg','png'].includes(ext)) return 'fas fa-file-image';
    return 'fas fa-file-alt';
}

function formatSize(b) {
    if (b < 1024)    return b + ' o';
    if (b < 1048576) return (b / 1024).toFixed(1) + ' Ko';
    return (b / 1048576).toFixed(1) + ' Mo';
}

function renderFiles(files) {
    if (!files || files.length === 0) {
        fileListEl.innerHTML = `
            <div class="doc-empty-state">
                <i class="fas fa-folder-open"></i>
                <span>Aucun fichier sélectionné</span>
            </div>`;
        return;
    }
    fileListEl.innerHTML = files.map(f => `
        <div class="doc-file-item">
            <i class="${getIcon(f.name)} doc-file-icon"></i>
            <div class="doc-file-info">
                <span class="doc-file-name">${f.name}</span>
                <span class="doc-file-size">${formatSize(f.size)}</span>
            </div>
            <span class="doc-file-ok"><i class="fas fa-check-circle"></i> Accepté</span>
        </div>
    `).join('');
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/porteur/projets/create.blade.php ENDPATH**/ ?>