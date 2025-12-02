

<?php $__env->startSection('title', 'Invoice | Edit'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-6">
                <h3><i class="icofont icofont-paper"></i> Edit Invoice #<?php echo e($invoice->invoice_number); ?></h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>"><i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Invoice</li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form class="needs-validation" method="POST" action="<?php echo e(url('/admin/invoices/update')); ?>" novalidate>
                <h5 class="mb-3 text-secondary fw-bold">Customer Information</h5>
                <div class="row g-3 mb-4">
                    <input type="hidden" name="invoice_id" value="<?php echo e($invoice->id); ?>">
                    <div class="col-md-4">
                        <label class="form-label">Customer Name</label>
                        <input class="form-control required letters-only" type="text" name="customer_name" value="<?php echo e($invoice->customer_name); ?>" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Customer Email</label>
                        <input class="form-control required email-only" type="email" name="customer_email" value="<?php echo e($invoice->customer_email); ?>" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Phone Number</label>
                        <input class="form-control required numbers-only" type="tel" name="customer_phone" value="<?php echo e($invoice->customer_phone); ?>" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-12">
                        <label class="form-label">Billing Address</label>
                        <textarea class="form-control required" name="billing_address" rows="2" required><?php echo e($invoice->billing_address); ?></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <hr>

                <h5 class="mb-3 text-secondary fw-bold">Products</h5>
                <div id="product-rows">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row g-3 align-items-end mb-3 product-row">
                        <input type="hidden" name="item_id[]" value="<?php echo e($item->id); ?>">
                        <div class="col-md-4">
                            <label class="form-label">Product Name</label>
                            <input class="form-control required" type="text" name="product_name[]" value="<?php echo e($item->product_name); ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Quantity</label>
                            <input class="form-control required numbers-only" type="number" name="quantity[]" value="<?php echo e($item->quantity); ?>" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Price (₹)</label>
                            <input class="form-control required numbers-only" type="number" step="0.01" name="price[]" value="<?php echo e((int)$item->price); ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Total (₹)</label>
                            <input class="form-control total-field" type="text" name="invoice_item_total[]" value="<?php echo e($item->total); ?>" readonly>
                        </div>
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn btn-danger remove-row"><i data-feather="trash-2"></i></button>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <button type="button" class="btn btn-sm btn-outline-success mb-4" id="add-product-row">
                    <i class="icofont icofont-plus-circle"></i> Add Another Product
                </button>

                <hr>

                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Subtotal (₹)</label>
                        <input class="form-control" type="number" step="0.01" name="subtotal" value="<?php echo e($invoice->subtotal); ?>" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Discount (₹)</label>
                        <input class="form-control" type="text" name="discount" value="<?php echo e($invoice->discount); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Total Payable (₹)</label>
                        <input class="form-control" type="number" step="0.01" name="total" value="<?php echo e($invoice->total); ?>" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payment Method</label>
                        <select class="form-select required" name="payment_method" required>
                            <option value="">Select Method</option>
                            <option value="Cash" <?php echo e($invoice->payment_method == 'Cash' ? 'selected' : ''); ?>>Cash</option>
                            <option value="Credit Card" <?php echo e($invoice->payment_method == 'Credit Card' ? 'selected' : ''); ?>>Credit Card</option>
                            <option value="UPI" <?php echo e($invoice->payment_method == 'UPI' ? 'selected' : ''); ?>>UPI</option>
                            <option value="Bank Transfer" <?php echo e($invoice->payment_method == 'Bank Transfer' ? 'selected' : ''); ?>>Bank Transfer</option>
                        </select>
                        <div class="invalid-feedback">Please select a payment method.</div>
                    </div>
                </div>

                <div id="deleted-items-container"></div>

                <div class="text-end">
                    <button class="btn btn-primary" type="submit">Update Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function() {
        feather.replace();

        $('#add-product-row').on('click', function() {
            let newRow = $('.product-row:first').clone();
            newRow.find('input').val('');
            $('#product-rows').append(newRow);
        });

        $(document).on('click', '.remove-row', function() {
            let row = $(this).closest('.product-row');

            let itemId = row.find('input[name="item_id[]"]').val();

            if (itemId) {
                $('#deleted-items-container').append(
                    `<input type="hidden" name="deleted_items[]" value="${itemId}">`
                );
            }

            if ($('.product-row').length > 1) {
                row.remove();
                updateSubtotal();
            }
        });

        $(document).on('input', 'input[name^="quantity"], input[name^="price"]', function() {
            let row = $(this).closest('.product-row');
            let qty = parseFloat(row.find('input[name^="quantity"]').val()) || 0;
            let price = parseFloat(row.find('input[name^="price"]').val()) || 0;
            let total = qty * price;
            row.find('.total-field').val(total.toFixed(2));
            updateSubtotal();
        });

        $('input[name="discount"]').on('input', function() {
            updateSubtotal();
        });

        function updateSubtotal() {
            let subtotal = 0;
            $('.total-field').each(function() {
                subtotal += parseFloat($(this).val()) || 0;
            });
            $('input[name="subtotal"]').val(subtotal.toFixed(2));

            let discount = parseFloat($('input[name="discount"]').val()) || 0;
            let total = subtotal - discount;
            $('input[name="total"]').val(total.toFixed(2));
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gg\views/admin/invoices/edit.blade.php ENDPATH**/ ?>