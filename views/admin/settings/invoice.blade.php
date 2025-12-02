<form class="needs-validation" method="POST" action="{{ url('/admin/settings/update') }}" novalidate>
    <div class="row g-3 mb-3 mt-3">
        <div class="col-md-3">
            <label class="form-label fw-semibold">Store Name</label>
            <input type="text" class="form-control required" name="store_name" value="{{ $config['store_name'] ?? null }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">GST Number</label>
            <input type="text" class="form-control required" name="gst_number" value="{{ $config['gst_number'] ?? null }}" required>
        </div>
        <div class="col-3">
            <label class="form-label fw-semibold">Address Line 1</label>
            <input type="text" class="form-control required" name="address_line1" value="{{ $config['address_line1'] ?? null }}">
        </div>
        <div class="col-3">
            <label class="form-label fw-semibold">Address Line 2</label>
            <input type="text" class="form-control required" name="address_line2" value="{{ $config['address_line2'] ?? null }}">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Phone Number 1</label>
            <input type="text" class="form-control required" name="phone_1" value="{{ $config['phone_1'] ?? null }}">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Phone Number 2</label>
            <input type="text" class="form-control required" name="phone_2" value="{{ $config['phone_2'] ?? null }}">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control required" name="store_email" value="{{ $config['store_email'] ?? null }}">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Default Warranty (Months)</label>
            <input type="text" class="form-control required" name="warranty_months" value="{{$config['warranty_months'] ?? null}}">
        </div>
    </div>
    <button class="btn btn-primary" type="submit" disabled> Update Configuration</button>
</form>