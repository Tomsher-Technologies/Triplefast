@extends('admin.layouts.app')
@section('title', 'View Sales Order Job Cards')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @php 
                $order_status = $order[0]->status ?? 1;
            @endphp
            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">Job Cards</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">

                    <div class="action-btn d-flex">
                        <a class="btn px-15 btn-primary" href="{{ route('order.index') }}">
                            <i class="la la-arrow-left white"></i> Back
                        </a>
                        @can('jobcard-create')
                            @if($order_status == 1)
                                <a href="#" class="btn px-15 btn-success ml-3" id="addJobCard">
                                    <i class="la la-plus white"></i> Add New Card
                                </a>
                            @endif
                        @endcan
                    </div>
                </div>
            </div>

        </div>
    </div>
   
    <div class="row">
        <div class="col-lg-12">
            <!-- Lists container -->
            <div class="kanban-board__card mb-50">
                <div class="kanban-header">
                    <h4>Sales Order: {{ $order[0]->order_no ?? '' }}</h4>
                </div>
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
                <section class="lists-container row">
                    @if($jobs)
                        @foreach($jobs as $job)
                            <div class="col-sm-4 mb-4">
                                <div class="list kanban-list">
                                    <div class="kanban-tops list-tops">
                                        <div class="d-flex justify-content-between align-items-center py-10">
                                            <h3 class="list-title">{{ $job->job_number ?? '' }}</h3>
                                            <div class="dropdown dropdown-click">
                                                <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <span data-feather="more-horizontal"></span>
                                                </button>
                                                <div class="dropdown-default dropdown-bottomRight dropdown-menu" style="">
                                                    @can('jobcard-view')
                                                    <a class="dropdown-item viewJobCard"  href="#" id="viewJobCard" data-id="{{ $job->id ?? '' }}">View Job Card</a>
                                                    @endcan
                                                    @can('jobcard-edit')
                                                        @if($order_status == 1)
                                                            <a class="dropdown-item editJobCard" href="#" id="editJobCard" data-id="{{ $job->id ?? '' }}">Edit Job Card</a>
                                                        @endif
                                                    @endcan
                                                    @can('jobcard-delete')
                                                        @if($order_status == 1)
                                                            <a class="dropdown-item deleteJobCard" href="#" id="deleteJobCard" data-id="{{ $job->id ?? '' }}">Delete Job Card</a>
                                                        @endif
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <ul class="kanban-items list-items  drag-drop mb-3">
                                        @if(!empty($job->job_operations))
                                            @foreach($job->job_operations as $oper)
                                                @php
                                                    if($oper->status == 1){
                                                        $status = 'completed';
                                                    }elseif($job->need_by_date < date('Y-m-d')){
                                                        $status = 'expired';
                                                    }else{
                                                        $status = '';
                                                    }

                                                @endphp
                                                <li class="d-flex justify-content-between align-items-center {{$status}} ">
                                                    <div class="lists-items-title operationView" data-id="{{ $oper->id }}">
                                                       {{ $oper->operation->operation_id ?? '' }}
                                                    </div>
                                                    @if($order_status == 1)
                                                        <button class="open-popup-modal editOperation" data-id="{{ $oper->id }}" data-jobid="{{ $job->id }}" type="button"><span data-feather="edit"></span></button>
                                                        <button class="open-popup-modal deleteOperation" type="button"  data-id="{{ $oper->id }}"><span data-feather="trash-2"></span></button>
                                                    @endif
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    @if($order_status == 1)
                                        <button class="add-card-btn newOperation" data-id="{{ $job->id ?? '' }}"><span data-feather="plus"></span>Add New Operation</button>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    @endif
                </section>
            </div>
            <!-- End of lists container -->
        </div>
    </div>

    <!-- Start: Job Card Modal -->
    <div class="modal-basic modal fade show" id="job-card" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-bg-white ">
                <div class="modal-header">
                    <h6 class="modal-title">Job Card Details</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span data-feather="x"></span></button>
                </div>
                <div class="modal-body col-sm-12 add-product__body px-sm-40 px-20 ">
                    <form class="form-horizontal fs-14 row repeater" id="saveJobCard" action="{{ route('job-cards-save') }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="order_id" id="order_id">
                        <input type="hidden" name="job_id" id="job_id">
                        <div class="form-group col-sm-6">
                            <label for="job_number">Job Number<span class="required">*</span></label>
                            <input type="text" class="form-control" id="job_number" name="job_number" placeholder="Enter Job Number" value="">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="part_id">Part<span class="required">*</span></label>
                            <select class="form-control select-2" id="part_id" name="part_id">
                                <option value="">Select part</option>
                                 @if($orderParts)
                                    @foreach($orderParts as $op)
                                        <option value="{{ $op->id }}">{{ $op->part_details->part_number }}</option>
                                    @endforeach
                                 @endif
                            </select>
                        </div>
                       
                        <div class="form-group col-sm-12 mb-10">
                            <label for="part_description">Description<span class="required">*</span></label>
                            <textarea class="form-control dynamic" rows="3" id="part_description" name="part_description" ></textarea>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="order_processor">Order Processer<span class="required">*</span></label>
                            <select class="form-control select-2" id="order_processor" name="order_processor"> 
                                <option value="">Select order processer</option>
                                @foreach($salesTeam as $sales)
                                    <option value="{{ $sales->id }}">{{ $sales->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="due_date">Due Date<span class="required">*</span></label>
                            <input type="text" class="form-control date-picker" id="due_date" name="due_date" placeholder="DD-MM-YYYY" value="">
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label for="start_date">Start Date<span class="required">*</span></label>
                            <input type="text" class="form-control date-picker" id="start_date" name="start_date" placeholder="DD-MM-YYYY" value="">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="need_date">Need By Date:<span class="required">*</span></label>
                            <input type="text" class="form-control date-picker" id="need_date" name="need_date" placeholder="DD-MM-YYYY" value="">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="req_date">Req. By<span class="required">*</span></label>
                            <input type="text" class="form-control date-picker" id="req_date" name="req_date" placeholder="DD-MM-YYYY" value="">
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label for="req_quantity">Qty Req<span class="required">*</span></label>
                            <input type="text" class="form-control" id="req_quantity" name="req_quantity" placeholder="Enter Qty Req" value="">
                        </div>
                       
                        <div class="form-group col-sm-6">
                            <label for="for_order">For Order<span class="required">*</span></label>
                            <input type="text" class="form-control" id="for_order" name="for_order" placeholder="Enter" value="">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="for_stock">For Stock:<span class="required">*</span></label>
                            <input type="text" class="form-control" id="for_stock" name="for_stock" placeholder="Enter" value="">
                        </div>

                        <div class="form-group col-sm-12">
                            <h6 class="fw-500">Raw Material Components</h6>
                        </div>
                       
                        <div data-repeater-list="components" class="col-sm-12">
                            <div data-repeater-item class="row">
                                <input type="hidden" class="form-control" id="component_id" name="component_id" value="0">
                                <div class="form-group col-sm-3">
                                    <label for="for_stock">Seq No.<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="seq_no" name="seq_no" placeholder="Enter Seq No." value="">
                                </div>
                                
                                <div class="form-group col-sm-5">
                                    <label for="part_id">Part Number<span class="required">*</span></label>
                                    <select class="form-control part_numbers" id="part_number" name="part_number">
                                        <option value="">Select Part Number</option> 
                                    </select>
                                </div>
                               
                                <div class="form-group col-sm-4">
                                    <label for="req_qty">Req Qty<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="req_qty" name="req_qty" placeholder="Enter Req Qty" value="">
                                </div>

                                <div class="form-group col-sm-12 mb-10">
                                    <label for="comp_description">Description<span class="required">*</span></label>
                                    <textarea class="form-control dynamic" rows="3" id="comp_description" name="comp_description" ></textarea>
                                </div>

                                <div class="text-right col-sm-12 mb-10 d-block">
                                    <input data-repeater-delete class="btn btn-danger d-initial button-custom" type="button" value="Delete" />
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <input data-repeater-create class="btn btn-primary btn-sm button-custom" type="button" value="Add New Component" />
                        </div>
                        <div class="row align-right">
                            <button type="submit" class="btn btn-success btn-sm">Save changes</button>
                            <button type="button" class="btn btn-danger btn-sm ml-2" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    <!-- End: Job Card Modal -->

     <!-- Start: Job Card View Modal -->
     <div class="modal-basic modal fade show" id="job-card-view" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-bg-white ">
                <div class="modal-header">
                    <h6 class="modal-title">Job Card Details</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span data-feather="x"></span></button>
                </div>
                <div class="modal-body col-sm-12 add-product__body px-sm-40 px-20 ">
                    <div class="card-grid-table f-14">
                        <table class="table table-bordered" >
                            <tbody class="">
                                <tr class="col-sm-12">
                                    <td class="order-td col-sm-4">
                                        <span class="order-view">Job Number</span>
                                        <p class="pt-1 pb-1" id="job_number_view"></p>
                                    </td>
                                    <td class="order-td col-sm-4">
                                        <span class="order-view">Customer</span>
                                        <p class="pt-1 pb-1" id="customer_view"></p>
                                    </td>
                                    <td class="order-td col-sm-4">
                                        <span class="order-view">Customer Order Number</span>
                                        <p class="pt-1 pb-1" id="customer_order_number_view"></p>
                                    </td>
                                    
                                </tr>
                                <tr class="col-sm-12">
                                <td class="order-td col-sm-4">
                                        <span class="order-view">Part</span>
                                        <p class="pt-1 pb-1" id="part_view"></p>
                                    </td>
                                    <td class="order-td col-sm-8" colspan="2">
                                        <span class="order-view">Description</span>
                                        <p class="pt-1 pb-1" id="description_view"></p>
                                    </td>
                                </tr>

                                <tr class="col-sm-12">
                                    <td class="order-td col-sm-4">
                                        <span class="order-view">Qty Req</span>
                                        <p class="pt-1 pb-1" id="qty_req_view"></p>
                                    </td>
                                    <td class="order-td col-sm-4">
                                        <span class="order-view">Due Date </span>
                                        <p class="pt-1 pb-1" id="due_date_view"></p>
                                    </td>
                                    <td class="order-td col-sm-4">
                                        <span class="order-view">Start Date</span>
                                        <p class="pt-1 pb-1" id="start_date_view"></p>
                                    </td>
                                                                  
                                </tr>
                                <tr class="col-sm-12">
                                    <td class="order-td col-sm-4">
                                        <span class="order-view">Need By Date</span>
                                        <p class="pt-1 pb-1" id="need_by_date_view"></p>
                                    </td>

                                    <td class="order-td col-sm-4">
                                        <span class="order-view">Req. By</span>
                                        <p class="pt-1 pb-1" id="req_by_view"></p>
                                    </td>
                                    <td class="order-td col-sm-4">
                                        <span class="order-view">Ship Via</span>
                                        <p class="pt-1 pb-1" id="ship_via_view"></p>
                                    </td>
                                    
                                </tr>
                                <tr class="col-sm-12">
                                    <td class="order-td col-sm-4">
                                        <span class="order-view">Order Processer</span>
                                        <p class="pt-1 pb-1" id="order_processer_view"></p>
                                    </td>

                                    <td class="order-td col-sm-4">
                                        <span class="order-view">For Order</span>
                                        <p class="pt-1 pb-1" id="for_order_view"></p>
                                    </td>

                                    <td class="order-td col-sm-4">
                                        <span class="order-view">For Stock</span>
                                        <p class="pt-1 pb-1" id="for_stock_view"></p>
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="user-skils border-bottom">
                        <div class="pt-sm-10 pb-sm-0 mb-2">
                            <div class="profile-header-title">
                                RAW MATERIAL COMPONENTS
                            </div>
                        </div>
                        <div class="pt-md-1 pt-0 f-13">
                            <div class="">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center fw-600">Seq No.</th>
                                                <th class="fw-600">Part Number</th>
                                                <th class="fw-600">Description</th>
                                                <th class="text-center fw-600">Req Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody class="f-13" id="row_materials">
                                            
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- End: Job Card View Modal -->

     <!-- Start: Job Card Modal -->
     <div class="modal-basic modal fade show" id="job-operation" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-bg-white ">
                <div class="modal-header">
                    <h6 class="modal-title">Job Card Details</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span data-feather="x"></span></button>
                </div>
                <div class="modal-body col-sm-12 add-product__body px-sm-40 px-20 ">
                    <form class="form-horizontal fs-14 row " id="saveOperations" action="{{ route('job-operation-save') }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="job_card_id" id="job_card_id">
                        <input type="hidden" name="job_operation_id" id="job_operation_id" value="0">
                        <div class="form-group col-sm-6">
                            <label for="op_seq_no">Seq No.<span class="required">*</span></label>
                            <input type="text" class="form-control" id="op_seq_no" name="op_seq_no" placeholder="Enter Seq No." value="">
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label for="operation_id">Operation<span class="required">*</span></label>
                            <select class="form-control op-select-2" id="operation_id" name="operation_id">
                                <option value="">Select operation</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="op_qty">Oper. Qty<span class="required">*</span></label>
                            <input type="text" class="form-control" id="op_qty" name="op_qty" placeholder="Enter Oper. Qty" value="">
                        </div>
                       
                        <div class="form-group col-sm-6">
                            <label for="part_description">Op Comments</label>
                            <textarea class="form-control " rows="3" id="op_comments" name="op_comments" ></textarea>
                        </div>

                       
                        <div class="row align-right">
                            <button type="submit" class="btn btn-success btn-sm">Save changes</button>
                            <button type="button" class="btn btn-danger btn-sm ml-2" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    <!-- End: Job Card Modal -->

    <!-- Start: Job Operations View Modal -->
    <div class="modal-basic modal fade show" id="job-operation-view" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content modal-bg-white ">
                <div class="modal-header">
                    <h6 class="modal-title">Operation Details</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span data-feather="x"></span></button>
                </div>
                <div class="modal-body col-sm-12 add-product__body px-sm-40 px-20 ">
                    <div class="card-grid-table f-14">
                        <table class="table table-bordered" >
                            <tbody class="">
                                <tr class="col-sm-12">
                                    <td class="order-td col-sm-6">
                                        <span class="order-view">Seq No.</span>
                                        <p class="pt-2 pb-2" id="op_seq_no_view"></p>
                                    </td>
                                    <td class="order-td col-sm-6">
                                        <span class="order-view">Oper. Qty</span>
                                        <p class="pt-2 pb-2" id="op_qty_view"></p>
                                    </td>
                                    
                                </tr>
                                <tr class="col-sm-12">
                                    <td class="order-td col-sm-12" colspan="2">
                                        <span class="order-view">Operation</span>
                                        <p class="pt-2 pb-2" id="operation_view"></p>
                                    </td>
                                </tr>
                                <tr class="col-sm-12">
                                    <td class="order-td col-sm-12" colspan="2">
                                        <span class="order-view">Op Comments</span>
                                        <p class="pt-2 pb-2" id="op_comments_view"></p>
                                    </td>
                                </tr>
                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: Job OPeration View Modal -->
</div>

@endsection

@section('header')
<style>
.border {
    border: 1px solid #d1d2da !important;
}
.add-product__body .form-group textarea {
    padding: 10px 15px;
    min-height: 90px;
}
.ui-datepicker{
    z-index:99999 !important; 
}
</style>

@endsection

@section('footer')
<script src="{{ asset('assets/vendor_assets/js/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('assets/vendor_assets/js/jquery/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
    
        var datePickerOptions = {
                                dateFormat: "dd-mm-yy",
                                changeMonth: true,
                                changeYear: true,
                                minDate: '{{ date("d-m-Y", strtotime($order[0]->order_date)) }}'
                            };
        $("#due_date,#start_date, #need_date,#req_date").datepicker(datePickerOptions);

        var $repeater = $('.repeater').repeater({
            initEmpty: false,
            show: function(e) {
                $(this).slideDown();
                var repeaterItems = $("div[data-repeater-item]");
                addFieldValidation(repeaterItems.length);
            },
            hide: function(deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            isFirstItemUndeletable: true
        });

        $(document).on('click', '#addJobCard', function() {
            $('#saveJobCard')[0].reset();
            $('[data-repeater-item]').slice(1).remove();
            $('[data-repeater-delete]').remove();
            $('label.error').remove();
            $('input').removeClass('error');
            $('textarea').removeClass('error');
            $('.select-2').val('').trigger('change');
            $('#part_description').html('');
            $('#part_number0').val('').trigger('change');
            $("#part_id option[class='appended']").remove();
            $('#order_id').val('{{ $order[0]->id ?? '' }}');
            $('#job_id').val(0);
            $('#job-card').modal({backdrop: 'static', keyboard: false, show:true});
        });
                              
        $("#saveJobCard").validate({
            rules: {
                job_number: {
                    required: true
                },
                part_id:{
                    required:true
                },
                part_description:{
                    required:true
                },
                order_processor:{
                    required:true
                },
                due_date:{
                    required:true
                },
                start_date:{
                    required:true
                },
                need_date:{
                    required:true
                },
                req_date:{
                    required:true
                },
                req_quantity:{
                    required:true
                },
                for_order:{
                    required:true
                },
                for_stock:{
                    required:true
                },
                'components[0][seq_no]':{
                    required:true
                },
                'components[0][part_number]':{
                    required:true
                },
                'components[0][req_qty]':{
                    required:true
                },
                'components[0][comp_description]':{
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

        initailizeSelect2();

        $('.select-2').select2({
            width: 'inherit',
            dropdownParent: $('#saveJobCard'), 
            placeholder: 'Select',
        });

        function initailizeSelect2(){
            $('.part_numbers').select2({
                minimumInputLength: 3,
                width: 'inherit',
                dropdownParent: $('#saveJobCard'),
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
            count = parseInt(count) - 1;
            $('[name="components['+count+'][seq_no]"]').attr("id","seq_no"+count);
            $('[name="components['+count+'][part_number]"]').attr("id","part_number"+count);
            $('[name="components['+count+'][req_qty]"]').attr("id","req_qty"+count);
            $('[name="components['+count+'][comp_description]"]').attr("id","comp_description"+count);

            $("#seq_no"+count).rules('add', { required: true });
            $("#part_number"+count).rules('add', { required: true });
            $("#req_qty"+count).rules('add', { required: true });
            $("#comp_description"+count).rules('add', { required: true });

            initailizeSelect2();
        }

        $(document).on('change', '#part_id', function(){
            var id = $(this).val();
          
            $.ajax({
                url: "{{ route('order-part-data') }}",
                type: "GET",
                data: {
                    id: id,
                    _token:'{{ @csrf_token() }}',
                },
                success: function (response) {
                    var resp = JSON.parse(response);
                    $('#part_description').html(resp.description);
                    $("#need_date").datepicker("setDate", resp.need_by_date);
                    $("#req_quantity").val(resp.quantity);
                }
            });
        });

        $(document).on('click', '.viewJobCard', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('view-jobcard') }}",
                type: "GET",
                data: {
                    id: id,
                    _token:'{{ @csrf_token() }}',
                },
                success: function (response) {
                    var res = JSON.parse(response);
                    res = res[0];
                    var customerName = res.order.customer.first_name;
                    $('#job_number_view').html(res.job_number);
                    $('#customer_view').html(customerName);
                    $('#customer_order_number_view').html(res.order.po_number);
                    $('#part_view').html(res.order_part.part_details.part_number);
                    $('#description_view').html(res.description);
                    $('#qty_req_view').html(res.qty_req);
                    $('#due_date_view').html(res.due_date_format);
                    $('#start_date_view').html(res.start_date_format);
                    $('#need_by_date_view').html(res.need_by_date_format);
                    $('#req_by_view').html(res.req_date_format);
                    $('#ship_via_view').html(res.order.shipping_via);
                    $('#for_order_view').html(res.for_order);
                    $('#for_stock_view').html(res.for_stock);
                    $('#order_processer_view').html(res.order_processer_user.name);

                    if((res.job_materials).length != 0){
                        var html = '';
                        $.each(res.job_materials, function (key, val) {
                            html +=  '<tr>'+
                                        ' <td class="text-center">'+ val.seq_no +' </td> '+  
                                        ' <td>'+ val.material_part.part_number +' </td> '+  
                                        ' <td>'+ val.description +' </td> '+  
                                        ' <td class="text-center">'+ val.req_qty +' </td> '+ 
                                        '</tr>'; 
                        });
                    }else{
                        html +=  '<tr><td colspan="4">No Details Found</td></tr>'
                    }

                    $('#row_materials').html(html);
                    $('#job-card-view').modal({backdrop: 'static', keyboard: false, show:true});
                }
            });
            
        });

        $(document).on('click', '.editJobCard', function() {
            $('label.error').remove();
            $('input').removeClass('error');
            $('textarea').removeClass('error');
            $('#order_id').val('{{ $order[0]->id ?? '' }}');
            var id = $(this).attr('data-id');
            $('#job_id').val(id);
            $.ajax({
                url: "{{ route('view-jobcard') }}",
                type: "GET",
                data: {
                    id: id,
                    _token:'{{ @csrf_token() }}',
                },
                success: function (response) {
                    var res = JSON.parse(response);
                    res = res[0];
                    var customerName = res.order.customer.first_name;
                   
                    $('#job_number').val(res.job_number);
                    
                    $('#req_quantity').val(res.qty_req);
                    $('#for_order').val(res.for_order);
                    $('#for_stock').val(res.for_stock);

                    $("#due_date").datepicker("setDate", res.due_date_format);
                    $("#start_date").datepicker("setDate", res.start_date_format);
                    $("#need_date").datepicker("setDate", res.need_by_date_format);
                    $("#req_date").datepicker("setDate", res.req_date_format);

                    $("#part_id option[class='appended']").remove();

                    var newOption = '<option value="'+res.order_part_id+'" class="appended" selected>'+res.order_part.part_details.part_number+'</option>';
                    
                    // Append it to the select
                    $('#part_id').append(newOption).trigger('change');
                    $('#order_processor').val(res.order_processer).trigger('change');
                    $('#part_description').val(res.description);
                    if((res.job_materials).length != 0){
                        var arr = [];
                        
                        $.each(res.job_materials, function (key, val) {
                            arr.push({
                                seq_no:  val.seq_no, 
                                part_number:  val.job_part_id,
                                req_qty:val.req_qty,
                                comp_description:val.description,
                                component_id:val.id,
                                part_name:val.material_part.part_number
                            });
                        });
                        $repeater.setList(arr);

                        var repeaterItems = $("div[data-repeater-item]").length;

                        for (rep = 0; rep < repeaterItems; rep++) {
                            addFieldValidation(rep);
                            var field = '#part_number'+rep;
                            var dataJson = arr[rep];
                            $(field).append('<option value="'+dataJson.part_number+'" selected>'+dataJson.part_name+'</option>').trigger('change');
                        }
                    }
                         
                    $('#job-card').modal({backdrop: 'static', keyboard: false, show:true});
                }
            });
            
        });

        $(document).on('click', '.deleteJobCard', function() {
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
                        url: "{{ route('job-card.delete') }}",
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

        $('#operation_id').select2({
            minimumInputLength: 3,
            width: 'inherit',
            dropdownParent: $('#saveOperations'),
            placeholder: 'Select operation',
            ajax: {
                url: '{{ route("ajax-operations") }}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.operation_id ,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        }); 

        $(document).on('click', '.newOperation', function() {
            $('#saveOperations')[0].reset();
            $('label.error').remove();
            $('input').removeClass('error');
            $('textarea').removeClass('error');
            $('.op-select-2').val('').trigger('change');
            $('#op_comments').html('');
            $('#operation').val('').trigger('change');
            $('#job_card_id').val($(this).attr('data-id'));
            $('#job_operation_id').val(0);
            $('#job-operation').modal({backdrop: 'static', keyboard: false, show:true});
        });
            
        $("#saveOperations").validate({
            rules: {
                op_seq_no: {
                    required: true
                },
                operation_id:{
                    required:true
                },
                op_qty:{
                    required:true
                }
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

        $(document).on('click', '.operationView', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('view-joboperation') }}",
                type: "GET",
                data: {
                    id: id,
                    _token:'{{ @csrf_token() }}',
                },
                success: function (response) {
                    var res = JSON.parse(response);
                    res = res[0];
                        
                    $('#op_seq_no_view').html(res.seq_no);
                    $('#op_qty_view').html(res.op_qty);
                    $('#operation_view').html(res.operation.operation_id+' ('+ res.operation.description +')');
                    $('#op_comments_view').html(res.op_comment);

                    $('#job-operation-view').modal({backdrop: 'static', keyboard: false, show:true});
                }
            });
            
        });

        $(document).on('click', '.editOperation', function(){
            $('label.error').remove();
            $('input').removeClass('error');
            $('textarea').removeClass('error');
            var id = $(this).attr('data-id');
            var jobid = $(this).attr('data-jobid');
            $('#job_operation_id').val(id);
            $('#job_card_id').val(jobid);

            $.ajax({
                url: "{{ route('view-joboperation') }}",
                type: "GET",
                data: {
                    id: id,
                    _token:'{{ @csrf_token() }}',
                },
                success: function (response) {
                    var res = JSON.parse(response);
                    res = res[0];
                        
                    $('#op_seq_no').val(res.seq_no);
                    $('#op_qty').val(res.op_qty);
                    $('#op_comments').val(res.op_comment);

                    var newOptionOp = '<option value="'+res.job_operation_id+'" class="appended" selected>'+res.operation.operation_id+'</option>';
                    
                    // Append it to the select
                    $('#operation_id').append(newOptionOp).trigger('change');

                    $('#job-operation').modal({backdrop: 'static', keyboard: false, show:true});
                }
            });
        });

        $(document).on('click', '.deleteOperation', function() {
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
                        url: "{{ route('job-operation.delete') }}",
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
</script>
@endsection

                      