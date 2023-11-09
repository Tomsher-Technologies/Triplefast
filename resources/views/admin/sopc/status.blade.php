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
                    <div class="col-xl-12 col-lg-12">
                        <div class="mx-sm-30 mx-20 ">
                            <!-- Start: card -->
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

                            <div class="card add-product p-sm-30 p-20 mb-30">
                                <div class="card-body p-0">
                                    <div class="card-header">
                                        <h4 class="fw-500 no-text-transform">SO Number : <b>{{$sopc->so_number}}</b>
                                        </h4>
                                        <button class="btn btn-sm btn-success btn-add" onclick="addLines()">
                                            <i class="la la-plus"></i> Add New Line Numbers 
                                        </button>
                                    </div>
                                    <!-- Start: card body -->
                                    <div class="px-sm-40 px-20">
                                        <!-- Start: form -->
                                        <form class="form-horizontal" id="createPart" action="{{ route('sopc.status-store') }}" method="POST" autocomplete="off">
                                            @csrf
                                            <!-- form group -->
                                            <div class="form-group">
                                                <input type="hidden" name="sopc_id"  id="sopc_id" value="{{ $sopc->id }}">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <th class="middle-center">Line Number</th>
                                                                <th class="middle-center">Status</th>
                                                                <th class="middle-center w-40">Remarks</th>
                                                                <th class="middle-center ">Updated By</th>
                                                                <th class="middle-center ">Updated Date</th>
                                                                <th class="middle-center ">Cancel Line</th>
                                                            </tr>
                                                            @foreach($items as $itm)
                                                                <tr>
                                                                    <td class="middle-center">
                                                                        <label class="ml-2">{{ $itm['line_no'] }}</label>
                                                                    </td>
                                                                    <td class="middle-center">
                                                                        <input class="custom-checkbox name" type="checkbox" value="" name="status[{{$itm['id']}}-{{$itm['line_no']}}]" id="status" {{ ($itm['status'] == 1) ? 'checked' : '' }} {{ ($itm['is_cancelled'] == 1) ? 'disabled' : '' }} >

                                                                        <input  type="hidden" value="{{$itm['updated_by']}}" name="user[{{$itm['id']}}-{{$itm['line_no']}}]" id="user"  >

                                                                        <input  type="hidden" value="{{$itm['updated_at']}}" name="date[{{$itm['id']}}-{{$itm['line_no']}}]" id="date"  >
                                                                    </td>
                                                                   
                                                                    <td>
                                                                        <textarea class="form-control" name="remark[{{$itm['id']}}-{{$itm['line_no']}}]" rows="2"  {{ ($itm['is_cancelled'] == 1) ? 'disabled' : '' }} >{{ $itm['remark'] }} </textarea>
                                                                    </td>
                                                                    <td class="middle-center"> 
                                                                        {{ $itm['updated_user']['name'] ?? '' }}
                                                                    </td>
                                                                    <td class="middle-center"> 
                                                                        {{ ($itm['updated_at'] != NULL) ? date('d-m-Y', strtotime($itm['updated_at'])) : '' }}
                                                                    </td>
                                                                    <td class="middle-center"> 
                                                                        @if($itm['is_cancelled'] == 0)
                                                                            <a href="#" title="Cancel Line" class="error" onclick="cancelLine({{ $itm['id'] }},{{ $itm['line_no'] }})"> 
                                                                                <span data-feather="x-circle"></span>
                                                                            </a>
                                                                        @else
                                                                            <span class="error">Cancelled</span>
                                                                        @endif
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
                                                <a href="{{ Session::has('last_url') ? Session::get('last_url') : route('sopc.index') }}">
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

<div class="modal-basic modal fade show" id="addLines" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content modal-bg-white ">
            <div class="modal-header">
                <h6 class="modal-title">Add New Line Numbers</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span data-feather="x"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group col-sm-12 ">
                    <label for="count">Number of Lines Needed<span class="required">*</span></label>
                    <input type="number" step="1" class="form-control" id="count" name="count" placeholder="" value="" style="border: 1px solid #d1d2d8;">
                    <span class="error f-13" id="countError">Please enter a valid number of lines</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="saveNewLines">Add Lines</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('header')
<style>

</style>
@endsection

@section('footer')
<script type="text/javascript">
    function cancelLine(lineId, lineNo){
        Swal.fire({
            title: "Are you sure?",
            text: 'Do you want to cancel this line?',
            icon: 'warning',
            confirmButtonText: "Yes, cancel it!",
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed){
                $.ajax({
                    url: "{{ route('line.cancel') }}",
                    type: "POST",
                    data: {
                        id: lineId,
                        line_no: lineNo,
                        sopc_id: $('#sopc_id').val(),
                        _token:'{{ @csrf_token() }}',
                    },
                    dataType: "html",
                    success: function () {
                        swal.fire("Done!", "Succesfully cancelled!", "success");
                        setTimeout(function () { 
                            window.location.reload();
                        }, 3000);  
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        swal.fire("Error!", "Please try again", "error");
                    }
                });
            }  
        });
    }

    function addLines(){
        $('#count').val('');
        $('#countError').css('display','none');
        $('#addLines').modal({backdrop: 'static', keyboard: false, show:true});
    }

    $(document).on('click','#saveNewLines',function(){
        var count = $('#count').val();
        var sopc_id = $('#sopc_id').val();
        if(count == 0){
            $('#countError').css('display','block');
        }else{
            $('#countError').css('display','none');
            $.ajax({
                url: "{{ route('line.add') }}",
                type: "POST",
                data: {
                    sopc_id: sopc_id,
                    count: count,
                    _token:'{{ @csrf_token() }}',
                },
                dataType: "html",
                success: function () {
                    $('#addLines').modal('hide');
                    swal.fire("Done!", "Succesfully created!", "success");
                    setTimeout(function () { 
                        window.location.reload();
                    }, 3000);  
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal.fire("Error!", "Please try again", "error");
                }
            });
        }
        
    });
</script>
@endsection