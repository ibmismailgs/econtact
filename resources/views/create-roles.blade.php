@extends('layouts.main')
@section('title', 'Roles')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
        <style>
            .group-name{
                text-transform: capitalize;
            }
        </style>
    @endpush


    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-award bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Roles')}}</h5>
                            <span>{{ __('Define roles of user')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="../index.html"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Roles')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row clearfix">
	        <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <!-- only those have manage_role permission will get access -->
            @can('manage_role')
			<div class="col-md-12">
	            <div class="card">
	                <div class="card-header"><h3>{{ __('Add Role')}}</h3></div>
	                <div class="card-body">
	                    <form class="forms-sample" method="POST" action="{{ route('role-store') }}" >
	                    	@csrf
	                        <div class="row">
	                            <div class="col-sm-12">
	                                <div class="form-group">
	                                    <label for="role">{{ __('Role')}}<span class="text-red">*</span></label>
	                                    <input type="text" class="form-control is-valid" id="role" name="role" placeholder="Role Name" required>
	                                </div>
	                            </div>
	                            <div class="col-sm-12 mt-4">
                                    <div>
                                        <h6 for="exampleInputEmail3"><strong>{{ __('Assign Permission')}}</strong></h6>
                                        <div class="col-sm-4">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="all_permission_checkbox" value="">
                                                <span class="custom-control-label">All Permissions</span>
                                            </label>
                                        </div>
                                    </div><hr>
                                    @foreach ($permissionGroups as $permissionGroup)
                                        <div class="row mt-4">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label class="custom-control custom-checkbox group-name">
                                                        <input type="checkbox" class="custom-control-input" id="group_checkbox-{{$permissionGroup->group_name}}" value="{{$permissionGroup->group_name}}" onclick="groupWisePermissionSelect(this, 'permissions-{{ $permissionGroup->group_name }}')">
                                                        <span class="custom-control-label">
                                                            {{ $permissionGroup->group_name }} (Select All)
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php $permissions= App\Http\Controllers\RolesController::getPermissionByGroupName($permissionGroup->group_name); ?>
                                            @foreach($permissions as $key => $permission)
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input permissions-{{ $permissionGroup->group_name }}" id="item_checkbox" name="permissions[]" value="{{$permission->name}}">
                                                            <span class="custom-control-label">
                                                                <!-- clean unescaped data is to avoid potential XSS risk -->
                                                                {{-- {{ clean($permission,'titles')}} --}}
                                                                {{ $permission->name }}
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach

	                                <div class="form-group">
	                                	<button type="submit" class="btn btn-primary btn-rounded">{{ __('Save')}}</button>
	                                </div>
	                            </div>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
            @endcan
		</div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <!--server side roles table script-->
    <script src="{{ asset('js/custom.js') }}"></script>
	@endpush

    <script>
        $('#all_permission_checkbox').on('click', function(){
            if($(this).is(':checked')){
                $('input[type=checkbox]').prop('checked', true);
            }else{
                $('input[type=checkbox]').prop('checked', false);
            }
        });

        function groupWisePermissionSelect(groupId, permissionClass){
            const permissionGroupId=$('#'+groupId.id);
            const permissionsClass= $('.'+permissionClass);

            if(permissionGroupId.is(':checked')){
                permissionsClass.prop('checked', true);
            }else{
                permissionsClass.prop('checked', false);
            }
        }

        // $('#group_checkbox').on('click', function(){
        //     if($(this).is(':checked')){
        //         $('input[type=checkbox]').prop('checked', true);
        //     }else{
        //         $('input[type=checkbox]').prop('checked', false);
        //     }
        // });
    </script>
@endsection
