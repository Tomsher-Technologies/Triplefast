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
                        <a class="btn btn-sm btn-primary btn-add" href="{{ Session::has('last_url') ? Session::get('last_url') : route('sopc.index') }}">
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
                                        <h6>Sales Order Number: <span class="f-16 {{ $sopc->report_type }}" >{{ $sopc->so_number ?? '' }} </span></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-grid-table table-responsive">
                                            <table class="table">
                                                <tbody class="">
                                                    <tr class="col-sm-12">
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Customer Name</span>
                                                            <p>{{ $sopc->customer->first_name ?? '' }}</p>
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
                                                            <p>{{ ($sopc->enter_date != '') ? date('d-m-Y',strtotime($sopc->enter_date)) : '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Issue Date</span>
                                                            <p>{{ ($sopc->issue_date != '') ? date('d-m-Y',strtotime($sopc->issue_date)) : '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Started Date</span>
                                                            <p>{{ ($sopc->started_date != '') ? date('d-m-Y',strtotime($sopc->started_date)) : '' }}</p>
                                                        </td>
                                                        
                                                    </tr>

                                                    <tr class="col-sm-12">
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Due  Date</span>
                                                            <p>{{ ($sopc->due_date != '') ? date('d-m-Y',strtotime($sopc->due_date)) : '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Target Date</span>
                                                            <p>{{ ($sopc->target_date != '') ? date('d-m-Y',strtotime($sopc->target_date)) : ''}}</p>
                                                        </td>

                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Completed Date</span>
                                                            <p>{{ ($sopc->completed_date != '') ? date('d-m-Y',strtotime($sopc->completed_date)) : ''}}</p>
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
                                                            <p>{{ ($sopc->machining != '') ? date('d-m-Y',strtotime($sopc->machining)) : '' }}</p>
                                                        </td>
                                                    </tr>

                                                    <tr class="col-sm-12">
                                                       
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Heat Treatment</span>
                                                            <p>{{ ($sopc->heat_treatment != '') ? date('d-m-Y',strtotime($sopc->heat_treatment)) : '' }}</p>
                                                        </td>

                                                        <!-- <td class="order-td col-sm-4">
                                                            <span class="order-view">S1</span>
                                                            <p>{{ $sopc->s1_date ?? '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Subcon</span>
                                                            <p>{{ $sopc->subcon ?? '' }}</p>
                                                        </td> -->
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Stock</span>
                                                            <p>{{ $sopc->stock ?? '' }}</p>
                                                        </td>

                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Total Value</span>
                                                            <p>{{ $sopc->total_value ?? '' }}</p>
                                                        </td>
                                                    </tr>

                                                    <tr class="col-sm-12">
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Fasteners</span>
                                                            <p>{{ $sopc->fasteners ?? '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Gasket</span>
                                                            <p>{{ $sopc->gasket ?? '' }}</p>
                                                        </td>

                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">PTFE</span>
                                                            <p>{{ $sopc->ptfe ?? '' }}</p>
                                                        </td>
                                                    </tr>
                                                    <tr class="col-sm-12">
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">S1F</span>
                                                            <p>{{ $sopc->s1f ?? '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">S1G</span>
                                                            <p>{{ $sopc->s1g ?? '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">S1P</span>
                                                            <p>{{ $sopc->s1p ?? '' }}</p>
                                                        </td>
                                                    </tr>    

                                                    <tr class="col-sm-12">
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Partial Value (Balance)</span>
                                                            <p>{{ $sopc->partial ?? '' }}</p>
                                                        </td>

                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">FIM-PTFE</span>
                                                            <p>{{ $sopc->fim_ptfe ?? '' }}</p>
                                                        </td>
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">FIM-ZY</span>
                                                            <p>{{ $sopc->fim_zy ?? '' }}</p>
                                                        </td>

                                                    </tr>    

                                                    <tr class="col-sm-12">
                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Charges</span>
                                                            <p>{{ $sopc->charges ?? '' }}</p>
                                                        </td>

                                                        <td class="order-td col-sm-4">
                                                            <span class="order-view">Hold</span>
                                                            <p>{{ $sopc->hold ?? '' }}</p>
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

                                                        <td class="order-td col-sm-12 " colspan="3">
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
            <div class="user-skils col-sm-12 d-flex">
                <div class="border-bottom-0 col-sm-6">
                    <div class="card-header border-bottom-0 pt-sm-25 pb-sm-0  px-md-25 px-3">
                        <div class="profile-header-title">
                            S1 Data
                        </div>
                    </div>
                    <div class="card-body pt-md-1 pt-0">
                        <div class="">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody class="f-14">
                                        <tr>
                                            <th class="text-center">Date</th>
                                            <th class=" w-70">Content</th>
                                        </tr>
                                        @if($s1_data)
                                            @foreach($s1_data as $s1Data)
                                            <tr>
                                                <td class="text-center">
                                                    {{ ($s1Data['content_date'] != NULL) ? date('d-m-Y', strtotime($s1Data['content_date'])) : '' }}
                                                </td>
                                                <td class="">
                                                    {{ $s1Data['content'] ?? ''}}
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-bottom-0 col-sm-6">
                    <div class="card-header border-bottom-0 pt-sm-25 pb-sm-0  px-md-25 px-3">
                        <div class="profile-header-title">
                            Subcon Data
                        </div>
                    </div>
                    <div class="card-body pt-md-1 pt-0">
                        <div class="">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody class="f-14">
                                        <tr>
                                            <th class="text-center">Date</th>
                                            <th class=" w-70">Content</th>
                                        </tr>
                                        @if($subcon_data)
                                            @foreach($subcon_data as $sub)
                                            <tr>
                                                <td class="text-center">
                                                    {{ ($sub['content_date'] != NULL) ? date('d-m-Y', strtotime($sub['content_date'])) : '' }}
                                                </td>
                                                <td class="">
                                                    {{ $sub['content'] ?? ''}}
                                                </td>
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
                                        <th class="text-center">Line</th>
                                        <th class="text-center">Status</th>
                                        <th class=" w-30">Remarks</th>
                                        <th class="text-center ">Updated By</th>
                                        <th class="text-center ">Updated Date</th>
                                    </tr>
                                    @if($sopc->sopcItems)
                                        @foreach($sopc->sopcItems as $key => $item)
                                        <tr>
                                            <td class="text-center">
                                                <b>{{ $item->line_no }}</b>
                                                @if($item->is_cancelled == 1) <span class="error">(Cancelled)</span> @endif 
                                            </td>
                                            <td class="text-center">
                                                @if( $item->status == 1)
                                                <span class="badge badge-round completed badge-lg">Completed</span>
                                                @else
                                                <span class="badge badge-round cancelled badge-lg">Not Completed</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->remark }}</td>
                                            <td class="text-center">{{ $item->updatedUser->name ?? '' }}</td>
                                            <td class="text-center">{{ ($item->updated_at != NULL) ? date('d-m-Y', strtotime($item->updated_at)) : '' }}</td>
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
    .hot{
        color: red !important;
    }
    .oem{
        color: orange !important;
    }
    .tpi{
        color: #008cff !important;
    }
    .normal{
        color : black !important;
    }
    .f-16{
        font-size : 16px !important;
    }
</style>

@endsection