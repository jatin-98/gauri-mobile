<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('uploads/logo/faav.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('uploads/logo/faav.png')}}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My App')</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/icofont.css')}}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/themify.css')}}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/flag-icon.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/feather-icon.css')}}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/scrollbar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/chartist.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/bootstrap.css')}}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{asset('assets/css/color-1.css')}}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/responsive.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/sweet-alert/sweetalert2.min.css') }}">
    <style>
        .needs-validation .invalid-feedback {
            color: #dc3545;
        }
    </style>
    @yield('styles')
</head>

<body>
    <div id="loading-overlay"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
                background:rgba(255,255,255,0.7); z-index:9999;
                align-items:center; justify-content:center;">
        <div class="col-md-3">
            <h6 class="sub-title mb-0 text-center">Loader 12</h6>
            <div class="loader-box">
                <div class="loader-12"></div>
            </div>
        </div>
    </div>
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
            </filter>
        </svg>
    </div>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        @include('admin.layouts.components.header')
        <!-- Page Header Ends-->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            @include('admin.layouts.components.sidebar')
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                @yield('content')
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
            @include('admin.layouts.components.footer')
        </div>
    </div>
    <script>
        const imageMap = {
            "barc": "{!! asset('assets/images/landing/layout-images/barc.jpg') !!}",
            "dubai": "{!! asset('assets/images/landing/layout-images/dubai.jpg') !!}",
            "london": "{!! asset('assets/images/landing/layout-images/london.jpg') !!}",
            "los": "{!! asset('assets/images/landing/layout-images/los.jpg') !!}",
            "madrid": "{!! asset('assets/images/landing/layout-images/madrid.jpg') !!}",
            "moscow": "{!! asset('assets/images/landing/layout-images/moscow.jpg') !!}",
            "newyork": "{!! asset('assets/images/landing/layout-images/newyork.jpg') !!}",
            "paris": "{!! asset('assets/images/landing/layout-images/paris.jpg') !!}",
            "romo": "{!! asset('assets/images/landing/layout-images/romo.jpg') !!}",
            "seoul": "{!! asset('assets/images/landing/layout-images/seoul.jpg') !!}",
            "singapore": "{!! asset('assets/images/landing/layout-images/singapore.jpg') !!}",
            "tokyo": "{!! asset('assets/images/landing/layout-images/tokyo.jpg') !!}"
        };

        const cssColorPath = "{!! asset('assets/css') !!}"
    </script>
    <!-- latest jquery-->
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js')}}"></script>

    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js')}}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js')}}"></script>
    <!-- scrollbar js-->
    <script src="{{ asset('assets/js/scrollbar/simplebar.js')}}"></script>
    <script src="{{ asset('assets/js/scrollbar/custom.js')}}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('assets/js/config.js')}}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/sidebar-menu.js')}}"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ asset('assets/js/script.js')}}"></script>
    <script src="{{ asset('assets/js/theme-customizer/customizer.js')}}"></script>
    <script src="{{ asset('assets/js/sweet-alert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js')}}"></script>
    <script src="{{ asset('assets/js/form.js')}}"></script>
    <script>
        const successMessage = `{{ \App\Core\Session::getFlash('success') ?? '' }}`;
        const errorMessage = `{{ \App\Core\Session::getFlash('error') ?? '' }}`;

        if (successMessage) showToast('success', successMessage);
        if (errorMessage) showToast('error', atob(errorMessage));
    </script>
    <!-- login js-->
    <!-- Plugin used-->

    @yield('scripts')
    <script>
        // Disable BFCache in Safari/Firefox
        window.onunload = function () {};

        window.addEventListener('pageshow', function (event) {
            if (event.persisted || (typeof window.performance != "undefined" && window.performance.navigation.type === 2)) {
                // Instantly hide the page to prevent a flash of protected content
                document.body.style.display = 'none';
                window.location.reload();
            }
        });
    </script>
</body>

</html>