@extends('layouts.main')
@section('title', 'Thana List')
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
                        <i class="fa fa-map-marker bg-blue"></i>
                        <div class="d-inline pt-5">
                            <h5 class="pt-10" >Thana List</h5>
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
                                <a href="#">{{ __('Thana')}}</a>
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
                        <h3 class="d-block w-100">{{ __('Thana')}}
                            @can('thana_create')
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
                                    <th>Division</th>
                                    <th>District</th>
                                    <th>Thana</th>
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
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Create Thana')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="add-data" class="forms-sample add-data" enctype="multipart/form-data" action="#" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="division_id" class="col-sm-2 col-form-label">Division<span class="text-red">*</span></label>

                            <div class="col-sm-10">

                                <select id="division_id" class="form-control select2 @error('division_id') is-invalid @enderror" >
                                    <option value="">Select Division</option>
                                    @foreach ($divisions as $key => $division)
                                        <option value="{{ $division->id }}" > {{ $division->name }} </option>
                                    @endforeach
                                </select>

                                @error('division_id')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="district_id" class="col-sm-2 col-form-label">District<span class="text-red">*</span></label>

                            <div class="col-sm-10">

                                <select id="district_id" class="form-control select2 @error('district_id') is-invalid @enderror" >
                                    <option value="">Select District</option>
                                </select>

                                @error('district_id')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Thana Name<span class="text-red">*</span></label>

                            <div class="col-sm-10">
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter thana name" required>

                                @error('name')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

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
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Edit Division')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="edit-data" action="#">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="division_id" class="col-sm-2 col-form-label">Division<span class="text-red">*</span></label>

                            <div class="col-sm-10">

                                <select id="divisionIdEdit"  class="form-control @error('division_id') is-invalid @enderror" >
                                    <option value="">Select Division</option>
                                    @foreach ($divisions as $key => $division)
                                        <option value="{{ $division->id }}" > {{ $division->name }} </option>
                                    @endforeach
                                </select>

                                @error('division_id')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="district_id" class="col-sm-2 col-form-label">District<span class="text-red">*</span></label>

                            <div class="col-sm-10">

                                <select id="districtIdEdit"  class="form-control @error('district_id') is-invalid @enderror" >
                                    <option value="">Select District</option>
                                    @foreach ($districts as $key => $district)
                                        <option value="{{ $district->id }}" > {{ $district->name }} </option>
                                    @endforeach
                                </select>

                                @error('district_id')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Thana Name<span class="text-red">*</span></label>

                            <div class="col-sm-10">
                                <input type="text" name="name" id="editName" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter thana name" required>

                                <input type="hidden" id="editId">

                                @error('name')
                                <span class="text-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </span>
                                @enderror

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

        var url = "{{ route('thana.store') }}";
        var name = $('#name').val();
        var division_id = $('#division_id').val();
        var district_id = $('#district_id').val();

        $.ajax({
            url: url,
            type: "get",
            data: {
                name : name,
                division_id : division_id,
                district_id : district_id,
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
            $('#editName').val(resp.thanaName);
            $('#divisionIdEdit').val(resp.divisionId);
            $('#districtIdEdit').val(resp.districtId);
            $('#editId').val(resp.ThanaId);
        }
    });
});

$('#update').on('click',function (event) {
        event.preventDefault();
        var id = $('#editId').val();
        var name = $('#editName').val();
        var district_id = $('#districtIdEdit').val();

        var url = '{{ route("thana.update",":id") }}';

        $.ajax({
        url: url.replace(':id', id),
        'type':'GET',
        'data':{
            name:name,
            district_id:district_id,
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
            url: "{{route('thana.index')}}",
            type: "get"
        },

        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true},
            {data: 'divisionName', name: 'divisionName' , searchable: true},
            {data: 'districtName', name: 'districtName' , searchable: true},
            {data: 'thanaName', name: 'thanaName' , searchable: true},
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
            'url':"{{ route('thana.status') }}",
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

    $("#divisionIdEdit").on('change', function(){
            var division_id = $('#divisionIdEdit').val();

            $.ajax({
                url: "{{ route('division-wise-district') }}",
                type: "GET",
                data: {
                    division_id:division_id,
                },
                success: function(resp){

                    $('#districtIdEdit').empty();
                    $('#districtIdEdit').append("<option value=''>--Select District--</option>");
                    $.each(resp.districts, function(key, district){
                        $('#districtIdEdit').append("<option value="+district.id+">"+district.name+"</option>");
                    });

                },
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
