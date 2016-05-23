@extends('layouts.app')

@section('content')
    <h3>Change Password</h3>
    <hr>
    {!! Form::model($user, ['method'=>'PATCH',
                            'action'=> ['UserController@updatePassword', $user->id]]) !!}
    @include('user._password')
    {!! Form::close() !!}
@endsection