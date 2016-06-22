@extends('layouts.app')

@section('content')
    <div class="container">
    {!! Form::model($user, ['method'=>'PATCH','action'=>['UserController@update',$user->slug]]) !!}
        <div class="col-md-6">
            @include('user._formAdmin')
        </div>
    {!! Form::close() !!}
        <div class="col-md-6">
            <h3>{!! $user->decorateName() !!}</h3>
            <div class="row">
                <img class="avatar" src="{{ $user->getAvatar() }}" alt="avatar">
                <a href="{{ action('UserController@avatarAdmin', $user->id) }}">Change avatar</a>
            </div>
        </div>
    </div>
@endsection