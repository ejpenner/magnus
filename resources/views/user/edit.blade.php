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
        <div class="panel panel-default">
            <div class="panel-body">
                {!! Form::model($user, ['method'=>'PATCH','action'=>['UserController@update',$user->slug]]) !!}
                    @include('user.partials._formAdmin')
                {!! Form::close() !!}
            </div>
        </div>

    </div>
@endsection