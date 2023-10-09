@extends('admin.layouts.app')
@section('title', 'Create Role')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="breadcrumb-main">
                    <h4 class="text-capitalize breadcrumb-title">Create New Role</h4>
                    <div class="breadcrumb-action justify-content-center flex-wrap">
                        <div class="action-btn">
                            <a class="btn btn-sm btn-primary btn-add" href="{{ route('roles.index') }}">
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
                            <form class="form-horizontal" id="createRole" action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data"  autocomplete="off">
                                @csrf
                                <div class="form-row mx-n15">
                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault01" class="il-gray fs-16 fw-500 align-center">Role Name<span class="required">*</span></label>
                                        <input type="text" class="form-control ih-medium ip-light radius-xs b-light" id="name"  name="name" placeholder="Enter name" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-20 px-15">
                                        <label for="validationDefault02" class="il-gray fs-16 fw-500 align-center">User Type<span class="required">*</span></label>
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
                                </div>
                                <div class="form-row mx-n15">
                                    <div class="col-md-12 mb-20 px-15">
                                        <label for="validationDefault03" class="il-gray fs-16 fw-500 align-center">Permissions<span class="required">*</span></label>
                                        <div class="row">
                                            
                                            @foreach($permission as $value)
                                                @php 
                                                    $selected = '';
                                                    if(old('permission')){
                                                        if(in_array($value->id, old('permission'))){
                                                            $selected = 'checked';
                                                        }
                                                    }
                                                   
                                                @endphp
                                                <div class="col-md-3">
                                                    <label class="fs-14 fw-400">
                                                        <input class="checkbox name" type="checkbox" value="{{$value->id}}" name="permission[]" id="permission" {{ $selected }}>
                                                        {{ $value->title }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('permission')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <div class="form-row mx-n15">
                                    <div class="col-md-12 mb-20 px-15 d-flex">
                                        <button class="btn btn-primary px-30" type="submit">Save</button>
                                        <a href="{{ route('roles.index') }}" class="btn btn-light btn-default btn-squared fw-400 text-capitalize ml-2">
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