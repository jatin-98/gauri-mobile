

<?php $__env->startSection('title', 'Sales | Edit'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <!-- Page Header -->
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3><i class="icon-bar-chart"></i> Edit Sale</h3>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>"><i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Sales</li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>

</div>

<!-- Edit Sale Form -->
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body">

                <form class="needs-validation" method="POST" action="<?php echo e(url('/admin/sales/update')); ?>" novalidate>
                <input type="hidden" name="id" value="<?php echo e($sale->id); ?>">

                <div class="row g-3 mt-2">

                    <!-- Product Name -->
                    <div class="col-md-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control required" name="product_name" value="<?php echo e($sale->product_name); ?>" required>
                        <div class="invalid-feedback">Please enter a product name.</div>
                    </div>

                    <!-- Cost Price -->
                    <div class="col-md-3">
                        <label class="form-label">Cost Price (₹)</label>
                        <input type="text" class="form-control numbers-only" name="cost_price" value="<?php echo e((int)$sale->cost_price); ?>" step="0.01" min="0" required>
                        <div class="invalid-feedback">Please enter a cost price.</div>
                    </div>

                    <!-- Sell Price -->
                    <div class="col-md-3">
                        <label class="form-label">Sell Price (₹)</label>
                        <input type="text" class="form-control numbers-only" name="sell_price" value="<?php echo e((int)$sale->sell_price); ?>" step="0.01" min="0" required>
                        <div class="invalid-feedback">Please enter a sell price.</div>
                    </div>

                    <!-- Handling Charges -->
                    <div class="col-md-3">
                        <label class="form-label">Handling Charges (₹)</label>
                        <input type="text" class="form-control numbers-only" name="handling_charges" value="<?php echo e((int)$sale->handling_charges); ?>" step="0.01" min="0" required>
                        <div class="invalid-feedback">Please enter handling charges.</div>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">
                        Update Sale
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gg\views/admin/sales/edit.blade.php ENDPATH**/ ?>