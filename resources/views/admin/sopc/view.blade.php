@extends('admin.layouts.app')
@section('title', 'View SOPC Report Details')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">View SOPC Report Details</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">
                    <div class="action-btn d-flex">
                        <a class="btn btn-sm btn-primary btn-add" href="{{ route('sopc.index') }}">
                            <i class="la la-arrow-left"></i> Back </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cos-lg-12 col-md-12  ">
        <div class="card mb-25">
            <div class="user-info border-bottom-0">
                <div class="card-header border-bottom-0 pt-sm-25 pb-sm-0  px-md-25 px-3">
                    <div class="profile-header-title">
                        SOPC info
                    </div>
                </div>
                <div class="card-body pt-md-1 pt-0 pb-0">
                    <div class="columnGrid-wrapper">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-default card-md bg-white card-bordered">
                                    <div class="card-header">
                                        <h6>Sales Order Number: {{ $sopc->so_number ?? '' }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-grid-table table-responsive">
                                            <table class="table">
                                                <tbody class="">
                                                    <tr class="col-sm-12">
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Customer Name</span>
                                                            <p>{{ $sopc->customer->first_name ?? '' }} {{ $sopc->customer->last_name ?? '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Customer ID</span>
                                                            <p>{{ $sopc->customer->custom_id ?? '' }} </p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Customer PO. NO.</span>
                                                            <p>{{ $sopc->po_number ?? '' }}</p>
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr class="col-sm-12">
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Enter Date</span>
                                                            <p>{{ ($sopc->enter_date != '') ? date('d-M-Y',strtotime($sopc->enter_date)) : '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Issue Date</span>
                                                            <p>{{ ($sopc->issue_date != '') ? date('d-M-Y',strtotime($sopc->issue_date)) : '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Started Date</span>
                                                            <p>{{ ($sopc->started_date != '') ? date('d-M-Y',strtotime($sopc->started_date)) : '' }}</p>
                                                        </td>
                                                        
                                                    </tr>

                                                    <tr class="col-sm-12">
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Due  Date</span>
                                                            <p>{{ ($sopc->due_date != '') ? date('d-M-Y',strtotime($sopc->due_date)) : '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Target Date</span>
                                                            <p>{{ ($sopc->target_date != '') ? date('d-M-Y',strtotime($sopc->target_date)) : ''}}</p>
                                                        </td>

                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Completed Date</span>
                                                            <p>{{ ($sopc->completed_date != '') ? date('d-M-Y',strtotime($sopc->completed_date)) : ''}}</p>
                                                        </td>
                                                       
                                                    </tr>
                                                    <tr class="col-sm-12">
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Total Items </span>
                                                            <p>{{ $sopc->total_items ?? 0 }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Division </span>
                                                            <p>{{ $sopc->division ?? '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Machining</span>
                                                            <p>{{ ($sopc->machining != '') ? date('d-M-Y',strtotime($sopc->machining)) : '' }}</p>
                                                        </td>
                                                    </tr>

                                                    <tr class="col-sm-12">
                                                       
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Heat Treatment</span>
                                                            <p>{{ ($sopc->heat_treatment != '') ? date('d-M-Y',strtotime($sopc->heat_treatment)) : '' }}</p>
                                                        </td>

                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">S1</span>
                                                            <p>{{ ($sopc->s1_date != '') ? date('d-M-Y',strtotime($sopc->s1_date)) : '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Subcon</span>
                                                            <p>{{ ($sopc->subcon != '') ? date('d-M-Y',strtotime($sopc->subcon)) : '' }}</p>
                                                        </td>
                                                    </tr>

                                                    <tr class="col-sm-12">
                                                        
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Stock</span>
                                                            <p>{{ ($sopc->stock != '') ? date('d-M-Y',strtotime($sopc->stock)) : '' }}</p>
                                                        </td>

                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Total Value</span>
                                                            <p>{{ $sopc->total_value ?? '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Status </span>
                                                            <p>
                                                            @if($sopc->job_status == 0)
                                                            <span class="badge badge-round not_started badge-lg">Not Started</span>
                                                            @elseif($sopc->job_status == 1)
                                                            <span class="badge badge-round started badge-lg">Started</span>
                                                            @elseif($sopc->job_status == 2)
                                                            <span class="badge badge-round partial badge-lg">Partial</span>
                                                            @elseif($sopc->job_status == 3)
                                                            <span class="badge badge-round hold badge-lg">Hold</span>
                                                            @elseif($sopc->job_status == 4)
                                                            <span class="badge badge-round completed badge-lg">Completed</span>
                                                            @elseif($sopc->job_status == 5)
                                                            <span class="badge badge-round cancelled badge-lg">Cancelled</span>
                                                            @endif
                                                            </p>
                                                        </td>

                                                    </tr>

                                                    <tr class="col-sm-12">
                                                        
                                                        <td colspan="3" class="order-td col-sm-12">
                                                            <span class="order-view">Jobs To Do </span>
                                                            <p>{{ $sopc->jobs_to_do ?? '' }}</p>
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
            <div class="user-skils border-bottom-0">
                <div class="card-header border-bottom-0 pt-sm-25 pb-sm-0  px-md-25 px-3">
                    <div class="profile-header-title">
                        Lines Status
                    </div>
                </div>
                <div class="card-body pt-md-1 pt-0">
                    <div class="">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody class="f-14">
                                    <tr>
                                        <th class="text-center w-20">Line</th>
                                        <th class="text-center w-30">Status</th>
                                        <th>Remarks</th>
                                    </tr>
                                    @if($sopc->sopcItems)
                                        @foreach($sopc->sopcItems as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $item->line_no }}</td>
                                            <td class="text-center">
                                                @if( $item->status == 1)
                                                <span class="badge badge-round completed badge-lg">Completed</span>
                                                @else
                                                <span class="badge badge-round cancelled badge-lg">Not Completed</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->remark }}</td>
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