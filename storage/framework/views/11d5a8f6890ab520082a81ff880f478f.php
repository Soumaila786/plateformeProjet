<?php
    $role = auth()->user()->role;
    $routeDownload = collect(['admin', 'approbateur', 'porteur'])
        ->first(fn ($r) => $r === $role && Route::has($r.'.projets.documents.download'));
?>

<?php if (isset($component)) { $__componentOriginal10bc9ab4bc16e5be58d7bd824e42dc1a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal10bc9ab4bc16e5be58d7bd824e42dc1a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cards.info','data' => ['titre' => 'Documents','icon' => 'fa-paperclip','class' => 'mb-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cards.info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['titre' => 'Documents','icon' => 'fa-paperclip','class' => 'mb-3']); ?>

    <?php $__empty_1 = true; $__currentLoopData = $projet->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="d-flex justify-content-between align-items-center py-2 <?php echo e(!$loop->last ? 'border-bottom' : ''); ?>">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-file text-muted"></i>
                <div>
                    <div class="small fw-semibold"><?php echo e($document->nomFichier); ?></div>
                    <div class="text-muted" style="font-size:.72rem;">
                        Ajouté le <?php echo e(optional($document->dateUpload)->format('d/m/Y')); ?> par <?php echo e($document->uploader->nomComplet ?? '—'); ?>

                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <?php if($routeDownload): ?>
                    <?php if (isset($component)) { $__componentOriginal297e0cb764496e02c55f24374a33184a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal297e0cb764496e02c55f24374a33184a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons.link','data' => ['href' => route($routeDownload.'.projets.documents.download', [$projet, $document]),'variant' => 'ghost','size' => 'sm','icon' => 'fa-download']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route($routeDownload.'.projets.documents.download', [$projet, $document])),'variant' => 'ghost','size' => 'sm','icon' => 'fa-download']); ?>
                        Télécharger
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal297e0cb764496e02c55f24374a33184a)): ?>
<?php $attributes = $__attributesOriginal297e0cb764496e02c55f24374a33184a; ?>
<?php unset($__attributesOriginal297e0cb764496e02c55f24374a33184a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal297e0cb764496e02c55f24374a33184a)): ?>
<?php $component = $__componentOriginal297e0cb764496e02c55f24374a33184a; ?>
<?php unset($__componentOriginal297e0cb764496e02c55f24374a33184a); ?>
<?php endif; ?>
                <?php endif; ?>
                <?php if($role === 'porteur' && $projet->isEditable()): ?>
                    <form action="<?php echo e(route('porteur.projets.documents.destroy', [$projet, $document])); ?>" method="POST" onsubmit="return confirm('Supprimer ce document ?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-link btn-sm text-danger text-decoration-none">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-muted small mb-0">Aucun document ajouté.</p>
    <?php endif; ?>

    <?php if($role === 'porteur' && $projet->isEditable()): ?>
        <form action="<?php echo e(route('porteur.projets.documents.store', $projet)); ?>" method="POST" enctype="multipart/form-data" class="mt-3 pt-3 border-top">
            <?php echo csrf_field(); ?>
            <label class="form-label small">Ajouter des documents (pdf, doc, xls, images — 10 Mo max chacun)</label>
            <div class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label small mb-1">Fichier</label>
                    <input type="file" name="documents[]" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small mb-1">Nom à afficher (optionnel)</label>
                    <input type="text" name="document_names[]" class="form-control form-control-sm" maxlength="255" placeholder="Ex. Rapport financier 2026">
                </div>
            </div>
            <div class="d-flex justify-content-end mt-2">
                <?php if (isset($component)) { $__componentOriginal33e4f43b1fe2812447ac9bb0c2eb15df = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal33e4f43b1fe2812447ac9bb0c2eb15df = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons.button','data' => ['type' => 'submit','variant' => 'outline','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'outline','size' => 'sm']); ?>Ajouter <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal33e4f43b1fe2812447ac9bb0c2eb15df)): ?>
<?php $attributes = $__attributesOriginal33e4f43b1fe2812447ac9bb0c2eb15df; ?>
<?php unset($__attributesOriginal33e4f43b1fe2812447ac9bb0c2eb15df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal33e4f43b1fe2812447ac9bb0c2eb15df)): ?>
<?php $component = $__componentOriginal33e4f43b1fe2812447ac9bb0c2eb15df; ?>
<?php unset($__componentOriginal33e4f43b1fe2812447ac9bb0c2eb15df); ?>
<?php endif; ?>
            </div>
        </form>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal10bc9ab4bc16e5be58d7bd824e42dc1a)): ?>
<?php $attributes = $__attributesOriginal10bc9ab4bc16e5be58d7bd824e42dc1a; ?>
<?php unset($__attributesOriginal10bc9ab4bc16e5be58d7bd824e42dc1a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal10bc9ab4bc16e5be58d7bd824e42dc1a)): ?>
<?php $component = $__componentOriginal10bc9ab4bc16e5be58d7bd824e42dc1a; ?>
<?php unset($__componentOriginal10bc9ab4bc16e5be58d7bd824e42dc1a); ?>
<?php endif; ?>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\projets\partials\_documents.blade.php ENDPATH**/ ?>