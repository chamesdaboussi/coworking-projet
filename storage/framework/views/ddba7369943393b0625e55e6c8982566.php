<?php $__env->startSection('title', 'Codes Promo'); ?>
<?php $__env->startSection('page-title', 'Codes Promotionnels'); ?>

<?php $__env->startSection('content'); ?>
<div class="fade-in" style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">
    <div class="card" style="padding: 0; overflow: hidden;">
        <table class="table">
            <thead><tr><th>Code</th><th>Type</th><th>Valeur</th><th>Utilisations</th><th>Expiration</th><th>Statut</th><th></th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $codes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><span style="font-family: monospace; font-size: 13px; color: var(--accent-light); background: rgba(79,126,247,0.1); padding: 3px 8px; border-radius: 6px; font-weight: 700;"><?php echo e($code->code); ?></span></td>
                    <td><span class="badge badge-<?php echo e($code->type === 'percent' ? 'purple' : 'blue'); ?>"><?php echo e($code->type === 'percent' ? 'Pourcentage' : 'Fixe'); ?></span></td>
                    <td style="font-weight: 700; color: #10b981;"><?php echo e($code->type === 'percent' ? $code->valeur . '%' : $code->valeur . ' DT'); ?></td>
                    <td style="color: var(--text-muted);"><?php echo e($code->usage_count); ?><?php echo e($code->usage_max ? '/' . $code->usage_max : ''); ?></td>
                    <td style="font-size: 13px; color: var(--text-muted);"><?php echo e($code->date_expiration ? $code->date_expiration->format('d/m/Y') : '∞'); ?></td>
                    <td><span class="badge badge-<?php echo e($code->actif ? 'green' : 'gray'); ?>"><?php echo e($code->actif ? 'Actif' : 'Inactif'); ?></span></td>
                    <td>
                        <form method="POST" action="<?php echo e(route('admin.promo.delete', $code->id_code)); ?>" onsubmit="return confirm('Supprimer ce code ?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" style="text-align: center; padding: 32px; color: var(--text-muted);">Aucun code promo.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if($codes->hasPages()): ?><div style="padding: 16px;"><?php echo e($codes->links()); ?></div><?php endif; ?>
    </div>
    <div class="card" style="position: sticky; top: 80px;">
        <h3 style="font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 700; margin-bottom: 16px;">Nouveau code promo</h3>
        <form method="POST" action="<?php echo e(route('admin.promo.store')); ?>">
            <?php echo csrf_field(); ?>
            <div style="margin-bottom: 12px;"><label class="form-label">Code *</label><input type="text" name="code" class="form-input" placeholder="EX: SUMMER20" required style="text-transform: uppercase;"></div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                <div><label class="form-label">Type</label><select name="type" class="form-input"><option value="percent">Pourcentage (%)</option><option value="fixed">Montant fixe ( DT)</option></select></div>
                <div><label class="form-label">Valeur *</label><input type="number" name="valeur" class="form-input" step="0.01" min="0" required></div>
            </div>
            <div style="margin-bottom: 12px;"><label class="form-label">Montant minimum</label><input type="number" name="valeur_min_commande" class="form-input" step="0.01" min="0" placeholder="0"></div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px;">
                <div><label class="form-label">Expiration</label><input type="date" name="date_expiration" class="form-input"></div>
                <div><label class="form-label">Utilisations max</label><input type="number" name="usage_max" class="form-input" min="1" placeholder="Illimité"></div>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Créer le code</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\yassin\Desktop\coworking\resources\views/admin/promo/index.blade.php ENDPATH**/ ?>