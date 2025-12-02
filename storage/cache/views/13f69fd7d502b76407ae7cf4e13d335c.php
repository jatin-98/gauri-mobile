


<?php $__env->startSection('title', 'Invoice ' . $invoice[0]->invoice_number); ?>

<?php $__env->startSection('styles'); ?>
<style>
    div#invoice-print-area {
        padding-top: 2rem;
        padding-bottom: 1rem;
    }
</style>
<?php $__env->stopSection(); ?>

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

    <!-- Action Buttons -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-wrap gap-3 justify-content-start align-items-center">

                <!-- Send Email Button -->
                <button class="btn btn-outline-success d-flex align-items-center gap-1" id="sendInvoiceBtn" data-id="<?php echo e($invoice[0]->invoice_id); ?>">
                    <i data-feather="send" width="18" height="18"></i>
                    <span>Send to Customer</span>
                    <small class="opacity-75">(via Email)</small>
                </button>

                <!-- Print Invoice Button -->
                <button onclick="printInvoice()" class="btn btn-outline-dark d-flex align-items-center gap-1">
                    <i data-feather="printer" width="19" height="19"></i>
                    <span>Print Invoice</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Invoice Content -->
    <div class="row">
        <div class="col-12">
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

<?php $__env->startSection('scripts'); ?>
<script>
    function printInvoice() {
        const printContent = document.getElementById('invoice-print-area').innerHTML;
        const originalContent = document.body.innerHTML;

        document.body.innerHTML = printContent;
        window.print();

        const mediaQueryList = window.matchMedia('print');

        mediaQueryList.addEventListener('change', function(e) {
            if (!e.matches) {
                document.body.innerHTML = originalContent;

                if (typeof feather !== "undefined") {
                    feather.replace();
                }

                window.location.reload();
            }
        });
    }

    $('#sendInvoiceBtn').on('click', function() {
        let invoiceId = $(this).data('id');
        const $button = $(this);

        $.ajax({
            url: "<?php echo e(url('/admin/send-invoice-to-customer/')); ?>",
            method: "POST",
            data: {
                invoiceId: invoiceId
            },
            beforeSend: function() {
                $button
                    .removeClass('btn-outline-success')
                    .addClass('btn-success')
                    .prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');
            },
            success: function(response) {
                showToast("success", "Invoice sent successfully!");
            },
            error: function(xhr) {
                let message = "Failed to send invoice.";
                showToast("error", message);
            },
            complete: function() {
                $button
                    .removeClass('btn-success')
                    .addClass('btn-outline-success')
                    .prop('disabled', false)
                    .html('Send Invoice');
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gauri-mobiles\views/admin/invoices/view.blade.php ENDPATH**/ ?>