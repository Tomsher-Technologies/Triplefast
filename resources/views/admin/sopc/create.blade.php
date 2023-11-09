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
                        <a class="btn btn-sm btn-primary btn-add" href="{{ Session::has('last_url') ? Session::get('last_url') : route('sopc.index') }}">
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
                            <form class="form-horizontal " id="saveSopc" action="{{ route('sopc.store') }}" method="POST" autocomplete="off">
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
                                                    <label for="name1">Report Type</label>
                                                    <select class="form-control" id="report_type" name="report_type">
                                                        <option {{ (old('report_type') == 'normal') ? 'selected' : '' }}  value="normal" >Normal</option>
                                                        <option {{ (old('report_type') == "hot") ? 'selected' : '' }} value="hot">Hot Jobs</option>
                                                        <option {{ (old('report_type') == 'oem') ? 'selected' : '' }}  value="oem">OEM</option>
                                                        <option {{ (old('report_type') == 'tpi') ? 'selected' : '' }}  value="tpi">TPI</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Enter Date</label>
                                                    <input type="text" class="form-control" id="enter_date" name="enter_date" placeholder="DD-MM-YYYY" value="{{ old('enter_date') }}" readonly>
                                                    <x-input-error name='enter_date'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Issue Date</label>
                                                    <input type="text" class="form-control" id="issue_date" name="issue_date" placeholder="DD-MM-YYYY" value="{{ old('issue_date') }}" readonly>
                                                    <x-input-error name='issue_date'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Started Date</label>
                                                    <input type="text" class="form-control date-picker" id="started_date" name="started_date" placeholder="DD-MM-YYYY" value="{{ old('started_date') }}" readonly>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Due Date</label>
                                                    <input type="text" class="form-control date-picker" id="due_date" name="due_date" placeholder="DD-MM-YYYY" value="{{ old('due_date') }}" readonly>
                                                    <x-input-error name='due_date'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Target Date</label>
                                                    <input type="text" class="form-control date-picker" id="target_date" name="target_date" placeholder="DD-MM-YYYY" value="{{ old('target_date') }}" readonly>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Completed Date</label>
                                                    <input type="text" class="form-control date-picker" id="completed_date" name="completed_date" placeholder="DD-MM-YYYY" value="{{ old('completed_date') }}" readonly>
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
                                                    <select class="form-control select2" id="customer_id" name="customer_id">
                                                        <option value="">Select Customer</option> 
                                                        @if($customers)
                                                            @foreach($customers as $cust)
                                                                <option @if(old('customer_id') == $cust->id) selected  @endif value="{{ $cust->id }}">{{ $cust->first_name }} - {{ $cust->custom_id }}</option>
                                                            @endforeach
                                                        @endif
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
                                                        <option {{ old('job_status') == "1" ? 'selected' : '' }} value="1">Started</option> 
                                                        <option {{ old('job_status') == "2" ? 'selected' : '' }} value="2">Partial</option> 
                                                        <option {{ old('job_status') == "3" ? 'selected' : '' }} value="3">Hold</option> 
                                                        <option {{ old('job_status') == "4" ? 'selected' : '' }} value="4">Completed</option> 
                                                        <option {{ old('job_status') == "5" ? 'selected' : '' }} value="5">Cancelled</option> 
                                                    </select>
                                                    <x-input-error name='job_status'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Machining</label>
                                                    <input type="text" class="form-control date-picker date-permission" id="machining" name="machining" placeholder="DD-MM-YYYY" value="{{ old('machining') }}" readonly>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Heat Treatment</label>
                                                    <input type="text" class="form-control date-picker date-permission" id="heat_treatment" name="heat_treatment" placeholder="DD-MM-YYYY" value="{{ old('heat_treatment') }}" readonly>
                                                </div>

                                                <div class="repeater_s1 repData col-12  p-10 mb-2">
                                                    <h6 class="p-10"><u>S1 Data</u></h6>
                                                    <div data-repeater-list="s1_data" class="col-12">
                                                        <!-- Start: product body -->
                                                        <div data-repeater-item class="row">
                                                            <div class="form-group col-sm-6">
                                                                <label for="s1_date">S1 Date</label>
                                                                <input type="text" class="form-control date-picker"  name="s1_date" placeholder="Enter S1" readonly value="{{ old('s1_date') }}">
                                                            </div>

                                                            <div class="form-group col-sm-6">
                                                                <label for="s1_content">S1 Content</label>
                                                                <input type="text" class="form-control" name="s1_content" placeholder="Enter S1 Content" value="{{ old('s1_content') }}">
                                                            </div>
                                                            <div class="text-right col-sm-12 d-block">
                                                                <input data-repeater-delete class="btn btn-danger d-initial" type="button" value="Delete"  style="background-color: #ff4d4f !important; border-color: #ff4d4f;"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 mb-10">
                                                        <input data-repeater-create class="btn btn-primary" type="button" value="Add New S1"  style="background-color: #5f63f2 !important;border-color: #5f63f2;"/>
                                                    </div>
                                                </div>

                                                <div class="repeater_sub repData col-12 p-10 mb-2">
                                                    <h6 class="p-10"><u>Subcon Data</u></h6>
                                                    <div data-repeater-list="subcon_data" class="col-12">
                                                        <!-- Start: product body -->
                                                        <div data-repeater-item class="row">
                                                            <div class="form-group col-sm-6">
                                                                <label for="subcon">Subcon Date</label>
                                                                <input type="text" class="form-control date-picker" name="subcon" readonly placeholder="Enter Subcon" value="{{ old('subcon') }}">
                                                            </div>
                                                            <div class="form-group col-sm-6">
                                                                <label for="subcon_content">Subcon Content</label>
                                                                <input type="text" class="form-control" name="subcon_content" placeholder="Enter Subcon" value="{{ old('subcon_content') }}">
                                                            </div>

                                                            <div class="text-right col-sm-12 d-block">
                                                                <input data-repeater-delete class="btn btn-danger d-initial" type="button" value="Delete" style="background-color: #ff4d4f !important; border-color: #ff4d4f;"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 mb-10">
                                                        <input data-repeater-create class="btn btn-primary" type="button" value="Add New Subcon" style="background-color: #5f63f2 !important;border-color: #5f63f2;"/>
                                                    </div>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Stock</label>
                                                    <input type="text" class="form-control" id="stock" name="stock" placeholder="Enter Stock" value="{{ old('stock') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Total Value </label>
                                                    <input type="number"  step="0.01" class="form-control" id="total_value" name="total_value" placeholder="Enter total value" value="{{ old('total_value') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Fasteners </label>
                                                    <input type="number"  step="0.01" class="form-control" id="fasteners" name="fasteners" placeholder="Enter Fasteners" value="{{ old('fasteners') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Gasket </label>
                                                    <input type="number"  step="0.01" class="form-control" id="gasket" name="gasket" placeholder="Enter Gasket" value="{{ old('gasket') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">PTFE </label>
                                                    <input type="number"  step="0.01" class="form-control" id="ptfe" name="ptfe" placeholder="Enter PTFE" value="{{ old('ptfe') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">S1F </label>
                                                    <input type="number"  step="0.01" class="form-control" id="s1f" name="s1f" placeholder="Enter S1F" value="{{ old('s1f') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">S1G </label>
                                                    <input type="number"  step="0.01" class="form-control" id="s1g" name="s1g" placeholder="Enter S1G" value="{{ old('s1g') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">S1P </label>
                                                    <input type="number"  step="0.01" class="form-control" id="s1p" name="s1p" placeholder="Enter S1P" value="{{ old('s1p') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">FIM-PTFE </label>
                                                    <input type="number"  step="0.01" class="form-control" id="fim_ptfe" name="fim_ptfe" placeholder="Enter FIM-PTFE" value="{{ old('fim_ptfe') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">FIM-ZY </label>
                                                    <input type="number"  step="0.01" class="form-control" id="fim_zy" name="fim_zy" placeholder="Enter FIM-ZY" value="{{ old('fim_zy') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Charges </label>
                                                    <input type="number"  step="0.01" class="form-control" id="charges" name="charges" placeholder="Enter Charges" value="{{ old('charges') }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Hold </label>
                                                    <input type="number"  step="0.01" class="form-control" id="hold" name="hold" placeholder="Enter Hold" value="{{ old('hold') }}">
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
                                    <a href="{{ Session::has('last_url') ? Session::get('last_url') : route('sopc.index') }}">
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
    .readonly {
        pointer-events : none !important;
        background-color: #f4f5f7 !important;
    }
    input:read-only {
        background-color:#fff !important;
    }
    .repData{
        border: 1px solid #979aa1;
        border-radius: 10px;
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
                                dateFormat: "dd-mm-yy",
                                changeMonth: true,
                                changeYear: true,
                                constrainInput: true,
                                showButtonPanel: true,
                                closeText: 'Clear',
                                onClose: function (dateText, inst) {
                                    if ($(window.event.srcElement).hasClass('ui-datepicker-close'))
                                    {
                                        document.getElementById(this.id).value = '';
                                    }
                                }
                            };
        $("#issue_date,.date-picker").datepicker(datePickerOptions);
        $("#enter_date").datepicker( {
                                dateFormat: "dd-mm-yy",
                                changeMonth: true,
                                changeYear: true,
                                maxDate: new Date(),
                                constrainInput: true,
                                showButtonPanel: true,
                                closeText: 'Clear',
                                onClose: function (dateText, inst) {
                                    if ($(window.event.srcElement).hasClass('ui-datepicker-close'))
                                    {
                                        document.getElementById(this.id).value = '';
                                    }
                                }
                            });


        var permissionCheck = $('#permission').val();
        
        if(permissionCheck != 1){
            $('#s1_date,#subcon,#stock').addClass('readonly');   
            $(".date-permission").addClass('readonly');    
        }
        $('.select2').select2();

        let rep_count = 0;

        $('.repeater_s1').repeater({
            initEmpty: false,
            show: function(e) {
                $(this).slideDown();
                rep_count = parseInt(rep_count) + 1;

                $(this).find('.date-picker').attr("id","s1_date"+rep_count);
                
                $(this).find('.date-picker').removeClass('hasDatepicker').datepicker(datePickerOptions);
            },
            hide: function(deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            isFirstItemUndeletable: true
        })

        $('.repeater_sub').repeater({
            initEmpty: false,
            show: function(e) {
                $(this).slideDown();
                rep_count = parseInt(rep_count) + 1;
                $(this).find('.date-picker').attr("id","sub_date"+rep_count);
                $(this).find('.date-picker').removeClass('hasDatepicker').datepicker(datePickerOptions);
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