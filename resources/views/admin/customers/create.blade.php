@extends('admin.layouts.app')
@section('title', 'Create Customer')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="breadcrumb-main">
                    <h4 class="text-capitalize breadcrumb-title">Create New Customer</h4>
                    <div class="breadcrumb-action justify-content-center flex-wrap">
                        <div class="action-btn">
                            <a class="btn btn-sm btn-primary btn-add" href="{{ route('customer.index') }}">
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
                            <form class="form-horizontal repeater" id="createOperation" action="{{ route('customer.store') }}" method="POST" autocomplete="off">
                                <div class="card add-product p-sm-30 p-20 mb-30">
                                    <div class="card-body p-0">
                                        <div class="card-header">
                                            <h6 class="fw-500">About Customer</h6>
                                        </div>
                                        <!-- Start: card body -->
                                        <div class="add-product__body px-sm-40 px-20">
                                            <!-- Start: form -->
                                            @csrf
                                            <!-- form group -->
                                            <div class="form-group">
                                                <label for="name1">Customer Name<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter Customer Name" value="{{ old('customer_name') }}">
                                                @error('customer_name')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- form group 1 -->
                                            <div class="form-group">
                                                <label for="customer_id">Customer ID<span class="required">*</span></label>
                                                <input type="text" class="form-control" id="customer_id" name="customer_id" placeholder="Enter Customer ID" value="{{ old('customer_id') }}">
                                                @error('customer_id')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}">
                                                <!-- @error('email')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror -->
                                            </div>

                                            <div class="form-group">
                                                <label for="phone_number">Phone Number</label>
                                                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number" value="{{ old('phone_number') }}">
                                                <!-- @error('phone_number')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror -->
                                            </div>

                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <textarea class="form-control ckeditor" id="address" name="address" placeholder="Enter Address" >{{ old('address') }}</textarea>
                                                <!-- @error('address')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror -->
                                            </div>
                                            <!-- End: form -->
                                        </div>
                                    <!-- End: card body -->
                                    </div>
                                </div>
                                <!-- End: card -->

                                <!-- <div class="card add-product p-sm-30 p-20 ">
                                    <div class="card-body p-0">
                                        <div class="card-header">
                                            <h6 class="fw-500">Shipping Address</h6>
                                        </div>
                                        <div data-repeater-list="shipping">
                                       
                                            <div data-repeater-item class="mt-3 px-sm-40 px-20">
                                                <div class="form-group">
                                                    <label for="shipping_address">Address</label>
                                                    <textarea class="form-control ckeditor" id="shipping_address" name="shipping_address" rows="5" placeholder="Enter Address" >{{ old('address') }}</textarea>
                                                    @error('shipping_address')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="text-right">
                                                    <input data-repeater-delete class="btn btn-danger" type="button" value="Delete" />
                                                </div>
                                            </div>
                                        
                                        </div>
                                        <div class=" px-sm-40 px-20">
                                            <input data-repeater-create class="btn btn-primary my-3" type="button" value="Add New Address" />
                                        </div>
                                    </div>
                                    
                                </div> -->

                                <div class="button-group add-product-btn d-flex justify-content-end mt-40">
                                    <button class="btn btn-primary btn-default btn-squared text-capitalize" type="submit">Save
                                    </button>
                                    <a href="{{ route('customer.index') }}">
                                        <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize">Cancel
                                        </button>
                                    </a>
                                </div>
                            </form>
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
<script src="{{ asset('assets/vendor_assets/js/jquery.repeater.min.js') }}"></script>

<script type="text/javascript">
     $(document).ready(function() {
            $('.repeater').repeater({
                initEmpty: false,
                show: function() {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                isFirstItemUndeletable: true
            })
        });
    
</script>
@endsection