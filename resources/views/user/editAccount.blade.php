@extends('layouts.app')

@section('content')
    <h3>Edit Account</h3>
    <hr>
    {!! Form::model($user, ['method'=>'PATCH',
                            'action'=> ['UserController@updateAccount', $user->id]]) !!}
    @include('user._form')
    {!! Form::close() !!}
@endsection