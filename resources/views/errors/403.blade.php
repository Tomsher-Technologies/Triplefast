
@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Start: error page -->
                <div class="min-vh-100 content-center">
                    <div class="error-page text-center">
                        <img src="{{ asset('assets/images/svg/404.svg') }}" alt="404" class="svg">
                        <div class="error-page__title">404</div>
                        <h5 class="fw-500">SORRY! YOU DON'T HAVE THE RIGHT PERMISSIONS.</h5>
                        
                    </div>
                </div>
                <!-- End: error page -->
            </div>
        </div>
    </div>
@endsection