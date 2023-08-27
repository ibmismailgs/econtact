@extends('layouts.main')
@section('title', 'Email Details')
@section('content')
@push('head')
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
                    <i class="fa fa-envelope bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >Email Details</h5>
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
                            <a href="#">{{ __('Email')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">{{ __('Email')}}</a>
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
                    <h3 class="d-block w-100">{{ __('SMS')}}
                        <small class="float-right">
                            <a title="Back" href="{{ URL::previous() }}" class="badge badge-secondary">
                                <i class="ik ik-arrow-left"></i>
                                Back
                            </a>
                        </small>
                    </h3>
                </div>

                    <div class="card-body">
                        @if ($data->type == 1)
                        <div class="table-bordered col-md-12">
                            <div class="btn-primary row "><span class="ml-10">Email Details</span></div>
                            <hr>
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">Date</label>
                                    <div class="col-sm-10">
                                        <label for="title" class="col-form-label">{{ Carbon\Carbon::parse($data->created_at)->format('d F Y') }}</label>
                                    </div>
                                </div>
                            <hr>
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">Client Name</label>
                                    <div class="col-sm-10">
                                        <label for="title" class="col-form-label">{{ $data->customers->name ?? '--' }}</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">Client Phone</label>
                                    <div class="col-sm-10">
                                        <label for="title" class="col-form-label">{{ $data->customers->primary_phone ?? '--' }}</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">Client Email</label>
                                    <div class="col-sm-10">
                                        <label for="title" class="col-form-label">{{ $data->customers->email ?? '--' }}</label>
                                    </div>
                                </div>

                                <hr>
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">Email Body</label>
                                    <div class="col-sm-10">
                                        <label for="title" class="col-form-label">{!! $data->text ?? '--' !!}</label>
                                    </div>
                                </div>
                        </div>
                        @endif

                        @if ($data->type == 2)
                        <div class="table-bordered col-md-12">
                            <div class="btn-primary row "><span class="ml-10">Email Details</span></div>
                            <hr>
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">Date</label>
                                    <div class="col-sm-10">
                                        <label for="title" class="col-form-label">{{ Carbon\Carbon::parse($data->created_at)->format('d F Y') }}</label>
                                    </div>
                                </div>
                            <hr>

                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label">Email Body</label>
                                <div class="col-sm-10">
                                    <label for="title" class="col-form-label">{!! $data->text ?? '--' !!}</label>
                                </div>
                            </div>

                            <hr>

                            <table id="data_table" class="table table-bordered table-striped data-table table-hover">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clients as $key => $client)
                                    <tr>
                                        <th>{{ $key + 1 }}</th>
                                        <th>{{ $client->name}}</th>
                                        <th>{{ $client->primary_phone }}</th>
                                        <th>{{ $client->email }}</th>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
