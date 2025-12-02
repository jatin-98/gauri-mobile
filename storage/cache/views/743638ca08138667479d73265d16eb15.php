

<?php $__env->startSection('title', 'Invoices | Listing'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/datatables.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Invoices</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>"> <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item active">Invoices</li>
                    <!-- <li class="breadcrumb-item active">Products</li> -->
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-none">
                    <h5>All Invoices</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display datatables" id="ajax-data-object">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Invoice Number</th>
                                    <th>Customer Name</th>
                                    <th>Customer Email</th>
                                    <th>Customer Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/js/datatable/datatables/jquery.dataTables.min.js')); ?>"></script>

<script>
    $(document).ready(function() {
    var url = `<?php echo e(url('/admin/datatable')); ?>`
    var columnData = [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'invoice_number', name: 'invoice_number' },
                    { data: 'customer_name', name: 'customer_name' },
                    { data: 'customer_email', name: 'customer_email' },
                    { data: 'customer_phone', name: 'customer_phone' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
    var AdditionalData = {
        tableName: 'invoices', 
        searchableColumns:['invoice_number', 'customer_name', 'customer_email', 'customer_phone'],
        orderbyColumns: ['invoice_number', 'customer_name', 'customer_email', 'customer_phone'],
        includeViewButton: 'includeViewButton',
        editUrl: `<?php echo e(url('/admin/invoices/edit')); ?>`
    }
    customDataTable(url,columnData,AdditionalData)
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gaurimobiles\views/admin/invoices/index.blade.php ENDPATH**/ ?>