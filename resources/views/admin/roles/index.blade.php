@extends('admin.layouts.app')
@section('title', 'All Roles')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="breadcrumb-main user-member justify-content-sm-between ">
                <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                    <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                        <h4 class="text-capitalize fw-500 breadcrumb-title">Role Management</h4>
                        <!-- <span class="sub-title ml-sm-25 pl-sm-25">274 Users</span> -->
                    </div>
                </div>
                <div class="action-btn">
                    @can('role-create')
                        <a href="{{ route('roles.create') }}" class="btn px-15 btn-primary" >
                        <i class="las la-plus fs-16"></i>Create New Role</a>
                    @endcan
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="userDatatable global-shadow border p-30 bg-white radius-xl w-100 mb-30">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table mb-0 table-borderless">
                        <thead>
                            <tr class="userDatatable-header">
                                <th>
                                    <span class="userDatatable-title">Sl No</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Role Name</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">User Type</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($roles[0]))
                                @foreach ($roles as $key => $role)
                                    <tr>
                                        <td>
                                            <div class="userDatatable-content">
                                            {{ $key + 1 + ($roles->currentPage() - 1) * $roles->perPage() }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                {{ $role->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                {{ $role->title }}
                                            </div>
                                        </td>
                                        <td>                                   
                                            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap" style="justify-content: center;">
                                                @can('role-view')
                                                    <li>
                                                        <a href="{{ route('roles.show',$role->id) }}" class="view" title="View Roles"> <span data-feather="eye"></span></a>
                                                    </li>
                                                @endcan
                                                @can('role-edit')
                                                    <li>
                                                        <a href="{{ route('roles.edit', $role->id) }}" title="Edit Roles" class="edit"> <span data-feather="edit"></span></a>
                                                    </li>
                                                @endcan
                                                <!--                                                 
                                                @if(Auth::user()->user_type == 'super_admin' || Auth::user()->can('role-delete') )
                                                    <li>
                                                        <a href="#" class="remove deleteRoles" data-id="{{$role->id}}" title="Delete Role"> <span data-feather="trash-2"></span></a>
                                                    </li>
                                                @endif -->
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center">
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
                        {{ $roles->appends(request()->input())->links() }}
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('header')
<style>
.orderDatatable_actions li a svg {
    width: 20px !important;
}
</style>
@endsection

@section('footer')
<script type="text/javascript">
    
</script>
@endsection