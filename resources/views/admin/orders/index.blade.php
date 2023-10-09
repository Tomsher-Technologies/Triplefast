@extends('admin.layouts.app')
@section('title', 'All Sales Orders')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="breadcrumb-main user-member justify-content-sm-between ">
                <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                    <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                        <h4 class="text-capitalize fw-500 breadcrumb-title">All Sales Orders</h4>
                        <!-- <span class="sub-title ml-sm-25 pl-sm-25">274 Users</span> -->
                    </div>
                </div>
                <div class="action-btn">
                    @can('order-create')
                    <a href="{{ route('order.create') }}" class="btn px-15 btn-primary">
                        <i class="las la-plus fs-16"></i>Create New Sales Order</a>
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

                <div class="table-responsive">
                    <div id="filter-form-container" class="footable-filtering-external footable-filtering-right">
                        <form class="form-inline"  autocomplete="off">
                            <div class="form-group d-flex align-items-center adv-table-searchs__status  mt-15 mb-0 mr-sm-30 mr-0">
                                <label class="d-flex align-items-center mb-sm-0 mb-2">Search with keyword</label>
                                <input type="text" class="form-control ml-sm-10 ml-0" placeholder="Search" id="keyword" name="keyword" value="{{ $search_term }}">
                            </div>

                            <div class="form-group d-flex align-items-center adv-table-searchs__status  mt-15 mb-0 mr-sm-30 mr-0">
                                <label class="d-flex align-items-center mb-sm-0 mb-2">Order Date</label>
                                <input type="text" class="form-control ml-sm-10 ml-0" placeholder="YYYY-MM-DD" id="order_date" name="order_date" value="{{ $search_order_date }}">
                            </div>

                            <div class="form-group atbd-select d-flex align-items-center adv-table-searchs__status  mt-15 mb-0 mr-sm-30 mr-0">
                                <label class="d-flex align-items-center mb-sm-0 mb-2">Status</label>
                                <select class="form-control ml-sm-10 ml-0" name="status" id="status">
                                    <option value="">All</option>
                                    <option value="1" @if($status_search == '1') selected @endif>Engineer</option>
                                    <option value="2" @if($status_search == '2') selected @endif>Released</option>
                                    <option value="3" @if($status_search == '3') selected @endif>Completed</option>
                                </select>
                            </div>
                            
                            <div class="form-group d-flex align-items-center adv-table-searchs__position  my-15 mr-sm-20 mr-0 ">
                                <button class="btn btn-primary btn-sm btn-rounded "><span data-feather="filter"></span>
                                    Filter
                                </button>
                                <a href="{{ route('order.index') }}" class="btn btn-light btn-sm btn-rounded ml-2"><span data-feather="refresh-cw"></span>
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
                                    <span class="userDatatable-title">Order Number</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">Customer ID</span>
                                </th>
                                
                                <th class="text-center">
                                    <span class="userDatatable-title">Order Date</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">PO Number</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">Sales Person</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">Ship By</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">Status</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($data[0]))
                            @foreach ($data as $key => $order)
                            <tr>
                                <td class="text-center">
                                    <div class="userDatatable-content">
                                        {{ $key + 1 + ($data->currentPage() - 1) * $data->perPage() }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="userDatatable-content">
                                        {{ $order->order_no }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="userDatatable-content">
                                        {{ $order->customer->custom_id ?? '' }}

                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="userDatatable-content" style="text-transform: none;">
                                        {{ date('d-M-Y',strtotime($order->order_date)) }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="userDatatable-content">
                                        {{ $order->po_number ?? '' }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="userDatatable-content">
                                    {!! $order->sales_person->name !!}
                                    </div>
                                </td>
                                
                                <td class="text-center">
                                    <div class="userDatatable-content">
                                    {{ date('d-M-Y',strtotime($order->ship_by_date)) }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="userDatatable-content">
                                        @if($order->status == 1)
                                        <span class="badge badge-round badge-info badge-lg">Engineer</span>
                                        @elseif($order->status == 2)
                                        <span class="badge badge-round badge-warning badge-lg">Released</span>
                                        @elseif($order->status == 3)
                                        <span class="badge badge-round badge-success badge-lg">Completed</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="text-center">
                                    <ul class="orderDatatable_actions mb-0 d-flex flex-wrap"
                                        style="justify-content: center;">
                                        @can('order-view')
                                        <li>
                                            <a href="{{ route('order.show',$order->id) }}" class="view viewCustomer" title="View Sales Order" data-id="{{$order->id}}">
                                                <span data-feather="eye"></span></a>
                                        </li>
                                        @endcan

                                        @can('jobcard-view')
                                            <li>
                                                <a href="{{ route('job-cards',$order->id) }}" class="view viewCustomer" title="View Job Cards" data-id="{{$order->id}}">
                                                    <span data-feather="layers"></span></a>
                                            </li>
                                        @endcan

                                        @can('order-edit')
                                            @if($order->status == 1)
                                                <li>
                                                    <a href="{{ route('order.edit', $order->id) }}" title="Edit Sales Order"
                                                        class="edit"> <span data-feather="edit"></span></a>
                                                </li>
                                            @endif
                                        @endcan

                                        @can('order-delete')
                                            @if($order->status == 1)
                                                <li>
                                                    <a href="#" class="remove deleteOrder" data-id="{{$order->id}}"
                                                        title="Delete Sales Order"> <span data-feather="trash-2"></span></a>
                                                </li>
                                            @endif
                                        @endcan
                                    </ul>
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