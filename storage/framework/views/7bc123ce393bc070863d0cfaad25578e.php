<?php $__env->startSection('title', 'Register Page'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card my-5">
        <form action="<?php echo e(route('register')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h3 class="mb-0"><b>Sign up</b></h3>
                    <a href="/login" class="link-primary">Already have an account?</a>
                </div>
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">

                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div><?php echo e($error); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                <?php endif; ?>
                <div class="form-group mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" required name="name" placeholder="Nama Lengkap"
                        autocomplete="off">
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Email Address*</label>
                    <input type="email" class="form-control" required name="email" placeholder="Email Address"
                        autocomplete="off">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" required name="password" placeholder="Password">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Password Confirmation</label>
                    <input type="password" class="form-control" required name="password_confirmation"
                        placeholder="Password Confirmation">
                </div>
                <div class="form-group mb-3 mt-3">
                    <?php echo NoCaptcha::display(['data-theme' => 'light']); ?>

                    <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger small d-block mt-2"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <p class="mt-4 text-sm text-muted">By Signing up, you agree to our <a href="#" class="text-primary">
                        Terms
                        of Service </a> and <a href="#" class="text-primary"> Privacy Policy</a></p>
                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
                <?php echo $__env->make('auth.sso', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            </div>

        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC_\bk_ukk2526\resources\views/auth/register.blade.php ENDPATH**/ ?>