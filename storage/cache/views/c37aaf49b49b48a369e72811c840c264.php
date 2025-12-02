<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'My App'); ?></title>

    <link rel="icon" href="<?php echo e(asset('uploads/logo/faav.png')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/vendors/bootstrap.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/color-1.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/responsive.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/sweet-alert/sweetalert2.min.css')); ?>">
    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body>

    <?php echo $__env->yieldContent('content'); ?>

    <script src="<?php echo e(asset('assets/js/jquery-3.5.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/script.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/sweet-alert/sweetalert2.all.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/custom.js')); ?>"></script>
    <script>
        const successMessage = `<?php echo e(\App\Core\Session::getFlash('success') ?? ''); ?>`;
        const errorMessage = `<?php echo e(\App\Core\Session::getFlash('error') ?? ''); ?>`;

        if (successMessage) showToast('success', successMessage);
        if (errorMessage) showToast('error', errorMessage);
    </script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\gaurimobiles\views/layouts/app.blade.php ENDPATH**/ ?>