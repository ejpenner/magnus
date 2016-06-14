@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Role Editor</h3>
        <table class="table">
            <thead>
            <tr>
                <th>Role Name</th>
                <th>Role Level</th>
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $i => $role)
                <tr>
                    <td><a href="{{ action('RoleController@show', $role->id) }}">{{ $role->role_name }}</a></td>
                    <td>{{ $role->level }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop