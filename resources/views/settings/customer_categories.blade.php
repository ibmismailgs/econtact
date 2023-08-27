@extends('layouts.main')
@section('title', 'Customer Categories')
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
                        <i class="fa fa-users bg-blue"></i>
                        <div class="d-inline pt-5">
                            <h5 class="pt-10" >Customer Categories</h5>
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
                                <a href="#">{{ __('Settings')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Customer Categories')}}</a>
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
                        <h3 class="d-block w-100">{{ __('Customer Categories')}}
                            @can('customer_categories_create')
                            <small class="float-right">
                                <a title="Create" href="#" type="button" class="badge badge-primary" data-toggle="modal" data-target="#addData">
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
                                    <th>Title</th>
                                    <th>Category Name</th>
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

    {{-- add modal --}}
    <div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Create Customer Categories')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="add-data" class="forms-sample add-data" enctype="multipart/form-data" action="#" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">Title<span class="text-red">*</span></label>

                            <div class="col-sm-10">
                                <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title" required>

                                @error('title')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category_id" class="col-sm-2 col-form-label"> Category</label>
                            <div class="col-sm-10">
                                <select id="category_id" class="form-control" >
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $key => $item)
                                        <option value="{{ $item->id }}" > {{ $item->title }} </option>
                                    @endforeach
                                </select>
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

{{-- edit modal --}}
 <div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Edit Customer Categories')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="edit-data" action="#">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">Title<span class="text-red">*</span></label>

                            <div class="col-sm-10">
                                <input type="text" name="title" id="editTitle" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title" required>

                                <input type="hidden" id="editId">
                                @error('title')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category_id" class="col-sm-2 col-form-label"> Category</label>
                            <div class="col-sm-10">
                                <select id="parentIdEdit" class="form-control" >
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $key => $item)
                                        <option value="{{ $item->id }}" > {{ $item->title }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close')}}</button>
                    <button type="button" id="update" class="btn btn-primary">{{ __('Update')}}</button>
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
    $(document).ready(function($){
     $('#save').on('click',function (event) {
        event.preventDefault();

        var url = "{{ route('customer-categories.store') }}";
        var title = $('#title').val();
        var category_id = $('#category_id').val();

        $.ajax({
            url: url,
            type: "get",
            data: {
                title : title,
                category_id : category_id,
            },
            success: function(data) {
                if (data.success === true) {
                    showSuccessToast(data.message);
                    $('#data_table').DataTable().ajax.reload();
                    $('#add-data').trigger('clear');
                    $('#add-data')[0].reset();
                }else{
                    showDangerToast(data.message);
                    $('#addData').modal('show');
                }
            },

        });
        $.noConflict();
        $('#addData').modal('hide');
    });
});

//edit menu
$('#data_table').on('click', '#edit[href]', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    $.ajax({
        type: "GET",
        url: url,
        success: function(resp) {
            $('#editTitle').val(resp.title);
            $('#parentIdEdit').val(resp.category_id);
            $('#editId').val(resp.id);
        }
    });
});

$('#update').on('click',function (event) {
        event.preventDefault();
        var id = $('#editId').val();
        var title = $('#editTitle').val();
        var category_id = $('#parentIdEdit').val();

        var url = '{{ route("customer-categories.update",":id") }}';

        $.ajax({
        url: url.replace(':id', id),
        'type':'GET',
        'data':{
            title:title,
            category_id:category_id,
        },
        success:function(data)
        {
            if (data.success === true) {
                showSuccessToast(data.message);
                $('#data_table').DataTable().ajax.reload();
                $('#editData').modal('hide');
            }else{
                showDangerToast(data.message);
                $('#editData').modal('show');
            }
        }
    });

    });

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
            url: "{{route('customer-categories.index')}}",
            type: "get"
        },

        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true},
            {data: 'title', name: 'title' , searchable: true},
            {data: 'categories', name: 'categories' , searchable: true},
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
            'url':"{{ route('customer-categories.status') }}",
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

        @if(Session::has('success'))
            showSuccessToast("{{ Session::get('success') }}");
        @elseif(Session::has('error'))
            showDangerToast("{{ Session::get('error') }}");
        @endif
    </script>
    @endpush
    @endsection
