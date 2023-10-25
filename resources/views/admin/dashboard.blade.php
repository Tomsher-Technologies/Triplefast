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
                                            @canany(['customer-list', 'customer-create', 'customer-edit','customer-view','customer.bulk-create'])
                                                <a href="{{ route('customer.index') }}">
                                            @endcanany      
                                                    <div class="d-flex">
                                                        <div class="revenue-chart-box__Icon mr-20 order-bg-opacity-primary">
                                                            <span data-feather="users" class="nav-icon"></span>
                                                        </div>
                                                        <div>
                                                            <h2>{{ $customers }}</h2>
                                                            <p class="mb-3 mt-1">Total Customers</p>
                                                            
                                                        </div>
                                                    </div>
                                            @canany(['customer-list', 'customer-create', 'customer-edit','customer-view','customer.bulk-create'])
                                                </a>
                                            @endcanany   
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 2 End  -->
                            </div>

                            <div class=" col-md-4">
                                <!-- Card 1 -->
                                <div class="ap-po-details ap-po-details--2 p-30 radius-xl bg-white d-flex justify-content-between mb-25">
                                    <div>
                                        <div class="overview-content overview-content3">
                                            <a href="{{ route('sopc.index') }}">
                                                <div class="d-flex">
                                                    <div class="revenue-chart-box__Icon mr-20 order-bg-opacity-info" style="background:#7c00ff26;">
                                                        <span data-feather="box" class="nav-icon" style="color: #a200ff;"></span>
                                                    </div>
                                                    
                                                    <div>
                                                        <h2>{{ $total }}</h2>
                                                        <p class="mb-3 mt-1">Total SOPC</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 1 End -->
                            </div>

                            <div class=" col-md-4">
                                <!-- Card 1 -->
                                <div class="ap-po-details ap-po-details--2 p-30 radius-xl bg-white d-flex justify-content-between mb-25">
                                    <div>
                                        <div class="overview-content overview-content3">
                                            <a href="{{ route('sopc.index',['status' => 0]) }}">
                                                <div class="d-flex">
                                                    <div class="revenue-chart-box__Icon mr-20 order-bg-opacity-info" style="background:#62656840;">
                                                        <span data-feather="circle" class="nav-icon" style="color: #575b5e;"></span>
                                                    </div>
                                                    <!-- circle -->
                                                    <div>
                                                        <h2>{{ $not_started }}</h2>
                                                        <p class="mb-3 mt-1">Not Started SOPC</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 1 End -->
                            </div>

                            <div class=" col-md-4">
                                <!-- Card 1 -->
                                <div class="ap-po-details ap-po-details--2 p-30 radius-xl bg-white d-flex justify-content-between mb-25">
                                    <div>
                                        <div class="overview-content overview-content3">
                                            <a href="{{ route('sopc.index',['status' => 1]) }}">
                                                <div class="d-flex">
                                                    <div class="revenue-chart-box__Icon mr-20 order-bg-opacity-info" style="background:#008cff36;">
                                                        <span data-feather="flag" class="nav-icon" style="color: #008cff;"></span>
                                                    </div>
                                                    
                                                    <div>
                                                        <h2>{{ $started }}</h2>
                                                        <p class="mb-3 mt-1">Started SOPC</p>
                                                    </div>
                                                </div>
                                            </a>
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
                                            <a href="{{ route('sopc.index',['status' => 2]) }}">
                                                <div class="d-flex">
                                                    <div class="revenue-chart-box__Icon mr-20 order-bg-opacity-warning" style="background:#f09b003b;">
                                                        <span data-feather="loader" class="nav-icon"></span>
                                                    </div>
                                                    <div>
                                                        <h2>{{ $partial }}</h2>
                                                        <p class="mb-3 mt-1">Partial SOPC</p>
                                                    </div>
                                                </div>
                                            </a>
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
                                            <a href="{{ route('sopc.index',['status' => 3]) }}">
                                                <div class="d-flex">
                                                    <div class="revenue-chart-box__Icon mr-20 order-bg-opacity-dark" style="background:#ff00001f;">
                                                        <span data-feather="pause" class="nav-icon" style="color:#ff00008c;"></span>
                                                    </div>
                                                    <div>
                                                        <h2>{{ $hold }}</h2>
                                                        <p class="mb-3 mt-1">Holded SOPC</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 1 End -->
                            </div>

                            <div class=" col-md-4">
                                <div class="ap-po-details ap-po-details--2 p-30 radius-xl bg-white d-flex justify-content-between mb-25">
                                    <div>
                                        <div class="overview-content overview-content3">
                                            <a href="{{ route('sopc.index',['status' => 4]) }}">
                                                <div class="d-flex">
                                                    <div class="revenue-chart-box__Icon mr-20 order-bg-opacity-success" style="background:#009e0036;">
                                                        <span data-feather="check-circle" class="nav-icon" style="color:#009e00;"></span>
                                                    </div>
                                                    <div>
                                                        <h2>{{ $completed }}</h2>
                                                        <p class="mb-3 mt-1">Completed SOPC</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                            <div class=" col-md-4">
                                <div class="ap-po-details ap-po-details--2 p-30 radius-xl bg-white d-flex justify-content-between mb-25">
                                    <div>
                                        <div class="overview-content overview-content3">
                                            <a href="{{ route('sopc.index',['status' => 5]) }}">
                                                <div class="d-flex">
                                                    <div class="revenue-chart-box__Icon mr-20 order-bg-opacity-danger" style="background: #e5000036;">
                                                    <span data-feather="x-circle" class="nav-icon" style="color:#e50000;"></span>
                                                    </div>
                                                    <div>
                                                        <h2>{{ $cancelled }}</h2>
                                                        <p class="mb-3 mt-1">Cancelled SOPC</p>
                                                    </div>
                                                </div>
                                            </a>
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