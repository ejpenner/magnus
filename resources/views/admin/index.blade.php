@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Admin Center
        </div>
        <div class="panel-body">
            <h4>Tools</h4>
            <ul>
                <li><a href="{{ action('UserController@index') }}">User Lookup</a></li>
                <li><a href="{{ action('AdminController@opus') }}">Opus Lookup</a></li>
                <li><a href="{{ action('AdminController@session') }}">Session Dump</a></li>
                <li><a href="{{ action('RoleController@index') }}">User Roles</a></li>
            </ul>
        </div>
    </div>
@endsection