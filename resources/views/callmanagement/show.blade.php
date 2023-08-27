@extends('layouts.main')
@section('title', 'Call-Management Details')
@section('content')

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="fa fa-phone bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >Call-Management Details</h5>
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
                            <a href="#">{{ __('Call-Management')}}</a>
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
                    <h3 class="d-block w-100">{{ __('Call-Management')}}
                        <small class="float-right">
                            <a title="Back" href="{{ URL::previous() }}" class="badge badge-secondary">
                                <i class="ik ik-arrow-left"></i>
                                Back
                            </a>
                        </small>
                    </h3>
                </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="btn-primary text-center">
                                    <td colspan="2">Call-Management Details</td>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr>
                                    <td width="50%">Date|Time</td>
                                    <td width="50%">{{ date('F m, Y', strtotime($data->date)) }} | {{ date('g:i a', strtotime($data->time )) }}</td>
                                </tr>

                                <tr>
                                    <td width="50%"> Name</td>
                                    <td width="50%">{{ $data->customers->name ?? '--' }}</td>
                                </tr>

                                <tr>
                                    <td width="50%">Phone</td>
                                    <td width="50%">{{ $data->customers->primary_phone ?? '--' }}</td>
                                </tr>

                                <tr>
                                    <td width="50%">Company Name</td>
                                    <td width="50%">{{ $data->customers->company_name ?? '--' }}</td>
                                </tr>

                                <tr>
                                    <td width="50%">Call Type</td>
                                    <td width="50%">{{ $data->callTypes->title ?? '--' }}</td>
                                </tr>

                                <tr>
                                    <td width="50%">Note</td>
                                    <td width="50%" style="word-break: break-word;">{!! $data->note ?? '--' !!}</td>
                                </tr>

                            </tbody>
                          </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
