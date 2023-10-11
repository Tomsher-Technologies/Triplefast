@extends('admin.layouts.auth')
@section('content')
    <div class="col-xl-7 col-lg-8 col-md-12">
        <div class=" mt-md-25 mt-0">
            <div class="card border-0">
                <div class="card-header border-0  pb-md-15 pb-10 pt-md-20 pt-10 ">
                
                    <div class="edit-profile__title">
                        
                        <h6 class=" pb-md-15 pb-10 pt-md-20 pt-10">Login </h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('login.custom') }}" method="POST" autocomplete="off" >
                          @csrf
                        <div class="edit-profile__body">
                            <div class="form-group mb-20">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" autocomplete="off">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-15">
                                <label for="password">password</label>
                                <div class="position-relative">
                                    <input id="password" type="password" placeholder="Password" autocomplete="new-password"  class="form-control" name="password" value="{{ old('password') }}">
                                    <div class=" text-light fs-16 field-icon toggle-password2">
                                        <span class="show-pass eye">
                                            <i class="fa fa-eye-slash"></i>
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <!-- <div class="signUp-condition signIn-condition">
                                <div class="checkbox-theme-default custom-checkbox ">
                                    <input class="checkbox" type="checkbox" name="remember" id="remember">
                                    <label for="check-1">
                                        <span class="checkbox-text">Remember Me</span>
                                    </label>
                                </div>
                                <a href="forget-password.html">forget password</a>
                                
                            </div> -->

                            <div>
                                @if(session()->has('status'))
                                    <div class="alert alert-danger">
                                        <strong>{{ session()->get('status') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="button-group d-flex pt-1 justify-content-md-start justify-content-center">
                                
                                <button type="submit" class="btn btn-primary btn-default btn-squared mr-15 text-capitalize lh-normal px-50 py-15 signIn-createBtn ">
                                Login
                                </button>
                            </div>
                            
                        </div>
                    </form>
                </div><!-- End: .card-body -->
            </div><!-- End: .card -->
        </div><!-- End: .edit-profile -->
    </div><!-- End: .col-xl-5 -->
@endsection