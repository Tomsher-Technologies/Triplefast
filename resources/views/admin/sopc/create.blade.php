@extends('admin.layouts.app')
@section('title', 'Create SOPC Report')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">Create New SOPC Report</h4>
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
                    <div class="col-sm-12 col-lg-12">
                        <div class="mx-sm-30 mx-20 ">
                            <form class="form-horizontal repeater" id="saveSopc" action="{{ route('sopc.store') }}" method="POST" autocomplete="off">
                                @csrf
                            <!-- Start: card -->
                                <div class="card add-product p-sm-30 p-20 mb-30">
                                    <div class="card-body p-0">
                                        <div class="card-header">
                                            <h6 class="fw-500">ORDER DETAILS</h6>
                                        </div>
                                        <!-- Start: card body -->
                                        <div class="add-product__body px-sm-40 px-20 row">
                                            <!-- Start: form -->
                                                <!-- form group -->
                                                <div class="form-group col-sm-6">
                                                    <input type="hidden" name="permission" id="permission" value="{{ auth()->user()->can('sopc-edit-dates') }}">
                                                    <label for="name1">SO Number<span class="required">*</span></label>
                                                    <input type="text" class="form-control" id="so_number" name="so_number" placeholder="Enter SO Number" value="{{ old('so_number') }}">
                                                    <x-input-error name='so_number'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Enter Date<span class="required">*</span></label>
                                                    <input type="text" class="form-control" id="enter_date" name="enter_date" placeholder="DD-MM-YYYY" value="{{ old('enter_date') }}">
                                                    <x-input-error name='enter_date'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Issue Date<span class="required">*</span></label>
                                                    <input type="text" class="form-control" id="issue_date" name="issue_date" placeholder="DD-MM-YYYY" value="{{ old('issue_date') }}">
                                                    <x-input-error name='issue_date'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Started Date<span class="required">*</span></label>
                                                    <input type="text" class="form-control date-picker" id="started_date" name="started_date" placeholder="DD-MM-YYYY" value="{{ old('started_date') }}">
                                                    <x-input-error name='started_date'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Due Date<span class="required">*</span></label>
                                                    <input type="text" class="form-control date-picker" id="due_date" name="due_date" placeholder="DD-MM-YYYY" value="{{ old('due_date') }}">
                                                    <x-input-error name='due_date'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Target Date<span class="required">*</span></label>
                                                    <input type="text" class="form-control date-picker" id="target_date" name="target_date" placeholder="DD-MM-YYYY" value="{{ old('target_date') }}">
                                                    <x-input-error name='target_date'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Completed Date</label>
                                                    <input type="text" class="form-control date-picker" id="completed_date" name="completed_date" placeholder="DD-MM-YYYY" value="{{ old('completed_date') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Total Items<span class="required">*</span></label>
                                                    <input type="number" class="form-control" id="total_items" name="total_items" placeholder="Enter Total Items" value="{{ old('total_items') }}">
                                                    <x-input-error name='total_items'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Division</label>
                                                    <input type="text" class="form-control" id="division" name="division" placeholder="Enter Division" value="{{ old('division') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Customer<span class="required">*</span></label>
                                                    <select class="form-control" id="customer_id" name="customer_id">
                                                        <option value="">Select Customer</option> 
                                                    </select>
                                                    <x-input-error name='customer_id'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Customer PO. NO.<span class="required">*</span></label>
                                                    <input type="text" class="form-control" id="po_number" name="po_number" placeholder="Enter PO Number" value="{{ old('po_number') }}">
                                                    <x-input-error name='po_number'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name2">Jobs To Do</label>
                                                    <textarea class="form-control" id="jobs_to_do" name="jobs_to_do" >{{ old('jobs_to_do') }}</textarea>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Job Status<span class="required">*</span></label>
                                                    <select class="form-control" id="job_status" name="job_status">
                                                        <option {{ old('job_status') == "" ? 'selected' : '' }} value="">Select Status</option> 
                                                        <option {{ old('job_status') == "0" ? 'selected' : '' }} value="0">Not Started</option> 
                                                        <option {{ old('job_status') == "1" ? 'selected' : '' }}value="1">Started</option> 
                                                        <option {{ old('job_status') == "2" ? 'selected' : '' }} value="2">Partial</option> 
                                                        <option {{ old('job_status') == "3" ? 'selected' : '' }} value="3">Hold</option> 
                                                        <option {{ old('job_status') == "4" ? 'selected' : '' }} value="4">Completed</option> 
                                                        <option {{ old('job_status') == "5" ? 'selected' : '' }} value="5">Cancelled</option> 
                                                    </select>
                                                    <x-input-error name='job_status'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Machining</label>
                                                    <input type="text" class="form-control date-picker date-permission" id="machining" name="machining" placeholder="DD-MM-YYYY" value="{{ old('machining') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Heat Treatment</label>
                                                    <input type="text" class="form-control date-picker date-permission" id="heat_treatment" name="heat_treatment" placeholder="DD-MM-YYYY" value="{{ old('heat_treatment') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">S1</label>
                                                    <input type="text" class="form-control date-picker date-permission" id="s1_date" name="s1_date" placeholder="DD-MM-YYYY" value="{{ old('s1_date') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Subcon</label>
                                                    <input type="text" class="form-control date-picker date-permission" id="subcon" name="subcon" placeholder="DD-MM-YYYY" value="{{ old('subcon') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Stock</label>
                                                    <input type="text" class="form-control date-picker date-permission" id="stock" name="stock" placeholder="DD-MM-YYYY" value="{{ old('stock') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Total Value </label>
                                                    <input type="text" class="form-control" id="total_value" name="total_value" placeholder="Enter total value" value="{{ old('total_value') }}">
                                                </div>

                                                <!-- form group 1 -->
                                                
                                            <!-- End: form -->
                                        </div>
                                        <!-- End: card body -->
                                    </div>
                                </div>

                                <div class="button-group add-product-btn d-flex justify-content-end mt-40">
                                    <button class="btn btn-primary btn-default btn-squared text-capitalize" type="submit">Save
                                    </button>
                                    <a href="{{ route('sopc.index') }}">
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
    input:read-only {
        pointer-events : none !important;
    }
</style>
@endsection
@section('footer')
<script src="{{ asset('assets/vendor_assets/js/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('assets/vendor_assets/js/jquery/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
    let issueDate = '';
    $(document).ready(function() {
        var datePickerOptions = {
                                dateFormat: "dd-M-yy",
                                changeMonth: true,
                                changeYear: true,
                            };
        $("#issue_date,.date-picker").datepicker(datePickerOptions);
        $("#enter_date").datepicker( {
                                dateFormat: "dd-M-yy",
                                changeMonth: true,
                                changeYear: true,
                                maxDate: new Date()
                            });

        $(document).on('change', '#issue_date', function(){
            issueDate = $('#issue_date').val();
            $(".date-picker").datepicker( "option", "minDate", new Date(issueDate) );
        });

        var permissionCheck = $('#permission').val();
        
        if(permissionCheck != 1){
            $(".date-permission").datepicker().attr('readonly','readonly');    
        }

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
    });
   
    
</script>
@endsection