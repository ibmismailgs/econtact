@extends('layouts.main')
@section('title', 'Edit Quotation')
@section('content')
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
@endpush
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fa fa-quote-left bg-blue"></i>
                        <div class="d-inline pt-5">
                            <h5 class="pt-10" >Edit Quotation</h5>
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
                                <a href="#">{{ __('Quotations')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Edit Quotation')}}</a>
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
                        <h3 class="d-block w-100">{{ __('Edit Quotation')}}
                            <small class="float-right">
                                <a title="Back" href="{{ URL::previous() }}" class="badge badge-secondary">
                                    <i class="ik ik-arrow-left"></i>
                                    Back
                                </a>
                            </small>
                        </h3>
                    </div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" action="{{ route('quotations.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="date">Date<span class="text-red">*</span></label>

                                        <input type="date" name="date" id="date" value="{{ $data->date }}" class="form-control @error('date') is-invalid @enderror" placeholder="Enter date address" required>

                                        @error('date')
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
                                        <label for="meeting_id">Meeting</label>
                                        @if ($auth && $auth->roles->count() > 0)
                                        @if ($user_role->name == 'Super Admin')
                                            <select name="meeting_id" id="meeting_id" class="form-control">
                                                <option value="">Select Meeting</option>
                                                @foreach ($meetings as $key => $meeting)
                                                    <option value="{{ $meeting->id }}" {{ $meeting->id == $data->meeting_id ? 'selected' : '' }}> {{ $meeting->title }} </option>
                                                @endforeach
                                            </select>
                                            @endif

                                            @if ($user_role->name == 'Supervisor')

                                            <select name="meeting_id" id="meeting_id" class="form-control">
                                                <option value="">Select Meeting</option>
                                                @foreach ($meetings as $key => $meeting)
                                                    @if ($meeting->created_by == Auth::user()->id)
                                                        <option value="{{ $meeting->id }}" {{ $meeting->id == $data->meeting_id ? 'selected' : '' }}> {{ $meeting->title }} </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @endif

                                        @else

                                        <select name="meeting_id" id="meeting_id" class="form-control">
                                            <option value="">Select Meeting</option>
                                            @foreach ($meetings as $key => $meeting)
                                                @if ($meeting->created_by == Auth::user()->id)
                                                    <option value="{{ $meeting->id }}" {{ $meeting->id == $data->meeting_id ? 'selected' : '' }}> {{ $meeting->title }} </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @endif

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="quotation_type_id">Quotation Type<span class="text-red">*</span></label>

                                        <select name="quotation_type_id" id="quotation_type_id" class="form-control @error('quotation_type_id') is-invalid @enderror">
                                            <option value="">Select Type</option>
                                            @foreach ($quotationTypes as $key => $item)
                                                <option value="{{ $item->id }}" {{ $item->id == $data->quotation_type_id ? 'selected' : '' }}> {{ $item->title }} </option>
                                            @endforeach
                                        </select>

                                        @error('quotation_type_id')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="quotation_no">Quotation No<span class="text-red">*</span></label>

                                        <input type="text" name="quotation_no" id="quotation_no" value="{{ $data->quotation_no }}" class="form-control @error('quotation_no') is-invalid @enderror" placeholder="Enter quotation no" required>

                                        @error('quotation_no')
                                        <span class="text-danger" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="amount">Amount<span class="text-red">*</span></label>

                                        <input type="text" name="amount" id="amount" value="{{ $data->amount }}" class="form-control @error('amount') is-invalid @enderror" placeholder="Enter amount" min="0" required>

                                        @error('amount')
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
