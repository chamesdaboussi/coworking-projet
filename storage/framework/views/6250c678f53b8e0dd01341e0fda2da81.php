<?php $__env->startSection('title', 'Paiements'); ?>
<?php $__env->startSection('page-title', 'Historique des paiements'); ?>
<?php $__env->startSection('content'); ?>
<div class="fade-in">
    <div class="card" style="padding:0; overflow:hidden;">
        <table class="table">
            <thead>
                <tr>
                    <th>Réservation</th>
                    <th>Espace</th>
                    <th>Méthode</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $paiements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><span style="font-family:monospace; color:var(--accent);"><?php echo e($p->reservation->code_confirmation); ?></span></td>
                    <td><?php echo e($p->reservation->espace->nom ?? '—'); ?></td>
                    <td>
                        <?php if($p->methode === 'stripe'): ?>
                            <span class="badge badge-blue">Carte de crédit</span>
                        <?php elseif($p->methode === 'cash'): ?>
                            <span class="badge badge-purple">Espèces</span>
                        <?php else: ?>
                            <span class="badge badge-gray"><?php echo e(ucfirst($p->methode)); ?></span>
                        <?php endif; ?>
                    </td>
                    <td><strong><?php echo e(number_format($p->montant, 2)); ?> DT</strong></td>
                    <td><span class="badge badge-<?php echo e($p->statut === 'paid' ? 'green' : ($p->statut === 'pending' ? 'yellow' : 'red')); ?>"><?php echo e(['paid'=>'Payé','pending'=>'En attente','failed'=>'Échoué'][$p->statut] ?? $p->statut); ?></span></td>
                    <td style="color:var(--text-muted);"><?php echo e($p->paid_at ? $p->paid_at->format('d/m/Y H:i') : $p->created_at->format('d/m/Y H:i')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" style="text-align:center; padding:40px; color:var(--text-muted);">Aucun paiement.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if($paiements->hasPages()): ?><div style="padding:14px; border-top:1px solid var(--border);"><?php echo e($paiements->links()); ?></div><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Daboussi\Desktop\coworking\resources\views/user/payments/history.blade.php ENDPATH**/ ?>