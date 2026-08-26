

<?php $__env->startSection('title', 'Configuration système'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <a href="<?php echo e(route('admin.dashboard')); ?>">Tableau de bord</a>
    <span>/</span>
    <span>Configuration système</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/parametres.css')); ?>">
    <?php $__env->stopPush(); ?>

    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Configuration système</h1>
            <p class="page-header-sub">Paramètres généraux de l'application</p>
        </div>
        <a href="<?php echo e(route('parametres.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour aux paramètres</a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/configuration.css')); ?>">
    <?php $__env->stopPush(); ?>

    <?php $premierGroupe = $configs->keys()->first(); ?>

    <div class="conf-tabs">
        <?php $__currentLoopData = $configs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupeKey => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button type="button" class="conf-tab <?php echo e($groupeKey === $premierGroupe ? 'active' : ''); ?>"
                    data-conf-tab="<?php echo e($groupeKey); ?>">
                <i class="fas <?php echo e($groupes[$groupeKey]['icon'] ?? 'fa-sliders'); ?> me-1"></i>
                <?php echo e($groupes[$groupeKey]['label'] ?? ucfirst($groupeKey)); ?>

            </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <form action="<?php echo e(route('admin.configuration.update')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <?php $__currentLoopData = $configs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupeKey => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="conf-groupe <?php echo e($groupeKey === $premierGroupe ? 'active' : ''); ?>" data-conf-groupe="<?php echo e($groupeKey); ?>">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.cards.info','data' => []]); ?>
<?php $component->withName('cards.info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $config): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="conf-field-row">
                            <div>
                                <div class="conf-field-label"><?php echo e($config->label ?? $config->cle); ?></div>
                                <?php if($config->description): ?>
                                    <div class="conf-field-desc"><?php echo e($config->description); ?></div>
                                <?php endif; ?>
                                <?php $__errorArgs = [$config->cle];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="conf-field-input d-flex align-items-center gap-2">
                                <?php if($config->type === 'boolean'): ?>
                                    <div class="form-check form-switch mb-0">
                                        <input type="hidden" name="<?php echo e($config->cle); ?>" value="0">
                                        <input class="form-check-input" type="checkbox" name="<?php echo e($config->cle); ?>" value="1"
                                               <?php echo e(old($config->cle, $config->valeur) === '1' ? 'checked' : ''); ?>>
                                    </div>

                                <?php elseif($config->type === 'color'): ?>
                                    <input type="color" name="<?php echo e($config->cle); ?>" class="form-control form-control-color"
                                           value="<?php echo e(old($config->cle, $config->valeur ?: '#6366f1')); ?>">

                                <?php elseif($config->type === 'image'): ?>
                                    <?php if($config->valeur): ?>
                                        <img src="<?php echo e(asset('storage/'.$config->valeur)); ?>" alt="" class="conf-logo-preview">
                                    <?php endif; ?>
                                    <input type="file" name="<?php echo e($config->cle); ?>" accept="image/*" class="form-control form-control-sm">

                                <?php elseif($config->type === 'number'): ?>
                                    <input type="number" name="<?php echo e($config->cle); ?>" class="form-control"
                                           value="<?php echo e(old($config->cle, $config->valeur)); ?>" min="0">

                                <?php elseif($config->type === 'email'): ?>
                                    <input type="email" name="<?php echo e($config->cle); ?>" class="form-control"
                                           value="<?php echo e(old($config->cle, $config->valeur)); ?>">

                                <?php else: ?>
                                    <input type="text" name="<?php echo e($config->cle); ?>" class="form-control"
                                           value="<?php echo e(old($config->cle, $config->valeur)); ?>">
                                <?php endif; ?>

                                
                                <button type="button" class="btn btn-outline-secondary btn-sm" title="Réinitialiser"
                                        data-reset-cle
                                        data-reset-url="<?php echo e(route('admin.configuration.reset', $config->cle)); ?>">
                                    <i class="fas fa-rotate-left"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-check me-1"></i>Enregistrer les modifications</button>
        </div>
    </form>

    <?php $__env->startPush('scripts'); ?>
        <script src="<?php echo e(asset('js/configuration.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/configuration/index.blade.php ENDPATH**/ ?>