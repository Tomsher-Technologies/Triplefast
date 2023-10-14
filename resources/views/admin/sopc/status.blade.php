@extends('admin.layouts.app')
@section('title', 'Edit Line Status')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">Edit Line Status</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">
                    <div class="action-btn">
                        <a class="btn btn-sm btn-primary btn-add" href="{{ route('sopc.index') }}">
                            <i class="la la-arrow-left"></i> Back </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <!-- Start: product page -->
            <div class="global-shadow border px-sm-30 py-sm-50 px-0 py-20 bg-white radius-xl w-100 mb-40">
                <div class="row justify-content-center">
                    <div class="col-xl-12 col-lg-12">
                        <div class="mx-sm-30 mx-20 ">
                            <!-- Start: card -->
                            <div class="card add-product p-sm-30 p-20 mb-30">
                                <div class="card-body p-0">
                                    <div class="card-header">
                                        <h4 class="fw-500 no-text-transform">SO Number : <b>{{$sopc->so_number}}</b>
                                        </h4>
                                    </div>
                                    <!-- Start: card body -->
                                    <div class="px-sm-40 px-20">
                                        <!-- Start: form -->
                                        <form class="form-horizontal" id="createPart" action="{{ route('sopc.status-store') }}" method="POST" autocomplete="off">
                                            @csrf
                                            <!-- form group -->
                                            <div class="form-group">
                                                <input type="hidden" name="sopc_id" value="{{ $sopc->id }}">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <th class="middle-center">Line Number</th>
                                                                <th class="middle-center">Status</th>
                                                                <th class="middle-center w-40">Remarks</th>
                                                                <th class="middle-center ">Updated By</th>
                                                                <th class="middle-center ">Updated Date</th>
                                                            </tr>
                                                            @foreach($items as $itm)
                                                                <tr>
                                                                    <td class="middle-center">
                                                                        <label class="ml-2">{{ $itm['line_no'] }}</label>
                                                                    </td>
                                                                    <td class="middle-center">
                                                                        <input class="custom-checkbox name" type="checkbox" value="" name="status[{{$itm['id']}}-{{$itm['line_no']}}]" id="status" {{ ($itm['status'] == 1) ? 'checked' : '' }}>
                                                                    </td>
                                                                   
                                                                    <td>
                                                                        <textarea class="form-control" name="remark[{{$itm['id']}}-{{$itm['line_no']}}]" rows="2">{{ $itm['remark'] }}</textarea>
                                                                    </td>
                                                                    <td class="middle-center"> 
                                                                        {{ $itm['updated_by']['name'] ?? '' }}
                                                                    </td>
                                                                    <td class="middle-center"> 
                                                                        {{ ($itm['updated_at'] != NULL) ? date('d-m-Y', strtotime($itm['updated_at'])) : '' }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                                @error('users')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="button-group add-product-btn d-flex justify-content-center mb-30">
                                                <button class="btn btn-primary btn-default btn-squared text-capitalize" type="submit">Save
                                                </button>
                                                <a href="{{ route('sopc.index') }}">
                                                    <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize"  type="button">Cancel
                                                    </button>
                                                </a>
                                            </div>
                                        </form>
                                        <!-- End: form -->
                                    </div>
                                    <!-- End: card body -->
                                </div>
                            </div>
                            <!-- End: card -->
                        </div>
                    </div>
                    <!-- ends: col-lg-8 -->
                </div>
            </div>
            <!-- End: Product page -->
        </div>
        <!-- ends: col-lg-12 -->
    </div>
</div>

@endsection

@section('footer')
<script type="text/javascript">

</script>
@endsection