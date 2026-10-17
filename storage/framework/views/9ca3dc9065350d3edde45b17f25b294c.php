<?php $__env->startSection('title', 'Utilisateurs'); ?>
<?php $__env->startSection('page-title', 'Gestion des utilisateurs'); ?>

<?php $__env->startSection('content'); ?>
<div class="fade-in">

<div class="card" style="padding:0;overflow:hidden;">
    <div style="padding:18px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
        <div>
            <h3 style="font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;margin:0;">Tous les utilisateurs</h3>
            <p style="color:var(--text-muted);font-size:13px;margin:2px 0 0;"><?php echo e($users->total()); ?> compte(s) enregistré(s)</p>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th style="text-align:center;">Réservations</th>
                <th>Rôle</th>
                <th>Inscrit le</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:34px;height:34px;border-radius:8px;background:linear-gradient(135deg,#ff8247,#4cbcbe);display:flex;align-items:center;justify-content:center;font-weight:700;color:white;font-size:13px;flex-shrink:0;">
                            <?php echo e(strtoupper(substr($user->prenom ?? $user->nom, 0, 1))); ?>

                        </div>
                        <div>
                            <div style="font-weight:600;font-size:13px;"><?php echo e($user->full_name); ?></div>
                            <?php if($user->role === 'admin'): ?>
                            <div style="font-size:11px;color:var(--accent);font-weight:600;">Administrateur</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                <td style="color:var(--text-muted);font-size:13px;"><?php echo e($user->email); ?></td>
                <td style="color:var(--text-muted);font-size:13px;"><?php echo e($user->telephone ?? '—'); ?></td>
                <td style="text-align:center;font-weight:600;"><?php echo e($user->reservations_count); ?></td>
                <td>
                    <span class="badge badge-<?php echo e($user->role === 'admin' ? 'purple' : 'blue'); ?>">
                        <?php echo e($user->role === 'admin' ? 'Admin' : 'Utilisateur'); ?>

                    </span>
                </td>
                <td style="color:var(--text-muted);font-size:12px;"><?php echo e($user->created_at->format('d/m/Y')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--text-muted);">Aucun utilisateur.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if($users->hasPages()): ?>
    <div style="padding:14px 20px;border-top:1px solid var(--border);"><?php echo e($users->links()); ?></div>
    <?php endif; ?>
</div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Daboussi\Desktop\coworking\resources\views/admin/users/index.blade.php ENDPATH**/ ?>