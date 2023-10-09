<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} - @yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- inject:css-->

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/bootstrap/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/fontawesome.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/main.css') }}">
    <!-- endinject -->

    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.png">
</head>

<body>
    <main class="main-content">

        <div class="signUP-admin">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-md-5 p-0">
                        <div class="signUP-admin-left signIn-admin-left position-relative">
                            <div class="signUP-overlay ">
                                <!-- <img class="svg signupTop" src="{{ asset('assets/images/signuptop.svg') }}" alt="img" />
                                <img class="svg signupBottom" src="{{ asset('assets/images/signupbottom.svg') }}" alt="img" /> -->
                                <img class="" src="{{ asset('assets/images/logo1.jpg') }}" width="350" height="100" alt="img" />
                            </div><!-- End: .signUP-overlay  -->
                            <div class="signUP-admin-left__content">
                                <div class="text-capitalize mb-md-30 mb-15 d-flex align-items-center justify-content-md-start justify-content-center">
                                  
                                </div>
                                <!-- <h1>TRIPLEFAST MIDDLE EAST LIMITED</h1> -->
                            </div><!-- End: .signUP-admin-left__content  -->
                            <div class="signUP-admin-left__img ">
                                <img class="img-fluid svg" src="{{ asset('assets/images/signupIllustration.svg') }}" alt="img" />
                            </div><!-- End: .signUP-admin-left__img  -->
                        </div><!-- End: .signUP-admin-left  -->
                    </div><!-- End: .col-xl-4  -->
                    <div class="col-xl-8 col-lg-7 col-md-7 col-sm-8">
                        <div class="signUp-admin-right signIn-admin-right  p-md-40 p-10">
                            <div class="signUp-topbar d-flex align-items-center justify-content-md-end justify-content-center mt-md-0 mb-md-0 mt-20 mb-1">
                               
                            </div><!-- End: .signUp-topbar  -->
                            <div class="row justify-content-center">
                            @yield('content')
                            </div>
                        </div><!-- End: .signUp-admin-right  -->
                    </div><!-- End: .col-xl-8  -->
                </div>
            </div>
        </div><!-- End: .signUP-admin  -->

    </main>
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

    <!-- inject:js-->

    <script src="{{ asset('assets/vendor_assets/js/jquery/jquery-3.5.1.min.js') }}"></script>

    <script src="{{ asset('assets/vendor_assets/js/jquery/jquery-ui.js') }}"></script>

    <script src="{{ asset('assets/vendor_assets/js/bootstrap/bootstrap.min.js') }}"></script>
<!--  -->
    <script src="{{ asset('assets/vendor_assets/js/main.js') }}"></script>

    <!-- endinject-->

    <script type="text/javascript">
        $(document).ready(function(){ 
            $("input").attr("autocomplete", "off"); 
        });

        var handleshowPass = function() {
            $('.show-pass').on('click', function() {
                $(this).toggleClass('active');
                if ($('#password').attr('type') == 'password') {
                    $('#password').attr('type', 'text');
                } else if ($('#password').attr('type') == 'text') {
                    $('#password').attr('type', 'password');
                }
            });
        }

        handleshowPass();
    </script>
</body>

</html>