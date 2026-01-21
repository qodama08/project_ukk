<?php $__env->startSection('title', 'Forgot Your Password ?'); ?>

<?php $__env->startSection('content'); ?>

    <div class="card my-5">
        <form method="POST" action="<?php echo e(route('forgot_password.send_link')); ?>">
            <?php echo csrf_field(); ?>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h3 class="mb-0"><b>Forgot Password</b></h3>
                    <a href="<?php echo e(route('login')); ?>" class="link-primary">Back to Login</a>
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
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Email Address"
                        autocomplete="off" autofocus required>
                </div>
                <p class="mt-4 text-sm text-muted">Do not forgot to check SPAM box.</p>
                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary">Send Password Reset Email</button>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC_\bk_ukk\resources\views/auth/forgot-password/email.blade.php ENDPATH**/ ?>