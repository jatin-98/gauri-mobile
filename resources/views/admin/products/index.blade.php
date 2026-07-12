@extends('admin.layouts.app')

@section('title', 'Products | Listing')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css')}}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Products</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}"> <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item active">Products</li>
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
                                    <th>Stock</th>
                                    <th>Description</th>
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
@endsection

@section('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>

<script>
    $(document).ready(function() {
    var url = `{{url('/admin/datatable')}}`

    var columnData = [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'stock', name: 'stock' },
                    { data: 'product_description', name: 'product_description' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]

    var AdditionalData = {
        tableName: 'products', 
        searchableColumns:['product_name', 'stock', 'product_description'],
        orderbyColumns: ['product_name', 'stock', 'product_description'],
        editUrl: `{{url('/admin/products/edit')}}`
    }

    customDataTable(url,columnData,AdditionalData)
    });
</script>
@endsection