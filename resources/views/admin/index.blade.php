@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Admin Center
        </div>
        <div class="panel-body">
            <a href="{{ action('UserController@index') }}">User Lookup</a>
            <a href="{{ action('AdminController@opus') }}">Opus Lookup</a>
            <a href="{{ action('AdminController@session') }}">Session Dump</a>
            <a href="{{ action('UserController@index') }}">Users</a>
            <a href="{{ action('RoleController@index') }}">User Roles</a>
        </div>
    </div>
@endsection