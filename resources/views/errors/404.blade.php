
<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex" />
    <title>{{ env('APP_NAME') }} - @yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- inject:css-->

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/bootstrap/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/line-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/main.css') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.png">

</head>

<body class="layout-dark side-menu overlayScroll">

    <div class="mobile-author-actions"></div>
   
    <main class="main-content">

        <div class="">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <!-- Start: error page -->
                        <div class="min-vh-100 content-center">
                            <div class="error-page text-center">
                                <img src="{{ asset('assets/images/svg/404.svg') }}" alt="404" class="svg">
                                <div class="error-page__title">404</div>
                                <h5 class="fw-500">SORRY! THE PAGE YOU ARE LOOKING FOR DOESN'T EXIST.</h5>
                            </div>
                        </div>
                        <!-- End: error page -->
                    </div>
                </div>
            </div>

        <div id="overlayer">
            <span class="loader-overlay">
                <div class="atbd-spin-dots spin-lg">
                    <span class="spin-dot badge-dot dot-primary"></span>
                    <span class="spin-dot badge-dot dot-primary"></span>
                    <span class="spin-dot badge-dot dot-primary"></span>
                    <span class="spin-dot badge-dot dot-primary"></span>
                </div>
            </span>
        </div>
        <div class="overlay-dark-sidebar"></div>

    <script src="{{ asset('assets/vendor_assets/js/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor_assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/vendor_assets/js/jquery/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/vendor_assets/js/main.js') }}"></script>
    
</body>

</html>