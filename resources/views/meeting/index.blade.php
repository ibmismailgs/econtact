@extends('layouts.main')
@section('title', 'Meeting List')
@section('content')
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/toggle.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/jquery-toast-plugin/dist/jquery.toast.min.css')}}">
@endpush
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fa fa-handshake bg-blue"></i>
                        <div class="d-inline pt-5">
                            <h5 class="pt-10" >Meeting List</h5>
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
                            @can('meeting_create')
                            <small class="float-right">
                                <a title="Create" href="{{ route('meeting.create') }}" type="button" class="badge badge-primary">
                                    <i class="fas fa-plus mr-1"></i>
                                    Create
                                </a>
                            </small>
                            @endcan
                        </h3>
                    </div>

                    <div class="card-body">
                        <table id="data_table" class="table table-bordered table-striped data-table table-hover">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Customer</th>
                                    <th>Meeting Type</th>
                                    <th>Date | Time</th>
                                    <th>Meeting Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- meeting status --}}
    <div class="modal fade" id="statusData" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Meeting Status')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="status-data" action="#">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="meeting_status" class="col-sm-2 col-form-label">Meeting Status<span class="text-red">*</span></label>

                            <div class="col-sm-10">
                                <select name="meeting_status" id="meeting_status" class="form-control @error('meeting_status') is-invalid @enderror">
                                    <option value="">Select Status</option>
                                    <option value="1">Success</option>
                                    <option value="2">Pending</option>
                                    <option value="3">Failled</option>
                                </select>

                                <input type="hidden" id="statusId">

                                @error('meeting_status')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status_note" class="col-sm-2 col-form-label"> Status Note<span class="text-red">*</span></label>

                            <div class="col-sm-10">
                                 <textarea name="status_note" id="status_note" class="form-control" cols="10" rows="3">{!! old('status_note') !!}</textarea>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close')}}</button>
                    <button type="button" id="statusupdate" class="btn btn-primary">{{ __('Submit')}}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- meeting minutes --}}
    <div class="modal fade" id="minuteData" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Create Meeting Minute')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="minute-data" class="forms-sample add-data" enctype="multipart/form-data" action="#" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="date" class="col-sm-2 col-form-label">Date<span class="text-red">*</span></label>

                            <div class="col-sm-10">
                                <input type="date" name="date" id="meetingMinuteDate" value="{{ old('date') }}" class="form-control @error('date') is-invalid @enderror" placeholder="Write date" required>

                                <input type="hidden" name="meeting_id" id="meetingminuteId">
                                @error('date')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="time" class="col-sm-2 col-form-label">Time<span class="text-red">*</span></label>

                            <div class="col-sm-10">
                                <input type="time" name="time" id="minutetime" value="{{ old('time') }}" class="form-control @error('time') is-invalid @enderror" placeholder="Write time" required>

                                @error('time')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="minute_note" class="col-sm-2 col-form-label">Minutes Note</label>

                            <div class="col-sm-10">
                                 <textarea name="minute_note" id="minute_note" class="form-control" cols="10" rows="3">{!! old('minute_note') !!}</textarea>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close')}}</button>
                    <button type="button" id="save" class="btn btn-primary">{{ __('Create')}}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- meeting reschedule --}}
    <div class="modal fade" id="RescheduleData" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Create Meeting Reschedule')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="reschedule-data" class="forms-sample reschedule" enctype="multipart/form-data" action="#" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="date" class="col-sm-2 col-form-label">Date<span class="text-red">*</span></label>

                            <div class="col-sm-10">
                                <input type="date" name="reschedule_date" id="meetingRescheduleDate" value="{{ old('date') }}" class="form-control @error('date') is-invalid @enderror" placeholder="Write date" required>

                                <input type="hidden" name="reschedule_meeting_id" id="meetingRescheduleId">
                                @error('date')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="time" class="col-sm-2 col-form-label">Time<span class="text-red">*</span></label>

                            <div class="col-sm-10">
                                <input type="time" name="reschedule_time" id="Rescheduletime" value="{{ old('time') }}" class="form-control @error('time') is-invalid @enderror" placeholder="Write time" required>

                                @error('time')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="reschedule_note" class="col-sm-2 col-form-label">Reschedule Note</label>

                            <div class="col-sm-10">
                                 <textarea name="reschedule_note" id="reschedule_note" class="form-control" cols="10" rows="3">{!! old('reschedule_note') !!}</textarea>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close')}}</button>
                    <button type="button" id="reschedulesave" class="btn btn-primary">{{ __('Create')}}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- meeting quotation --}}
    <div class="modal fade" id="quotationData" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Create Quotation')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="quotation-data" class="forms-sample add-data" enctype="multipart/form-data" action="#" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="quotation_date" class="col-sm-3 col-form-label">Date<span class="text-red">*</span></label>

                            <div class="col-sm-9">
                                <input type="date" name="date" id="quotation_date" value="{{ old('date') }}" class="form-control @error('date') is-invalid @enderror" placeholder="Enter date">

                                @error('date')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label" style="font-size: 12px">Quotation Type<span class="text-red">*</span></label>

                            <div class="col-sm-9">
                                <select name="quotation_type_id" id="quotation_type_id" class="form-control @error('quotation_type_id') is-invalid @enderror">
                                    <option value="">Select Type</option>
                                    @foreach ($quotationTypes as $key => $item)
                                        <option value="{{ $item->id }}" > {{ $item->title }} </option>
                                    @endforeach
                                </select>

                                <input type="hidden" name="meeting_id" id="meetiongQuotationId">
                                <input type="hidden" name="customer_id" id="customer_id">
                                @error('date')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="quotation_no" class="col-sm-3 col-form-label">Quotation No<span class="text-red">*</span></label>

                            <div class="col-sm-9">
                                <input type="text" name="quotation_no" id="quotation_no" value="{{ old('quotation_no') }}" class="form-control @error('quotation_no') is-invalid @enderror" placeholder="Enter quotation no">

                                @error('quotation_no')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="time" class="col-sm-3 col-form-label">Amount<span class="text-red">*</span></label>

                            <div class="col-sm-9">
                                <input type="text" name="amount" id="amount" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror" placeholder="Enter amount" min="0">

                                @error('amount')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="note" class="col-sm-3 col-form-label">Note</label>

                            <div class="col-sm-9">
                                 <textarea name="note" id="quotation_note" class="form-control" cols="10" rows="3">{!! old('note') !!}</textarea>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close')}}</button>
                    <button type="button" id="quotationsave" class="btn btn-primary">{{ __('Create')}}</button>
                </div>
            </div>
        </div>
    </div>

@push('script')
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-toast-plugin/dist/jquery.toast.min.js')}}"></script>
<script src="{{ asset('js/alerts.js')}}"></script>
<script src="{{ asset('plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
<script>

    $(document).ready( function () {
        var dTable = $('#data_table').DataTable({
        order: [],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        processing: true,
        responsive: false,
        serverSide: true,
        scroller: {
            loadingIndicator: false
        },
        language: {
            processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
            },
        pagingType: "full_numbers",
        ajax: {
            url: "{{route('meeting.index')}}",
            type: "get"
        },

        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true},
            {data: 'name', name: 'name' , searchable: true},
            {data: 'title', name: 'title' , searchable: true},
            {data: 'dateTime', name: 'dateTime' , searchable: true},
            {data: 'meetingStatus', name: 'meetingStatus' , searchable: true},
            {data: 'action', searchable: false, orderable: false}
        ],
    });
    });

    $('#data_table').on('click', '#delete[href]', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        swal({
                title: `Are you sure ?`,
                text: "Want to delete this record?",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {submit: true, _method: 'delete', _token: "{{ csrf_token() }}"}
            }).always(function (data) {
                $('#data_table').DataTable().ajax.reload();
                if (data.success === true) {
                    showSuccessToast(data.message);
                }else{
                    showDangerToast(data.message);
                }
            });
        }
        });
    });

    $('#data_table').on('click', '#meetingId[href]', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            type: "GET",
            url: url,
            success: function(resp) {
                $('#statusId').val(resp.id);
                $('#meeting_status').val(resp.meeting_status);
                $('#status_note').val(resp.status_note);
            }
        });
    });


    $('#statusupdate').on('click',function (event) {
        event.preventDefault();

        var meeting_status = $('#meeting_status').val();
        var status_note = $('#status_note').val();
        var id = $('#statusId').val();

        var url = '{{ route("meeting.status.store",":id") }}';

        $.ajax({
        url: url.replace(':id', id),
        'type':'GET',
        'data':{
            status_note:status_note,
            meeting_status:meeting_status,
        },
        success:function(data)
        {
            if (data.success === true) {
                showSuccessToast(data.message);
                $('#data_table').DataTable().ajax.reload();
                $('#statusData').modal('hide');
                $('#status-data').trigger('clear');
                $('#status-data')[0].reset();
            }else{
                showDangerToast(data.message);
                $('#statusData').modal('show');
            }
        }
    });

    });


    $('#data_table').on('click', '#minuteId[href]', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            type: "GET",
            url: url,
            success: function(resp) {
                $('#meetingminuteId').val(resp.id);
            }
        });
    });

    $('#save').on('click',function (event) {
        event.preventDefault();

        var url = "{{ route('meeting-minutes.create') }}";

        var date = $('#meetingMinuteDate').val();
        var time = $('#minutetime').val();
        var meeting_id = $('#meetingminuteId').val();
        var note = $('#minute_note').val();

        $.ajax({
        url: url,
        'type':'get',
        'data':{
            date:date,
            time:time,
            meeting_id:meeting_id,
            note:note,
        },
        success:function(data)
        {
            if (data.success === true) {
                showSuccessToast(data.message);
                $('#data_table').DataTable().ajax.reload();
                $('#minuteData').modal('hide');
                $('#minute-data').trigger('clear');
                $('#minute-data')[0].reset();
            }else{
                showDangerToast(data.message);
                $('#minuteData').modal('show');
            }
        }
    });

    });

    $('#data_table').on('click', '#RescheduleId[href]', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            type: "GET",
            url: url,
            success: function(resp) {
                $('#meetingRescheduleId').val(resp.id);
            }
        });
    });

    $('#reschedulesave').on('click',function (event) {
        event.preventDefault();

        var url = "{{ route('meeting-reschedule.create') }}";

        var reschedule_date = $('#meetingRescheduleDate').val();
        var reschedule_time = $('#Rescheduletime').val();
        var reschedule_meeting_id = $('#meetingRescheduleId').val();
        var reschedule_note = $('#reschedule_note').val();

        $.ajax({
        url: url,
        type:'GET',
        data:{
            date:reschedule_date,
            time:reschedule_time,
            meeting_id:reschedule_meeting_id,
            note:reschedule_note,
        },
        success:function(data)
        {
            if (data.success === true) {
                showSuccessToast(data.message);
                $('#data_table').DataTable().ajax.reload();
                $('#RescheduleData').modal('hide');
                $('#reschedule-data').trigger('clear');
                $('#reschedule-data')[0].reset();
            }else{
                showDangerToast(data.message);
                $('#RescheduleData').modal('show');
            }
        }
    });

    });

    $('#data_table').on('click', '#quotationId[href]', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            type: "GET",
            url: url,
            success: function(resp) {
                $('#meetiongQuotationId').val(resp.id);
                $('#customer_id').val(resp.customer_id);
            }
        });
    });

    $('#quotationsave').on('click',function (event) {
        event.preventDefault();

        var url = "{{ route('quotation.store') }}";

        var type = $('#quotation_type_id').val();
        var customer_id = $('#customer_id').val();
        var date = $('#quotation_date').val();
        var quotation_no = $('#quotation_no').val();
        var meeting_id = $('#meetiongQuotationId').val();
        var amount = $('#amount').val();
        var note = $('#quotation_note').val();

        $.ajax({
        url: url,
        'type':'get',
        'data':{
            date:date,
            quotation_type_id:type,
            customer_id:customer_id,
            meeting_id:meeting_id,
            quotation_no:quotation_no,
            amount:amount,
            note:note,
        },
        success:function(data)
        {
            if (data.success === true) {
                showSuccessToast(data.message);
                $('#data_table').DataTable().ajax.reload();
                $('#quotationData').modal('hide');
                $('#quotation-data').trigger('clear');
                $('#quotation-data')[0].reset();
            }else{
                showDangerToast(data.message);
                $('#quotationData').modal('show');
            }
        }
    });

    });

        @if(Session::has('success'))
            showSuccessToast("{{ Session::get('success') }}");
        @elseif(Session::has('error'))
            showDangerToast("{{ Session::get('error') }}");
        @endif
</script>
@endpush
@endsection
