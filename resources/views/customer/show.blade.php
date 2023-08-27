@extends('layouts.main')
@section('title', 'Customer Profile')
@section('content')
@push('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
@endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Customer Profile')}}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Customer Details')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Profile')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="@if(isset($data->attachment)){{ asset('img/attachment/'.$data->attachment)}} @else {{asset('img/profile.png')}}  @endif" alt="Profile" width="150">
                            <h4 class="card-title mt-10">{{ $data->name ?? '--' }}</h4>
                        </div>
                    </div>
                    <hr class="mb-0">
                    <div class="card-body">
                        @if ($data->designation != '')
                            <small class="text-muted d-block">{{ __('Designation')}} </small>
                            <h6>{{ $data->designation ?? '--' }}</h6>
                        @endif

                        <small class="text-muted d-block">{{ __('Email')}} </small>
                        <h6>{{ $data->email ?? '--' }}</h6>

                        <small class="text-muted d-block pt-10">{{ __('Primary Phone')}}</small>
                        <h6>{{ $data->primary_phone ?? '--' }}</h6>

                        @if ($data->secondary_phone != '')
                            <small class="text-muted d-block pt-10">{{ __('Secondary Phone')}}</small>
                            <h6>{{ $data->secondary_phone ?? '--' }}</h6>
                        @endif

                        @if ($data->company_name != '')
                            <small class="text-muted d-block pt-10">{{ __('Company Name')}}</small>
                            <h6>{{ $data->company_name ?? '--' }}</h6>
                        @endif

                        <small class="text-muted d-block pt-10">{{ __('Address')}}</small>
                        <h6>{{ $data->address ?? '--' }}</h6>

                        <small class="text-muted d-block pt-10">{{ __('Division')}}</small>
                        <h6>{{ $data->divisions->name ?? '--' }}</h6>

                        <small class="text-muted d-block pt-10">{{ __('District')}}</small>
                        <h6>{{ $data->districits->name ?? '--' }}</h6>

                        <small class="text-muted d-block pt-10">{{ __('Thana')}}</small>
                        <h6>{{ $data->thanas->name ?? '--' }}</h6>

                        <small class="text-muted d-block pt-10">{{ __('Thana')}}</small>
                        <h6>{{ $data->thanas->name ?? '--' }}</h6>

                        <small class="text-muted d-block pt-10">{{ __('Customer Categories')}}</small>
                        <h6>{{ $data->customerCategories->title ?? '--' }}</h6>

                        @if(isset($data->customerSubCategories))
                            <small class="text-muted d-block pt-10">{{ __('Customer Sub-Categories')}}</small>
                            <h6>{{ $data->customerSubCategories->title ?? '--' }}</h6>
                        @endif

                        <small class="text-muted d-block pt-10">{{ __('Customer Source')}}</small>
                        <h6>{{ $data->clientSources->title ?? '--' }}</h6>

                        <small class="text-muted d-block pt-10">{{ __('Customer Status')}}</small>
                        <h6>{{ $data->customerTypes->title ?? '--' }}</h6>

                        <small class="text-muted d-block pt-10">{{ __('Outlet')}}</small>
                        <h6>{{ $data->outlets->title ?? '--' }}</h6>

                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="card">
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-timeline-tab" data-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="true">{{ __('Meeting')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">{{ __('Quotation')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">{{ __('Setting')}}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="pills-sms-tab" data-toggle="pill" href="#sms-send" role="tab" aria-controls="pills-sms" aria-selected="false">{{ __('SMS')}}</a>
                        </li>

                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                            <div class="card-body">
                                <div class="profiletimeline mt-0">
                                    @foreach ($meetings as $meeting)
                                    <div class="sl-item">
                                        <div class="sl-left"> <p>{{ $loop->iteration }}</p>
                                        </div>
                                        <div class="sl-right">
                                            <div>
                                                <span class="sl-date">{{ Carbon\Carbon::parse($meeting->date)->format('d F Y') }}, {{ date('g:i a', strtotime($meeting->time)) ?? '--' }}
                                                </span>
                                                <p>{{ $meeting->title ?? '--' }} --
                                                    <a href="javascript:void(0)">
                                                        {{ $meeting->meetingTypes->title ?? '--' }}
                                                    </a>
                                                </p>
                                                <blockquote class="mt-10">
                                                    {!! $meeting->note ?? '--' !!}
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="card-body">
                                <div class="profiletimeline mt-0">
                                    @foreach ($quotations as $quotation)
                                    <div class="sl-item">
                                        <div class="sl-left"> <p>{{ $loop->iteration }}</p>
                                        </div>
                                        <div class="sl-right">
                                            <div>
                                                <span class="sl-date">{{ Carbon\Carbon::parse($quotation->date)->format('d F Y') }}, {{ date('g:i a', strtotime($quotation->time)) ?? '--' }}
                                                </span>
                                                <p>Type : {{ $quotation->quotationTypes->title ?? '--' }},
                                                </p>
                                                <p> No : {{ $quotation->quotation_no ?? '--' }} </p>

                                                <p> Amount : {{ number_format($quotation->amount) ?? '--' }}
                                                </p>

                                                <blockquote class="mt-10">
                                                    {!! $quotation->note ?? '--' !!}
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                            <div class="card-body">
                                <form enctype="multipart/form-data" action="{{ route('client.update', $data->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="name">Name<span class="text-red">*</span></label>

                                                <input type="text" name="name" id="name" value="{{ $data->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Write name" required>

                                                @error('name')
                                                <span class="text-danger" role="alert">
                                                    <p>{{ $message }}</p>
                                                </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="primary_phone">Primary Phone<span class="text-red">*</span></label>

                                                <input type="text" name="primary_phone" id="primary_phone" value="{{ $data->primary_phone }}" class="form-control @error('primary_phone') is-invalid @enderror" placeholder="Enter primary phone" required>

                                                @error('primary_phone')
                                                <span class="text-danger" role="alert">
                                                    <p>{{ $message }}</p>
                                                </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="secondary_phone">Secondary Phone</label>

                                                <input type="text" name="secondary_phone" id="secondary_phone" value="{{ $data->secondary_phone }}" class="form-control" placeholder="Enter secondary phone">

                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="email">Email</label>

                                                <input type="text" name="email" id="email" value="{{ $data->email }}" class="form-control" placeholder="Enter email address" >

                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="division_id">Division<span class="text-red">*</span></label>

                                                <select name="division_id" id="division_id" class="form-control select2 @error('division_id') is-invalid @enderror" required>
                                                    <option value="">Select Division</option>
                                                    @foreach ($divisions as $key => $division)
                                                        <option value="{{ $division->id }}" @if($data->division_id == $division->id) selected @endif> {{ $division->name }} </option>
                                                    @endforeach
                                                </select>

                                                @error('division_id')
                                                <span class="text-danger" role="alert">
                                                    <p>{{ $message }}</p>
                                                </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="district_id">District<span class="text-red">*</span></label>

                                                <select name="district_id" id="district_id" class="form-control select2 @error('district_id') is-invalid @enderror" required>
                                                    <option value="">Select District</option>
                                                     @foreach ($districts as $key => $district)
                                                        <option value="{{ $district->id }}" @if($data->district_id == $district->id) selected @endif> {{ $district->name }} </option>
                                                    @endforeach
                                                </select>

                                                @error('district_id')
                                                <span class="text-danger" role="alert">
                                                    <p>{{ $message }}</p>
                                                </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="thana_id">Thana<span class="text-red">*</span></label>

                                                <select name="thana_id" id="thana_id" class="form-control select2 @error('thana_id') is-invalid @enderror" required>
                                                    <option value="">Select Thana</option>
                                                    @foreach ($thanas as $key => $thana)
                                                        <option value="{{ $thana->id }}" @if($data->thana_id == $thana->id) selected @endif> {{ $thana->name }} </option>
                                                    @endforeach
                                                </select>

                                                @error('thana_id')
                                                <span class="text-danger" role="alert">
                                                    <p>{{ $message }}</p>
                                                </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="client_source_id">Customer Source<span class="text-red">*</span></label>

                                                <select name="client_source_id" id="client_source_id" class="form-control select2 @error('client_source_id') is-invalid @enderror" required>
                                                    <option value="">Select Source</option>
                                                    @foreach ($clientSources as $key => $clientSource)
                                                        <option value="{{ $clientSource->id }}" @if($data->client_source_id == $clientSource->id) selected @endif> {{ $clientSource->title }} </option>
                                                @endforeach
                                                </select>

                                                @error('client_source_id')
                                                <span class="text-danger" role="alert">
                                                    <p>{{ $message }}</p>
                                                </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="customer_category_id">Customer Category<span class="text-red">*</span></label>

                                                <select name="customer_category_id" id="customer_category_id" class="form-control select2 @error('customer_category_id') is-invalid @enderror" required>
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $key => $category)
                                                        <option value="{{ $category->id }}" @if($data->customer_category_id == $category->id) selected @endif> {{ $category->title }} </option>
                                                    @endforeach
                                                </select>

                                                @error('customer_category_id')
                                                <span class="text-danger" role="alert">
                                                    <p>{{ $message }}</p>
                                                </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="customer_type_id">Customer Type<span class="text-red">*</span></label>

                                                <select name="customer_type_id" id="customer_type_id" class="form-control select2 @error('customer_type_id') is-invalid @enderror" required>
                                                    <option value="">Select Type</option>
                                                    @foreach ($clientTypes as $key => $clientType)
                                                        <option value="{{ $clientType->id }}" @if($data->customer_type_id == $clientType->id) selected @endif> {{ $clientType->title }} </option>
                                                    @endforeach
                                                </select>

                                                @error('customer_type_id')
                                                <span class="text-danger" role="alert">
                                                    <p>{{ $message }}</p>
                                                </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="outlet_id">Outlet<span class="text-red">*</span></label>

                                                <select name="outlet_id" id="outlet_id" class="form-control select2 @error('outlet_id') is-invalid @enderror" required>
                                                    <option value="">Select Outlet</option>
                                                    @foreach ($outlets as $key => $outlet)
                                                        <option value="{{ $outlet->id }}" @if($data->outlet_id == $outlet->id) selected @endif> {{ $outlet->title }} </option>
                                                    @endforeach
                                                </select>

                                                @error('outlet_id')
                                                <span class="text-danger" role="alert">
                                                    <p>{{ $message }}</p>
                                                </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="address">Address<span class="text-red">*</span></label>
                                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" cols="1" rows="1">{!! $data->address !!}</textarea>

                                                @error('address')
                                                <span class="text-danger" role="alert">
                                                    <p>{{ $message }}</p>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        </div>

                                        <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="attachment">Attachment (only image)</label>

                                                <input data-height="100" type="file" name="attachment" id="attachment" class="form-control dropify" data-default-file="{{ asset('img/attachment/'.$data->attachment) }}">

                                                <input type="hidden" name="current_image" value="{{ $data->attachment }}" />

                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="note">Note</label>
                                                <textarea name="note" id="note" class="form-control" cols="20" rows="5">{!! $data->note !!}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success mr-2">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="sms-send" role="tabpanel" aria-labelledby="pills-sms-tab">
                            <div class="card-body">

                                <form enctype="multipart/form-data" action="{{ route('sms-marketing.store') }}" method="POST">
                                    @csrf
                                    <div class="row">

                                        <input type="hidden" name="sms_type" value="1">
                                        <input type="hidden" name="customer_id" value="{{ $data->id }}">

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="text">Text<span class="text-red">*</span></label>
                                                <textarea name="text" id="text" class="form-control @error('text') is-invalid @enderror" cols="3" rows="3" required>{!! old('text') !!}</textarea>

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
                                            <button type="submit" class="btn btn-success mr-2">Send</button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="profiletimeline mt-0">
                                    @foreach ($sms as $item)
                                    <div class="sl-item">
                                        <div class="sl-left"> <p>{{ $loop->iteration }}</p>
                                        </div>
                                        <div class="sl-right">
                                            <div>
                                                <span class="sl-date">{{ Carbon\Carbon::parse($item->created_at)->format('d F Y') }}, {{ date('g:i a', strtotime($item->created_at)) ?? '--' }}
                                                </span>
                                                <blockquote class="mt-10">
                                                    {!! $item->text ?? '--' !!}
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.dropify').dropify();

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
