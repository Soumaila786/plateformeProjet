<?php $__env->startSection('title', 'Créer un utilisateur'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="projets-page">

    <div class="page-header">
        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="projets-title">Création d'un utilisateur</h1>
            <p class="projets-subtitle">Remplissez les informations du nouveau compte</p>
        </div>
    </div>

    <form action="<?php echo e(route('admin.users.store')); ?>" method="POST" class="projet-form">
        <?php echo csrf_field(); ?>

        <div class="form-card">

            <div class="form-card-header">
                <i class="fas fa-user"></i>
                <span>Informations personnelles</span>
            </div>

            <div class="form-card-body">
                <div class="form-row">

                    <div class="form-col">
                        <label class="field-label">Nom complet <span class="required">*</span></label>
                        <input  type="text"
                                name="nomComplet"
                                value="<?php echo e(old('nomComplet')); ?>"
                                class="field-input <?php $__errorArgs = ['nomComplet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Prénom Nom"
                                required >
                        <?php $__errorArgs = ['nomComplet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-col">
                        <label class="field-label">Email <span class="required">*</span></label>
                        <input  type="email"
                                name="email"
                                value="<?php echo e(old('email')); ?>"
                                class="field-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="email@exemple.com"
                                required >
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-col">
                        <label class="field-label">Rôle <span class="required">*</span></label>
                        <select name="role" class="field-input <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">— Sélectionner le rôle —</option>
                            
                            <option value="porteur"      <?php echo e(old('role') === 'porteur'      ? 'selected' : ''); ?>>Porteur de projet</option>
                            <option value="planificateur" <?php echo e(old('role') === 'planificateur'      ? 'selected' : ''); ?>>Planificateur</option>
                            <option value="approbateur"  <?php echo e(old('role') === 'approbateur'  ? 'selected' : ''); ?>>Approbateur</option>
                            <option value="validateur"   <?php echo e(old('role') === 'validateur'   ? 'selected' : ''); ?>>Validateur</option>
                        </select>
                        <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-col">
                        <label class="field-label">Téléphone</label>
                        <input  type="text"
                                name="contact"
                                value="<?php echo e(old('contact')); ?>"
                                class="field-input <?php $__errorArgs = ['contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="+226 XX XX XX XX">
                        <?php $__errorArgs = ['contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-col">
                        <label class="field-label">Fonction</label>
                        <input  type="text"
                                name="fonction"
                                value="<?php echo e(old('fonction')); ?>"
                                class="field-input <?php $__errorArgs = ['fonction'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Département---">
                        <?php $__errorArgs = ['fonction'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-col">
                        <label class="field-label">Matricule</label>
                        <input  type="text"
                                name="matricule"
                                value="<?php echo e(old('matricule')); ?>"
                                class="field-input <?php $__errorArgs = ['matricule'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="MAT-001UJKZ">
                        <?php $__errorArgs = ['matricule'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-col form-col-full">
                        <label class="field-label">Organisation / Structure</label>
                        <input  type="text"
                                name="organisation"
                                value="<?php echo e(old('organisation')); ?>"
                                class="field-input <?php $__errorArgs = ['organisation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Nom de l'organisation">
                        <?php $__errorArgs = ['organisation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div id="role-fields">

                        
                        <div class="role-group d-none" id="porteur-fields">
                            <div class="form-col">
                                <label>Spécialité</label>
                                <input  type="text"
                                        name="specialite"
                                        class="field-input">
                            </div>
                        </div>

                        
                        <div class="role-group d-none" id="approbateur-fields">
                            <div class="form-col">
                                <label>Service</label>
                                <input  type="text"
                                        name="service"
                                        class="field-input">
                            </div>
                            <div class="form-col">
                                <label>Poste</label>
                                <input  type="text"
                                        name="poste"
                                        class="field-input">
                            </div>
                        </div>

                        <div class="role-group d-none" id="planificateur-fields">
                            <div class="form-col">
                                <label>Service</label>
                                <input  type="text"
                                        name="service"
                                        class="field-input">
                            </div>
                        </div>

                        
                        <div class="role-group d-none" id="validateur-fields">
                            <div class="form-col">
                                <label>Date début mandat</label>
                                <input  type="date"
                                        name="dateDebutMandat"
                                        class="field-input">
                            </div>
                            <div class="form-col">
                                <label>Date fin mandat</label>
                                <input  type="date"
                                        name="dateFinMandat"
                                        class="field-input">
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i>
                Créer l'utilisateur
            </button>
        </div>

    </form>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const roleSelect = document.querySelector('select[name="role"]');

    const groups = {
        porteur: document.getElementById('porteur-fields'),
        approbateur: document.getElementById('approbateur-fields'),
        planificateur: document.getElementById('planificateur-fields'),
        validateur: document.getElementById('validateur-fields')
    };

    function hideAll() {
        Object.values(groups).forEach(g => g.classList.add('d-none'));
    }

    function showFields(role) {
        hideAll();
        if (groups[role]) {
            groups[role].classList.remove('d-none');
        }
    }

    // changement du select
    roleSelect.addEventListener('change', function () {
        showFields(this.value);
    });

    // au chargement (important si old())
    showFields(roleSelect.value);
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/admin/users/create.blade.php ENDPATH**/ ?>