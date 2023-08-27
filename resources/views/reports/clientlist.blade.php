@extends('layouts.main')
@section('title', 'Customer Management Report')
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
                        <i class="fa fa-users bg-blue"></i>
                        <div class="d-inline pt-5">
                            <h5 class="pt-10" >Customer Management Report</h5>
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
                                <a href="#">{{ __('Customer Management Report')}}</a>
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
                            <label for="status"><b>Choose Customer</b></label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Select</option>
                                <option value="1"> Active</option>
                                <option value="0"> Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="division_id">Division</label>
                            <select name="division_id" id="division_id" class="form-control select2">
                                <option value="">Select Division</option>
                                @foreach ($divisions as $key => $division)
                                    <option value="{{ $division->id }}" > {{ $division->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="district_id">District</label>
                            <select name="district_id" id="district_id" class="form-control select2">
                                <option value="">Select District</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="thana_id">Thana</label>
                            <select name="thana_id" id="thana_id" class="form-control select2">
                                <option value="">Select Thana</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="client_source_id">Customer Source</label>
                            <select name="client_source_id" id="client_source_id" class="form-control select2">
                                <option value="">Select Source</option>
                                @foreach ($clientSources as $key => $clientSource)
                                    <option value="{{ $clientSource->id }}" > {{ $clientSource->title }} </option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="customer_category_id">Customer Category</label>

                            <select name="customer_category_id" id="customer_category_id" class="form-control select2">
                                <option value="">Select Category</option>
                                @foreach ($categories as $key => $category)
                                    <option value="{{ $category->id }}" > {{ $category->title }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4 group-sms">
                        <div class="form-group">
                            <label for="customer_subcategory_id">Customer Sub-Category</label>
                            <select name="customer_subcategory_id" id="customer_subcategory_id" class="form-control select2">
                                <option value="">Select Sub-Category</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="customer_type_id">Customer Status</label>

                            <select name="customer_type_id" id="customer_type_id" class="form-control select2">
                                <option value="">Select Status</option>
                                @foreach ($clientTypes as $key => $clientType)
                                    <option value="{{ $clientType->id }}" > {{ $clientType->title }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="outlet_id">Outlet</label>

                            <select name="outlet_id" id="outlet_id" class="form-control select2" >
                                <option value="">Select Outlet</option>
                                @foreach ($outlets as $key => $outlet)
                                    <option value="{{ $outlet->id }}" > {{ $outlet->title }} </option>
                                @endforeach
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
                    <table style="width:100%; display:none" id="data">
                    <tr>
                        <td>Total Customer: <b id="totalCustomer"></b></td>
                        <td>New Customer: <b id="newCustomer"></b></td>
                        <td>Follow-up Customer: <b id="oldCustomer"></b></td>
                      </tr>
                    </table>
                </div>
            </div>
        </div>

        <div style="display: none" class="row data-show">
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-body">
                        <small class="float-right">
                            <a style="font-size: 7px; font-weight:bold" title="Create" href="{{ route('customer-export') }}" type="button" class="badge badge-primary">
                                <i class="fa fa-download mr-1"></i>
                                Download
                            </a>
                        </small>
                        <table id="data_table" class="table table-bordered table-striped data-table table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Date</th>
                                    {{-- <th>User</th> --}}
                                    <th>Customer</th>
                                    <th>Company</th>
                                    <th>Status</th>
                                    <th>Category</th>
                                    <th>Outlet</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Note</th>
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
<script src="{{ asset('js/alerts.js')}}"></script>
<script src="{{ asset('plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
<script>
    $('#search').on('click',function(event){
			event.preventDefault();
            $('.data-show').show();
            var status = $("#status").val();
            var division_id = $("#division_id").val();
            var district_id = $("#district_id").val();
            var thana_id = $("#thana_id").val();
            var client_source_id = $("#client_source_id").val();
            var customer_category_id = $("#customer_category_id").val();
            var customer_subcategory_id = $("#customer_subcategory_id").val();
            var customer_type_id = $("#customer_type_id").val();
            var outlet_id = $("#outlet_id").val();
            var user_id = $("#user_id").val();
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();

            if(user_id == '' && status == '' && division_id == '' && district_id == '' && thana_id == '' && client_source_id == '' && customer_category_id == '' && customer_type_id == '' && outlet_id == '' && start_date == '' && end_date == ''){
                swal({
                title: 'Error!!!',
                text: "Enter Any Value",
                dangerMode: true,
                });

                $("#status").val('');
                $("#division_id").val('');
                $("#district_id").val('');
                $("#thana_id").val('');
                $("#client_source_id").val('');
                $("#customer_category_id").val('');
                $("#customer_type_id").val('');
                $("#outlet_id").val('');
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
                responsive: true,
				bDestroy: true,
                autoWidth: true,
				ajax: {
					url: "{{route('client-report')}}",
					type: "GET",
					data:{
						'status':status,
						'division_id':division_id,
						'district_id':district_id,
						'thana_id':thana_id,
						'client_source_id':client_source_id,
						'customer_category_id':customer_category_id,
						'customer_subcategory_id':customer_subcategory_id,
						'customer_type_id':customer_type_id,
						'outlet_id':outlet_id,
						'user_id':user_id,
						'start_date':start_date,
						'end_date':end_date,
					},
				},
				columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'date', name: 'date'},
				// {data: 'user', name: 'user'},
				{data: 'name', name: 'name'},
				{data: 'company', name: 'company'},
				{data: 'clientStatus', name: 'clientStatus'},
				{data: 'customerCategories', name: 'customerCategories'},
				{data: 'outlet', name: 'outlet'},
				{data: 'primary_phone', name: 'primary_phone'},
				{data: 'email', name: 'email'},
				{data: 'note', name: 'note'},
				{data: 'action', name: 'action'},
             ],
             initComplete: function(data) {
                    $('#data').show()
                    var total = data.json.total;
                    var oldCustomer = data.json.oldCustomer;
                    var newCustomer = data.json.newCustomer;
                    document.getElementById('totalCustomer').innerHTML = total;
                    document.getElementById('newCustomer').innerHTML = newCustomer;
                    document.getElementById('oldCustomer').innerHTML = oldCustomer;
                },
             dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                            {
                                extend: 'colvis',
                                className: 'btn-sm btn-warning',
                                title: 'Customer Management Report',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ':visible',
                                }
                            },
                            {
                                extend: 'copy',
                                className: 'btn-sm btn-info',
                                title: 'Customer Management Report',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ':visible',
                                }
                            },
                            {
                                extend: 'csv',
                                className: 'btn-sm btn-success',
                                title: 'Customer Management Report',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ':visible',
                                }
                            },
                            {
                                extend: 'excel',
                                className: 'btn-sm btn-dark',
                                title: 'Customer Management Report',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ':visible',
                                }
                            },
                            {
                                extend: 'pdf',
                                className: 'btn-sm btn-primary',
                                title: 'Customer Management Report',
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
                                title: 'Customer Management Report',
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
