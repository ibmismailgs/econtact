@extends('layouts.main')
@section('title', 'Meeting Report')
@section('content')
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
@endpush
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fa fa-handshake bg-blue"></i>
                        <div class="d-inline pt-5">
                            <h5 class="pt-10" >Meeting Report</h5>
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
                                <a href="#">{{ __('Reports')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Meeting Report')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">

                    @php
                        $auth = Auth::user();
                        $user_role = $auth->roles->first();
                    @endphp

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="user_id"><b>Choose User</b></label>

                            @if ($auth && $auth->roles->count() > 0)
                                @if ($user_role->name == 'Super Admin')
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}"> {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            @if ($user_role->name == 'Supervisor')
                            <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">

                            <input type="text"  value="{{ Auth::user()->name }}"class="form-control @error('user_id') is-invalid @enderror" readonly>
                            @endif

                            @else
                            <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="text"  value="{{ Auth::user()->name }}"class="form-control @error('user_id') is-invalid @enderror" readonly>
                            @endif

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="customer_id">Choose Customer<span class="text-red">*</span></label>

                            @if ($auth && $auth->roles->count() > 0)

                                @if ($user_role->name == 'Super Admin')
                                    <select name="customer_id" id="customer_id" class="form-control select2 @error('customer_id') is-invalid @enderror" required>
                                        <option value="">Select Customer</option>
                                        @foreach ($clients as $key => $client)
                                            <option value="{{ $client->id }}" > {{ $client->name }} </option>
                                        @endforeach
                                    </select>
                                @endif

                                @if ($user_role->name == 'Supervisor')
                                <select name="customer_id" id="customer_id" class="form-control select2 @error('customer_id') is-invalid @enderror" required>
                                    <option value="">Select Customer</option>
                                        @foreach ($clients as $key => $client)
                                            @if ($client->created_by == Auth::user()->id)
                                                <option value="{{ $client->id }}" > {{ $client->name }} </option>
                                            @endif
                                        @endforeach
                                </select>
                            @endif

                            @else

                            <select name="customer_id" id="customer_id" class="form-control select2 @error('customer_id') is-invalid @enderror" required>
                                <option value="">Select Customer</option>
                                    @foreach ($clients as $key => $client)
                                        @if ($client->created_by == Auth::user()->id)
                                            <option value="{{ $client->id }}" > {{ $client->name }} </option>
                                        @endif
                                    @endforeach
                            </select>
                            @endif

                            @error('customer_id')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="meeting_type_id">Meeting Type</label>

                            <select name="meeting_type_id" id="meeting_type_id" class="form-control select2">
                                <option value="">Select Type</option>
                                @foreach ($meetingTypes as $key => $meetingType)
                                    <option value="{{ $meetingType->id }}" > {{ $meetingType->title }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="meeting_status">Meeting Status</label>
                            <select name="meeting_status" id="meeting_status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="1">Success</option>
                                <option value="2">Pending</option>
                                <option value="3">Failled</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="start_date"><b>Start Date</b></label>
                            <input type="date" name="start_date" id="start_date" class="form-control"  placeholder="Enter start date">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="end_date"><b>End Date</b></label>
                            <input type="date" name="end_date" id="end_date" class="form-control" placeholder="Enter end date">
                        </div>
                    </div>
                </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-sm" type="submit" id="search" name="search"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
            </div>
        </div>

         <div class="card">
            <div class="card-body">
                <div class="row">
                    <table style="width:100%; display:none" id="meetingData">
                    <tr>
                        <td>Total Meeting: <b id="meeting"></b></td>
                        <td>New-Meeting: <b id="newmeeting"></b></td>
                        <td>Re-Schedule-Meeting: <b id="oldmeeting"></b></td>
                        <td>Total Success: <b id="success"></b></td>
                        <td>Total Failled: <b id="failled"></b></td>
                        <td>Total Pending: <b id="pending"></b></td>
                      </tr>
                    </table>
                </div>
            </div>
        </div>

        <div style="display: none" class="row data-show">
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-body">
                        <table id="data_table" class="table table-bordered table-striped data-table table-hover">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    {{-- <th>User</th> --}}
                                    <th>Customer</th>
                                    <th>Company</th>
                                    <th>Date | Time</th>
                                    <th>Meeting Type</th>
                                    <th>Status</th>
                                    <th>Status Note</th>
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

@push('script')
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert/dist/sweetalert.min.js') }}"></script>

<script>

    $('#search').on('click',function(event){
			event.preventDefault();
            $('.data-show').show();
            var customer_id = $("#customer_id").val();
            var meeting_type_id = $("#meeting_type_id").val();
            var meeting_status = $("#meeting_status").val();
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var user_id = $("#user_id").val();

            if(user_id == '' && customer_id == '' && meeting_type_id == '' && meeting_status == '' && start_date == '' && end_date == ''){
                swal({
                title: 'Error!!!',
                text: "Enter Any Value",
                dangerMode: true,
                });

                $("#customer_id").val('');
                $("#meeting_type_id").val('');
                $("#meeting_status").val('');
                $("#start_date").val('');
                $("#end_date").val('');
                $('.data-show').hide();
               return false;
            }else if(start_date != '' && end_date == ''){
                swal({
                    title: 'Error!!!',
                    text: "Enter End Date",
                    dangerMode: true,
                });
                $("#start_date").val('');
                return ;
            }

			var table =  $('#data_table').DataTable({
				order: [],
				lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
				processing: true,
				serverSide: true,
				"bDestroy": true,
				ajax: {
					url: "{{ route('meeting-report') }}",
					type: "GET",
					data:{
						'customer_id':customer_id,
						'meeting_type_id':meeting_type_id,
						'meeting_status':meeting_status,
						'start_date':start_date,
						'end_date':end_date,
						'user_id':user_id,
					},
				},
				columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                // {data: 'user', name: 'user'},
				{data: 'client', name: 'client'},
				{data: 'company', name: 'company'},
				{data: 'dateTime', name: 'dateTime'},
				{data: 'type', name: 'type'},
                {data: 'status', name: 'status'},
				{data: 'note', name: 'note'},
				{data: 'action', name: 'action'},
             ],
             initComplete: function(data) {
                    $('#meetingData').show();
                    var totalMeeting = data.json.totalMeeting;
                    var totalSuccess = data.json.totalSuccess;
                    var totalPending = data.json.totalPending;
                    var totalFail = data.json.totalFail;
                    var newMeeting = data.json.newMeeting;
                    var oldMeeting = data.json.oldMeeting;

                    document.getElementById('meeting').innerHTML = totalMeeting;
                    document.getElementById('success').innerHTML = totalSuccess;
                    document.getElementById('pending').innerHTML = totalPending;
                    document.getElementById('failled').innerHTML = totalFail;
                    document.getElementById('failled').innerHTML = totalFail;
                    document.getElementById('newmeeting').innerHTML = newMeeting;
                    document.getElementById('oldmeeting').innerHTML = oldMeeting;
                },
             dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                            {
                                extend: 'colvis',
                                className: 'btn-sm btn-warning',
                                title: 'Meeting Report',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ':visible',
                                }
                            },
                            {
                                extend: 'copy',
                                className: 'btn-sm btn-info',
                                title: 'Meeting Report',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ':visible',
                                }
                            },
                            {
                                extend: 'csv',
                                className: 'btn-sm btn-success',
                                title: 'Meeting Report',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ':visible',
                                }
                            },
                            {
                                extend: 'excel',
                                className: 'btn-sm btn-dark',
                                title: 'Meeting Report',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ':visible',
                                }
                            },
                            {
                                extend: 'pdf',
                                className: 'btn-sm btn-primary',
                                title: 'Meeting Report',
                                pageSize: 'A2',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ':visible',
                                }
                            },
                            {
                                extend: 'print',
                                className: 'btn-sm btn-danger',
                                title: 'Meeting Report',
                                pageSize: 'A2',
                                header: true,
                                footer: true,
                                orientation: 'landscape',
                                exportOptions: {
                                    columns: ':visible',
                                    stripHtml: false
                                }
                            },

                        ],
			});
		});

$("#user_id").on('change', function(){
    var user_id = $('#user_id').val();

    $.ajax({
        url: "{{ route('user-wise-client') }}",
        type: "GET",
        data: {
            user_id:user_id,
        },
        success: function(resp){

            $('#customer_id').empty();
            $('#customer_id').append("<option value=''>--Select Client--</option>");
            $.each(resp.users, function(key, user){
                $('#customer_id').append("<option value="+user.id+">"+user.name+"</option>");
            });

        },
    });
});

</script>
@endpush
@endsection
