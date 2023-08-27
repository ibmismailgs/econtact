@extends('layouts.main')
@section('title', 'Quotation Details')
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
                    <i class="fa fa-users bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >Quotation Details</h5>
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
                            <a href="#">{{ __('Quotation')}}</a>
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
                    <h3 class="d-block w-100">{{ __('Quotation')}}
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
                                    <td colspan="2">Quotation Details</td>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td width="50%">Date</td>
                                    <td width="50%">{{ date('F m, Y', strtotime($data->date)) }}</td>
                                </tr>
                                <tr>
                                    <td width="50%">Customer Name</td>
                                    <td width="50%">{{ $data->customers->name ?? '--' }}</td>
                                </tr>

                                <tr>
                                    <td width="50%">Quotation Type</td>
                                    <td width="50%">{{ $data->quotationTypes->title ?? '--' }}</td>
                                </tr>

                                <tr>
                                    <td width="50%">Quotation No</td>
                                    <td width="50%">{{ $data->quotation_no ?? '--' }}</td>
                                </tr>


                                <tr>
                                    <td width="50%">Amount</td>
                                    <td width="50%">{{ number_format($data->amount, 2) ?? '--' }}</td>
                                </tr>

                                @if(isset($data->meetings))
                                    <td width="50%">Meeting Title</td>
                                    <td width="50%" style="word-break: break-word;">{{ $data->meetings->title ?? '--' }}</td>
                                @endif

                                <tr>
                                    <td width="50%">Status</td>
                                    <td width="50%" style="word-break: break-word;">
                                        @if($data->status == 1)
                                          <span class="badge badge-success" title="Success">Success</span>
                                        @elseif($data->status == 2)
                                          <span class="badge badge-info" title="Pending">Pending</span>
                                        @elseif($data->status == 3)
                                          <span class="badge badge-danger" title="Failled">Failled</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td width="50%">Status Note</td>
                                    <td width="50%" style="word-break: break-word;">{!! $data->status_note ?? '--' !!}</td>
                                </tr>

                                <tr>
                                    <td width="50%">Quotation Note</td>
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
