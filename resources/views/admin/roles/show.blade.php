@extends('admin.layouts.app')
@section('title', 'View Role')
@section('content') 
<div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="breadcrumb-main">
                    <h4 class="text-capitalize breadcrumb-title">View Role Details</h4>
                    <div class="breadcrumb-action justify-content-center flex-wrap">
                        <div class="action-btn">
                            <a class="btn btn-sm btn-primary btn-add" href="{{ route('roles.index') }}">
                                <i class="la la-arrow-left"></i> Back </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="cos-lg-12 col-md-12  ">
            <div class="card mb-25">
                
                <div class="user-info border-bottom">
                    <div class="card-header border-bottom-0 pt-sm-25 pb-sm-0  px-md-25 px-3">
                        <div class="profile-header-title">
                            Role info
                        </div>
                    </div>
                    <div class="card-body pt-md-1 pt-0 pb-0">
                        <div class="user-content-info">
                            <p class="user-content-info__item">
                                <label class="il-gray fs-14 fw-400 align-center"> Role Name : </label> 
                                 <label class="il-gray fs-16 fw-500 align-center ml-3"> {{ $role[0]->name ?? '' }} </label> 
                            </p>
                            <p class="user-content-info__item">
                                <label class="il-gray fs-14 fw-400 align-center"> User Type : </label> 
                                <label class="il-gray fs-16 fw-500 align-center ml-3"> {{ $role[0]->title ?? '' }}</label> 
                            </p>
                            <p class="user-content-info__item">
                                <label class="il-gray fs-14 fw-400 align-center"> Created Date : </label> 
                                <label class="il-gray fs-16 fw-500 align-center ml-3"> {{ (isset($role[0]->created_at)) ? date('d-m-Y', strtotime($role[0]->created_at)) : '' }}</label> 
                            </p>
                        </div>
                    </div>
                </div>
                <div class="user-skils border-bottom">
                    <div class="card-header border-bottom-0 pt-sm-25 pb-sm-0  px-md-25 px-3">
                        <div class="profile-header-title">
                            Permissions
                        </div>
                    </div>
                    <div class="card-body pt-md-1 pt-0">
                        <ul class="user-skils-parent">

                        @if(!empty($rolePermissions))
                            @foreach($rolePermissions as $v)
                            <li class="user-skils-parent__item">
                                <a href="#">{{ $v->title }}</a>
                            </li>
                            @endforeach
                        @endif
                            
                           
                        </ul>
                    </div>
                </div>
                
            </div>
        </div>

    </div>
@endsection