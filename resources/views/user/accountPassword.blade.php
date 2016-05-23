@extends('layouts.app')

@section('content')
    <div class="container col-md-6 col-md-offset-3">
        <h3>Change Password</h3>
        <hr>
        {!! Form::model($user, ['method'=>'PATCH',
                                'action'=> ['UserController@updatePassword', $user->id]]) !!}
        @include('user._password')
        {!! Form::close() !!}
    </div>
@endsection