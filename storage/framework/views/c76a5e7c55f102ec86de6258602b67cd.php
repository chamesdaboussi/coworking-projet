<?php $__env->startSection('title', 'Utilisateurs'); ?>
<?php $__env->startSection('page-title', 'Gestion des utilisateurs'); ?>
<?php $__env->startSection('content'); ?>
<div class="fade-in">
    <div class="card" style="padding: 0; overflow: hidden;">
        <table class="table">
            <thead><tr><th>Utilisateur</th><th>Email</th><th>Téléphone</th><th>Réservations</th><th>Rôle</th><th>Inscrit le</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><strong><?php echo e($user->full_name); ?></strong></td>
                    <td style="color: var(--text-muted);"><?php echo e($user->email); ?></td>
                    <td style="color: var(--text-muted);"><?php echo e($user->telephone ?? '—'); ?></td>
                    <td style="text-align: center; font-weight: 600;"><?php echo e($user->reservations_count); ?></td>
                    <td><span class="badge badge-<?php echo e($user->role === 'admin' ? 'purple' : 'blue'); ?>"><?php echo e($user->role); ?></span></td>
                    <td style="color: var(--text-muted);"><?php echo e($user->created_at->format('d/m/Y')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" style="text-align: center; padding: 32px; color: var(--text-muted);">Aucun utilisateur.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if($users->hasPages()): ?><div style="padding: 16px;"><?php echo e($users->links()); ?></div><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\yassin\Desktop\coworking\resources\views/admin/users/index.blade.php ENDPATH**/ ?>