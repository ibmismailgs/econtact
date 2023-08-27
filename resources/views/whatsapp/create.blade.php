@extends('layouts.main')
@section('title', 'Create Whatsapp Message')
@section('content')
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
@endpush
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fa fa-envelope bg-blue"></i>
                        <div class="d-inline pt-5">
                            <h5 class="pt-10" >Create Whatsapp Message</h5>
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
                                <a href="#">{{ __('Whatsapp Message')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Whatsapp Message')}}</a>
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
                        <h3 class="d-block w-100">{{ __('Whatsapp Message')}}
                            <small class="float-right">
                                <a title="Back" href="{{ URL::previous() }}" class="badge badge-secondary">
                                    <i class="ik ik-arrow-left"></i>
                                    Back
                                </a>
                            </small>
                        </h3>
                    </div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" action="{{ route('whatsapp-marketing.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="type">Message Type<span class="text-red">*</span></label>

                                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                            <option value="">Select</option>
                                            <option value="1">Individual</option>
                                            <option value="2">Group</option>

                                        </select>

                                        @error('type')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4 single-client">
                                    <div class="form-group">
                                        <label for="customer_id">Client Name<span class="text-red">*</span></label>

                                        <select name="customer_id" id="customer_id" class="form-control select2 @error('customer_id') is-invalid @enderror">
                                            <option value="">Select Client</option>
                                            @foreach ($clients as $key => $client)
                                                <option value="{{ $client->id }}" > {{ $client->name }} </option>
                                            @endforeach
                                        </select>

                                        @error('customer_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-4 group-sms">
                                    <div class="form-group">
                                        <label for="division_id">Division</label>

                                        <select name="division_id" id="division_id" class="form-control select2">
                                            <option value="">Select Division</option>
                                            @foreach ($divisions as $key => $division)
                                                <option value="{{ $division->id }}" > {{ $division->name }} </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="col-sm-4 group-sms">
                                    <div class="form-group">
                                        <label for="district_id">District</label>

                                        <select name="district_id" id="district_id" class="form-control select2">
                                            <option value="">Select District</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-sm-4 group-sms">
                                    <div class="form-group">
                                        <label for="thana_id">Thana</label>

                                        <select name="thana_id" id="thana_id" class="form-control select2">
                                            <option value="">Select Thana</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4 group-sms">
                                    <div class="form-group">
                                        <label for="customer_source_id">Client Source</label>

                                        <select name="customer_source_id" id="customer_source_id" class="form-control select2">
                                            <option value="">Select Source</option>
                                            @foreach ($clientSources as $key => $clientSource)
                                                <option value="{{ $clientSource->id }}" > {{ $clientSource->title }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4 group-sms">
                                    <div class="form-group">
                                        <label for="customer_category_id">Client Category</label>

                                        <select name="customer_category_id" id="customer_category_id" class="form-control select2">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $key => $category)
                                                <option value="{{ $category->id }}" > {{ $category->title }} </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="col-sm-4 group-sms">
                                    <div class="form-group">
                                        <label for="customer_type_id">Client Type</label>

                                        <select name="customer_type_id" id="customer_type_id" class="form-control select2">
                                            <option value="">Select Type</option>
                                            @foreach ($clientTypes as $key => $clientType)
                                                <option value="{{ $clientType->id }}" > {{ $clientType->title }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4 group-sms">
                                    <div class="form-group">
                                        <label for="outlet_id">Outlet</label>

                                        <select name="outlet_id" id="outlet_id" class="form-control select2">
                                            <option value="">Select Outlet</option>
                                            @foreach ($outlets as $key => $outlet)
                                                <option value="{{ $outlet->id }}" > {{ $outlet->title }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="text">Email Body<span class="text-red">*</span></label>
                                        <textarea name="text" id="text" class="form-control html-editor @error('text') is-invalid @enderror" cols="3" rows="3" required>{!! old('text') !!}</textarea>

                                        @error('text')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror
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

        $('.group-sms').hide();
        $('.single-client').hide();
        $('.group-client').hide();

        $("#type").on('change', function(){
        if ($(this).val() == 1) {
             $('.group-sms').hide();
             $('.single-client').show();
        }else if($(this).val() == 2){
            $('.group-sms').show();
            $('.single-client').hide();
        }else{
            $('.group-sms').hide();
            $('.single-client').hide();
        }
    });

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
    </script>
@endpush
@endsection
