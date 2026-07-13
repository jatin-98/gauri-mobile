@extends('admin.layouts.app')

@section('title', 'Sales | Edit')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Header -->
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3><i class="icon-bar-chart"></i> Edit Sale</h3>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}"><i data-feather="home"></i></a></li>
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

            <form class="needs-validation" method="POST" action="{{ url('/admin/sales/update') }}" novalidate>
    {!! csrf_field() !!}

                <input type="hidden" name="id" value="{{ $sale->id }}">
                <input type="hidden" name="product_name" id="product_name" value="{{ $sale->product_name }}">

                <div class="row g-3 mt-2">

                    <!-- Product Name (Select2) -->
                    <div class="col-md-3">
                        <label class="form-label">Product Name</label>

                        <select class="js-example-basic-single col-sm-12 required" name="product_id" required>
                            <!-- Preselected option -->
                            <option value="{{ $sale->product_id }}" selected>{{ $sale->product_name }}</option>
                        </select>

                        <div class="invalid-feedback">Please select a product name.</div>
                    </div>

                    <!-- Cost Price -->
                    <div class="col-md-3">
                        <label class="form-label">Cost Price (₹)</label>
                        <input type="text" class="form-control numbers-only"
                            name="cost_price"
                            value="{{ (int)$sale->cost_price }}" required>
                    </div>

                    <!-- Sell Price -->
                    <div class="col-md-3">
                        <label class="form-label">Sell Price (₹)</label>
                        <input type="text" class="form-control numbers-only"
                            name="sell_price"
                            value="{{ (int)$sale->sell_price }}" required>
                    </div>

                    <!-- Handling Charges -->
                    <div class="col-md-3">
                        <label class="form-label">Handling Charges (₹)</label>
                        <input type="text" class="form-control numbers-only"
                            name="handling_charges"
                            value="{{ (int)$sale->handling_charges }}" required>
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
@endsection

@section('scripts')
<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>

<script>
    $(".js-example-basic-single").select2({
        placeholder: "Select Product",
        allowClear: true,
        ajax: {
            url: `{{url('/admin/fetch-products')}}`,
            dataType: 'json',
            method: 'POST',
            data: function(params) {
                return {
                    product_name: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(item => ({
                        id: item.id,
                        text: item.product_name,
                        full: item
                    }))
                };
            }
        }
    });

    // Set product name on select
    $(".js-example-basic-single").on('select2:select', function(e) {
        const selected = e.params.data;
        $('#product_name').val(selected.text);
    });

    $(".js-example-basic-single").on('select2:clear', function() {
        $('#product_name').val('');
    });
</script>
@endsection