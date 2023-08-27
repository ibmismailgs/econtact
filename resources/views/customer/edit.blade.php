@extends('layouts.main')
@section('title', 'Edit Customer')
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
                        <i class="fa fa-users bg-blue"></i>
                        <div class="d-inline pt-5">
                            <h5 class="pt-10" >Edit Customer</h5>
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
                                <a href="#">{{ __('Customers')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Customer')}}</a>
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
                        <h3 class="d-block w-100">{{ __('Customer')}}
                            <small class="float-right">
                                <a title="Back" href="{{ URL::previous() }}" class="badge badge-secondary">
                                    <i class="ik ik-arrow-left"></i>
                                    Back
                                </a>
                            </small>
                        </h3>
                    </div>

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
                                        <label for="designation">Designation</label>
                                        <input type="text" name="designation" id="designation" value="{{ $data->designation }}" class="form-control" placeholder="Write designation">
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
                                        <input type="text" name="email" id="email" value="{{ $data->email }}" class="form-control" placeholder="Enter email address">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="company_name">Company Name</label>

                                        <input type="text" name="company_name" id="company_name" value="{{ $data->company_name }}" class="form-control" placeholder="Enter company name">

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
                                        <label for="customer_subcategory_id">Customer Sub-Category</label>
                                        <select name="customer_subcategory_id" id="customer_subcategory_id" class="form-control select2" required>
                                            <option value="">Select Sub-Category</option>
                                            @foreach ($subcategories as $key => $category)
                                                <option value="{{ $category->id }}" @if($data->customer_subcategory_id == $category->id) selected @endif> {{ $category->title }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customer_type_id">Customer Status<span class="text-red">*</span></label>

                                        <select name="customer_type_id" id="customer_type_id" class="form-control select2 @error('customer_type_id') is-invalid @enderror" required>
                                            <option value="">Select Status</option>
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

                                <div class="col-sm-6">
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

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="address">Address<span class="text-red">*</span></label>
                                        <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" cols="2" rows="2">{!! $data->address !!}</textarea>

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

                                        <input type="file" name="attachment" id="attachment" class="form-control dropify" data-default-file="{{ asset('img/attachment/'.$data->attachment) }}">

                                        <input type="hidden" name="current_image" value="{{ $data->attachment }}" />

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="note">Note</label>
                                        <textarea name="note" id="note" class="form-control" cols="20" rows="9">{!! $data->note !!}</textarea>
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

$("#customer_category_id").on('change', function(){
    var customer_category_id = $('#customer_category_id').val();

    $.ajax({
        url: "{{ route('category-wise-subcategory') }}",
        type: "GET",
        data: {
            category_id:customer_category_id,
        },
        success: function(resp){

            $('#customer_subcategory_id').empty();
            $('#customer_subcategory_id').append("<option value=''>--Select Sub-Category--</option>");
            $.each(resp.categories, function(key, category){
                $('#customer_subcategory_id').append("<option value="+category.id+">"+category.title+"</option>");
            });

        },
    });
});
</script>
@endpush
@endsection
