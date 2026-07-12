@extends('admin.layouts.app')

@section('title', 'Settings')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css')}}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Settings</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}"> <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item active">Settings</li>
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
                <div class="card-body">
                    <ul class="nav nav-tabs border-tab nav-secondary mb-4" id="productTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="single-tab" data-bs-toggle="tab" href="#single" role="tab">
                                <i class="icon-email"></i> Email Configuration
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="multiple-tab" data-bs-toggle="tab" href="#multiple" role="tab">
                                <i class="icon-receipt"></i> Invoice Configuration
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="create-tab" data-bs-toggle="tab" href="#create" role="tab">
                                <i class="icon-plus"></i> Invoice Configuration
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="productTabContent">
                        <div class="tab-pane fade show active" id="single" role="tabpanel" aria-labelledby="single-tab">
                            @include('admin.settings.email')
                        </div>
                        <div class="tab-pane fade" id="multiple" role="tabpanel" aria-labelledby="multiple-tab">
                            @include('admin.settings.invoice')
                        </div>
                        <div class="tab-pane fade" id="create" role="tabpanel" aria-labelledby="create-tab">
                            @include('admin.settings.create')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection