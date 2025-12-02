

<?php $__env->startSection('title', 'Products | Edit'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3><i class="icofont icofont-social-dropbox"></i> Update Product</h3>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>"><i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Products</li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Product Forms -->
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body">

            <!-- Tab Content -->
            <!-- Single Product -->
            <div class="tab-pane fade show active" id="single" role="tabpanel" aria-labelledby="single-tab">
                <form class="needs-validation" method="POST" action="<?php echo e(url('/admin/products/edit')); ?>" novalidate>
                    <div class="row g-3 mb-3 mt-3">
                        <input type="hidden" name="id" value="<?php echo e($product->id); ?>">
                        <div class="col-md-6">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control required" name="product_name" value="<?php echo e($product->product_name); ?>" required>
                            <div class="invalid-feedback">Please enter a product name.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stock</label>
                            <input type="text" class="form-control numbers-only required" name="stock" value="<?php echo e($product->stock); ?>" required min="0">
                            <div class="invalid-feedback">Please enter a valid stock quantity.</div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Product Description</label>
                            <textarea class="form-control" name="product_description" rows="3" placeholder="Enter product description (optional)"><?php echo e($product->product_description); ?></textarea>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit"> Update Product</button>
                </form>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gg\views/admin/products/edit.blade.php ENDPATH**/ ?>