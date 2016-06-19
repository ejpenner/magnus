@extends('layouts.app')

@section('content')
    <div class="container col-md-6 col-md-offset-3">
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
    <div class="container col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                Update Permission Model
            </div>
            <div class="panel-body">
                {!! Form::model($role->permission, ['method'=>'patch', 'action'=>['PermissionController@update', $role->permission->id]]) !!}
                @include('role._permissionForm')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection