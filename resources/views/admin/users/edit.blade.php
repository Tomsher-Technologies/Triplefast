@extends('admin.layouts.app')

@section('title', 'Update User')
@section('content')

<div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="breadcrumb-main">
                    <h4 class="text-capitalize breadcrumb-title">Update User</h4>
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
                          
                            {!! Form::model($user, ['method' => 'PATCH','autocomplete' => 'off','route' => ['users.update', $user->id], 'enctype' => 'multipart/form-data']) !!}
                                @csrf
                                <div class="form-row mx-n15">
                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault01" class="il-gray fs-14 fw-500 align-center">Name<span class="required">*</span></label>
                                        <input type="text" class="form-control ih-medium ip-light radius-xs b-light" id="name"  name="name" placeholder="Enter name" value="{{ old('name',$user->name) }}">
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault02" class="il-gray fs-14 fw-500 align-center">User Type<span class="required">*</span></label>
                                        <select class="custom-select form-control select-arrow-none ih-medium  radius-xs b-light shadow-none color-light  fs-14" id="user_type" name="user_type">
                                            <option value="">Select</option>
                                            @foreach($user_types as $type)
                                                <option @if(old('user_type',$user->user_type) == $type->id) selected  @endif value="{{ $type->id }}">{{ $type->title }}</option>
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
                                            @foreach($roles as $rol)
                                                <option @if(isset($userRole[0]) && (old('role', $userRole[0]) == $rol['id']) ) selected  @endif value="{{ $rol['id'] }}">{{ $rol['name'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault01" class="il-gray fs-14 fw-500 align-center">Email<span class="required">*</span></label>
                                        <input type="text" class="form-control ih-medium ip-light radius-xs b-light" id="email"  name="email" placeholder="Enter email" value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault01" class="il-gray fs-14 fw-500 align-center">Password</label>
                                        <input type="text" class="form-control ih-medium ip-light radius-xs b-light" id="password"  name="password" placeholder="Enter password" value="{{ old('password') }}">
                                    </div>

                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault01" class="il-gray fs-14 fw-500 align-center">Phone Number</label>
                                        <input type="text" class="form-control ih-medium ip-light radius-xs b-light" id="phone_number"  name="phone_number" placeholder="Enter phone number" value="{{ old('phone_number',$user->user_details->phone_number) }}">
                                        @error('phone_number')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault01" class="il-gray fs-14 fw-500 align-center">Profile Image</label>
                                        
                                        <input type="file" class="form-control ih-medium ip-light radius-xs b-light" id="profile_image" name="profile_image" >
                                        @if($user->user_details->profile_image != NULL)
                                            <img class="mt-3" src="{{ asset($user->user_details->profile_image) }}" style="width:200px; height:150px" />
                                        @endif
                                    </div>

                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="is_active" class="il-gray fs-14 fw-500 align-center">Active Status<span class="required">*</span></label>
                                        <select class="custom-select form-control select-arrow-none ih-medium  radius-xs b-light shadow-none color-light  fs-14" id="is_active" name="is_active">
                                            <option value="1" @if($user->is_active == 1) selected @endif>Active</option>
                                            <option value="0" @if($user->is_active == 0) selected @endif>Inactive</option>
                                        </select>
                                        @error('is_active')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-20 px-15" id="emailNotification">
                                        <label for="validationDefault01" class="il-gray fs-14 fw-500 align-center">Email Notification</label>
                                        
                                        <div class="custom-control custom-switch switch-primary switch-lg ">
                                            <input type="checkbox" class="custom-control-input" id="switch-s3" name="notification" @if($user->email_notification == 1) checked @endif>
                                            <label class="custom-control-label" for="switch-s3"></label>
                                        </div>
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
                                {!! Form::close() !!}
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

    var usertype = '{{ $user->user_type }}';
    // if(usertype == 4){
    //     $('#emailNotification').css('display','block');
    // }else{
    //     $('#emailNotification').css('display','none');
    // }
    
    $('#user_type').on('change', function() {
        var userType = $(this).val();

        // if(userType == 4){
        //     $('#emailNotification').css('display','block');
        // }else{
        //     $('#emailNotification').css('display','none');
        // }

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