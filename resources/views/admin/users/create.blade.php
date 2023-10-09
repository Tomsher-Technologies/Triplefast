@extends('admin.layouts.app')
@section('title', 'Create User')

@section('content')

<div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="breadcrumb-main">
                    <h4 class="text-capitalize breadcrumb-title">Create New User</h4>
                    <div class="breadcrumb-action justify-content-center flex-wrap">
                        <div class="action-btn">
                            <a class="btn btn-sm btn-primary btn-add" href="{{ route('users.index') }}">
                                <i class="la la-arrow-left"></i> Back </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="form-element">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-default card-md mb-4">
                        <!-- <div class="card-header">
                            <h6>Role Details</h6>
                        </div> -->
                        <div class="card-body pb-md-50">
                            <form class="form-horizontal" id="createRole" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data"  autocomplete="off">
                                @csrf
                                <div class="form-row mx-n15">
                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault01" class="il-gray fs-14 fw-500 align-center">Name<span class="required">*</span></label>
                                        <input type="text" class="form-control ih-medium ip-light radius-xs b-light" id="name"  name="name" placeholder="Enter name" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault02" class="il-gray fs-14 fw-500 align-center">User Type<span class="required">*</span></label>
                                        <select class="custom-select form-control select-arrow-none ih-medium  radius-xs b-light shadow-none color-light  fs-14" id="user_type" name="user_type">
                                            <option value="">Select</option>
                                            @foreach($user_types as $type)
                                                <option @if(old('user_type') == $type->id) selected  @endif value="{{ $type->id }}">{{ $type->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_type')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault02" class="il-gray fs-14 fw-500 align-center">User Role<span class="required">*</span></label>
                                        <select class="custom-select form-control select-arrow-none ih-medium  radius-xs b-light shadow-none color-light  fs-14" id="role" name="role">
                                            <option value="">Select</option>
                                            
                                        </select>
                                        @error('role')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault01" class="il-gray fs-14 fw-500 align-center">Email<span class="required">*</span></label>
                                        <input type="text" class="form-control ih-medium ip-light radius-xs b-light" id="email"  name="email" placeholder="Enter email" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault01" class="il-gray fs-14 fw-500 align-center">Password<span class="required">*</span></label>
                                        <input type="text" class="form-control ih-medium ip-light radius-xs b-light" id="password"  name="password" placeholder="Enter password" value="{{ old('password') }}">
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault01" class="il-gray fs-14 fw-500 align-center">Confirm Password<span class="required">*</span></label>
                                        <input type="text" class="form-control ih-medium ip-light radius-xs b-light" id="confirm-password"  name="confirm-password" placeholder="Enter confirm password" value="{{ old('confirm-password') }}">
                                        @error('confirm-password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault01" class="il-gray fs-14 fw-500 align-center">Phone Number</label>
                                        <input type="text" class="form-control ih-medium ip-light radius-xs b-light" id="phone_number"  name="phone_number" placeholder="Enter phone number" value="{{ old('phone_number') }}">
                                        @error('phone_number')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault01" class="il-gray fs-14 fw-500 align-center">Profile Image</label>
                                        
                                        <input type="file" class="form-control ih-medium ip-light radius-xs b-light" id="profile_image" name="profile_image" >
                                    </div>
                                </div>
                            
                                <div class="form-row mx-n15">
                                    <div class="col-md-12 mb-20 px-15 d-flex">
                                        <button class="btn btn-primary px-30" type="submit">Save</button>
                                        <a href="{{ route('users.index') }}" class="btn btn-light btn-default btn-squared fw-400 text-capitalize ml-2">
                                            Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- ends: .card -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
<script type="text/javascript">
    
    $('#user_type').on('change', function() {
        var userType = $(this).val();
        $.ajax({
            url: "{{ route('ajax-roles') }}",
            type: "GET",
            data: {
                type: userType,
                _token:'{{ @csrf_token() }}',
            },
            dataType: "html",
            success: function (resp) {
                $('#role').html(resp);
            }
        });
    });
  
</script>
@endsection