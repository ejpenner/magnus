@extends('layouts.app')

@section('content')
    <div class="container">
        <h4><img src="{{ $user->getAvatar() }}" alt="avatar"></h4>
        <h3>{{ $user->name }} - <small>{{ $user->username }}</small></h3>
        <hr>
        {!! Form::model($user, ['method'=>'PATCH','action'=>['UserController@update',$user->slug]]) !!}
        @include('user.partials._formAdmin', [$permissions])
        {!! Form::close() !!}
    </div>
@endsection