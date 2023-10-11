@extends('admin.layouts.app')
@section('title', 'All Users')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="breadcrumb-main user-member justify-content-sm-between ">
                <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                    <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                        <h4 class="text-capitalize fw-500 breadcrumb-title">Users Management</h4>
                        <!-- <span class="sub-title ml-sm-25 pl-sm-25">274 Users</span> -->
                    </div>
                </div>
                <div class="action-btn">
                    @can('user-create')
                    <a href="{{ route('users.create') }}" class="btn px-15 btn-primary">
                        <i class="las la-plus fs-16"></i>Create New User</a>
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
                            <div class="form-group atbd-select d-flex align-items-center adv-table-searchs__position my-md-25 my-15 mr-sm-20 mr-0 ">
                                <label class="d-flex align-items-center mb-sm-0 mb-2">Team</label>
                                <select class="form-control ml-sm-10 ml-0" id="team" name="team">
                                    <option value="">All</option>
                                    @foreach($user_types as $type)
                                        <option @if($team_search == $type->id) selected  @endif value="{{ $type->id }}">{{ $type->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group d-flex align-items-center adv-table-searchs__position my-md-25 my-15 mr-sm-20 mr-0 ">
                                <button class="btn btn-primary btn-sm btn-rounded "><span data-feather="filter"></span>
                                    Filter
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-light btn-sm btn-rounded"><span data-feather="refresh-cw"></span>
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
                                    <span class="userDatatable-title">Name</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Team</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Role</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Email</span>
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
                            @foreach ($data as $key => $user)
                            <tr>
                                <td>
                                    <div class="userDatatable-content">
                                        {{ $key + 1 + ($data->currentPage() - 1) * $data->perPage() }}
                                    </div>
                                </td>
                                <td>
                                    <div class="userDatatable-content">
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td>
                                    <div class="userDatatable-content">
                                        {{ $user->userType[0]->title ?? '' }}

                                    </div>
                                </td>

                                <td>
                                    <div class="userDatatable-content">
                                        @php
                                        setPermissionsTeamId($user->user_type);
                                        @endphp
                                        @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                        {{ $v }}
                                        @endforeach
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="userDatatable-content" style="text-transform: none;">
                                        {{ $user->email }}
                                    </div>
                                </td>
                                

                                <td>
                                    <div class="userDatatable-content">
                                        @if($user->is_active == 1)
                                        <span class="badge badge-round badge-success badge-lg">Active</span>
                                        @else
                                        <span class="badge badge-round badge-danger badge-lg">Inactive</span>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <ul class="orderDatatable_actions mb-0 d-flex flex-wrap"
                                        style="justify-content: center;">
                                        @can('user-view')
                                        <li>
                                            <a href="#" class="view viewUser" title="View User" data-id="{{$user->id}}">
                                                <span data-feather="eye"></span></a>
                                        </li>
                                        @endcan
                                        @can('user-edit')
                                        <li>
                                            <a href="{{ route('users.edit', $user->id) }}" title="Edit User"
                                                class="edit"> <span data-feather="edit"></span></a>
                                        </li>
                                        @endcan

                                        @can('user-delete')
                                        <!-- <li>
                                            <a href="#" class="remove deleteUser" data-id="{{$user->id}}"
                                                title="Delete User"> <span data-feather="trash-2"></span></a>
                                        </li> -->
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
        <div class="modal-basic modal fade" id="viewUserData" tabindex="-1" role="dialog" style="display: none;"
            aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content modal-bg-white ">
                    <div class="modal-header">
                        <h6 class="modal-title">User Details</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-x">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg></button>
                    </div>
                    <div class="modal-body">
                        <div id="viewUserDataDiv">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-primary btn-sm">Save changes</button> -->
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
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
$(document).on('click', '.deleteUser', function() {
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
                url: "{{ route('users.delete') }}",
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

$(document).on('click', '.viewUser', function() {
    var id = $(this).attr('data-id');
    $.ajax({
        url: "{{ route('users.view') }}",
        type: "GET",
        data: {
            id: id,
            _token: '{{ @csrf_token() }}',
        },
        dataType: "html",
        success: function(reponse) {
            $('#viewUserDataDiv').html(reponse);
            $('#viewUserData').modal('show');
        }
    });
});
</script>
@endsection