@extends('admin.layouts.app')
@section('title', 'Update SOPC Report')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">Update SOPC Report</h4>
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
                            <form class="form-horizontal repeater" id="saveSopc" action="{{ route('sopc.update', $sopc->id) }}" method="POST" autocomplete="off">
                                @csrf
                                @method('PATCH')
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
                                                <input type="hidden" name="permission" id="permission" value="{{ auth()->user()->can('sopc-edit-dates') }}">
                                                <div class="form-group col-sm-6">
                                                    <label for="name1">SO Number<span class="required">*</span></label>
                                                    <input type="text" class="form-control" id="so_number" name="so_number" placeholder="Enter SO Number" value="{{ old('so_number', $sopc->so_number) }}" >
                                                    <x-input-error name='so_number'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Report Type</label>
                                                    <select class="form-control" id="report_type" name="report_type">
                                                        <option {{ (old('report_type', $sopc->report_type) == 'normal') ? 'selected' : '' }}  value="normal" >Normal</option>
                                                        <option {{ (old('report_type', $sopc->report_type) == "hot") ? 'selected' : '' }} value="hot">Hot Jobs</option>
                                                        <option {{ (old('report_type', $sopc->report_type) == 'oem') ? 'selected' : '' }}  value="oem">OEM</option>
                                                        <option {{ (old('report_type', $sopc->report_type) == 'tpi') ? 'selected' : '' }}  value="tpi">TPI</option>
                                                    </select>
                                                </div>

                                                @php        
                                                    $enter_date = ($sopc->enter_date != '') ? date('d-m-Y', strtotime($sopc->enter_date)) : '';
                                                @endphp
                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Enter Date</label>
                                                    <input type="text" class="form-control" id="enter_date" name="enter_date" placeholder="DD-MM-YYYY" readonly value="{{ old('enter_date', $enter_date) }}" readonly>
                                                </div>
                                                @php        
                                                    $issue_date = ($sopc->issue_date != '') ? date('d-m-Y', strtotime($sopc->issue_date)) : '';
                                                @endphp
                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Issue Date</label>
                                                    <input type="text" class="form-control" id="issue_date" name="issue_date" placeholder="DD-MM-YYYY" value="{{ old('issue_date', $issue_date) }}" readonly>
                                                   
                                                </div>
                                                @php        
                                                    $started_date = ($sopc->started_date != '') ? date('d-m-Y', strtotime($sopc->started_date)) : '';
                                                @endphp
                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Started Date</label>
                                                    <input type="text" class="form-control date-picker" id="started_date" name="started_date" placeholder="DD-MM-YYYY" value="{{ old('started_date', $started_date) }}" readonly>
                                                </div>
                                                @php        
                                                    $due_date = ($sopc->due_date != '') ? date('d-m-Y', strtotime($sopc->due_date)) : '';
                                                @endphp
                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Due Date</label>
                                                    <input type="text" class="form-control date-picker" id="due_date" name="due_date" placeholder="DD-MM-YYYY" value="{{ old('due_date', $due_date) }}" readonly>
                                                    
                                                </div>
                                                @php        
                                                    $target_date = ($sopc->target_date != '') ? date('d-m-Y', strtotime($sopc->target_date)) : '';
                                                @endphp
                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Target Date</label>
                                                    <input type="text" class="form-control date-picker" id="target_date" name="target_date" placeholder="DD-MM-YYYY" value="{{ old('target_date', $target_date) }}" readonly>
                                                </div>
                                                @php        
                                                    $completed_date = ($sopc->completed_date != '') ? date('d-m-Y', strtotime($sopc->completed_date)) : '';
                                                @endphp
                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Completed Date</label>
                                                    <input type="text" class="form-control date-picker" id="completed_date" name="completed_date" placeholder="DD-MM-YYYY" value="{{ old('completed_date', $completed_date) }}" readonly>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Total Items<span class="required">*</span></label>
                                                    <input type="number" class="form-control readonly" id="total_items" name="total_items" placeholder="Enter Total Items" value="{{ old('total_items', $sopc->total_items) }}" readonly>
                                                    <x-input-error name='total_items'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Division</label>
                                                    <input type="text" class="form-control" id="division" name="division" placeholder="Enter Division" value="{{ old('division', $sopc->division) }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Customer<span class="required">*</span></label>
                                                    <select class="form-control select2" id="customer_id" name="customer_id">
                                                        <option value="">Select Customer</option> 
                                                        @if($customers)
                                                            @foreach($customers as $cust)
                                                                <option @if(old('customer_id',$sopc->customer_id) == $cust->id) selected  @endif value="{{ $cust->id }}">{{ $cust->first_name }} - {{ $cust->custom_id }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <x-input-error name='customer_id'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Customer PO. NO.<span class="required">*</span></label>
                                                    <input type="text" class="form-control" id="po_number" name="po_number" placeholder="Enter PO Number" value="{{ old('po_number', $sopc->po_number) }}">
                                                    <x-input-error name='po_number'/>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name2">Jobs To Do</label>
                                                    <textarea class="form-control" id="jobs_to_do" name="jobs_to_do" >{{ old('jobs_to_do', $sopc->jobs_to_do) }}</textarea>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Job Status<span class="required">*</span></label>
                                                    <select class="form-control" id="job_status" name="job_status">
                                                        <option {{ old('job_status', $sopc->job_status) == "" ? 'selected' : '' }} value="">Select Status</option> 
                                                        <option {{ old('job_status', $sopc->job_status) == "0" ? 'selected' : '' }} value="0">Not Started</option> 
                                                        <option {{ old('job_status', $sopc->job_status) == "1" ? 'selected' : '' }} value="1">Started</option> 
                                                        <option {{ old('job_status', $sopc->job_status) == "2" ? 'selected' : '' }} value="2">Partial</option> 
                                                        <option {{ old('job_status', $sopc->job_status) == "3" ? 'selected' : '' }} value="3">Hold</option> 
                                                        <option {{ old('job_status', $sopc->job_status) == "4" ? 'selected' : '' }} value="4">Completed</option> 
                                                        <option {{ old('job_status', $sopc->job_status) == "5" ? 'selected' : '' }} value="5">Cancelled</option> 
                                                    </select>
                                                    <x-input-error name='job_status'/>
                                                </div>
                                                @php        
                                                    $machining = ($sopc->machining != '') ? date('d-m-Y', strtotime($sopc->machining)) : '';
                                                @endphp
                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Machining</label>
                                                    <input type="text" class="form-control date-picker date-permission" id="machining" name="machining" placeholder="DD-MM-YYYY" value="{{ old('machining', $machining) }}" readonly>
                                                </div>
                                                @php        
                                                    $heat_treatment = ($sopc->heat_treatment != '') ? date('d-m-Y', strtotime($sopc->heat_treatment)) : '';
                                                @endphp
                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Heat Treatment</label>
                                                    <input type="text" class="form-control date-picker date-permission" id="heat_treatment" name="heat_treatment" placeholder="DD-MM-YYYY" value="{{ old('heat_treatment', $heat_treatment) }}" readonly>
                                                </div>
                                                <div class="repeater_s1 repData col-12  p-10 mb-2">
                                                    <h6 class="p-10"><u>S1 Data</u></h6>
                                                    <div data-repeater-list="s1_data" class="col-12">
                                                        <!-- Start: product body -->
                                                        <div data-repeater-item class="row">
                                                            <div class="form-group col-sm-6">
                                                                <label for="name1">S1 Date</label>
                                                                <input type="text" class="form-control date-picker"  name="s1_date" readonly placeholder="Enter S1" value="{{ old('s1_date') }}">
                                                                <input type="hidden" name="s1_id" value="0">
                                                            </div>

                                                            <div class="form-group col-sm-6">
                                                                <label for="name1">S1 Content</label>
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
                                                                <label for="name1">Subcon Date</label>
                                                                <input type="text" readonly class="form-control date-picker" name="subcon" placeholder="Enter Subcon" value="{{ old('subcon') }}">
                                                                <input type="hidden"  name="sub_id" value="0">
                                                            </div>
                                                            <div class="form-group col-sm-6">
                                                                <label for="name1">Subcon Content</label>
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

                                                @php        
                                                    $stock = $sopc->stock;
                                                @endphp
                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Stock</label>
                                                    <input type="text" class="form-control" id="stock" name="stock" placeholder="Enter Stock" value="{{ old('stock', $stock) }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Total Value </label>
                                                    <input type="text" class="form-control" id="total_value" name="total_value" placeholder="Enter total value" value="{{ old('total_value', $sopc->total_value) }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Fasteners </label>
                                                    <input type="text" class="form-control" id="fasteners" name="fasteners" placeholder="Enter Fasteners" value="{{ old('fasteners', $sopc->fasteners) }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Gasket </label>
                                                    <input type="text" class="form-control" id="gasket" name="gasket" placeholder="Enter Gasket" value="{{ old('gasket', $sopc->gasket) }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">PTFE </label>
                                                    <input type="text" class="form-control" id="ptfe" name="ptfe" placeholder="Enter PTFE" value="{{ old('ptfe', $sopc->ptfe) }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">S1F </label>
                                                    <input type="text" class="form-control" id="s1f" name="s1f" placeholder="Enter S1F" value="{{ old('s1f', $sopc->s1f) }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">S1G </label>
                                                    <input type="text" class="form-control" id="s1g" name="s1g" placeholder="Enter S1G" value="{{ old('s1g', $sopc->s1g) }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">S1P </label>
                                                    <input type="text" class="form-control" id="s1p" name="s1p" placeholder="Enter S1P" value="{{ old('s1p', $sopc->s1p) }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Partial Value (Balance) </label>
                                                    <input type="number"  step="0.01" class="form-control" id="partial" name="partial" placeholder="Enter Partial Value" value="{{ old('partial', $sopc->partial) }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">FIM-PTFE </label>
                                                    <input type="text" class="form-control" id="fim_ptfe" name="fim_ptfe" placeholder="Enter FIM-PTFE" value="{{ old('fim_ptfe', $sopc->fim_ptfe) }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">FIM-ZY </label>
                                                    <input type="text" class="form-control" id="fim_zy" name="fim_zy" placeholder="Enter FIM-ZY" value="{{ old('fim_zy', $sopc->fim_zy) }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Charges </label>
                                                    <input type="text" class="form-control" id="charges" name="charges" placeholder="Enter Charges" value="{{ old('charges', $sopc->charges) }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name1">Hold </label>
                                                    <input type="text" class="form-control" id="hold" name="hold" placeholder="Enter Hold" value="{{ old('hold', $sopc->hold) }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="name2">Remarks</label>
                                                    <textarea class="form-control" id="remarks" name="remarks" >{{ old('remarks', $sopc->remarks) }}</textarea>
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
            // alert('no permission');
            $('#s1_date,#subcon,#stock').addClass('readonly');   
            $(".date-permission").addClass('readonly');    
        }


        $('.select2').select2(); 
        let rep_count = 0;

        var s1_repeater = $('.repeater_s1').repeater({
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
                            });

        var suncon_repeater = $('.repeater_sub').repeater({
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

        var s1Data = {!! $s1Data !!};
        s1_repeater.setList(s1Data);

        var subconData = {!! $subconData !!};
        suncon_repeater.setList(subconData);
    });
   
    
</script>
@endsection