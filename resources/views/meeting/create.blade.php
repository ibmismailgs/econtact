@extends('layouts.main')
@section('title', 'Create Meeting')
@section('content')
@push('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
    <style>
        .checkmark {
        /* position: absolute; */
        height: 20px;
        width: 20px;
        background-color: #eee;
    }
    </style>
    @endpush
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fa fa-handshake bg-blue"></i>
                        <div class="d-inline pt-5">
                            <h5 class="pt-10" >Create Meeting</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Meetings')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Meeting')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-header">
                        <h3 class="d-block w-100">{{ __('Meeting')}}
                            <small class="float-right">
                                <a title="Back" href="{{ URL::previous() }}" class="badge badge-secondary">
                                    <i class="ik ik-arrow-left"></i>
                                    Back
                                </a>
                            </small>
                        </h3>
                    </div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" action="{{ route('meeting.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="title">Meeting Title<span class="text-red">*</span></label>

                                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Write title" required>

                                        @error('title')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                            @php
                                $auth = Auth::user();
                                $user_role = $auth->roles->first();
                           @endphp

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="customer_id">Customer<span class="text-red">*</span></label>

                                    @if ($auth && $auth->roles->count() > 0)

                                        @if ($user_role->name == 'Super Admin')
                                            <select name="customer_id" id="customer_id" class="form-control select2 @error('customer_id') is-invalid @enderror" required>
                                                <option value="">Select Customer</option>
                                                @foreach ($clients as $key => $client)
                                                    <option value="{{ $client->id }}" > {{ $client->name }} </option>
                                                @endforeach
                                            </select>
                                        @endif

                                        @if ($user_role->name == 'Supervisor')
                                        <select name="customer_id" id="customer_id" class="form-control select2 @error('customer_id') is-invalid @enderror" required>
                                            <option value="">Select Customer</option>
                                                @foreach ($clients as $key => $client)
                                                    @if ($client->created_by == Auth::user()->id)
                                                        <option value="{{ $client->id }}" > {{ $client->name }} </option>
                                                    @endif
                                                @endforeach
                                        </select>
                                    @endif

                                    @else

                                    <select name="customer_id" id="customer_id" class="form-control select2 @error('customer_id') is-invalid @enderror" required>
                                        <option value="">Select Customer</option>
                                            @foreach ($clients as $key => $client)
                                                @if ($client->created_by == Auth::user()->id)
                                                    <option value="{{ $client->id }}" > {{ $client->name }} </option>
                                                @endif
                                            @endforeach
                                    </select>
                                    @endif

                                    @error('customer_id')
                                    <span class="text-danger" role="alert">
                                        <p>{{ $message }}</p>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                            
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="meeting_type_id">Meeting Type<span class="text-red">*</span></label>

                                        <select name="meeting_type_id" id="meeting_type_id" class="form-control select2 @error('meeting_type_id') is-invalid @enderror" required>
                                            <option value="">Select Type</option>
                                            @foreach ($meetingTypes as $key => $meetingType)
                                                <option value="{{ $meetingType->id }}" > {{ $meetingType->title }} </option>
                                            @endforeach
                                        </select>

                                        @error('meeting_type_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="date">Date<span class="text-red">*</span></label>

                                        <input type="date" name="date" id="date" value="{{ old('date') }}" class="form-control @error('date') is-invalid @enderror" placeholder="Write date" required>

                                        @error('date')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="time">Time<span class="text-red">*</span></label>

                                        <input type="time" name="time" id="time" value="{{ old('time') }}" class="form-control @error('time') is-invalid @enderror" placeholder="Write time" required>


                                        @error('time')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="col-sm-4">
                                    <div class="form-group">
                                        <span class="d-flex">
                                            <span style="margin-left: 5px; height:32px; font-size:14px; text-align:center; padding-top: 8px;margin-top: 25px;" id="add" class="badge badge-success">Add Quotation : </span> &nbsp;&nbsp;

                                            <input style="width: 35px !important; height:32px !important;margin-top: 25px;" type="checkbox" name="addquotation" class="checkoption checkmark" value="1"></span>

                                        </span>

                                            @error('time')
                                            <span class="text-danger" role="alert">
                                                <p>{{ $message }}</p>
                                            </span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4 quotation">
                                    <div class="form-group">
                                        <label for="quotation_type_id">Quotation Type<span class="text-red">*</span></label>

                                        <select name="quotation_type_id" id="quotation_type_id" class="form-control @error('quotation_type_id') is-invalid @enderror">
                                            <option value="">Select Type</option>
                                            @foreach ($quotationTypes as $key => $item)
                                                <option value="{{ $item->id }}" > {{ $item->title }} </option>
                                            @endforeach
                                        </select>

                                        @error('quotation_type_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4 quotation">
                                    <div class="form-group">
                                        <label for="quotation_no">Quotation No<span class="text-red">*</span></label>

                                        <input type="text" name="quotation_no" id="quotation_no" value="{{ old('quotation_no') }}" class="form-control @error('quotation_no') is-invalid @enderror" placeholder="Enter quotation no">

                                        @error('quotation_no')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4 quotation">
                                    <div class="form-group">
                                        <label for="amount">Amount<span class="text-red">*</span></label>

                                        <input type="text" name="amount" id="amount" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror" placeholder="Enter amount" min="0">

                                        @error('amount')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div> --}}

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="note">Note</label>
                                        <textarea name="note" id="note" class="form-control" cols="10" rows="2">{!! old('note') !!}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success mr-2">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('script')
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $("#division_id").on('change', function(){
            var division_id = $('#division_id').val();

            $.ajax({
                url: "{{ route('division-wise-district') }}",
                type: "GET",
                data: {
                    division_id:division_id,
                },
                success: function(resp){

                    $('#district_id').empty();
                    $('#district_id').append("<option value=''>--Select District--</option>");
                    $.each(resp.districts, function(key, district){
                        $('#district_id').append("<option value="+district.id+">"+district.name+"</option>");
                    });

                },
            });
        });

        $("#district_id").on('change', function(){
            var district_id = $('#district_id').val();

            $.ajax({
                url: "{{ route('district-wise-thana') }}",
                type: "GET",
                data: {
                    district_id:district_id,
                },
                success: function(resp){

                    $('#thana_id').empty();
                    $('#thana_id').append("<option value=''>--Select Thana--</option>");
                    $.each(resp.thans, function(key, thana){
                        $('#thana_id').append("<option value="+thana.id+">"+thana.name+"</option>");
                    });

                },
            });
        });

        $(".quotation").hide();

        $('.checkoption').click(function() {
          $('.checkoption').not(this).prop('checked', false);

          if (this.checked) {
            $(".quotation").show();
            } else {
                $(".quotation").hide();
            }

        });

    </script>
@endpush
@endsection
