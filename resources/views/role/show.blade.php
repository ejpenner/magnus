@extends('layouts.app')

@section('content')
    <div class="container">
        {!! Form::model($role, ['method'=>'patch', 'action'=>['RoleController@update', $role->id]]) !!}
            @include('role._roleForm')
        {!! Form::close() !!}
    </div>
    <div class="container">
        {!! Form::model($role->permission, ['method'=>'patch', 'action'=>['PermissionController@update', $role->permission->id]]) !!}
            @include('role._permissionForm')
        {!! Form::close() !!}
    </div>
@endsection