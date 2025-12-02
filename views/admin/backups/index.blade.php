@extends('admin.layouts.app')

@section('title', 'Backups | Listing')

@section('styles')
<style>
    .hover-shadow-lg {
        transition: all 0.3s ease;
    }

    .hover-shadow-lg:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12) !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3><i data-feather="upload-cloud"></i> Backups</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/admin')}}"> <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item active">Backups</li>
                    <!-- <li class="breadcrumb-item active">Products</li> -->
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 text-end">
            <button type="button" class="btn btn-primary" onclick="navigateViaJs(`{{url('admin/create-backup')}}`)">
                <i class="fa fa-cloud-upload" style="margin-right:8px;"></i> Create Backup
            </button>
        </div>
    </div>
    <div class="row g-4">
        @forelse($backups as $backup)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100 hover-shadow-lg transition">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="bg-success bg-opacity-10 rounded-pill p-3">
                            <i data-feather="file-text" class="text-success" style="width:28px;height:28px;"></i>
                        </div>
                        <span class="badge bg-success-subtle text-success fw-semibold">
                            {{ \Carbon\Carbon::parse($backup['created_date'])->diffForHumans() }}
                        </span>
                    </div>

                    <h5 class="fw-bold mb-2">{{ $backup['name'] }}</h5>
                    <p class="text-muted small mb-3">
                        <i class="fa fa-calendar-o" class="me-1"></i>
                        {{ \Carbon\Carbon::parse($backup['created_date'])->format('d M Y, h:i A') }}
                    </p>

                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-primary fw-semibold">
                            <i data-feather="hard-drive" class="me-1"></i>
                            {{ $backup['size'] }}
                        </span>

                        <div class="btn-group" role="group">
                            <a href="{{ url('/storage/backups/'.$backup['raw_name']) }}"
                                class="btn btn-outline-primary btn-sm">
                                <i data-feather="download"></i>
                            </a>
                            <button onclick="navigateViaJs(`{{url('admin/delete-backup/'.$backup['raw_name'])}}`)"
                                class="btn btn-outline-danger btn-sm">
                                <i data-feather="trash-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i data-feather="database" style="width:80px;height:80px;" class="text-muted mb-4"></i>
            <h4 class="text-muted">No backups found</h4>
            <p class="text-muted">Your first backup will appear here automatically.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection