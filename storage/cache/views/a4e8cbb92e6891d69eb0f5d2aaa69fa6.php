


<?php $__env->startSection('title', 'Invoice ' . $invoice[0]->invoice_number); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <!-- Page Title -->
    <div class="page-title">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h3>Invoice <?php echo e($invoice[0]->invoice_number); ?></h3>
            </div>
            <div class="col-12 col-md-6 text-md-end mt-3 mt-md-0">
                <ol class="breadcrumb justify-content-end mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>"><i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Invoices</li>
                    <li class="breadcrumb-item active"><?php echo e($invoice[0]->invoice_number); ?></li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Print Button + Invoice Card -->
    <div class="row">
        <div class="col-12">
            <!-- Invoice Content (Only this prints) -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div id="invoice-print-area">
                        <?php echo $__env->make('admin.invoices.email', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gg\views/admin/invoices/view.blade.php ENDPATH**/ ?>