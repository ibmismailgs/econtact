@extends('layouts.main')
@section('title', 'Customer Management')
@section('content')
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/toggle.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/jquery-toast-plugin/dist/jquery.toast.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
@endpush
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fa fa-users bg-blue"></i>
                        <div class="d-inline pt-5">
                            <h5 class="pt-10" >Customer Management</h5>
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
                                <a href="#">{{ __('Customers')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Customer')}}</a>
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
                        <h3 class="d-block w-100">{{ __('Customer')}}
                            @can('customer_create')
                            <small class="float-right">
                                <a title="Create" href="{{ route('client.create') }}" type="button" class="badge badge-primary">
                                    <i class="fas fa-plus mr-1"></i>
                                    Create
                                </a>
                            </small>
                            @endcan
                        </h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-12 col-sm-12 col-md-4 mb-2">
                                    <a title="Download" href="{{ route('excel-download') }}" type="button" class="btn btn-sm btn-primary">
                                        Sample Excel Download
                                    </a>
                                </div>

                                @can('customer_import')
                                <div class="form-group col-12 col-sm-12 col-md-4 mb-2">
                                    <form action="{{ route('excel-import') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex">
                                            <input type="file" name="import_file" class="form-control" required>&nbsp;&nbsp;&nbsp;
                                            <input type="submit" class="btn-sm btn btn-success" value="Import">
                                        </div>
                                    </form>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="data_table" class="table table-bordered table-striped data-table table-hover">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Company</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Assign To</th>
                                    <th>Status</th>
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
     <div class="modal fade" id="assignData" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Client Assign')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="status-data" action="#">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="assign_to" class="col-sm-2 col-form-label">Customer Name<span class="text-red">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="clientName" class="form-control" readonly>
                                <input type="hidden" id="clientId" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="assign_to" class="col-sm-2 col-form-label">Employee<span class="text-red">*</span></label>

                            <div class="col-sm-10">
                                <select name="assign_to" id="assign_to" class="form-control select2 @error('assign_to') is-invalid @enderror">
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close')}}</button>
                    <button type="button" id="save" class="btn btn-primary">{{ __('Submit')}}</button>
                </div>
            </div>
        </div>
    </div>

@push('script')
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-toast-plugin/dist/jquery.toast.min.js')}}"></script>
<script src="{{ asset('js/alerts.js')}}"></script>
<script src="{{ asset('plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
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
            url: "{{route('client.index')}}",
            type: "get"
        },

        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true},
            {data: 'name', name: 'name' , searchable: true},
            {data: 'designation', name: 'designation' , searchable: true},
            {data: 'company', name: 'company' , searchable: true},
            {data: 'primary_phone', name: 'primary_phone' , searchable: true},
            {data: 'email', name: 'email' , searchable: true},
            {data: 'assign', name: 'assign', searchable: false},
            {data: 'status', name: 'status', searchable: false},
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

    $('.card-body').on('click', '.changeStatus', function (e) {
    e.preventDefault();
    var id = $(this).attr('getId');
        swal({
            title: `Are you sure?`,
            text: `Want to change this status?`,
            buttons: true,
            dangerMode: true,
        }).then((changeStatus) => {
    if (changeStatus) {
        $.ajax({
            'url':"{{ route('client.status') }}",
            'type':'get',
            'dataType':'json',
            'data':{id:id},
            success:function(data)
            {
                $('#data_table').DataTable().ajax.reload();
                if (data.success === true) {
                    showSuccessToast(data.message);
                }else{
                    showDangerToast(data.message);
                }
            }
        });
    }
    });
    })


    $('#data_table').on('click', '#assignId[href]', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            type: "GET",
            url: url,
            success: function(resp) {
                $('#clientId').val(resp.id);
                $('#clientName').val(resp.name);
            }
        });
    });


    $('#save').on('click',function (event) {
        event.preventDefault();

        var assign_to = $('#assign_to').val();
        var id = $('#clientId').val();

        var url = '{{ route("client.assign.create",":id") }}';

        $.ajax({
        url: url.replace(':id', id),
        'type':'GET',
        'data':{
            assign_to:assign_to,
        },
        success:function(data)
        {
            if (data.success === true) {
                showSuccessToast(data.message);
                $('#data_table').DataTable().ajax.reload();
                $('#assignData').modal('hide');
            }else{
                showDangerToast(data.message);
                $('#assignData').modal('show');
            }
        }
    });

    });


        @if(Session::has('success'))
            showSuccessToast("{{ Session::get('success') }}");
        @elseif(Session::has('error'))
            showDangerToast("{{ Session::get('error') }}");
        @endif

        $('#client_id').select2();
        $('#employee_id').select2();
    </script>
    @endpush
    @endsection
