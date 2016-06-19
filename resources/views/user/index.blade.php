@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th><span class="pull-left"><a class="btn btn-default" href="{{ action('UserController@create') }}"><i class="fa fa-plus"></i> Create New User</a></span></th>
                </tr>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Operations</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><a href="{{ action('UserController@edit', [$user->slug]) }}">{{ $user->name }}</a></td>
                        <td><a href="{{ action('ProfileController@show', $user->slug) }}">{{ $user->username }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->listRoles() }}</td>
                        <td>
                            @include('partials._slugOperations', ['model'=>$user, 'controller' => 'UserController'])
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $users->render() }}
        </div>
    </div>
@endsection