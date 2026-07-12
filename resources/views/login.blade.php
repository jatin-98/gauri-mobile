@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 p-0">
            <div class="login-card">
                <div>
                    <div class="text-center">
                        <img src="{{ asset('uploads/logo/Original.png') }}" alt="Logo" class="img-fluid" style="max-width: 275px; height: auto;">
                    </div>
                    <div class="card-body p-4">
                        <div class="login-main">
                            <form class="theme-form" method="POST" action="{{url('/login')}}">
                                <h4>Sign in to your account</h4>
                                <p>Enter your email & password to login</p>

                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="form-control email-only" name="email" type="email" required placeholder="you@example.com">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control required" name="password" type="password" required placeholder="*********">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="text-end mt-3">
                                    <button class="btn btn-primary w-100" type="submit">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/form.js') }}"></script>
@endsection