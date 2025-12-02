@extends('admin.layouts.app')

@section('title', 'Invoices | Listing')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css')}}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Invoices</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}"> <i data-feather="home"></i></a></li>
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
@endsection

@section('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>

<script>
    $(document).ready(function() {
    var url = `{{url('/admin/datatable')}}`
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
        editUrl: `{{url('/admin/invoices/edit')}}`
    }
    customDataTable(url,columnData,AdditionalData)
    });
</script>
@endsection