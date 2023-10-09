@extends('admin.layouts.app')
@section('title', 'Update Sales Order')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">Update Sales Order Details</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">
                    <div class="action-btn">
                        <a class="btn btn-sm btn-primary btn-add" href="{{ route('order.index') }}">
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
                    <div class="col-sm-12 col-lg-12">
                        <div class="mx-sm-30 mx-20 ">
                            
                            {!! Form::model($order, ['method' => 'PATCH','id' => 'saveOrder','class' => 'form-horizontal repeater','autocomplete' => 'off','route' => ['order.update', $order->id]]) !!}
                            @csrf
                            <!-- Start: card -->
                                <div class="card add-product p-sm-30 p-20 mb-30">
                                    <div class="card-body p-0">
                                        <div class="card-header">
                                            <h6 class="fw-500">Order Details</h6>
                                        </div>
                                        <!-- Start: card body -->
                                        <div class="add-product__body px-sm-40 px-20 row">
                                            <!-- Start: form -->
                                                <!-- form group -->
                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Order Number<span class="required">*</span></label>
                                                    <input type="text" class="form-control" id="order_number" name="order_number" placeholder="Enter Order Number" value="{{ $order->order_no ?? ''}}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Order Date<span class="required">*</span></label>
                                                    <input type="text" class="form-control" disabled id="order_date" name="order_date" placeholder="DD-MM-YYYY" value="{{ date('d-M-Y', strtotime($order->order_date)) ?? ''}}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Customer<span class="required">*</span></label>
                                                    <select class="form-control" id="customer_id" name="customer_id">
                                                        <option value="">Select Customer</option> 
                                                        <option value="{{ $order->customer_id }}" selected>{{ $order->customer->first_name ?? '' }} {{ $order->customer->last_name ?? '' }}</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Customer Shipping Address<span class="required">*</span></label>
                                                    <select class="form-control" id="shipping_address" name="shipping_address">
                                                        <option value="">Select Shipping Address</option> 
                                                        @foreach($custShipAddress as $ship)
                                                            <option {{ ($ship->id == $order->shipping_id) ? 'selected' : '' }} value="{{ $ship->id }}">{{ $ship->shipping_address }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Need By Date<span class="required">*</span></label>
                                                    <input type="text" class="form-control date-picker" id="need_by_date" name="need_by_date" placeholder="DD-MM-YYYY" value="{{ date('d-M-Y', strtotime($order->need_by_date)) ?? ''}}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Ship By Date<span class="required">*</span></label>
                                                    <input type="text" class="form-control date-picker" id="ship_by_date" name="ship_by_date" placeholder="DD-MM-YYYY" value="{{ date('d-M-Y', strtotime($order->ship_by_date)) ?? ''}}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">PO Number<span class="required">*</span></label>
                                                    <input type="text" class="form-control" id="po_number" name="po_number" placeholder="Enter PO Number" value="{{ $order->po_number ?? ''}}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Sales Person<span class="required">*</span></label>
                                                    <select class="form-control" id="sales_person" name="sales_person">
                                                        <option value="">Select Sales Person</option> 
                                                        @foreach($salesTeam as $sales)
                                                            <option {{ ($sales->id == $order->sales_person_id) ? 'selected' : '' }} value="{{ $sales->id }}">{{ $sales->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Terms<span class="required">*</span></label>
                                                    <input type="text" class="form-control" id="terms" name="terms" placeholder="Enter Terms" value="{{ $order->terms ?? ''}}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Shipping Terms <span class="required">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_terms" name="shipping_terms" placeholder="Shipping Terms" value="{{ $order->shipping_terms ?? ''}}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Shipping Via <span class="required">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_via" name="shipping_via" placeholder="Shipping Via" value="{{ $order->shipping_via ?? ''}}">
                                                </div>

                                                <!-- form group 1 -->
                                                <div class="form-group col-sm-6">
                                                    <label for="name2">Description</label>
                                                    <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="{{ $order->description ?? ''}}">
                                                </div>
                                            <!-- End: form -->
                                        </div>
                                        <!-- End: card body -->
                                    </div>
                                </div>

                                <div class="card add-product p-sm-30 p-20 mb-30 ">
                                    <div class="card-body p-0">
                                        <div class="card-header">
                                            <h6 class="fw-500">Required Parts</h6>
                                        </div>
                                        <div data-repeater-list="shipping">
                                        <!-- Start: product body -->
                                            <div data-repeater-item class="add-product__body px-sm-40 px-20 row">
                                                <input type="hidden" class="form-control" name="order_part_id" id="order_part_id" value="0">
                                                <div class="form-group col-sm-4 mb-10">
                                                    <label for="part_number">Part Number<span class="required">*</span></label>
                                                    <select class="form-control dynamic part_numbers" id="part_number" name="part_number">
                                                        <option value="">Select Part Number</option> 
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-4 mb-10">
                                                    <label for="name2">Quantity<span class="required">*</span></label>
                                                    <input type="text" class="form-control dynamic" id="quantity" name="quantity" placeholder="Enter Quantity" value="">
                                                </div>

                                                <div class="form-group col-sm-4 mb-10">
                                                    <label for="name1">Need By Date<span class="required">*</span></label>
                                                    <input type="text" class="form-control dynamic_date  date-picker" id="line_need_by_date" name="line_need_by_date" placeholder="DD-MM-YYYY" value="">
                                                </div>

                                                <div class="form-group col-sm-8 mb-10">
                                                    <label for="name2">Part Description<span class="required">*</span></label>
                                                    <textarea class="form-control dynamic" rows="3" id="part_description" name="part_description" ></textarea>
                                                </div>

                                                <div class="form-group col-sm-4 mb-10">
                                                    <label for="name2">Rev</label>
                                                    <textarea class="form-control dynamic" rows="3" id="rev" name="rev" ></textarea>
                                                </div>

                                                

                                                <div class="text-right col-sm-12 mb-10 d-block">
                                                    <input data-repeater-delete class="btn btn-danger d-initial" type="button" value="Delete" />
                                                </div>
                                            </div>
                                        <!-- End: product body -->
                                        </div>
                                        <div class=" px-sm-40 px-20 col-sm-12 mb-10">
                                            <input data-repeater-create class="btn btn-primary my-3" type="button" value="Add New Part" />
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="button-group add-product-btn d-flex justify-content-end mt-40">
                                    <button class="btn btn-primary btn-default btn-squared text-capitalize" type="submit">Save
                                    </button>
                                    <a href="{{ route('order.index') }}">
                                        <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize"  type="button">Cancel
                                        </button>
                                    </a>
                                </div>
                            </form>
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

@section('header')
<style>
    .add-product__body .form-group textarea {
        padding: 10px 15px;
        min-height: 90px;
    }
    .add-product__body {
        padding: 10px 28px;
    }
    
</style>
@endsection
@section('footer')
<script src="{{ asset('assets/vendor_assets/js/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('assets/vendor_assets/js/jquery/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
    let orderDate = '';
    $(document).ready(function() {
        var datePickerOptions = {
                                dateFormat: "dd-M-yy",
                                changeMonth: true,
                                changeYear: true,
                                minDate:  new Date('{{$order->order_date}}')
                            };
        $("#order_date,#need_by_date,#ship_by_date,.dynamic_date").datepicker(datePickerOptions);

      
        $("#saveOrder").validate({
            rules: {
                order_number: {
                    required: true
                },
                order_date:{
                    required:true
                },
                customer:{
                    required:true
                },
                shipping_address:{
                    required:true
                },
                need_by_date:{
                    required:true
                },
                ship_by_date:{
                    required:true
                },
                po_number:{
                    required:true
                },
                sales_person:{
                    required:true
                },
                terms:{
                    required:true
                },
                shipping_terms:{
                    required:true
                },
                shipping_via:{
                    required:true
                },
                description:{
                    required:true
                },
                'shipping[0][part_number]':{
                    required:true
                },
                'shipping[0][quantity]':{
                    required:true
                },
                'shipping[0][part_description]':{
                    required:true
                },
                'shipping[0][line_need_by_date]':{
                    required:true
                },
                
            },
            errorPlacement: function (error, element) {
                if(element.hasClass('select2')) {
                    error.insertAfter(element.next('.select2-container'));
                }else{
                    error.appendTo(element.parent("div"));
                }
            },
            submitHandler: function(form,event) {
                
                form.submit();
            }
        });

        var $repeater =  $('.repeater').repeater({
            initEmpty: false,
            show: function(e) {
                $(this).slideDown();
                var repeaterItems = $("div[data-repeater-item]");
                addFieldValidation(repeaterItems.length - 1);
            },
            hide: function(deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            isFirstItemUndeletable: true
        });

        var data = {!! $order_parts !!};
        
        $repeater.setList(data);
        
        var repeaterItems = $("div[data-repeater-item]").length;
        
        for (rep = 0; rep < repeaterItems; rep++) {
            addFieldValidation(rep);
            var field = '#part_number'+rep;
            var dataJson = data[rep];
            $(field).append(dataJson.part_number).trigger('change');
        }
       

       
        $(document).on('change', '#order_date', function(){
            orderDate = $('#order_date').val();
            $(".date-picker").datepicker( "option", "minDate", new Date(orderDate) );
        });

        $('#customer_id').select2({
            minimumInputLength: 2,
            width: 'inherit',
            placeholder: 'Select a customer by Name/Customer ID',
            ajax: {
                url: '{{ route("ajax-customers") }}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.first_name+ ' '+ item.last_name +' - '+item.custom_id,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });   

        $('#shipping_address').select2();
        
        $(document).on('change', '#customer_id', function(){
            var customer_id = $('#customer_id').val();
          
            $.ajax({
                url: "{{ route('customer-addresses') }}",
                type: "GET",
                data: {
                    id: customer_id,
                    _token:'{{ @csrf_token() }}',
                },
                success: function (response) {
                    $('#shipping_address').empty();
                    $('#shipping_address').append(response).trigger('change');
                }
            });
        });
        initailizeSelect2()
        
    });
    function initailizeSelect2(){
        $('.part_numbers').select2({
            minimumInputLength: 3,
            width: 'inherit',
            placeholder: 'Select part number',
            ajax: {
                url: '{{ route("ajax-parts") }}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.part_number ,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        }); 
    }  

        
 
    function addFieldValidation(count,datePickerOptions){
        count = parseInt(count);
    
        $('[name="shipping['+count+'][part_number]"]').attr("id","part_number"+count);
        $('[name="shipping['+count+'][quantity]"]').attr("id","quantity"+count);
        $('[name="shipping['+count+'][part_description]"]').attr("id","part_description"+count);
        $('[name="shipping['+count+'][line_need_by_date]"]').attr("id","line_need_by_date"+count);

        $("#part_number"+count).rules('add', { required: true });
        $("#quantity"+count).rules('add', { required: true });
        $("#part_description"+count).rules('add', { required: true });
        $("#line_need_by_date"+count).rules('add', { required: true });

        $(".dynamic_date").removeClass('hasDatepicker').datepicker({
                                dateFormat: "dd-M-yy",
                                changeMonth: true,
                                changeYear: true,
                                minDate:  new Date('{{$order->order_date}}')
                            });
        if(orderDate != ''){
            $(".dynamic_date").datepicker( "option", "minDate", new Date(orderDate) );
        }
        initailizeSelect2();
    }
    
</script>
@endsection