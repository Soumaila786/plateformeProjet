<?php $__env->startSection('title', 'Mes projets traités'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/approbateur.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="aprob-page">

    
    <div class="aprob-header">

        <div>
            <h1 class="aprob-header-title">Mes projets traités</h1>
            <p class="aprob-header-sub">
                <?php echo e($projets->total()); ?>

                projet<?php echo e($projets->total() > 1 ? 's' : ''); ?>

                traité<?php echo e($projets->total() > 1 ? 's' : ''); ?>

            </p>
        </div>

        <a href="<?php echo e(route('approbateur.projets.index')); ?>" class="aprob-btn aprob-btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Projets à approuver
        </a>

    </div>

    
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">

        <div class="aprob-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput"
                    placeholder="Rechercher par titre ou code..."
                    value="<?php echo e(request('search')); ?>">
        </div>

        <select id="secteurSelect" class="aprob-select">
            <option value="">Tous les secteurs</option>
            <?php $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($secteur->id); ?>" <?php echo e(request('secteur_id') == $secteur->id ? 'selected' : ''); ?>>
                <?php echo e($secteur->nomSecteur); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <div class="aprob-status-filters">
            <?php
                $statuts = [
                    '' => 'Tous',
                    'en_examen'=>'En examen',
                    'approuve'=>'Approuvé',
                    'rejete'=>'Rejeté'
                ];
            ?>
            <?php $__currentLoopData = $statuts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('approbateur.projets.mes_projets', array_merge(request()->query(), ['statut'=>$val]))); ?>"
                class="aprob-status-filter <?php echo e(request('statut','') === $val ? 'active' : ''); ?>">
                <?php echo e($label); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if(request('search') || request('secteur_id') || request('statut')): ?>
        <a href="<?php echo e(route('approbateur.projets.mes_projets')); ?>" class="aprob-reset-btn">
            <i class="fas fa-times"></i>
            Réinitialiser
        </a>
        <?php endif; ?>
    </div>

    
    <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $stMap = [
            'en_examen' => ['lbl'=>'En examen', 'cls'=>'aprob-badge-en_examen', 'dot'=>'#f97316'],
            'approuve'  => ['lbl'=>'Approuvé',  'cls'=>'aprob-badge-approuve',  'dot'=>'#22c55e'],
            'rejete'    => ['lbl'=>'Rejeté',    'cls'=>'aprob-badge-rejete',    'dot'=>'#ef4444'],
        ];
        $st = $stMap[$projet->statutProjet] ?? ['lbl'=>$projet->statutProjet,'cls'=>'aprob-badge-brouillon','dot'=>'#9ca3af'];
        $dateTraitement = $projet->dateApprobation ?? $projet->updated_at;
    ?>

    <div class="aprob-projet-row <?php echo e($projet->statutProjet); ?>">

        <div class="aprob-projet-avatar">
            <?php echo e(strtoupper(substr(optional($projet->secteur)->nomSecteur ?? $projet->titre, 0, 1))); ?>

        </div>

        <div class="aprob-projet-info">

            <div class="aprob-projet-top">
                <span class="aprob-projet-code"><?php echo e($projet->codeProjet); ?></span>
                <span class="aprob-projet-titre"><?php echo e($projet->titre); ?></span>
            </div>

            <p class="aprob-projet-meta">
                <span><i class="fas fa-user"></i><?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?></span>
                <span><i class="fas fa-tag"></i><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></span>
                <?php if($projet->montantDemande): ?>
                <span>
                    <i class="fas fa-coins"></i>
                    <strong><?php echo e(number_format($projet->montantDemande, 0, ',', ' ')); ?> F CFA</strong>
                </span>
                <?php endif; ?>
                <?php if($dateTraitement): ?>
                <span>
                    <i class="fas fa-calendar-check"></i>
                    Traité le <?php echo e($dateTraitement->format('d/m/Y')); ?>

                </span>
                <?php endif; ?>
            </p>

        </div>

        <div class="aprob-projet-badges">
            <span class="aprob-badge <?php echo e($st['cls']); ?>">
                <span class="aprob-dot" style="background:<?php echo e($st['dot']); ?>;"></span>
                <?php echo e($st['lbl']); ?>

            </span>
            <a href="<?php echo e(route('approbateur.projets.show', $projet)); ?>"
                class="aprob-btn aprob-btn-outline aprob-btn-icon" title="Voir">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="aprob-empty">
        <i class="fas fa-folder-open"></i>
        <p>
            <?php if(request('statut') || request('search') || request('secteur_id')): ?>
                Aucun projet ne correspond à votre recherche.
            <?php else: ?>
                Aucun projet traité pour l'instant.
            <?php endif; ?>
        </p>
    </div>
    <?php endif; ?>

    
    <div class="aprob-pagination">
        <?php echo e($projets->withQueryString()->links()); ?>

    </div>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
    let timer;

    document.getElementById('searchInput').addEventListener('input', function () {
        clearTimeout(timer);
        const val = this.value;
        timer = setTimeout(() => {
            const url = new URL(window.location.href);
            url.searchParams.set('search', val);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }, 450);
    });

    document.getElementById('secteurSelect').addEventListener('change', function () {
        const url = new URL(window.location.href);
        if (this.value) url.searchParams.set('secteur_id', this.value);
        else url.searchParams.delete('secteur_id');
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/approbateur/projets/mes_projets.blade.php ENDPATH**/ ?>