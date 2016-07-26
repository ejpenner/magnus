@extends('layouts.app')

@section('content')
    <div class="container col-lg-3 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Update Role Model
            </div>
            <div class="panel-body">
                {!! Form::model($role, ['method'=>'patch', 'action'=>['RoleController@update', $role->id]]) !!}
                @include('role._roleForm')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="container col-md-6">
        {!! Form::model($role->permission, ['method'=>'patch', 'action'=>['PermissionController@update', $role->permission->id]]) !!}
        <div class="panel panel-default">
            <div class="panel-heading">
                Select Role Permissions
            </div>
            <div class="panel-body">
                <div class="permission-select text-center">
                    @include('permission.partials._form', ['permissionFields' => $permissionFields, 'permissions' => $role->permission])
                </div>
            </div>
        </div>
        <div class="pull-right">
            {!! Form::submit('Save Configuration', ['class' => 'btn btn-primary btn-lg']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection