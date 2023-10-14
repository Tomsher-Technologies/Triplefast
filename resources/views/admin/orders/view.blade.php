@extends('admin.layouts.app')
@section('title', 'View Sales Order Details')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">View Sales Order Details</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">
                    <div class="action-btn d-flex">
                        <a class="btn btn-sm btn-primary btn-add" href="{{ route('order.index') }}">
                            <i class="la la-arrow-left"></i> Back </a>

                        <a href="{{ route('job-cards',$order[0]->id) }}" class="btn btn-sm btn-success btn-add ml-3" data-id="{{$order[0]->id}}"><span data-feather="layers"></span>Job Cards</a>
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
                        Sales Order info
                    </div>
                </div>
                <div class="card-body pt-md-1 pt-0 pb-0">
                    <div class="columnGrid-wrapper">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-default card-md bg-white card-bordered">
                                    <div class="card-header">
                                        <h6>Sales Order: {{ $order[0]->order_no ?? '' }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-grid-table table-responsive">
                                            <table class="table">
                                                <tbody class="">
                                                    <tr class="col-sm-12">
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Customer Name</span>
                                                            <p>{{ $order[0]->customer->first_name ?? '' }} {{ $order[0]->customer->last_name ?? '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Customer ID</span>
                                                            <p>{{ $order[0]->customer->custom_id ?? '' }} </p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Shipping Address</span>
                                                            <p>{{ $order[0]->customer_shipping->shipping_address }}</p>
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr class="col-sm-12">
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Order Date</span>
                                                            <p>{{ date('d-m-Y',strtotime($order[0]->order_date)) }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">PO Number</span>
                                                            <p>{{ $order[0]->po_number ?? '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Need By</span>
                                                            <p>{{ date('d-m-Y',strtotime($order[0]->need_by_date)) }}</p>
                                                        </td>
                                                        
                                                    </tr>

                                                    <tr class="col-sm-12">
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Ship By </span>
                                                            <p>{{ date('d-m-Y',strtotime($order[0]->ship_by_date)) }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Sales Person </span>
                                                            <p>{!! $order[0]->sales_person->name !!}</p>
                                                        </td>

                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Terms </span>
                                                            <p>{{ $order[0]->terms }}</p>
                                                        </td>
                                                       
                                                    </tr>
                                                    <tr class="col-sm-12">
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Shipping Terms </span>
                                                            <p>{{ $order[0]->shipping_terms }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Ship Via </span>
                                                            <p>{{ $order[0]->shipping_via }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Status </span>
                                                            <p>
                                                                @if($order[0]->status == 1)
                                                                    <span class="badge badge-round badge-info badge-lg">Engineer</span>
                                                                @elseif($order[0]->status == 2)
                                                                    <span class="badge badge-round badge-warning badge-lg">Released</span>
                                                                @elseif($order[0]->status == 3)
                                                                    <span class="badge badge-round badge-success badge-lg">Completed</span>
                                                                @endif
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-skils border-bottom">
                <div class="card-header border-bottom-0 pt-sm-25 pb-sm-0  px-md-25 px-3">
                    <div class="profile-header-title">
                        Parts Required
                    </div>
                </div>
                <div class="card-body pt-md-1 pt-0">
                    <div class="">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody class="f-14">
                                    <tr>
                                        <th class="text-center">Line</th>
                                        <th class="text-center">Order Qty</th>
                                        <th class="text-center">Part Number</th>
                                        <th>Description</th>
                                        <th>Rev</th>
                                        <th class="text-center">Line Need By</th>
                                    </tr>
                                    @if($order[0]->order_parts)
                                        @foreach($order[0]->order_parts as $key => $parts)
                                        <tr>
                                            <td class="text-center">{{ $key+1 }}</td>
                                            <td class="text-center">{{ $parts->quantity }}</td>
                                            <td class="text-center">{{ $parts->part_details->part_number }}</td>
                                            <td>{{ $parts->description }}</td>
                                            <td>{{ $parts->rev }}</td>
                                            <td class="text-center">{{ date('d-m-Y',strtotime($parts->need_by_date)) }}</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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