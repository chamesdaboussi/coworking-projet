<?php $__env->startSection('title', 'Mes Réservations'); ?>
<?php $__env->startSection('page-title', 'Mes réservations'); ?>

<?php $__env->startSection('content'); ?>
<div class="fade-in">

    <!-- Filters -->
    <div class="card" style="margin-bottom: 20px;">
        <form method="GET" action="<?php echo e(route('reservations.index')); ?>" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 2; min-width: 200px;">
                <label class="form-label">Rechercher</label>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-input" placeholder="Code, espace...">
            </div>
            <div style="flex: 1; min-width: 140px;">
                <label class="form-label">Statut</label>
                <select name="statut" class="form-input">
                    <option value="">Tous</option>
                    <option value="pending"   <?php echo e(request('statut') === 'pending'   ? 'selected' : ''); ?>>En attente</option>
                    <option value="confirmed" <?php echo e(request('statut') === 'confirmed' ? 'selected' : ''); ?>>Confirmée</option>
                    <option value="expired"   <?php echo e(request('statut') === 'expired'   ? 'selected' : ''); ?>>Expirée</option>
                    <option value="cancelled" <?php echo e(request('statut') === 'cancelled' ? 'selected' : ''); ?>>Annulée</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 140px;">
                <label class="form-label">Du</label>
                <input type="date" name="date_debut" value="<?php echo e(request('date_debut')); ?>" class="form-input">
            </div>
            <div style="flex: 1; min-width: 140px;">
                <label class="form-label">Au</label>
                <input type="date" name="date_fin" value="<?php echo e(request('date_fin')); ?>" class="form-input">
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn btn-primary">Filtrer</button>
                <a href="<?php echo e(route('reservations.index')); ?>" class="btn btn-outline">Réinitialiser</a>
            </div>
        </form>
    </div>

    <!-- Actions bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <div style="font-size: 14px; color: var(--text-muted);">
            <strong style="color: var(--text);"><?php echo e($reservations->total()); ?></strong> réservation(s) trouvée(s)
        </div>
        <a href="<?php echo e(route('reservations.create')); ?>" class="btn btn-primary btn-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nouvelle réservation
        </a>
    </div>

    <!-- Table -->
    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Espace</th>
                        <th>Période</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Paiement</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <span style="font-family: monospace; font-size: 12px; color: var(--accent); background: rgba(79,126,247,0.08); padding: 3px 8px; border-radius: 6px; white-space: nowrap;"><?php echo e($r->code_confirmation); ?></span>
                        </td>
                        <td>
                            <div style="font-weight: 500; font-size: 14px;"><?php echo e($r->espace->nom); ?></div>
                            <div style="font-size: 11px; color: var(--text-muted);"><?php echo e($r->espace->type_libelle); ?></div>
                        </td>
                        <td style="white-space: nowrap; font-size: 13px; color: var(--text-muted);">
                            <?php echo e($r->period_label); ?>

                        </td>
                        <td>
                            <span class="badge badge-<?php echo e($r->type_reservation === 'daily' ? 'blue' : 'purple'); ?>">
                                <?php echo e($r->type_reservation === 'daily' ? 'Journalier' : 'Horaire'); ?>

                            </span>
                        </td>
                        <td style="font-weight: 700; white-space: nowrap;"><?php echo e(number_format($r->prix_final, 2)); ?> DT</td>
                        <td><span class="badge badge-<?php echo e($r->status_badge['color']); ?>"><?php echo e($r->status_badge['label']); ?></span></td>
                        <td>
                            <?php if($r->latestPaiement): ?>
                                <span class="badge badge-<?php echo e($r->latestPaiement->statut === 'paid' ? 'green' : ($r->latestPaiement->statut === 'pending' ? 'yellow' : 'red')); ?>">
                                    <?php echo e(['paid' => 'Payé', 'pending' => 'En attente', 'failed' => 'Échoué'][$r->latestPaiement->statut] ?? $r->latestPaiement->statut); ?>

                                </span>
                            <?php else: ?>
                                <span class="badge badge-gray">Non payé</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: right; white-space: nowrap;">
                            <a href="<?php echo e(route('reservations.show', $r->id_reservation)); ?>" class="btn btn-outline btn-sm">Voir</a>
                            <?php if($r->isPending()): ?>
                                <a href="<?php echo e(route('reservations.payment', $r->id_reservation)); ?>" class="btn btn-primary btn-sm" style="margin-left: 4px;">Payer</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 48px; color: var(--text-muted);">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 12px; display: block; opacity: 0.3;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <p style="font-size: 15px; margin-bottom: 12px;">Aucune réservation trouvée</p>
                            <a href="<?php echo e(route('reservations.create')); ?>" class="btn btn-primary btn-sm">Créer ma première réservation</a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($reservations->hasPages()): ?>
        <div style="padding: 16px 20px; border-top: 1px solid var(--border);">
            <?php echo e($reservations->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Daboussi\Desktop\coworking\resources\views/user/reservations/index.blade.php ENDPATH**/ ?>