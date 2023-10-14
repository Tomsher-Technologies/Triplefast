@extends('admin.layouts.app')
@section('title', 'Timeline Details')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">Timeline Details</h4>
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
            <div class="card card-default card-md mb-4">
                <div class="card-header  py-20">
                    <h6>SO Number : {{ $sopc->so_number }} - Timeline</h6>
                </div>
                <div class="card-body p-30">
                    <div class="timeline-box--3 timeline-vertical">
                        <ul class="timeline">
                            @if($timeline)
                                @php  $i=1; @endphp
                                @foreach($timeline as $time)
                                    <li class="{{ ($i % 2 == 0) ? 'timeline-inverted' : ''}} " >
                                        <span class="timeline-single__buble">
                                            <span class="bg-success"></span>
                                        </span>
                                        <div class="timeline-single">
                                            <div class="timeline-single__days">
                                                <span>{{ date('d-m-Y H:i a', strtotime($time['created_at'])) }}</span>
                                            </div>
                                            <div class="timeline-single__content">
                                                <div class="d-flex justify-content-between align-content-center flex-wrap">
                                                    <div class="align-content-center pr-10">
                                                        <p>
                                                            {!! $time['content'] !!}
                                                        </p>
                                                        <p class="text-success font-500">- {{ $time['updated_by']['name'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ends: .timelline-single -->
                                    </li>
                                    
                                    @php  $i++; @endphp
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <!-- ends: .card -->
        </div>
    </div>
</div>

@endsection

@section('footer')
<script type="text/javascript">

</script>
@endsection