@extends('layouts.app')

@section('content')
    <h3>{{ $user->name }}</h3>
    <hr>
    {!! Form::model($user, ['method'=>'PATCH','action'=>['UserController@update',$user->id]]) !!}
    @include('user._formAdmin')
    {!! Form::close() !!}
@endsection