<?php $__env->startSection('title', 'Paiements'); ?>
<?php $__env->startSection('page-title', 'Paiements'); ?>

<?php $__env->startSection('content'); ?>
<div class="fade-in">

    
    <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:14px;margin-bottom:24px;">
        <div class="stat-card" style="text-align:center;">
            <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;">Total encaissé</div>
            <div style="font-size:22px;font-weight:800;color:var(--accent);"><?php echo e(number_format($stats['total_paid'], 2)); ?> DT</div>
        </div>
        <div class="stat-card" style="text-align:center;">
            <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;">Payés</div>
            <div style="font-size:22px;font-weight:800;color:#16a34a;"><?php echo e($stats['count_paid']); ?></div>
        </div>
        <div class="stat-card" style="text-align:center;">
            <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;">En attente</div>
            <div style="font-size:22px;font-weight:800;color:#d97706;"><?php echo e($stats['count_pending']); ?></div>
        </div>
        <div class="stat-card" style="text-align:center;">
            <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;">Cartes de crédit</div>
            <div style="font-size:22px;font-weight:800;color:var(--text);"><?php echo e($stats['count_stripe']); ?></div>
        </div>
        <div class="stat-card" style="text-align:center;">
            <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;">Cash</div>
            <div style="font-size:22px;font-weight:800;color:var(--text);"><?php echo e($stats['count_cash']); ?></div>
        </div>
    </div>

    
    <div class="card" style="padding:0;overflow:hidden;">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Espace</th>
                    <th>Réservation</th>
                    <th>Méthode</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $paiements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $r = $p->reservation;
                    $u = $r?->utilisateur;
                ?>
                <tr>
                    <td style="color:var(--text-muted);font-size:12px;"><?php echo e($p->id_paiement); ?></td>
                    <td>
                        <?php if($u): ?>
                            <div style="font-weight:600;font-size:13px;"><?php echo e($u->full_name); ?></div>
                            <div style="color:var(--text-muted);font-size:12px;"><?php echo e($u->email); ?></div>
                        <?php else: ?>
                            <span style="color:var(--text-muted);">—</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:13px;"><?php echo e($r?->espace?->nom ?? '—'); ?></td>
                    <td>
                        <?php if($r): ?>
                            <a href="<?php echo e(route('reservations.show', $r->id_reservation)); ?>"
                               style="font-family:monospace;font-size:12px;color:var(--accent);text-decoration:none;font-weight:700;">
                                <?php echo e($r->code_confirmation); ?>

                            </a>
                        <?php else: ?>
                            <span style="color:var(--text-muted);">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($p->methode === 'stripe'): ?>
                            <span class="badge badge-blue">Carte de crédit</span>
                        <?php elseif($p->methode === 'cash'): ?>
                            <span class="badge badge-purple">Espèces</span>
                        <?php else: ?>
                            <span class="badge badge-gray"><?php echo e(ucfirst($p->methode)); ?></span>
                        <?php endif; ?>
                    </td>
                    <td style="font-weight:700;"><?php echo e(number_format($p->montant, 2)); ?> DT</td>
                    <td>
                        <?php if($p->statut === 'paid'): ?>
                            <span class="badge badge-green">Payé</span>
                        <?php elseif($p->statut === 'pending'): ?>
                            <span class="badge badge-yellow">En attente</span>
                        <?php else: ?>
                            <span class="badge badge-red">Échoué</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:12px;color:var(--text-muted);white-space:nowrap;">
                        <?php echo e($p->paid_at ? $p->paid_at->format('d/m/Y H:i') : $p->created_at->format('d/m/Y H:i')); ?>

                    </td>
                    <td>
                        <?php if($r && $p->methode === 'cash' && $p->statut === 'pending'): ?>
                            <form method="POST" action="<?php echo e(route('admin.reservations.validateCash', $r->id_reservation)); ?>">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-success btn-sm" onclick="return confirm('Valider ce paiement cash ?')">
                                    Valider
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9" style="text-align:center;color:var(--text-muted);padding:40px;">
                        Aucun paiement trouvé.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <?php if($paiements->hasPages()): ?>
    <div style="margin-top:18px;display:flex;justify-content:center;">
        <?php echo e($paiements->links()); ?>

    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Daboussi\Desktop\coworking\resources\views/admin/payments/index.blade.php ENDPATH**/ ?>