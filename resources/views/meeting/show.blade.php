@extends('layouts.main')
@section('title', 'Meeting Details')
@section('content')

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="fa fa-handshake bg-blue"></i>
                    <div class="d-inline pt-5">
                        <h5 class="pt-10" >Meeting Details</h5>
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
            <div class="col-md-4">
                <div class="card task-board">
                    <div class="card-header">
                        <h3>{{ __('Meeting')}}</h3>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="ik ik-chevron-left action-toggle"></i></li>
                                <li><i class="ik ik-rotate-cw reload-card" data-loading-effect="pulse"></i></li>
                                <li><i class="ik ik-minus minimize-card"></i></li>
                                <li><i class="ik ik-x close-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body todo-task">
                        <div class="dd" data-plugin="nestable">

                            <ol class="dd-list">
                                <li class="dd-item" data-id="1">
                                    <div class="dd-handle">
                                        <h6>{{ __('Meeting Title') }}</h6>
                                        <p>{{ $data->title ?? '--' }}</p>
                                    </div>
                                </li>

                                <li class="dd-item" data-id="2">
                                    <div class="dd-handle">
                                        <h6>{{ __('Meeting Type')}}</h6>
                                        <p>{{ $data->meetingTypes->title ?? '--' }}</p>
                                    </div>
                                </li>

                                <li class="dd-item" data-id="3">
                                    <div class="dd-handle">
                                        <h6>{{ __('Meeting Date | Time')}}</h6>
                                        <p>{{ Carbon\Carbon::parse($data->date)->format('d F Y') }}, {{ date('g:i a', strtotime($data->time)) }}</p>
                                    </div>
                                </li>

                                @if ($data->is_reschedule == 1)
                                <li class="dd-item" data-id="3">
                                    <div class="dd-handle">
                                        <h6>{{ __('Reschedule Date | Time')}}</h6>
                                        @foreach ($meetingReschedules as $meetingReschedule)
                                            <p>{{ Carbon\Carbon::parse($meetingReschedule->date)->format('d F Y') }}, {{ date('g:i a', strtotime($meetingReschedule->time)) }}</p>
                                            <blockquote class="mt-10">
                                                {!! $meetingReschedule->note ?? '--' !!}
                                            </blockquote>
                                        @endforeach
                                    </div>
                                </li>
                                @endif

                                <li class="dd-item" data-id="3">
                                    <div class="dd-handle">
                                        <h6>{{ __('Meeting Status')}}</h6>
                                        <p>
                                            @if($data->meeting_status == 1)
                                            <span class="badge badge-success" title="Success">Success</span>
                                            @elseif($data->meeting_status == 2)
                                            <span class="badge badge-info" title="Pending">Pending</span>
                                            @elseif($data->meeting_status == 3)
                                            <span class="badge badge-danger" title="Failled">Failled</span>
                                            @endif
                                        </p>
                                    </div>
                                </li>

                                <li class="dd-item" data-id="3">
                                    <div class="dd-handle">
                                        <h6>@if($data->meeting_status == 1)Success
                                            @elseif($data->meeting_status == 2)Pending
                                            @elseif($data->meeting_status == 3)Failled
                                            @endif Note</h6>
                                        <p>{{ $data->status_note ?? '--' }}</p>
                                    </div>
                                </li>

                                <li class="dd-item" data-id="3">
                                    <div class="dd-handle">
                                        <h6>{{ __('Meeting Note')}}</h6>
                                        <p>{!! $data->note ?? '--' !!}</p>
                                    </div>
                                </li>

                            </ol>
                        </div>

                    </div>
                </div>
            </div>


           @if (count($meetingMinutes) > 0)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Minute</h3>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="ik ik-chevron-left action-toggle"></i></li>
                                <li><i class="ik ik-rotate-cw reload-card" data-loading-effect="pulse"></i></li>
                                <li><i class="ik ik-minus minimize-card"></i></li>
                                <li><i class="ik ik-x close-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body progress-task">
                        <div class="dd" data-plugin="nestable">
                            <ol class="dd-list">
                                <li class="dd-item" data-id="1">
                                    @foreach ($meetingMinutes as $meetingMinute)
                                    <div class="dd-handle">
                                        <h6>{{ Carbon\Carbon::parse($meetingMinute->date)->format('d F Y') }}, {{ date('g:i a', strtotime($meetingMinute->time)) ?? '--' }}</h6>
                                        <p>{!! $meetingMinute->note ?? '--' !!}</p>
                                    </div>
                                    @endforeach
                                </li>
                            </ol>
                        </div>
                    </div>

                </div>
            </div>
        @endif

        @if ($data->addquotation == 1)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Quotation</h3>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="ik ik-chevron-left action-toggle"></i></li>
                                <li><i class="ik ik-rotate-cw reload-card" data-loading-effect="pulse"></i></li>
                                <li><i class="ik ik-minus minimize-card"></i></li>
                                <li><i class="ik ik-x close-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body completed-task">
                        <div class="dd" data-plugin="nestable">
                            <ol class="dd-list">

                                <li class="dd-item" data-id="1">
                                    @foreach ($quotations as $quotation)
                                    <div class="dd-handle">
                                        <h6>{{ Carbon\Carbon::parse($quotation->date)->format('d F Y') }}, {{ date('g:i a', strtotime($quotation->time)) ?? '--' }}
                                        </h6>
                                        <h6>Type : {{ $quotation->quotationTypes->title ?? '--' }}
                                        </h6>
                                        <h6>No : {{ $quotation->quotation_no ?? '--' }} </h6>

                                        <h6> Amount : {{ number_format($quotation->amount) ?? '--' }}
                                        </h6>

                                        <blockquote class="mt-10">
                                            {!! $quotation->note ?? '--' !!}
                                        </blockquote>
                                    </div>
                                    @endforeach
                                </li>

                            </ol>
                        </div>
                    </div>

                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- push external js -->
    @push('script')
        <script src="{{ asset('plugins/nestable/jquery.nestable.js') }}"></script>
        <script src="{{ asset('js/taskboard.js') }}"></script>
    @endpush
@endsection
