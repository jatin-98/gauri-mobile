<form class="needs-validation" method="POST" action="<?php echo e(url('/admin/settings/update')); ?>" novalidate>
    <div class="row g-3 mb-3 mt-3">
        <div class="col-md-6">
            <label class="form-label fw-semibold">SMTP Host</label>
            <input type="text" class="form-control required" name="smtp_host" value="<?php echo e($emailConfig['smtp_host'] ?? null); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">SMTP Port</label>
            <input type="number" class="form-control required" name="smtp_port" value="<?php echo e($emailConfig['smtp_port'] ?? null); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">SMTP Username</label>
            <input type="text" class="form-control required" name="smtp_username" value="<?php echo e($emailConfig['smtp_username'] ?? null); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">SMTP Password</label>
            <input type="password" class="form-control" name="smtp_password" placeholder="Leave blank to keep current">
        </div>
        <div class="col-md-12">
            <label class="form-label fw-semibold">From Email</label>
            <input type="email" class="form-control required" name="from_email" value="<?php echo e($emailConfig['from_email'] ?? null); ?>" required>
        </div>
    </div>
    <button class="btn btn-primary" type="submit"> Update Configuration</button>
</form><?php /**PATH C:\xampp\htdocs\gaurimobiles\views/admin/settings/email.blade.php ENDPATH**/ ?>