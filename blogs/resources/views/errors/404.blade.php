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

    <title>My Blog | 404</title>
    <!-- begin:: icon -->
    <link rel="apple-touch-icon" href="{{ asset_admin('images/icon/apple-touch-icon.png') }}" sizes="180x180" />
    <link rel="icon" href="{{ asset_admin('images/icon/favicon-32x32.png') }}" type="image/x-icon" sizes="32x32" />
    <link rel="icon" href="{{ asset_admin('images/icon/favicon-16x16.png') }}" type="image/x-icon" sizes="16x16" />
    <link rel="icon" href="{{ asset_admin('images/icon/favicon.ico') }}" type="image/x-icon" />
    <!-- end:: icon -->

    <!-- Layout config Js -->
    <script src="{{ asset_admin('js/layout.js') }}"></script>

    <!-- begin:: css global -->
    <link rel="stylesheet" type="text/css" href="{{ asset_admin('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset_admin('css/icons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset_admin('css/app.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset_admin('css/custom.min.css') }}">
    <!-- end:: css global -->

    <!-- begin:: css local -->
    @yield('css')
    <!-- end:: css local -->
</head>

<body>
    <div class="auth-page-wrapper py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="auth-page-content overflow-hidden p-0">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="text-center">
                            <img src="{{ asset_admin('images/maintance/error400-cover.png') }}" alt="error img" class="img-fluid">
                            <div class="mt-3">
                                <h3 class="text-uppercase">Sorry, Page not Found 😭</h3>
                                <p class="text-muted mb-4">The page you are looking for not available!</p>
                                <button onclick="history.back()" class="btn btn-primary"><i class="mdi mdi-arrow-left me-1"></i>Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>