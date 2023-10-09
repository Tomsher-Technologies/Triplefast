@extends('admin.layouts.app')

@section('title', 'All Parts')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="breadcrumb-main user-member justify-content-sm-between ">
                <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                    <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                        <h4 class="text-capitalize fw-500 breadcrumb-title">Parts Management</h4>
                        <!-- <span class="sub-title ml-sm-25 pl-sm-25">274 Users</span> -->
                    </div>
                </div>
                <div class="action-btn d-flex">
                    @can('parts-create')
                    <a href="{{ route('parts.bulk-create') }}" class="btn px-15 btn-success">
                        <i class="las la-upload fs-16"></i>Upload Bulk Parts</a>
                    <a href="{{ route('parts.create') }}" class="btn px-15 btn-primary ml-3">
                        <i class="las la-plus fs-16"></i>Create New Part</a>
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
                @elseif ($message = Session::get('error'))
                <div class="alert-big alert alert-danger  alert-dismissible fade show " role="alert">
                    <div class="alert-icon">
                        <span data-feather="layers"></span>
                    </div>
                    <div class="alert-content">
                        <h6 class="alert-heading">Error</h6>
                        <p>{{ $message }}</p>
                        <button type="button" class="close text-capitalize" data-dismiss="alert" aria-label="Close">
                            <span data-feather="x" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
                @endif

                @if ($message = Session::get('warning'))
                <div class="alert-big alert alert-warning  alert-dismissible fade show " role="alert">
                    <div class="alert-icon">
                        <span data-feather="layers"></span>
                    </div>
                    <div class="alert-content">
                        <h6 class="alert-heading">Warning</h6>
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
                            <div class="form-group d-flex align-items-center adv-table-searchs__status my-md-25 mt-15 mb-0 mr-sm-30 mr-0">
                                <label class="d-flex align-items-center mb-sm-0 mb-2">Search with keyword</label>
                                <input type="text" class="form-control ml-sm-10 ml-0" placeholder="Search" id="keyword" name="keyword" value="{{ $search_term }}">
                            </div>
                            <div class="form-group atbd-select d-flex align-items-center adv-table-searchs__status my-md-25 mt-15 mb-0 mr-sm-30 mr-0">
                                <label class="d-flex align-items-center mb-sm-0 mb-2">Status</label>
                                <select class="form-control ml-sm-10 ml-0" name="status" id="status">
                                    <option value="">All</option>
                                    <option value="1" @if($status_search == '1') selected @endif>Active</option>
                                    <option value="0" @if($status_search == '0') selected @endif>Inactive</option>
                                </select>
                            </div>

                            <div class="form-group d-flex align-items-center adv-table-searchs__position my-md-25 my-15 mr-sm-20 mr-0 ">
                                <button class="btn btn-primary btn-sm btn-rounded "><span data-feather="filter"></span>
                                    Filter
                                </button>
                                <a href="{{ route('parts.index') }}" class="btn btn-light btn-sm btn-rounded"><span data-feather="refresh-cw"></span>
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                    <table class="table mb-0 table-borderless">
                        <thead>
                            <tr class="userDatatable-header">
                                <th>
                                    <span class="userDatatable-title">Sl No</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Part Number</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Description</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Status</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($data[0]))
                            @foreach ($data as $key => $part)
                            <tr>
                                <td>
                                    <div class="userDatatable-content">
                                        {{ $key + 1 + ($data->currentPage() - 1) * $data->perPage() }}
                                    </div>
                                </td>
                                <td>
                                    <div class="userDatatable-content">
                                        {{ $part->part_number }}
                                    </div>
                                </td>
                                <td>
                                    <div class="userDatatable-content">
                                        {{ $part->description ?? '' }}

                                    </div>
                                </td>
                                <td>
                                    <div class="userDatatable-content">
                                        @if($part->is_active == 1)
                                        <span class="badge badge-round badge-success badge-lg">Active</span>
                                        @else
                                        <span class="badge badge-round badge-danger badge-lg">Inactive</span>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <ul class="orderDatatable_actions mb-0 d-flex flex-wrap"
                                        style="justify-content: center;">
                                       
                                        @can('parts-edit')
                                        <li>
                                            <a href="{{ route('parts.edit', $part->id) }}" title="Edit Parts" class="edit"> <span data-feather="edit"></span></a>
                                        </li>
                                        @endcan

                                        @can('parts-delete')
                                        <li>
                                            <a href="#" class="remove deleteParts" data-id="{{$part->id}}"
                                                title="Delete Parts"> <span data-feather="trash-2"></span></a>
                                        </li>
                                        @endcan
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="text-center">
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

$(document).on('click', '.deleteParts', function() {
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
                url: "{{ route('parts.delete') }}",
                type: "POST",
                data: {
                    id: id,
                    _token: '{{ @csrf_token() }}',
                },
                dataType: "html",
                success: function(resp) {
                    if(resp == 0){
                        swal.fire("Done!", "Succesfully deleted!", "success");
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    }else{
                        swal.fire("Error!", "Failed! It is already used for sales orders.", "error");
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal.fire("Error deleting!", "Please try again", "error");
                }
            });
        }
    });
});

</script>
@endsection