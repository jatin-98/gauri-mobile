

<?php $__env->startSection('title', 'Products | Add'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3><i class="icofont icofont-social-dropbox"></i> Manage Products</h3>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>"><i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Products</li>
                    <li class="breadcrumb-item active">Add</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Product Forms -->
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Tabs -->
            <ul class="nav nav-tabs border-tab nav-secondary mb-4" id="productTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="single-tab" data-bs-toggle="tab" href="#single" role="tab">
                        <i class="icofont icofont-plus-circle"></i> Add Single Product
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="multiple-tab" data-bs-toggle="tab" href="#multiple" role="tab">
                        <i class="icofont icofont-multiple"></i> Add Multiple Products
                    </a>
                </li>
                <li class="nav-item d-none">
                    <a class="nav-link" id="import-tab" data-bs-toggle="tab" href="#import" role="tab">
                        <i class="icofont icofont-upload-alt"></i> Import Products
                    </a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="productTabContent">
                <!-- Single Product -->
                <div class="tab-pane fade show active" id="single" role="tabpanel" aria-labelledby="single-tab">
                    <form class="needs-validation" method="POST" action="<?php echo e(url('/admin/products/add')); ?>" novalidate>
                        <div class="row g-3 mb-3 mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control required" name="product_name" placeholder="Enter product name" required>
                                <div class="invalid-feedback">Please enter a product name.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Stock</label>
                                <input type="number" class="form-control numbers-only required" name="stock" placeholder="Enter available stock" required min="0">
                                <div class="invalid-feedback">Please enter a valid stock quantity.</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Product Description</label>
                                <textarea class="form-control" name="product_description" rows="3" placeholder="Enter product description (optional)"></textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit"> Add Product</button>
                    </form>
                </div>

                <!-- Multiple Products -->
                <div class="tab-pane fade" id="multiple" role="tabpanel" aria-labelledby="multiple-tab">
                    <form class="needs-validation" method="POST" action="<?php echo e(url('/admin/products/add')); ?>" id="multi-product-form" novalidate>
                        <div id="product-wrapper">
                            <div class="product-row row g-3 mb-3 align-items-end mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" class="form-control required" name="product_name[]" placeholder="Enter product name" required>
                                    <div class="invalid-feedback">Please enter product name.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Stock</label>
                                    <input type="text" class="form-control numbers-only required" name="stock[]" placeholder="Enter stock" required min="0">
                                    <div class="invalid-feedback">Please enter stock quantity.</div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Product Description</label>
                                    <textarea class="form-control" name="product_description[]" rows="3" placeholder="Enter product description (optional)"></textarea>
                                </div>
                                <div class="col-md-2 d-flex align-items-end justify-content-center">
                                    <button type="button" class="btn btn-danger remove-row w-100" style="display:none;">
                                        <i class="icofont icofont-bin"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-outline-dark" id="add-more-btn">
                                <i class="icofont icofont-plus-circle"></i> Add More
                            </button>
                            <button class="btn btn-primary" type="submit"><i class="icofont icofont-upload-alt"></i> Submit All</button>
                        </div>
                    </form>
                </div>

                <!-- Import Products -->
                <div class="tab-pane fade text-center py-5" id="import" role="tabpanel" aria-labelledby="import-tab">
                    <h4 class="text-muted"><i data-feather="clock"></i> Import feature coming soon...</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function() {
        feather.replace();

        // Add new product row
        $('#add-more-btn').click(function() {
            let clone = $('#product-wrapper .product-row:first').clone();
            clone.find('input').val('');
            clone.find('.invalid-feedback').text('');
            clone.find('.remove-row').show();
            clone.hide().appendTo('#product-wrapper').slideDown(200);
        });

        // Remove a row
        $(document).on('click', '.remove-row', function() {
            if ($('#product-wrapper .product-row').length > 1) {
                $(this).closest('.product-row').slideUp(200, function() {
                    $(this).remove();
                });
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gg\views/admin/products/add.blade.php ENDPATH**/ ?>