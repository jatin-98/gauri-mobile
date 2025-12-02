<form class="needs-validation" method="POST" action="<?php echo e(url('/admin/settings/insert')); ?>" novalidate>
    <div class="row g-3 mb-3 mt-3">
        <div class="col-md-6">
            <label class="form-label fw-semibold">Enter Key</label>
            <input type="text" class="form-control required" name="key" placeholder="Enter Key">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Enter Value</label>
            <input type="text" class="form-control required" name="value" placeholder="Enter Value">
        </div>
    </div>
    <button class="btn btn-primary" type="submit"> Create Configuration</button>
</form><?php /**PATH C:\xampp\htdocs\gauri-mobiles\views/admin/settings/create.blade.php ENDPATH**/ ?>