

<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 p-0">
            <div class="login-card">
                <div>
                    <div>
                        <a class="logo" href="#">
                            <img class="img-fluid for-light" src="<?php echo e(asset('uploads/logo/Original.png')); ?>" alt="looginpage" style="max-width: 275px; height: auto;">
                            <img class="img-fluid for-dark" src="../assets/images/logo/logo_dark.png" alt="looginpage">
                        </a>
                    </div>
                    <div class="login-main">
                        <form class="theme-form" method="POST" action="<?php echo e(url('/register')); ?>">
                            <h4>Create your account</h4>
                            <p>Enter your personal details to create account</p>
                            <div class="form-group">
                                <label class="col-form-label pt-0">Your Name</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input class="form-control letters-only" name="first_name" type="text" required="" placeholder="First name">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-6">
                                        <input class="form-control letters-only" name="last_name" type="text" required="" placeholder="Last name">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Email Address</label>
                                <input class="form-control email-only" type="email" name="email" required="" placeholder="Test@gmail.com">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Password</label>
                                <div class="form-input position-relative">
                                    <input class="form-control required" type="password" name="password" required="" placeholder="*********">
                                    <div class="invalid-feedback"></div>
                                    <div class="show-hide"><span class="show"></span></div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <button class="btn btn-primary btn-block w-100" type="submit">Create Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/js/form.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gg\views/register.blade.php ENDPATH**/ ?>