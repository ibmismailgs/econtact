@extends('layouts.main')
@section('title', 'Quotation List')
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
                        <i class="fa fa-quote-left bg-blue"></i>
                        <div class="d-inline pt-5">
                            <h5 class="pt-10" >Quotation List</h5>
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
                        @can('quotation_create')
                            <small class="float-right">
                                <a title="Create" href="{{ route('quotations.create') }}" type="button" class="badge badge-primary">
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
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Quotation No</th>
                                    <th>Status</th>
                                    <th>Amount</th>
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

    <div class="modal fade" id="statusData" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Quotation Status')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="status-data" action="#">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="status" class="col-sm-2 col-form-label">Quotation Status<span class="text-red">*</span></label>

                            <div class="col-sm-10">
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="">Select Status</option>
                                    <option value="1">Success</option>
                                    <option value="2">Pending</option>
                                    <option value="3">Failled</option>
                                </select>

                                <input type="hidden" id="statusId">

                                @error('status')
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
            url: "{{route('quotations.index')}}",
            type: "get"
        },

        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true},
            {data: 'date', name: 'date' , searchable: true},
            {data: 'name', name: 'name' , searchable: true},
            {data: 'quotation_no', name: 'quotation_no' , searchable: true},
            {data: 'status', name: 'status' , searchable: true},
            {data: 'amount', name: 'amount' , searchable: true},
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

    $('#data_table').on('click', '#quotationId[href]', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            type: "GET",
            url: url,
            success: function(resp) {
                $('#statusId').val(resp.id);
                $('#status').val(resp.status);
                $('#status_note').val(resp.status_note);
            }
        });
    });


    $('#statusupdate').on('click',function (event) {
        event.preventDefault();

        var status = $('#status').val();
        var status_note = $('#status_note').val();
        var id = $('#statusId').val();

        var url = '{{ route("quotation.status.store",":id") }}';

        $.ajax({
        url: url.replace(':id', id),
        'type':'GET',
        'data':{
            status_note:status_note,
            status:status,
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

@if(Session::has('success'))
    showSuccessToast("{{ Session::get('success') }}");
@elseif(Session::has('error'))
    showDangerToast("{{ Session::get('error') }}");
@endif
</script>
@endpush
@endsection
