<?php $__env->startSection('title', 'Réservations Admin'); ?>
<?php $__env->startSection('page-title', 'Liste des réservations'); ?>
<?php $__env->startSection('content'); ?>
<div class="fade-in">
    <div class="card" style="margin-bottom:16px;">
        <form method="GET" action="<?php echo e(route('admin.reservations')); ?>" style="display:flex;gap:10px;flex-wrap:wrap;align-items:end;">
            <div style="flex:2;min-width:220px;"><label class="form-label">Recherche</label><input class="form-input" name="search" value="<?php echo e(request('search')); ?>" placeholder="code, client, espace..."></div>
            <div><label class="form-label">Paiement</label><select class="form-input" name="payment"><option value="">Tous</option><option value="cash" <?php if(request('payment')==='cash'): echo 'selected'; endif; ?>>Cash</option><option value="stripe" <?php if(request('payment')==='stripe'): echo 'selected'; endif; ?>>En ligne</option></select></div>
            <div><label class="form-label">Statut</label><select class="form-input" name="statut"><option value="">Tous</option><option value="pending" <?php if(request('statut')==='pending'): echo 'selected'; endif; ?>>En attente</option><option value="confirmed" <?php if(request('statut')==='confirmed'): echo 'selected'; endif; ?>>Confirmée</option></select></div>
            <button class="btn btn-primary">Filtrer</button><a class="btn btn-outline" href="<?php echo e(route('admin.reservations')); ?>">Reset</a>
        </form>
    </div>

    <div class="card" style="padding:0;overflow:hidden;">
        <table class="table">
            <thead><tr><th>Code</th><th>Client</th><th>Espace</th><th>Dates</th><th>Montant</th><th>Statut</th><th>Paiement</th><th>Action</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><span style="font-family:monospace;color:var(--accent);"><?php echo e($r->code_confirmation); ?></span></td>
                    <td><strong><?php echo e($r->utilisateur->full_name); ?></strong><br><span style="color:var(--text-muted);font-size:12px;"><?php echo e($r->utilisateur->email); ?></span></td>
                    <td><?php echo e($r->espace->nom); ?></td>
                    <td><?php echo e($r->period_label); ?></td>
                    <td><strong><?php echo e(number_format($r->prix_final, 2)); ?> DT</strong></td>
                    <td><span class="badge badge-<?php echo e($r->status_badge['color']); ?>"><?php echo e($r->status_badge['label']); ?></span></td>
                    <td>
                        <?php if($r->latestPaiement): ?>
                            <?php
                                $methodeLabel = $r->latestPaiement->methode === 'stripe' ? 'Carte de crédit' : ($r->latestPaiement->methode === 'cash' ? 'Espèces' : ucfirst($r->latestPaiement->methode));
                                $statutLabel = $r->latestPaiement->statut === 'paid' ? 'Payé' : ($r->latestPaiement->statut === 'pending' ? 'En attente' : 'Échoué');
                            ?>
                            <span class="badge badge-<?php echo e($r->latestPaiement->statut === 'paid' ? 'green' : ($r->latestPaiement->statut === 'pending' ? 'yellow' : 'red')); ?>"><?php echo e($methodeLabel); ?> — <?php echo e($statutLabel); ?></span>
                        <?php else: ?> <span class="badge badge-gray">Non payé</span><?php endif; ?>
                    </td>
                    <td style="white-space:nowrap;">
                        <a href="<?php echo e(route('reservations.show', $r->id_reservation)); ?>" class="btn btn-outline btn-sm">Voir</a>
                        <?php if($r->latestPaiement && $r->latestPaiement->methode === 'cash' && $r->latestPaiement->statut === 'pending'): ?>
                        <form method="POST" action="<?php echo e(route('admin.reservations.validateCash', $r->id_reservation)); ?>" style="display:inline;"><?php echo csrf_field(); ?><button class="btn btn-success btn-sm" onclick="return confirm('Valider le paiement cash ?')">Valider cash</button></form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" style="text-align:center;padding:40px;color:var(--text-muted);">Aucune réservation.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if($reservations->hasPages()): ?><div style="padding:14px;border-top:1px solid var(--border);"><?php echo e($reservations->links()); ?></div><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Daboussi\Desktop\coworking\resources\views/admin/reservations/index.blade.php ENDPATH**/ ?>