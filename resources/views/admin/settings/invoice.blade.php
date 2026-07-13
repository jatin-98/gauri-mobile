<form class="needs-validation" method="POST" action="{{ url('/admin/settings/update') }}" novalidate>
    {!! csrf_field() !!}
    <div class="row g-3 mt-3">

        <!-- Store Details -->
        <h5 class="fw-bold mt-3">Store Details</h5>

        <div class="col-md-3">
            <label class="form-label fw-semibold">Store Name</label>
            <input type="text required" class="form-control" name="store_name" value="{{ $config['store_name'] ?? '' }}" required>
        </div>

        <div class="col-md-3">
            <label class="form-label fw-semibold">GST Number</label>
            <input type="text required" class="form-control" name="gst_number" value="{{ $config['gst_number'] ?? '' }}" required>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control" name="store_email" value="{{ $config['store_email'] ?? '' }}">
        </div>

        <!-- Address -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Address Line 1</label>
            <input type="text required" class="form-control" name="address_line1" value="{{ $config['address_line1'] ?? '' }}">
        </div>

        <div class="col-md-6">
            <label class="form-label fw-semibold">Address Line 2</label>
            <input type="text required" class="form-control" name="address_line2" value="{{ $config['address_line2'] ?? '' }}">
        </div>

        <!-- Contact Info -->
        <div class="col-md-3">
            <label class="form-label fw-semibold">Phone Number 1</label>
            <input type="text required" class="form-control" name="phone_1" value="{{ $config['phone_1'] ?? '' }}">
        </div>

        <div class="col-md-3">
            <label class="form-label fw-semibold">Phone Number 2</label>
            <input type="text required" class="form-control" name="phone_2" value="{{ $config['phone_2'] ?? '' }}">
        </div>

        <div class="col-md-3">
            <label class="form-label fw-semibold">Default Warranty (Months)</label>
            <input type="text required" class="form-control numbers-only" name="warranty_months" value="{{ $config['warranty_months'] ?? '' }}">
        </div>

        <div class="col-md-3">
            <label class="form-label fw-semibold">Note</label>
            <input type="text required" class="form-control numbers-only" name="note" value="{{ $config['note'] ?? '' }}">
        </div>

        <!-- Terms & Conditions -->
        <h5 class="fw-bold mt-4">Terms & Conditions</h5>

        <div class="col-md-12">
            <div class="row g-2">
                @for($i = 1; $i <= 5; $i++)
                    <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">{{ $i }}</span>
                        <input type="text required" class="form-control" name="tnc{{ $i }}" placeholder="Enter Term {{ $i }}" value="{{ $config['tnc'.$i] ?? '' }}">
                    </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Submit -->
    <div class="col-12 text-end mt-4">
        <button class="btn btn-primary px-4" type="submit" disabled>
            Update Configuration
        </button>
    </div>

    </div>
</form>