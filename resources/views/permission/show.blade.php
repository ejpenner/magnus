@extends('layouts.app')

@section('content')
    {!! Form::model($permissions, ['method' => 'PATCH', 'action' => ['PermissionController@update', $permissions->id]]) !!}
        <div class="permission-select">
            @include('permission.partials._form', ['permissionFields' => $permissionFields, 'permissions' => $permissions])
        </div>
    {!! Form::submit('Save Configuration', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection