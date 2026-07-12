{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-title mb-4">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h3>Dashboard</h3>
            </div>
            <div class="col-12 col-md-6 text-md-end mt-3 mt-md-0">
                <span class="text-muted">Today is {{ date('l, j F Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        @include('admin.dashboard.cards')
    </div>

    <!-- Main Chart + Quick Stats -->
    <div class="row g-4">
        <!-- Quick Stats -->
        {{--<div class="col-xl-12">
            @include('admin.dashboard.quick_stats')
        </div>--}}

        <!-- Sales Chart -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i data-feather="trending-up" class="text-success me-2"></i>
                        Sales Overview
                    </h5>

                    <!-- Dropdown Filter -->
                    <select id="salesPeriodFilter" class="form-select w-auto shadow-sm" style="min-width: 180px;">
                        <option value="30">Last 30 Days</option>
                        <option value="180">Last 6 Months</option>
                        <option value="365">Last 12 Months</option>
                        <option value="all" selected>All Time</option>
                    </select>
                </div>
                <div class="card-body">
                    <div id="basic-apex"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mt-4">
        @include('admin.dashboard.best_products')
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>

<script>
    var data = JSON.parse(`{!! $chartData !!}`);

    // Extract arrays
    var labels = data.map(item => item.date);
    var salesData = data.map(item => item.total_sales);

    var options = {
        chart: {
            height: 350,
            type: 'area',
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },

        series: [{
            name: "Total Sales",
            data: salesData
        }],

        labels: labels,

        xaxis: {
            type: 'datetime'
        },

        yaxis: {
            labels: {
                formatter: function(value) {
                    return Math.round(value);
                }
            }
        },

        legend: {
            horizontalAlign: 'left'
        },
        colors: [CubaAdminConfig.primary]
    };

    var chart = new ApexCharts(
        document.querySelector("#basic-apex"),
        options
    );

    chart.render();
</script>

@endsection