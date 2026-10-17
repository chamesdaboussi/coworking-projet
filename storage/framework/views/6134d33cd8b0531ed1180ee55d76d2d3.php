<?php if($paginator->hasPages()): ?>
<nav style="display: flex; align-items: center; justify-content: center; gap: 6px; flex-wrap: wrap;">
    
    <?php if($paginator->onFirstPage()): ?>
        <span style="padding: 8px 14px; border-radius: 8px; font-size: 13px; color: var(--text-muted); background: var(--surface3); border: 1px solid var(--border); cursor: not-allowed; opacity: 0.5;">← Précédent</span>
    <?php else: ?>
        <a href="<?php echo e($paginator->previousPageUrl()); ?>" style="padding: 8px 14px; border-radius: 8px; font-size: 13px; color: var(--text); background: var(--surface3); border: 1px solid var(--border); text-decoration: none; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--accent)'; this.style.color='var(--accent-light)';" onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--text)';">← Précédent</a>
    <?php endif; ?>

    
    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(is_string($element)): ?>
            <span style="padding: 8px 10px; color: var(--text-muted); font-size: 13px;"><?php echo e($element); ?></span>
        <?php endif; ?>

        <?php if(is_array($element)): ?>
            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($page == $paginator->currentPage()): ?>
                    <span style="padding: 8px 14px; border-radius: 8px; font-size: 13px; font-weight: 700; color: white; background: var(--accent); border: 1px solid var(--accent);"><?php echo e($page); ?></span>
                <?php else: ?>
                    <a href="<?php echo e($url); ?>" style="padding: 8px 14px; border-radius: 8px; font-size: 13px; color: var(--text); background: var(--surface3); border: 1px solid var(--border); text-decoration: none; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--accent)'; this.style.color='var(--accent-light)';" onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--text)';"><?php echo e($page); ?></a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <?php if($paginator->hasMorePages()): ?>
        <a href="<?php echo e($paginator->nextPageUrl()); ?>" style="padding: 8px 14px; border-radius: 8px; font-size: 13px; color: var(--text); background: var(--surface3); border: 1px solid var(--border); text-decoration: none; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--accent)'; this.style.color='var(--accent-light)';" onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--text)';">Suivant →</a>
    <?php else: ?>
        <span style="padding: 8px 14px; border-radius: 8px; font-size: 13px; color: var(--text-muted); background: var(--surface3); border: 1px solid var(--border); cursor: not-allowed; opacity: 0.5;">Suivant →</span>
    <?php endif; ?>
</nav>
<?php endif; ?>
<?php /**PATH C:\Users\Daboussi\Desktop\coworking (4)\coworking\resources\views/vendor/pagination/custom.blade.php ENDPATH**/ ?>