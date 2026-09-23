<form method="GET" action="<?php echo e(url()->current()); ?>" class="an-filters mb-4">
    <div>
        <label for="date_debut" class="form-label small">Du</label>
        <input type="date" id="date_debut" name="date_debut" value="<?php echo e(request('date_debut')); ?>" class="form-control form-control-sm">
    </div>
    <div>
        <label for="date_fin" class="form-label small">Au</label>
        <input type="date" id="date_fin" name="date_fin" value="<?php echo e(request('date_fin')); ?>" class="form-control form-control-sm">
    </div>
    <div>
        <label for="type_projet_id" class="form-label small">Type de projet</label>
        <select id="type_projet_id" name="type_projet_id" class="form-select form-select-sm">
            <option value="">Tous les types</option>
            <?php $__currentLoopData = $typesProjets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($type->id); ?>" <?php echo e((string) request('type_projet_id') === (string) $type->id ? 'selected' : ''); ?>><?php echo e($type->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label for="secteur_id" class="form-label small">Secteur</label>
        <select id="secteur_id" name="secteur_id" class="form-select form-select-sm">
            <option value="">Tous les secteurs</option>
            <?php $__currentLoopData = $secteursFiltres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($secteur->id); ?>" <?php echo e((string) request('secteur_id') === (string) $secteur->id ? 'selected' : ''); ?>><?php echo e($secteur->nomSecteur); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <?php if(auth()->user()->role !== 'porteur'): ?>
        <div>
            <label for="user_id" class="form-label small">Porteur</label>
            <select id="user_id" name="user_id" class="form-select form-select-sm">
                <option value="">Tous les porteurs</option>
                <?php $__currentLoopData = $porteursFiltres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $porteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($porteur->id); ?>" <?php echo e((string) request('user_id') === (string) $porteur->id ? 'selected' : ''); ?>><?php echo e($porteur->nomComplet); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Filtrer</button>
    <a href="<?php echo e(url()->current()); ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-rotate-left me-1"></i>Réinitialiser</a>
</form>
<?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views\analytique\partials\_filtres.blade.php ENDPATH**/ ?>