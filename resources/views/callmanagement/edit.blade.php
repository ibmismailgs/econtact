@extends('layouts.main')
@section('title', 'Edit Call-Management')
@section('content')
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
@endpush
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fa fa-phone bg-blue"></i>
                        <div class="d-inline pt-5">
                            <h5 class="pt-10" >Edit Call-Management</h5>
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
                                <a href="#">{{ __('Call-Managements')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Edit Call-Management')}}</a>
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
                        <h3 class="d-block w-100">{{ __('Edit Call-Management')}}
                            <small class="float-right">
                                <a title="Back" href="{{ URL::previous() }}" class="badge badge-secondary">
                                    <i class="ik ik-arrow-left"></i>
                                    Back
                                </a>
                            </small>
                        </h3>
                    </div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" action="{{ route('call-management.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="date">Date<span class="text-red">*</span></label>

                                        <input type="date" name="date" id="date" value="{{ $data->date }}" class="form-control @error('date') is-invalid @enderror" placeholder="Enter date" required>

                                        @error('date')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="time">Time<span class="text-red">*</span></label>

                                        <input type="time" name="time" id="time" value="{{ $data->time }}" class="form-control @error('time') is-invalid @enderror" placeholder="Enter time" required>

                                        @error('time')
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

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="customer_id">Customer<span class="text-red">*</span></label>
                                        @if ($auth && $auth->roles->count() > 0)
                                        @if ($user_role->name == 'Super Admin')
                                        <select name="customer_id" id="customer_id" class="form-control select2 @error('customer_id') is-invalid @enderror" required>
                                            <option value="">Select Customer</option>
                                            @foreach ($clients as $key => $client)
                                                <option value="{{ $client->id }}" @if($data->customer_id == $client->id) selected @endif> {{ $client->name }} </option>
                                            @endforeach
                                        </select>

                                        @endif

                                        @if ($user_role->name == 'Supervisor')

                                        <select name="customer_id" id="customer_id" class="form-control select2 @error('customer_id') is-invalid @enderror" required>
                                            <option value="">Select Customer</option>
                                            @foreach ($clients as $key => $client)
                                                @if ($client->created_by == Auth::user()->id)
                                                <option value="{{ $client->id }}" @if($data->customer_id == $client->id) selected @endif> {{ $client->name }} </option>
                                                @endif
                                            @endforeach
                                        </select>

                                        @endif
                                        @else

                                        <select name="customer_id" id="customer_id" class="form-control select2 @error('customer_id') is-invalid @enderror" required>
                                            <option value="">Select Customer</option>
                                            @foreach ($clients as $key => $client)
                                                @if ($client->created_by == Auth::user()->id)
                                                <option value="{{ $client->id }}" @if($data->customer_id == $client->id) selected @endif> {{ $client->name }} </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="call_type_id">Call Type<span class="text-red">*</span></label>

                                        <select name="call_type_id" id="call_type_id" class="form-control @error('call_type_id') is-invalid @enderror">
                                            <option value="">Select Type</option>
                                            @foreach ($callTypes as $key => $item)
                                                <option value="{{ $item->id }}" {{ $item->id == $data->call_type_id ? 'selected' : '' }}> {{ $item->title }} </option>
                                            @endforeach
                                        </select>

                                        @error('call_type_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="note">Note</label>
                                        <textarea name="note" id="note" class="form-control" cols="10" rows="3">{!! $data->note !!}</textarea>
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
@endpush
@endsection
