@extends('admin.layouts.app')
@section('content')
<div class="crm sales">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="breadcrumb-main">
                            <h4 class="text-capitalize breadcrumb-title">Dashboard</h4>
                            <div class="breadcrumb-action justify-content-center flex-wrap">
                                <!-- <div class="action-btn">
                                    <div class="form-group mb-0">
                                        <div class="input-container icon-left position-relative">
                                            <span class="input-icon icon-left">
                                                <span data-feather="calendar"></span>
                                            </span>
                                            <input type="text" class="form-control form-control-default date-ranger"
                                                name="date-ranger" placeholder="Oct 30, 2019 - Nov 30, 2019">
                                            <span class="input-icon icon-right">
                                                <span data-feather="chevron-down"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div> -->
                                
                                <!-- <div class="action-btn">
                                    <a href="" class="btn btn-sm btn-primary btn-add">
                                        <i class="la la-plus"></i> Add New</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ends: .row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class=" col-md-4">
                                <!-- Card 2 End  -->
                                <div class="ap-po-details ap-po-details--2 p-30 radius-xl bg-white d-flex justify-content-between mb-25">
                                    <div>
                                        <div class="overview-content overview-content3">
                                            <div class="d-flex">
                                                <div class="revenue-chart-box__Icon mr-20 order-bg-opacity-primary">
                                                    <span data-feather="users" class="nav-icon"></span>
                                                </div>
                                                <div>
                                                    <h2>{{ $customers }}</h2>
                                                    <p class="mb-3 mt-1">Total Customers</p>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 2 End  -->
                            </div>
                            <div class=" col-md-4">
                                <!-- Card 1 -->
                                <div
                                    class="ap-po-details ap-po-details--2 p-30 radius-xl bg-white d-flex justify-content-between mb-25">
                                    <div>
                                        <div class="overview-content overview-content3">
                                            <div class="d-flex">
                                                <div class="revenue-chart-box__Icon mr-20 order-bg-opacity-warning">
                                                    <span data-feather="loader" class="nav-icon"></span>
                                                </div>
                                                <div>
                                                    <h2>{{ $partial }}</h2>
                                                    <p class="mb-3 mt-1">Partial SOPC</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 1 End -->
                            </div>

                            <div class=" col-md-4">
                                <!-- Card 1 -->
                                <div
                                    class="ap-po-details ap-po-details--2 p-30 radius-xl bg-white d-flex justify-content-between mb-25">
                                    <div>
                                        <div class="overview-content overview-content3">
                                            <div class="d-flex">
                                                <div class="revenue-chart-box__Icon mr-20 order-bg-opacity-dark">
                                                    <span data-feather="shopping-bag" class="nav-icon"></span>
                                                </div>
                                                <div>
                                                    <h2>{{ $hold }}</h2>
                                                    <p class="mb-3 mt-1">Holded SOPC</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 1 End -->
                            </div>

                            <div class=" col-md-4">
                                <div class="ap-po-details ap-po-details--2 p-30 radius-xl bg-white d-flex justify-content-between mb-25">
                                    <div>
                                        <div class="overview-content overview-content3">
                                            <div class="d-flex">
                                                <div class="revenue-chart-box__Icon mr-20 order-bg-opacity-success">
                                                    <span data-feather="box" class="nav-icon"></span>
                                                </div>
                                                <div>
                                                    <h2>{{ $completed }}</h2>
                                                    <p class="mb-3 mt-1">Completed SOPC</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                            <div class=" col-md-4">
                                <div class="ap-po-details ap-po-details--2 p-30 radius-xl bg-white d-flex justify-content-between mb-25">
                                    <div>
                                        <div class="overview-content overview-content3">
                                            <div class="d-flex">
                                                <div class="revenue-chart-box__Icon mr-20 order-bg-opacity-danger">
                                                <span data-feather="x-circle" class="nav-icon"></span>
                                                </div>
                                                <div>
                                                    <h2>{{ $cancelled }}</h2>
                                                    <p class="mb-3 mt-1">Cancelled SOPC</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection