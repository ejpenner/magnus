@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Change Avatar
                </div>
                <div class="panel-body">
                    @include('user.partials._avatar')
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Change User Settings
                </div>
                <div class="panel-body">
                    {!! Form::model($user, ['method'=>'PATCH',
                            'action'=> ['UserController@updateAccount', $user->slug]]) !!}
                    @include('user._form')
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Change Password
                </div>
                <div class="panel-body">
                    {!! Form::model($user, ['method'=>'PATCH',
                                    'action'=> ['UserController@updatePassword', $user->slug]]) !!}
                    @include('user._password')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection