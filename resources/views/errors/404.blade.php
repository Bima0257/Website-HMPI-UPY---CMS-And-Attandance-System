<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title Meta -->
    <meta charset="utf-8" />
    <title>Page Not Found - 404 | Rasket - Responsive Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully responsive premium admin dashboard template" />
    <meta name="author" content="Techzaa" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets_dashboard/images/favicon.ico') }}">

    <!-- Vendor css (Require in all Page) -->
    <link href="{{ asset('assets_dashboard/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Icons css (Require in all Page) -->
    <link href="{{ asset('assets_dashboard/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css (Require in all Page) -->
    <link href="{{ asset('assets_dashboard/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Theme Config js (Require in all Page) -->
    <script src="{{ asset('assets_dashboard/js/config.min.js') }}"></script>
</head>

<body class="authentication-bg">

    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="card auth-card">
                        <div class="card-body p-0">
                            <div class="row align-items-center g-0">
                                <div class="col">
                                    <div class="p-4">
                                        <div class="mx-auto mb-4 text-center">
                                            <div class="mx-auto text-center auth-logo">
                                                <a href="index.html" class="logo-dark">
                                                    <img src="{{ asset('assets_dashboard/images/logo-sm.png') }}"
                                                        height="30" class="me-1" alt="logo sm">
                                                    <img src="{{ asset('') }}assets_dashboard/images/logo-dark.png"
                                                        height="24" alt="logo dark">
                                                </a>

                                                <a href="index.html" class="logo-light">
                                                    <img src="{{ asset('assets_dashboard/images/logo-sm.png') }}"
                                                        height="30" class="me-1" alt="logo sm">
                                                    <img src="{{ asset('') }}assets_dashboard/images/logo-light.png"
                                                        height="24" alt="logo light">
                                                </a>
                                            </div>

                                            <img src="{{ asset('assets_dashboard/images/404.svg') }}" alt="auth"
                                                height="250" class="mt-5 mb-3" />

                                            <h2 class="fs-22 lh-base">Page Not Found !</h2>
                                            <p class="text-muted mt-1 mb-4">The page you're trying to reach seems to
                                                have gone <br /> missing in the digital wilderness.</p>

                                            <div class="text-center">
                                                @if (Request::is('dashboard*'))
                                                    <a href="{{ url('/dashboard') }}" class="btn btn-info">Back to
                                                        Dashboard</a>
                                                @else
                                                    <a href="{{ url('/') }}" class="btn btn-info">Back to Home</a>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                        </div> <!-- end card-body -->
                    </div> <!-- end card -->

                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
    </div>

    <!-- Vendor Javascript (Require in all Page) -->
    <script src="{{ asset('assets_dashboard/js/vendor.js') }}"></script>

    <!-- App Javascript (Require in all Page) -->
    <script src="{{ asset('assets_dashboard/js/app.js') }}"></script>

</body>

</html>
