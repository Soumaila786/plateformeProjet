<?php $__env->startSection('title', 'Projets à valider'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/validDash.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="vpage">

    
    <div class="page-header" style="margin-bottom:16px;">
        <div>
            <h1 class="page-title">Projets à valider</h1>
            <p class="page-sub"><?php echo e($projets->total()); ?> projet(s) en attente de validation</p>
        </div>
        <a href="<?php echo e(route('validateur.projets.mes_projets')); ?>" class="btn-back"
            style="background:#f0fdfa;color:#0f766e;border-color:#99f6e4;">
            <i class="fas fa-history"></i> Mes projets traités
        </a>
    </div>

    
    <form method="GET" action="<?php echo e(route('validateur.projets.index')); ?>" id="filterForm">
        <div style="display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap;align-items:center;">

            
            <div style="position:relative;flex:1;min-width:200px;">
                <i class="fas fa-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:.75rem;"></i>
                <input type="text" name="search" id="searchInput"
                        value="<?php echo e(request('search')); ?>"
                        placeholder="Rechercher par titre ou code..."
                        style="width:100%;padding:8px 10px 8px 30px;border:1px solid #e5e7eb;
                                border-radius:8px;font-size:.78rem;outline:none;">
            </div>

            
            <select name="secteur_id" onchange="document.getElementById('filterForm').submit()"
                    style="padding:8px 12px;border:1px solid #e5e7eb;border-radius:8px;
                            font-size:.78rem;color:#374151;background:#fff;min-width:160px;">
                <option value="">Tous les secteurs</option>
                <?php $__currentLoopData = $secteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($secteur->id); ?>" <?php echo e(request('secteur_id') == $secteur->id ? 'selected' : ''); ?>>
                    <?php echo e($secteur->nomSecteur); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            
            <button type="submit"
                    style="padding:8px 16px;background:#0d9488;color:#fff;border:none;
                            border-radius:8px;font-size:.78rem;font-weight:700;cursor:pointer;">
                <i class="fas fa-filter"></i> Filtrer
            </button>

            <?php if(request('search') || request('secteur_id')): ?>
            <a href="<?php echo e(route('validateur.projets.index')); ?>"
               style="padding:8px 12px;background:#f3f4f6;color:#6b7280;border-radius:8px;
                      font-size:.78rem;font-weight:600;text-decoration:none;">
                <i class="fas fa-times"></i> Réinitialiser
            </a>
            <?php endif; ?>
        </div>
    </form>

    
    <?php $__empty_1 = true; $__currentLoopData = $projets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="proj-card" style="margin-bottom:10px;">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;">
            <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                    <span style="font-size:.68rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;">
                        <?php echo e($projet->codeProjet); ?>

                    </span>
                    <span class="status-badge" style="background:#f0fdf4;color:#15803d;">
                        <span class="dot" style="background:#22c55e;"></span>Approuvé
                    </span>
                </div>
                <h3 style="font-size:.9rem;font-weight:700;color:#111827;margin:0 0 6px;line-height:1.3;">
                    <?php echo e($projet->titre); ?>

                </h3>
                <div style="display:flex;flex-wrap:wrap;gap:12px;font-size:.73rem;color:#9ca3af;">
                    <span><i class="fas fa-user" style="margin-right:3px;"></i><?php echo e(optional($projet->porteur)->nomComplet ?? '—'); ?></span>
                    <span><i class="fas fa-tag" style="margin-right:3px;"></i><?php echo e(optional($projet->secteur)->nomSecteur ?? '—'); ?></span>
                    <span><i class="fas fa-wallet" style="margin-right:3px;"></i><?php echo e(number_format($projet->montantDemande ?? 0, 0, ',', ' ')); ?> F CFA</span>
                    <span><i class="fas fa-calendar" style="margin-right:3px;"></i>Approuvé le <?php echo e(optional($projet->dateApprobation)->format('d/m/Y') ?? '—'); ?></span>
                </div>
            </div>
            <a href="<?php echo e(route('validateur.projets.show', $projet)); ?>" class="btn-examiner">
                <i class="fas fa-eye"></i> Examiner
            </a>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="empty-state" style="margin-top:30px;">
        <i class="fas fa-check-double" style="font-size:2rem;color:#0d9488;margin-bottom:8px;"></i>
        <p>Aucun projet en attente de validation.</p>
    </div>
    <?php endif; ?>

    
    <?php if($projets->hasPages()): ?>
    <div style="margin-top:16px;"><?php echo e($projets->withQueryString()->links()); ?></div>
    <?php endif; ?>

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
    }, 500);
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\dell\Desktop\Laravel\projetSoutenance\resources\views/validateur/projets/index.blade.php ENDPATH**/ ?>