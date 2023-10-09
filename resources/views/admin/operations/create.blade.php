@extends('admin.layouts.app')
@section('title', 'Create Operation')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">Create New Operation</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">
                    <div class="action-btn">
                        <a class="btn btn-sm btn-primary btn-add" href="{{ route('operations.index') }}">
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
                    <div class="col-xl-7 col-lg-10">
                        <div class="mx-sm-30 mx-20 ">
                            <!-- Start: card -->
                            <div class="card add-product p-sm-30 p-20 mb-30">
                                <div class="card-body p-0">
                                    <div class="card-header">
                                        <h6 class="fw-500">About Operation</h6>
                                    </div>
                                    <!-- Start: card body -->
                                    <div class="add-product__body px-sm-40 px-20">
                                        <!-- Start: form -->
                                        <form class="form-horizontal" id="createOperation" action="{{ route('operations.store') }}" method="POST" autocomplete="off">
                                            @csrf
                                            <!-- form group -->
                                            <div class="form-group">
                                                <label for="name1">Operation ID<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="operation_id" name="operation_id" placeholder="Enter Operation ID" value="{{ old('operation_id') }}">
                                                @error('operation_id')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- form group 1 -->
                                            <div class="form-group">
                                                <label for="name2">Description<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="{{ old('description') }}">
                                                @error('description')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="button-group add-product-btn d-flex justify-content-end mt-40">
                                                <button class="btn btn-primary btn-default btn-squared text-capitalize" type="submit">Save
                                                </button>
                                                <a href="{{ route('operations.index') }}">
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