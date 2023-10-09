@extends('admin.layouts.app')
@section('title', 'All Sales Orders')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="breadcrumb-main user-member justify-content-sm-between ">
                <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                    <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                        <h4 class="text-capitalize fw-500 breadcrumb-title">SOPC Reports</h4>
                        <!-- <span class="sub-title ml-sm-25 pl-sm-25">274 Users</span> -->
                    </div>
                </div>
                <div class="action-btn">
                    @can('sopc-create')
                    <a href="{{ route('sopc.create') }}" class="btn px-15 btn-primary">
                        <i class="las la-plus fs-16"></i>Create New SOPC Report</a>
                    @endcan
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="userDatatable global-shadow border p-10 bg-white radius-xl w-100 mb-30">
                @if ($message = Session::get('success'))
                <div class="alert-big alert alert-success  alert-dismissible fade show " role="alert">
                    <div class="alert-icon">
                        <span data-feather="layers"></span>
                    </div>
                    <div class="alert-content">
                        <h6 class="alert-heading">Success</h6>
                        <p>{{ $message }}</p>
                        <button type="button" class="close text-capitalize" data-dismiss="alert" aria-label="Close">
                            <span data-feather="x" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
                @endif

                <div class="table-responsive min-height750">
                    <div id="filter-form-container" class="footable-filtering-external footable-filtering-right">
                        <form class="form-inline"  autocomplete="off">
                            
                            <div class="form-group d-flex align-items-center adv-table-searchs__status  mt-15 mb-0 mr-sm-30 mr-0">
                                <label class="d-flex align-items-center mb-sm-0 mb-2">SO Number</label>
                                <input type="text" class="form-control ml-sm-10 ml-0" placeholder="Search with SO Number" id="so_number" name="so_number" value="{{ $search_so_number }}">
                            </div>

                            <div class="form-group atbd-select d-flex align-items-center adv-table-searchs__status  mt-15 mb-0 mr-sm-30 mr-0">
                                <label class="d-flex align-items-center mb-sm-0 mb-2">Status</label>
                                <select class="form-control ml-sm-10 ml-0"  name="status" id="status">
                                    <option {{ $status_search == "" ? 'selected' : '' }} value="">Select Status</option> 
                                    <option {{ $status_search == "0" ? 'selected' : '' }} value="0">Not Started</option> 
                                    <option {{ $status_search == "1" ? 'selected' : '' }} value="1">Started</option> 
                                    <option {{ $status_search == "2" ? 'selected' : '' }} value="2">Partial</option> 
                                    <option {{ $status_search == "3" ? 'selected' : '' }} value="3">Hold</option> 
                                    <option {{ $status_search == "4" ? 'selected' : '' }} value="4">Completed</option> 
                                    <option {{ $status_search == "5" ? 'selected' : '' }} value="5">Cancelled</option> 
                                </select>
                            </div>
                            
                            <div class="form-group d-flex align-items-center adv-table-searchs__position  my-15 mr-sm-20 mr-0 ">
                                <button class="btn btn-primary btn-sm btn-rounded "><span data-feather="filter"></span>
                                    Filter
                                </button>
                                <a href="{{ route('sopc.index') }}" class="btn btn-light btn-sm btn-rounded ml-2"><span data-feather="refresh-cw"></span>
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                    <table class="table mb-0 table-borderless">
                        <thead>
                            <tr class="userDatatable-header">
                                <th class="text-center">
                                    <span class="userDatatable-title">Sl No</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">SO Number</span>
                                </th>
                                
                                <th class="text-center">
                                    <span class="userDatatable-title">Issue Date</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">Started Date</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">Target Date</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">Completed Date</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">Status</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">Created By</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($data[0]))
                            @foreach ($data as $key => $report)
                            <tr>
                                <td class="text-center">
                                    <div class="userDatatable-content">
                                        {{ $key + 1 + ($data->currentPage() - 1) * $data->perPage() }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="userDatatable-content">
                                        {{ $report->so_number ?? '' }}
                                    </div>
                                </td>
                                
                                <td class="text-center">
                                    <div class="userDatatable-content" style="text-transform: none;">
                                        {{ ($report->issue_date != '') ? date('d-M-Y',strtotime($report->issue_date)) : '' }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="userDatatable-content" style="text-transform: none;">
                                        {{ ($report->started_date != '') ? date('d-M-Y',strtotime($report->started_date)) : '' }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="userDatatable-content" style="text-transform: none;">
                                        {{ ($report->target_date != '') ? date('d-M-Y',strtotime($report->target_date)) : ''}}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="userDatatable-content" style="text-transform: none;">
                                        {{ ($report->completed_date != '') ? date('d-M-Y',strtotime($report->completed_date)) : ''}}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="userDatatable-content">
                                        @if($report->job_status == 0)
                                        <span class="badge badge-round not_started badge-lg">Not Started</span>
                                        @elseif($report->job_status == 1)
                                        <span class="badge badge-round started badge-lg">Started</span>
                                        @elseif($report->job_status == 2)
                                        <span class="badge badge-round partial badge-lg">Partial</span>
                                        @elseif($report->job_status == 3)
                                        <span class="badge badge-round hold badge-lg">Hold</span>
                                        @elseif($report->job_status == 4)
                                        <span class="badge badge-round completed badge-lg">Completed</span>
                                        @elseif($report->job_status == 5)
                                        <span class="badge badge-round cancelled badge-lg">Cancelled</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="userDatatable-content">
                                        {{ $report->createdBy->name ?? '' }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="dropdown dropleft">
                                        <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span data-feather="more-horizontal"></span>
                                        </button>
                                        <div class="dropdown-menu">
                                            @can('sopc-view')
                                                <a class="dropdown-item" href="{{ route('sopc.show',$report->id) }}"><span data-feather="eye"></span> &nbsp;View Report Details</a>
                                                <a class="dropdown-item" href="{{ route('sopc.timeline',$report->id) }}"><span data-feather="clock"></span> &nbsp;View Timeline</a>
                                            @endcan
                                            @can('sopc-edit')
                                                <a class="dropdown-item" href="{{ route('sopc.edit', $report->id) }}">
                                                    <span data-feather="edit"></span>  &nbsp;Edit Report
                                                </a>
                                                <a class="dropdown-item" href="{{ route('sopc.notification', $report->id) }}">
                                                    <span data-feather="bell"></span>  &nbsp;Edit Notification Settings
                                                </a>
                                                <a class="dropdown-item" href="{{ route('sopc.status', $report->id) }}">
                                                    <span data-feather="edit"></span>  &nbsp;Edit Line Status
                                                </a>
                                            @endcan
                                           
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div class="atbd-empty__image">
                                        <img src="{{ asset('assets/images/1.svg')}}" alt="Admin Empty">
                                    </div>
                                    No data found.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $data->appends(request()->input())->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </div>
        
    </div>
</div>

@endsection

@section('header')

@endsection
@section('footer')

<script type="text/javascript">
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    $(document).on('click', '.deleteOrder', function() {
        var id = $(this).attr('data-id');
        Swal.fire({
            title: "Are you sure?",
            text: 'Do you want to continue?',
            icon: 'warning',
            confirmButtonText: "Yes, delete it!",
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('order.delete') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: '{{ @csrf_token() }}',
                    },
                    dataType: "html",
                    success: function() {
                        swal.fire("Done!", "Succesfully deleted!", "success");
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal.fire("Error deleting!", "Please try again", "error");
                    }
                });
            }
        });
    });

    $("#order_date").datepicker({
                                dateFormat: "yy-mm-dd",
                                changeMonth: true,
                                changeYear: true,
                                maxDate: '{{ date("Y-m-d") }}'
                            });

</script>
@endsection