@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th><span class="pull-left"><a class="btn btn-default" href="{{ action('UserController@create') }}"><i class="fa fa-plus"></i> Create New User</a></span></th>
                </tr>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><a href="{{ action('UserController@edit', [$user->id]) }}">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->nu_id }}</td>
                        <td>{{ $user->permission_id }}</td>
                        <td>
                            {!! Form::model($user, [
                                'method' => 'DELETE',
                                'class' => 'delete-confirm',
                                'action' => [
                                'UserController@destroy',
                                $user->id
                                ]
                                ]) !!}
                            <a href="{{ action('UserController@edit', [$user->id]) }}"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</button></a>
                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection