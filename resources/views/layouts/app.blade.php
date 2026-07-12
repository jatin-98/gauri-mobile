<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My App')</title>

    <link rel="icon" href="{{ asset('uploads/logo/faav.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sweet-alert/sweetalert2.min.css') }}">
    @yield('styles')
</head>

<body>

    @yield('content')

    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/sweet-alert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
        const successMessage = `{{ \App\Core\Session::getFlash('success') ?? '' }}`;
        const errorMessage = `{{ \App\Core\Session::getFlash('error') ?? '' }}`;

        if (successMessage) showToast('success', successMessage);
        if (errorMessage) showToast('error', errorMessage);
    </script>

    @yield('scripts')
</body>

</html>