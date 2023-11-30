@extends('admin.layouts.app')
@section('title', 'Notifications')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="breadcrumb-main user-member justify-content-sm-between ">
                <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                    <div class="d-flex align-items-center user-member__title justify-content-center mr-sm-25">
                        <h4 class="text-capitalize fw-500 breadcrumb-title">All Notifications</h4>
                        <!-- <span class="sub-title ml-sm-25 pl-sm-25">274 Users</span> -->
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class=" projectDatatable project-table global-shadow border p-10 bg-white radius-xl w-100 mb-30">
               
                <div class="table-responsive">
                    <div id="filter-form-container" class="footable-filtering-external footable-filtering-right">
                        <form class="form-inline"  autocomplete="off">
                    
                            <div class="form-group d-flex align-items-center adv-table-searchs__status  mt-15 mb-0 mr-sm-30 mr-0">
                                <label class="d-flex align-items-center mb-sm-0 mb-2">Date</label>
                                <input type="text" class="form-control ml-sm-10 ml-0" placeholder="DD-MM-YYYY" id="date_search" name="date_search" value="{{ $date_search }}">
                            </div>

                            <div class="form-group d-flex align-items-center adv-table-searchs__position  my-15 mr-sm-20 mr-0 ">
                                <button class="btn btn-primary btn-sm btn-rounded "><span data-feather="filter"></span>
                                    Filter
                                </button>
                                <a href="{{ route('notifications') }}" class="btn btn-light btn-sm btn-rounded ml-2"><span data-feather="refresh-cw"></span>
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                    <table class="table mb-0 table-bordered">
                        <thead>
                            <tr class="userDatatable-header">
                                <th class="text-center">
                                    <span class="userDatatable-title">Sl No</span>
                                </th>
                                <th class="w-70">
                                    <span class="userDatatable-title">Notifications</span>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title">Date</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($notifications[0]))
                            @foreach ($notifications as $key => $not)
                            <tr>
                                <td class="text-center">
                                    <div class="userDatatable-content">
                                        {{ $key + 1 + ($notifications->currentPage() - 1) * $notifications->perPage() }}
                                    </div>
                                </td>
                                <td>
                                    <div class="userDatatable-content">
                                        {!! $not->content !!}
                                        @if($not->is_read == 0)
                                        <span class="badge badge-success menuItem">New</span>
                                        @endif
                                    </div>
                                </td>
                                
                                <td class="text-center">
                                    <div class="userDatatable-content" style="text-transform: none;">
                                        {{ ($not->created_at) ? date('d-m-Y H:i a',strtotime($not->created_at)) : '' }}
                                        
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="3" class="text-center">
                                    <div class="atbd-empty__image">

                                        <img src="{{ asset('assets/images/1.svg')}}" alt="Empty">

                                    </div>
                                    No data found.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $notifications->appends(request()->input())->links('pagination::bootstrap-5') }}
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
    

    $("#date_search").datepicker({
                                dateFormat: "dd-mm-yy",
                                changeMonth: true,
                                changeYear: true,
                                maxDate: '{{ date("d-m-Y") }}'
                            });

</script>
@endsection