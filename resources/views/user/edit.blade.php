@extends('layouts.app')
@include('partials._cropperScript')
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
                @include('user.partials._formAdmin')
            </div>
        {!! Form::close() !!}
    </div>
@endsection