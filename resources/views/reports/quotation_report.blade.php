@extends('layouts.main')
@section('title', 'Quotation Report')
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
                            <h5 class="pt-10" >Quotation Report</h5>
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
                                <a href="#">{{ __('Quotation Report')}}</a>
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
                            <label for="quotation_type_id">Quotation Type<span class="text-red">*</span></label>

                            <select name="quotation_type_id" id="quotation_type_id" class="form-control @error('quotation_type_id') is-invalid @enderror">
                                <option value="">Select Type</option>
                                @foreach ($quotationTypes as $key => $item)
                                    <option value="{{ $item->id }}" > {{ $item->title }} </option>
                                @endforeach
                            </select>

                            @error('quotation_type_id')
                            <span class="text-danger" role="alert">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror

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
                    <table style="width:100%; display:none" id="qutationData">
                    <tr>
                        <td>Total Quotation: <b id="quotation"></b></td>
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
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Company</th>
                                    <th>Quotation Type</th>
                                    <th>Quotation No</th>
                                    <th>Quotation Amount</th>
                                    <th>Meeting Status</th>
                                    <th>Note</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            <tfoot>
                                <tr id="total_tr">
                                    <td class="tg-0lax" colspan="5"></td>
                                    <td class="tg-0lax" style="background: #f2f2f2">Total</td>
                                    <td class="tg-0lax" style="background: #f2f2f2"><b id="totalAmount"> </b></td>
                                    <td class="tg-0lax"></td>
                                    <td class="tg-0lax"></td>
                                    <td class="tg-0lax"></td>
                                </tr>
                            </tfoot>

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
            var quotation_type_id = $("#quotation_type_id").val();
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var user_id = $("#user_id").val();

            if(user_id =='' && customer_id == '' && quotation_type_id == '' && start_date == '' && end_date == ''){
                swal({
                title: 'Error!!!',
                text: "Enter Any Value",
                dangerMode: true,
                });

                $("#customer_id").val('');
                $("#quotation_type_id").val('');
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
					url: "{{ route('quotation-report') }}",
					type: "GET",
					data:{
						'customer_id':customer_id,
						'quotation_type_id':quotation_type_id,
						'start_date':start_date,
						'end_date':end_date,
						'user_id':user_id,
					},
				},
				columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'date', name: 'date'},
                {data: 'client', name: 'client'},
                {data: 'company', name: 'company'},
                {data: 'type', name: 'type'},
				{data: 'quotation_no', name: 'quotation_no'},
				{data: 'amount', name: 'amount'},
				{data: 'status', name: 'status'},
				{data: 'note', name: 'note'},
				{data: 'action', name: 'action'},
             ],
             initComplete: function(data) {
                    $('#total_tr').show();
                    $('#qutationData').show();

                    var totalAmount = data.json.totalAmount;
                    var totalQuotation = data.json.totalQuotation;
                    var totalSuccess = data.json.totalSuccess;
                    var totalPending = data.json.totalPending;
                    var totalFail = data.json.totalFail;

                    document.getElementById('totalAmount').innerHTML = totalAmount;
                    document.getElementById('quotation').innerHTML = totalQuotation;
                    document.getElementById('success').innerHTML = totalSuccess;
                    document.getElementById('pending').innerHTML = totalPending;
                    document.getElementById('failled').innerHTML = totalFail;
                },
             dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                            {
                                extend: 'colvis',
                                className: 'btn-sm btn-warning',
                                title: 'Quotation Report',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ':visible',
                                }
                            },
                            {
                                extend: 'copy',
                                className: 'btn-sm btn-info',
                                title: 'Quotation Report',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ':visible',
                                }
                            },
                            {
                                extend: 'csv',
                                className: 'btn-sm btn-success',
                                title: 'Quotation Report',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ':visible',
                                }
                            },
                            {
                                extend: 'excel',
                                className: 'btn-sm btn-dark',
                                title: 'Quotation Report',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ':visible',
                                }
                            },
                            {
                                extend: 'pdf',
                                className: 'btn-sm btn-primary',
                                title: 'Quotation Report',
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
                                title: 'Quotation Report',
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
