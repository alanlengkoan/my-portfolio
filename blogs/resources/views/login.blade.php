<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <title>Selamat Datang | {{ $title }}</title>

    <!-- begin:: icon -->
    <link rel="apple-touch-icon" href="{{ asset_admin('images/icon/apple-touch-icon.png') }}" sizes="180x180" />
    <link rel="icon" href="{{ asset_admin('images/icon/favicon-32x32.png') }}" type="image/x-icon" sizes="32x32" />
    <link rel="icon" href="{{ asset_admin('images/icon/favicon-16x16.png') }}" type="image/x-icon" sizes="16x16" />
    <link rel="icon" href="{{ asset_admin('images/icon/favicon.ico') }}" type="image/x-icon" />
    <!-- end:: icon -->

    <!-- begin:: css global -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
    <!-- end:: css global -->
</head>

<div class="auth-wrapper">
    <div class="auth-content">
        <div class="card">
            <div class="row align-items-center text-center">
                <div class="col-md-12">
                    <div class="card-body">
                        <img src="{{ asset('assets/admin/images/auth/auth-logo-dark.png') }}" alt="logo" width="100" class="img-fluid mb-4">
                        <h4 class="mb-3 f-w-400">Masuk</h4>

                        <form action="{{ route('auth.check') }}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group mb-3">
                                <label class="floating-label" for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username" />
                            </div>
                            <div class="form-group mb-4">
                                <label class="floating-label" for="Password">Password</label>
                                <input type="password" class="form-control" name="password" id="Password" />
                            </div>
                            <button type="submit" class="btn btn-block btn-primary mb-4">Masuk</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- begin:: js global -->
<script src="{{ asset('assets/admin/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/ripple.js') }}"></script>
<script src="{{ asset('assets/admin/js/pcoded.min.js') }}"></script>
<!-- begin:: js global -->

</body>

</html>