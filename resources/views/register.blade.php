@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 p-0">
            <div class="login-card">
                <div>
                    <div>
                        <a class="logo" href="#">
                            <img class="img-fluid for-light" src="{{ asset('uploads/logo/Original.png') }}" alt="looginpage" style="max-width: 275px; height: auto;">
                            <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo_dark.png')}}" alt="looginpage">
                        </a>
                    </div>
                    <div class="login-main">
                        <form class="theme-form" method="POST" action="{{url('/register')}}">
                            <h4>Create your account</h4>
                            <p>Enter your personal details to create account</p>
                            <div class="form-group">
                                <label class="col-form-label pt-0">Your Name</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input class="form-control letters-only" name="first_name" type="text" required="" placeholder="First name">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-6">
                                        <input class="form-control letters-only" name="last_name" type="text" required="" placeholder="Last name">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Email Address</label>
                                <input class="form-control email-only" type="email" name="email" required="" placeholder="Test@gmail.com">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Password</label>
                                <div class="form-input position-relative">
                                    <input class="form-control required" type="password" name="password" required="" placeholder="*********">
                                    <div class="invalid-feedback"></div>
                                    <div class="show-hide"><span class="show"></span></div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <button class="btn btn-primary btn-block w-100" type="submit">Create Account</button>
                            </div>
                        </form>
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