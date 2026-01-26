<?php $__env->startSection('title', 'Login Page'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card my-5">
        <form method="POST" action="<?php echo e(route('login.post')); ?>">
            <?php echo csrf_field(); ?>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h3 class="mb-0"><b>Login</b></h3>
                    <a href="/register" class="link-primary">Don't have an account?</a>
                </div>
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">

                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div><?php echo e($error); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                <?php endif; ?>
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                <div class="form-group mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" placeholder="Email Address"
                        value="<?php echo e(session('registered_email')); ?>" autocomplete="off" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password</label>

                    <?php if(session('registered_email')): ?>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password"
                            autofocus required>
                    <?php else: ?>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password"
                            required>
                    <?php endif; ?>
                </div>
                <div class="d-flex mt-1 justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" name="remember">
                        <label class="form-check-label text-muted" for="customCheckc1">Keep me sign
                            in</label>
                    </div>
                    <a href="<?php echo e(route('forgot_password.email_form')); ?>" class="text-secondary f-w-400">Forgot Password?</a>
                </div>
                <div class="form-group mb-3 mt-3">
                    <div style="display: flex; justify-content: center;">
                        <?php echo NoCaptcha::display(['data-theme' => 'light']); ?>

                    </div>
                    <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger small d-block mt-2 text-center"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                <?php echo $__env->make('auth.sso', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\ukk2526\resources\views/auth/login.blade.php ENDPATH**/ ?>