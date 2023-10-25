@extends('admin.layouts.app')
@section('title', 'View Customer')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">View Customer Details</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">
                    <div class="action-btn">
                        <a class="btn btn-sm btn-primary btn-add" href="{{ route('customer.index') }}">
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
                        Customer info
                    </div>
                </div>
                <div class="card-body pt-md-1 pt-0 pb-0">
                    <div class="user-content-info">
                        <p class="user-content-info__item">
                            <label class="il-gray fs-14 fw-400 align-center"> Name : </label>
                            <label class="il-gray fs-16 fw-500 align-center ml-3"> {{ $customer[0]->first_name ?? '' }}</label>
                        </p>
                        <p class="user-content-info__item">
                            <label class="il-gray fs-14 fw-400 align-center"> Email : </label>
                            <label class="il-gray fs-16 fw-500 align-center ml-3">
                                {{ $customer[0]->email ?? '' }}</label>
                        </p>
                        <p class="user-content-info__item">
                            <label class="il-gray fs-14 fw-400 align-center"> Customer ID : </label>
                            <label class="il-gray fs-16 fw-500 align-center ml-3">
                                {{ $customer[0]->custom_id ?? '' }}</label>
                        </p>
                        <p class="user-content-info__item">
                            <label class="il-gray fs-14 fw-400 align-center"> Phone Number : </label>
                            <label class="il-gray fs-16 fw-500 align-center ml-3">
                                {{ $customer[0]->phone_number ?? '' }}</label>
                        </p>
                        <p class="user-content-info__item">
                            <label class="il-gray fs-14 fw-400 align-center"> Address : </label>
                            <label class="il-gray fs-16 fw-500 align-center ml-3">
                                {{ $customer[0]->address ?? '' }}</label>
                        </p>
                        <p class="user-content-info__item">
                            <label class="il-gray fs-14 fw-400 align-center"> Created Date : </label>
                            <label class="il-gray fs-16 fw-500 align-center ml-3">
                                {{ (isset($customer[0]->created_at)) ? date('d-m-Y', strtotime($customer[0]->created_at)) : '' }}</label>
                        </p>
                    </div>
                </div>
            </div>
            <!-- <div class="user-skils border-bottom">
                <div class="card-header border-bottom-0 pt-sm-25 pb-sm-0  px-md-25 px-3">
                    <div class="profile-header-title">
                        Shipping Addresses
                    </div>
                </div>
                <div class="card-body pt-md-1 pt-0">
                    <div class="row">
                        @if(!empty($customer[0]->shipping_address))
                            @foreach($customer[0]->shipping_address as $key=>$v)
                                <div class="col-md-4 mb-20">
                                    <div class="card card-default card-md bg-white ">
                                        <div class="card-header border">
                                            <h6>Address {{$key+1}}</h6>
                                        </div>
                                        <div class="card-body border pt-0 pb-0">
                                            <div class="card-content pre-line">
                                                <p>{!! trim($v->shipping_address) !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
@endsection

@section('header')
<style>
    .border{
        border: 1px solid #d1d2da !important;
    }
</style>

@endsection