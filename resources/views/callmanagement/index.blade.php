@extends('layouts.main')
@section('title', 'Call-Management List')
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
                        <i class="fa fa-phone bg-blue"></i>
                        <div class="d-inline pt-5">
                            <h5 class="pt-10" >Call-Management List</h5>
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
                            @can('call_create')
                                <small class="float-right">
                                    <a title="Create" href="{{ route('call-management.create') }}" type="button" class="badge badge-primary">
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
                                    <th>Date|Time</th>
                                    <th>Customer</th>
                                    <th>Phone</th>
                                    <th>Company</th>
                                    <th>Call Type</th>
                                    <th>Follow-up Date</th>
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
            url: "{{route('call-management.index')}}",
            type: "get"
        },

        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true},
            {data: 'dateTime', name: 'dateTime' , searchable: true},
            {data: 'name', name: 'name' , searchable: true},
            {data: 'primary_phone', name: 'primary_phone' , searchable: true},
            {data: 'company', name: 'company' , searchable: true},
            {data: 'callType', name: 'callType' , searchable: true},
            {data: 'followUpDate', name: 'followUpDate' , searchable: true},
            {data: 'note', name: 'note' , searchable: true},
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

        @if(Session::has('success'))
            showSuccessToast("{{ Session::get('success') }}");
        @elseif(Session::has('error'))
            showDangerToast("{{ Session::get('error') }}");
        @endif
    </script>
    @endpush
    @endsection
