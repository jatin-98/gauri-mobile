

<?php $__env->startSection('title', 'Sales | Listing'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/vendors/datatables.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3><i class="icon-bar-chart"></i> Sales</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>"> <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item active">Sales</li>
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
                    <h5>All Products</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display datatables" id="ajax-data-object">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Product Name</th>
                                    <th>Cost Price</th>
                                    <th>Sell Price</th>
                                    <th>Handling Charges</th>
                                    <th>Profit</th>
                                    <th>Sale Date</th>
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
                    { data: 'product_name', name: 'product_name' },
                    { data: 'cost_price', name: 'cost_price', render: (data) => {return `₹${parseInt(data)}`} },
                    { data: 'sell_price', name: 'sell_price', render: (data) => {return `₹${parseInt(data)}`} },
                    { data: 'handling_charges', name: 'handling_charges', render: (data) => {return `₹${parseInt(data)}`} },
                    { data: 'profit', name: 'profit', render: (data) => {return `₹${parseInt(data)}`} },
                    { data: 'sale_date', name: 'sale_date'},
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]

    var AdditionalData = {
        tableName: 'sales', 
        searchableColumns:['product_name', 'cost_price', 'sell_price', 'handling_charges', 'profit', 'sale_date'],
        orderbyColumns: ['product_name', 'cost_price', 'sell_price', 'handling_charges', 'profit', 'sale_date'],
        editUrl: `<?php echo e(url('/admin/sales/edit')); ?>`
    }

    customDataTable(url,columnData,AdditionalData)
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gaurimobiles\views/admin/sales/index.blade.php ENDPATH**/ ?>