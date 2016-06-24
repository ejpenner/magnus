@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                Change Avatar
            </div>
            <div class="panel-body">
                @include('user.partials._avatarAdmin')
            </div>
        </div>
    {!! Form::model($user, ['method'=>'PATCH','action'=>['UserController@update',$user->slug]]) !!}
        <div class="col-md-6">
            @include('user._formAdmin')
        </div>
    {!! Form::close() !!}
@endsection