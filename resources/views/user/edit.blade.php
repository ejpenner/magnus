@extends('layouts.app')

@section('content')
    <div class="container">
    <h3>{{ $user->name }}</h3>
    <hr>
    {!! Form::model($user, ['method'=>'PATCH','action'=>['UserController@update',$user->slug]]) !!}
    @include('user._formAdmin')
    {!! Form::close() !!}
    </div>
@endsection