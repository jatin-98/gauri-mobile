@extends('admin.layouts.app')

@section('title', 'Sales | Add')

@section('content')
<div class="container-fluid">

    <!-- Page Header -->
    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3><i class="icon-bar-chart"></i> Add Sales</h3>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}"><i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Sales</li>
                    <li class="breadcrumb-item active">Add</li>
                </ol>
            </div>
        </div>
    </div>

</div>

<!-- Add Sale Form -->
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body">

            <form class="needs-validation" method="POST" action="{{ url('/admin/sales/add') }}" novalidate>
                <div class="row g-3 mt-2">

                    <!-- Product Name -->
                    <div class="col-md-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control required" name="product_name" placeholder="Enter product name" required>
                        <div class="invalid-feedback">Please enter a product name.</div>
                    </div>

                    <!-- Cost Price -->
                    <div class="col-md-3">
                        <label class="form-label">Cost Price (₹)</label>
                        <input type="number" class="form-control numbers-only" name="cost_price" placeholder="Enter cost price" step="0.01" min="0" required>
                        <div class="invalid-feedback">Please enter a cost price.</div>
                    </div>

                    <!-- Sell Price -->
                    <div class="col-md-3">
                        <label class="form-label">Sell Price (₹)</label>
                        <input type="number" class="form-control numbers-only" name="sell_price" placeholder="Enter sell price" step="0.01" min="0" required>
                        <div class="invalid-feedback">Please enter a sell price.</div>
                    </div>

                    <!-- Handling Charges -->
                    <div class="col-md-3">
                        <label class="form-label">Handling Charges (₹)</label>
                        <input type="number" class="form-control numbers-only" name="handling_charges" placeholder="Enter packaging/transport charges" step="0.01" min="0" required>
                        <div class="invalid-feedback">Please enter handling charges.</div>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">
                        <i class="icofont icofont-plus-circle"></i> Add Sale
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection