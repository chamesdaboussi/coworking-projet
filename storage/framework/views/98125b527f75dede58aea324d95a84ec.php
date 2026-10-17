<?php $__env->startSection('content'); ?>
<div style="min-height: 100vh; display: flex; background: var(--surface); position: relative; overflow: hidden;">
    <!-- Background decoration -->
    <div style="position: absolute; top: -200px; right: -200px; width: 600px; height: 600px; background: radial-gradient(circle, rgba(79,126,247,0.08) 0%, transparent 70%); pointer-events: none;"></div>
    <div style="position: absolute; bottom: -200px; left: -200px; width: 500px; height: 500px; background: radial-gradient(circle, rgba(124,95,207,0.06) 0%, transparent 70%); pointer-events: none;"></div>

    <!-- Left Cadre (Info/Welcome Section) -->
    <div style="flex: 1; background: linear-gradient(135deg, #4f7ef7, #7c5fcf); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
        
        <div style="text-align: center; color: white; padding: 40px; max-width: 80%;">
            <div style="font-size: 72px; margin-bottom: 24px;">🏢</div>
            <h1 style="font-family: 'Poppins', sans-serif; font-size: 36px; font-weight: 800; margin-bottom: 16px;">Bienvenue sur CoWork</h1>
            <p style="font-size: 18px; opacity: 0.9; margin-bottom: 32px; line-height: 1.6;">
                Votre plateforme de coworking moderne.<br>
                Collaborez, partagez et réussissez ensemble.
            </p>
        </div>
    </div>

    <!-- Right Side: Form Section -->
    <div style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 24px;">
        <div style="width: 100%; max-width: 460px;" class="fade-in">
            <!-- Logo (small version) -->
            <div style="text-align: center; margin-bottom: 32px;">
                <div style="display: inline-flex; align-items: center; gap: 12px;">
                    <div style="background: linear-gradient(135deg, #4f7ef7, #7c5fcf); border-radius: 14px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                    <span style="font-family: 'Poppins', sans-serif; font-size: 26px; font-weight: 800; color: var(--text);">Co<span style="background: linear-gradient(135deg, #4f7ef7, #7c5fcf); -webkit-background-clip: text; background-clip: text; color: transparent;">Work</span></span>
                </div>
                <p style="color: var(--text-muted); font-size: 15px; margin-top: 12px;">Connectez-vous à votre espace de travail</p>
            </div>

            <!-- Card (Form) -->
            <div class="card" style="background: var(--surface2); border: 1px solid var(--border); box-shadow: 0 24px 48px rgba(0,0,0,0.1); border-radius: 24px;">
                <h2 style="font-family: 'Poppins', sans-serif; font-size: 24px; font-weight: 700; margin-bottom: 28px; text-align: center;">Connexion</h2>

                <?php if($errors->any()): ?>
                    <div class="alert alert-error" style="background: rgba(220,53,69,0.1); border-left: 3px solid #dc3545; padding: 12px 16px; border-radius: 12px; margin-bottom: 24px;">
                        <?php echo e($errors->first()); ?>

                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('login.post')); ?>">
                    <?php echo csrf_field(); ?>
                    <div style="margin-bottom: 20px;">
                        <label class="form-label" style="display: block; margin-bottom: 8px; font-weight: 500;">Adresse email</label>
                        <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="form-input" placeholder="votre@email.com" required autofocus
                               style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border); background: var(--surface); transition: all 0.2s;">
                    </div>
                    <div style="margin-bottom: 24px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <label class="form-label" style="font-weight: 500;">Mot de passe</label>
                            <a href="#" style="font-size: 13px; color: var(--accent-light); text-decoration: none;">Mot de passe oublié ?</a>
                        </div>
                        <input type="password" name="password" class="form-input" placeholder="••••••••" required
                               style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border); background: var(--surface);">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; justify-content: center; padding: 14px; border-radius: 40px; font-weight: 600; display: flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #4f7ef7, #7c5fcf); border: none; color: white;">
                        Se connecter
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </button>
                </form>
            </div>

            <p style="text-align: center; margin-top: 28px; color: var(--text-muted); font-size: 14px;">
                Pas encore de compte ?
                <a href="<?php echo e(route('register')); ?>" style="color: #4f7ef7; font-weight: 600; text-decoration: none;">Créer un compte</a>
            </p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\yassin\Desktop\coworking\resources\views/auth/login.blade.php ENDPATH**/ ?>