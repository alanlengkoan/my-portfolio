<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="my blog" />
    <meta name="keywords" content="my blog" />
    <meta name="author" content="my blog" />

    <title>My Blog | {{ $title }}</title>
    <!-- begin:: icon -->
    <link rel="apple-touch-icon" href="{{ asset_admin('images/icon/apple-touch-icon.png') }}" sizes="180x180" />
    <link rel="icon" href="{{ asset_admin('images/icon/favicon-32x32.png') }}" type="image/x-icon" sizes="32x32" />
    <link rel="icon" href="{{ asset_admin('images/icon/favicon-16x16.png') }}" type="image/x-icon" sizes="16x16" />
    <link rel="icon" href="{{ asset_admin('images/icon/favicon.ico') }}" type="image/x-icon" />
    <!-- end:: icon -->

    <!-- Layout config Js -->
    <script src="{{ asset_admin('js/layout.js') }}"></script>

    <!-- begin:: css global -->
    <link rel="stylesheet" type="text/css" href="{{ asset_admin('libs/sweetalert2/sweetalert2.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset_admin('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset_admin('css/icons.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset_admin('css/app.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset_admin('css/custom.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset_admin('my_assets/my_css.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- end:: css global -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- begin:: css local -->
    @yield('css')
    <!-- end:: css local -->
</head>

<body>
    <div id="layout-wrapper">
        <!-- begin:: navbar -->
        @include('admin.layouts.navbar')
        <!-- end:: navbar -->

        <!-- begin:: sidebar -->
        @include('admin.layouts.sidebar')
        <!-- end:: sidebar -->

        <div class="vertical-overlay"></div>

        <!-- begin:: main content -->
        <div class="main-content">
            <!-- begin:: body -->
            @yield('content')
            <!-- end:: body -->

            <!-- begin:: footer -->
            @include('admin.layouts.footer')
            <!-- end:: footer -->
        </div>
        <!-- end:: main content -->
    </div>

    <!-- begin:: jd global -->
    <script type="text/javascript" src="{{ asset_admin('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_admin('libs/simplebar/simplebar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_admin('libs/node-waves/waves.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_admin('libs/feather-icons/feather.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_admin('js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script type="text/javascript" src="{{ asset_admin('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_admin('libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset_admin('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="text/javascript" src="{{ asset_admin('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset_admin('my_assets/my_fun.js') }}"></script>
    <!-- end:: jd global -->

    <!-- begin:: js local -->
    @yield('js')
    <!-- end:: js local -->
</body>

</html>